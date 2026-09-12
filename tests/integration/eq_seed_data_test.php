<?php
/**
 * bbGuild EQ Extension — seed data structural correctness
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * This plugin has no external API, so there are no HTTP fixtures to
 * mock — the only relevant integration coverage is fixture-loading
 * correctness: once eq_installer has run against a real database, is
 * the seeded data internally consistent?
 *
 * Extends \phpbb_functional_test_case (not \phpbb_database_test_case —
 * per the 2026-09 correction in bbguildwow's tests/integration-tests.md,
 * only phpbb_functional_test_case gives a real DB connection, a real
 * installed extension, and working get_db()/get_extension_manager()
 * helpers in this test framework). No HTTP request is made.
 *
 * Asserts, beyond what the functional tests already cover:
 * - every class_id has a valid class_armor_type
 * - every race_id's race_faction_id is 0 or a faction_id present in
 *   bb_factions for game_id='eq'
 * - no duplicate class_id or race_id per game_id
 * - every seeded class_id/race_id has a matching bb_language row
 *   (this installer seeds language rows for both attributes)
 *
 * @group integration
 */
class avathar_bbguildeq_eq_seed_data_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}

	private function fetch_all(string $sql): array
	{
		$db = $this->get_db();
		$result = $db->sql_query($sql);
		$rows = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		return $rows;
	}

	public function test_every_class_has_valid_armor_type()
	{
		$prefix = $this->get_table_prefix();
		$valid = array('CLOTH', 'LEATHER', 'PLATE');

		$rows = $this->fetch_all("SELECT class_id, class_armor_type FROM {$prefix}bb_classes WHERE game_id = 'eq'");
		$this->assertNotEmpty($rows, 'expected eq classes to be seeded');

		foreach ($rows as $row)
		{
			$this->assertContains(
				$row['class_armor_type'],
				$valid,
				"class_id {$row['class_id']} has invalid armor type '{$row['class_armor_type']}'"
			);
		}
	}

	public function test_every_race_references_a_valid_faction()
	{
		$prefix = $this->get_table_prefix();

		$faction_rows = $this->fetch_all("SELECT faction_id FROM {$prefix}bb_factions WHERE game_id = 'eq'");
		$valid_factions = array_column($faction_rows, 'faction_id');
		$valid_factions = array_map('intval', $valid_factions);
		$valid_factions[] = 0;

		$race_rows = $this->fetch_all("SELECT race_id, race_faction_id FROM {$prefix}bb_races WHERE game_id = 'eq'");
		$this->assertNotEmpty($race_rows, 'expected eq races to be seeded');

		foreach ($race_rows as $row)
		{
			$this->assertContains(
				(int) $row['race_faction_id'],
				$valid_factions,
				"race_id {$row['race_id']} references unknown faction_id {$row['race_faction_id']}"
			);
		}
	}

	public function test_no_duplicate_class_ids_for_game()
	{
		$prefix = $this->get_table_prefix();
		$rows = $this->fetch_all("SELECT class_id FROM {$prefix}bb_classes WHERE game_id = 'eq'");
		$ids = array_column($rows, 'class_id');

		$this->assertSame(count($ids), count(array_unique($ids)), 'duplicate class_id found for game_id=eq');
	}

	public function test_no_duplicate_race_ids_for_game()
	{
		$prefix = $this->get_table_prefix();
		$rows = $this->fetch_all("SELECT race_id FROM {$prefix}bb_races WHERE game_id = 'eq'");
		$ids = array_column($rows, 'race_id');

		$this->assertSame(count($ids), count(array_unique($ids)), 'duplicate race_id found for game_id=eq');
	}

	public function test_every_class_id_has_a_language_row()
	{
		$prefix = $this->get_table_prefix();

		$class_ids = array_map('intval', array_column(
			$this->fetch_all("SELECT class_id FROM {$prefix}bb_classes WHERE game_id = 'eq'"),
			'class_id'
		));
		$lang_ids = array_map('intval', array_column(
			$this->fetch_all("SELECT attribute_id FROM {$prefix}bb_language WHERE game_id = 'eq' AND attribute = 'class'"),
			'attribute_id'
		));

		sort($class_ids);
		$lang_ids = array_unique($lang_ids);
		sort($lang_ids);

		$this->assertSame($class_ids, array_values($lang_ids), 'every seeded class_id should have exactly one language row');
	}

	public function test_every_race_id_has_a_language_row()
	{
		$prefix = $this->get_table_prefix();

		$race_ids = array_map('intval', array_column(
			$this->fetch_all("SELECT race_id FROM {$prefix}bb_races WHERE game_id = 'eq'"),
			'race_id'
		));
		$lang_ids = array_map('intval', array_column(
			$this->fetch_all("SELECT attribute_id FROM {$prefix}bb_language WHERE game_id = 'eq' AND attribute = 'race'"),
			'attribute_id'
		));

		sort($race_ids);
		$lang_ids = array_unique($lang_ids);
		sort($lang_ids);

		$this->assertSame($race_ids, array_values($lang_ids), 'every seeded race_id should have exactly one language row');
	}
}
