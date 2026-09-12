<?php
/**
 * bbGuild EQ Extension — enable test
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Enables bbguild core, then bbguildeq on top. Asserts:
 * - 'eq' row present in bb_games
 * - bbguildeq's classes (Warrior, Cleric, ...) seeded in bb_classes for
 *   game_id='eq'
 * - avathar\bbguildeq\ext::BBGUILDEQ_VERSION matches composer.json
 *
 * Unlike bbguildwow, this plugin declares no ACP module of its own, so
 * there is nothing to assert in the ACP module tree here.
 *
 * Catches: migration regressions, services.yml misconfig, missing tables.
 *
 * @group functional
 */
class avathar_bbguildeq_extension_enable_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	public function test_eq_game_row_present()
	{
		$db = $this->get_db();
		$sql = 'SELECT game_id, game_name
			FROM ' . $this->get_table_prefix() . "bb_games
			WHERE game_id = 'eq'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertNotFalse($row, 'expected an eq row in bb_games');
		$this->assertSame('eq', $row['game_id']);
	}

	public function test_eq_classes_seeded()
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(*) AS cnt
			FROM ' . $this->get_table_prefix() . "bb_classes
			WHERE game_id = 'eq'";
		$result = $db->sql_query($sql);
		$count = (int) $db->sql_fetchfield('cnt');
		$db->sql_freeresult($result);

		$this->assertSame(17, $count, 'expected all 17 EQ classes seeded for game_id=eq');

		$sql = 'SELECT name
			FROM ' . $this->get_table_prefix() . "bb_language
			WHERE game_id = 'eq' AND attribute = 'class' AND language = 'en'
			ORDER BY attribute_id ASC";
		$result = $db->sql_query($sql);
		$names = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$names[] = $row['name'];
		}
		$db->sql_freeresult($result);

		$this->assertContains('Warrior', $names);
		$this->assertContains('Cleric', $names);
	}

	public function test_version_constant_matches_composer_json()
	{
		$composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

		$this->assertSame($composer['version'], \avathar\bbguildeq\ext::BBGUILDEQ_VERSION);
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}
}
