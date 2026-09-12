<?php
/**
 * @package bbGuild EQ Extension
 * @copyright (c) 2026 avathar.be
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace avathar\bbguildeq\tests\game;

use PHPUnit\Framework\TestCase;
use avathar\bbguildeq\game\eq_installer;

class eq_installer_test extends TestCase
{
	/** @var eq_installer */
	protected $installer;

	/** @var array Captured sql_multi_insert calls: array of [table, data] */
	protected $inserted = array();

	/** @var \PHPUnit\Framework\MockObject\MockObject */
	protected $db;

	protected function setUp(): void
	{
		parent::setUp();

		$this->inserted = array();

		$this->db = $this->createMock(\phpbb\db\driver\driver_interface::class);

		// Capture sql_multi_insert calls
		$this->db->method('sql_multi_insert')
			->willReturnCallback(function ($table, $data) {
				$this->inserted[] = array('table' => $table, 'data' => $data);
			});

		// sql_query (DELETE statements) — no-op
		$this->db->method('sql_query')->willReturn(true);
		$this->db->method('sql_escape')->willReturnCallback(function ($v) { return $v; });

		$cache = $this->createMock(\phpbb\cache\driver\driver_interface::class);
		$config = new \phpbb\config\config(array());
		$user = $this->getMockBuilder(\phpbb\user::class)
			->disableOriginalConstructor()
			->getMock();

		$this->installer = new eq_installer($this->db, $cache, $config, $user);

		// Set table_names and game_id via reflection (normally set by install())
		$ref = new \ReflectionClass($this->installer);

		$tn = $ref->getProperty('table_names');
		$tn->setAccessible(true);
		$tn->setValue($this->installer, array(
			'bb_factions_table'  => 'phpbb_bb_factions',
			'bb_classes_table'   => 'phpbb_bb_classes',
			'bb_races_table'     => 'phpbb_bb_races',
			'bb_language_table'  => 'phpbb_bb_language',
		));

		$gid = $ref->getProperty('game_id');
		$gid->setAccessible(true);
		$gid->setValue($this->installer, 'eq');
	}

	/**
	 * Invoke a protected method on the installer.
	 */
	private function invoke_protected(string $method_name): void
	{
		$this->inserted = array();
		$method = new \ReflectionMethod(eq_installer::class, $method_name);
		$method->setAccessible(true);
		$method->invoke($this->installer);
	}

	/**
	 * Set (key => value) or remove (value === null) a single entry in the
	 * installer's table_names map, on top of whatever setUp() put there.
	 */
	private function set_table_name(string $key, ?string $value): void
	{
		$ref = new \ReflectionClass($this->installer);
		$tn = $ref->getProperty('table_names');
		$tn->setAccessible(true);
		$current = $tn->getValue($this->installer);

		if ($value === null)
		{
			unset($current[$key]);
		}
		else
		{
			$current[$key] = $value;
		}

		$tn->setValue($this->installer, $current);
	}

	// ── Factions ───────────────────────────────────────────

	public function test_install_factions_count(): void
	{
		$this->invoke_protected('install_factions');
		$this->assertCount(1, $this->inserted);
		$this->assertCount(3, $this->inserted[0]['data']);
	}

	public function test_install_factions_ids(): void
	{
		$this->invoke_protected('install_factions');
		$factions = $this->inserted[0]['data'];
		$ids = array_column($factions, 'faction_id');
		$this->assertContains(1, $ids, 'Good faction_id=1');
		$this->assertContains(2, $ids, 'Evil faction_id=2');
		$this->assertContains(3, $ids, 'Neutral faction_id=3');
	}

	public function test_install_factions_names(): void
	{
		$this->invoke_protected('install_factions');
		$factions = $this->inserted[0]['data'];
		$names = array_column($factions, 'faction_name');
		$this->assertContains('Good', $names);
		$this->assertContains('Evil', $names);
		$this->assertContains('Neutral', $names);
	}

	public function test_install_factions_game_id(): void
	{
		$this->invoke_protected('install_factions');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertSame('eq', $row['game_id']);
		}
	}

	// ── Classes ────────────────────────────────────────────

	public function test_install_classes_count(): void
	{
		$this->invoke_protected('install_classes');
		// First insert: class rows, second insert: language rows
		$this->assertCount(2, $this->inserted);
		$this->assertCount(17, $this->inserted[0]['data']);
	}

	public function test_install_classes_valid_armor_types(): void
	{
		$this->invoke_protected('install_classes');
		$valid = array('CLOTH', 'LEATHER', 'PLATE');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertContains($row['class_armor_type'], $valid, "class_id {$row['class_id']} has valid armor type");
		}
	}

	public function test_install_classes_valid_faction_reference(): void
	{
		$this->invoke_protected('install_classes');
		// EQ classes are all faction-neutral (Neutral = 3) — every class is
		// available regardless of the character's own faction.
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertSame(3, $row['class_faction_id'], "class_id {$row['class_id']} references faction 3 (Neutral)");
		}
	}

	public function test_install_classes_language_coverage(): void
	{
		$this->invoke_protected('install_classes');
		$lang_rows = $this->inserted[1]['data'];
		$languages = array_unique(array_column($lang_rows, 'language'));
		sort($languages);
		// EQ is English-only — unlike WoW's 4-language coverage.
		$this->assertSame(array('en'), $languages);
	}

	public function test_install_classes_language_entries_count(): void
	{
		$this->invoke_protected('install_classes');
		$lang_rows = $this->inserted[1]['data'];
		// 17 classes x 1 language (en) = 17 total
		$this->assertCount(17, $lang_rows);
	}

	public function test_install_classes_language_attribute_ids_match_class_ids(): void
	{
		$this->invoke_protected('install_classes');
		$class_ids = array_column($this->inserted[0]['data'], 'class_id');
		sort($class_ids);
		$lang_ids = array_column($this->inserted[1]['data'], 'attribute_id');
		sort($lang_ids);
		$this->assertSame($class_ids, $lang_ids, 'every class_id has a matching language attribute_id');
	}

	// ── Races ──────────────────────────────────────────────

	public function test_install_races_count(): void
	{
		$this->invoke_protected('install_races');
		// First insert: race rows, second insert: language rows
		$this->assertCount(2, $this->inserted);
		$this->assertCount(17, $this->inserted[0]['data']);
	}

	public function test_install_races_valid_factions(): void
	{
		$this->invoke_protected('install_races');
		foreach ($this->inserted[0]['data'] as $row)
		{
			$this->assertContains($row['race_faction_id'], array(1, 2, 3), "race_id {$row['race_id']} has valid faction");
		}
	}

	public function test_install_races_language_coverage(): void
	{
		$this->invoke_protected('install_races');
		$lang_rows = $this->inserted[1]['data'];
		$languages = array_unique(array_column($lang_rows, 'language'));
		sort($languages);
		// EQ is English-only — unlike WoW's 4-language coverage.
		$this->assertSame(array('en'), $languages);
	}

	public function test_install_races_language_entries_count(): void
	{
		$this->invoke_protected('install_races');
		$lang_rows = $this->inserted[1]['data'];
		// 17 races x 1 language (en) = 17 total
		$this->assertCount(17, $lang_rows);
	}

	public function test_install_races_language_attribute_ids_match_race_ids(): void
	{
		$this->invoke_protected('install_races');
		$race_ids = array_column($this->inserted[0]['data'], 'race_id');
		sort($race_ids);
		$lang_ids = array_column($this->inserted[1]['data'], 'attribute_id');
		sort($lang_ids);
		$this->assertSame($race_ids, $lang_ids, 'every race_id has a matching language attribute_id');
	}

	// ── has_api_support() ──────────────────────────────────

	public function test_has_api_support_defaults_false(): void
	{
		// eq_installer does not override has_api_support() — the abstract
		// base's default (no API) applies, matching eq_provider::has_api().
		$method = new \ReflectionMethod(eq_installer::class, 'has_api_support');
		$method->setAccessible(true);
		$this->assertFalse($method->invoke($this->installer));
	}

	// ── install_roles() is not overridden ──────────────────

	public function test_installer_does_not_declare_its_own_install_roles(): void
	{
		// eq_installer.php has no install_roles() of its own — the base
		// class's default (DPS/Healer/Tank, en/fr/de/it) is inherited
		// unchanged. Guard against silently adding one without updating
		// this suite's assumptions.
		$this->assertFalse(
			(new \ReflectionClass(eq_installer::class))->hasMethod('install_roles')
				&& (new \ReflectionMethod(eq_installer::class, 'install_roles'))->getDeclaringClass()->getName() === eq_installer::class
		);
	}

	// ── Specializations (install_specs) ─────────────────────
	//
	// Classic EverQuest (this plugin's target — see the races/classes
	// above: Vah Shir, Iksar, Froglok, Drakkin, Beastlord, Berserker) has
	// no named subclass/specialization layer above its 16 classes — each
	// class_id already is the terminal build. eq_provider::spec_catalog()
	// is therefore deliberately empty (see its docblock), and
	// install_specs() must confirm-empty rather than insert anything,
	// even when the specializations table is wired in.

	public function test_install_specs_is_confirmed_empty_when_table_wired(): void
	{
		$this->set_table_name('bb_specializations_table', 'phpbb_bb_specializations');

		$this->invoke_protected('install_specs');

		$this->assertCount(0, $this->inserted, 'EQ has no spec layer to seed — install_specs() must not insert any rows');
	}

	public function test_install_specs_skips_when_table_not_wired(): void
	{
		$this->set_table_name('bb_specializations_table', null);

		$this->invoke_protected('install_specs');

		$this->assertCount(0, $this->inserted, 'install_specs() must no-op when bb_specializations_table is not in table_names');
	}
}
