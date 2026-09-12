<?php
/**
 * bbGuild EQ Extension — guild view render test
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Inserts a guild fixture with game_id='eq' and one player of a valid EQ
 * class/race, seeds the roster portal module for that guild (mirroring
 * how bbguild core seeds its own "Test Guild" in migrations/v200b3), and
 * GETs /guild/{guild_id} as an authenticated user. Asserts:
 * - Response is 200
 * - Roster portal module rendered the player row (player name present)
 * - Class image resolves under ext/avathar/bbguildeq/images/, proving
 *   game_registry routed the image path through eq_provider rather than
 *   core's generic fallback
 *
 * Catches: guild_context wiring, image path resolution for a non-API
 * game plugin, portal module registration.
 *
 * @group functional
 */
class avathar_bbguildeq_guild_view_renders_test extends phpbb_functional_test_case
{
	/** Arbitrary guild id unlikely to collide with core's seeded guild_id=0/1 */
	const TEST_GUILD_ID = 42424;

	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	private function get_table_prefix(): string
	{
		return self::$config['table_prefix'];
	}

	private function insert_guild_fixture(): void
	{
		$db = $this->get_db();
		$prefix = $this->get_table_prefix();

		$db->sql_query('DELETE FROM ' . $prefix . 'bb_guild WHERE id = ' . self::TEST_GUILD_ID);
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_guild ' . $db->sql_build_array('INSERT', array(
			'id'             => self::TEST_GUILD_ID,
			'name'           => 'EQ Test Guild',
			'realm'          => 'Test Realm',
			'region'         => 'us',
			'roster'         => 1,
			'players'        => 1,
			'emblemurl'      => '',
			'game_id'        => 'eq',
			'game_edition'   => 'retail',
			'min_armory'     => 0,
			'rec_status'     => 0,
			'guilddefault'   => 0,
			'armory_enabled' => 0,
			'armoryresult'   => '',
			'recruitforum'   => 0,
			'faction'        => 3,
		)));

		$db->sql_query('DELETE FROM ' . $prefix . 'bb_ranks WHERE guild_id = ' . self::TEST_GUILD_ID);
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_ranks ' . $db->sql_build_array('INSERT', array(
			'guild_id'    => self::TEST_GUILD_ID,
			'rank_id'     => 0,
			'rank_name'   => 'Guild Leader',
			'rank_hide'   => 0,
			'rank_prefix' => '',
			'rank_suffix' => '',
		)));

		$db->sql_query('DELETE FROM ' . $prefix . 'bb_players WHERE player_guild_id = ' . self::TEST_GUILD_ID);
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_players ' . $db->sql_build_array('INSERT', array(
			'game_id'          => 'eq',
			'player_name'      => 'Testwarrior',
			'player_region'    => 'us',
			'player_realm'     => '',
			'player_title'     => '',
			'player_level'     => 60,
			'player_race_id'   => 2,   // Human (faction 3, Neutral)
			'player_class_id'  => 1,   // Warrior (imagename 'eq_warrior')
			'player_rank_id'   => 0,
			'player_role'      => '',
			'player_comment'   => '',
			'player_joindate'  => time(),
			'player_outdate'   => 0,
			'player_guild_id'  => self::TEST_GUILD_ID,
			'player_gender_id' => 0,
			'player_achiev'    => 0,
			'player_armory_url'   => '',
			'player_portrait_url' => '',
			'player_spec'      => '',
			'phpbb_user_id'    => 0,
			'player_status'    => 1,
			'deactivate_reason'=> '',
			'last_update'      => time(),
		)));

		// Seed the roster portal module for this guild, mirroring the
		// column/order bbguild core's own migration uses for its seeded
		// "Test Guild" (guild_id=1) — a fresh guild otherwise has no
		// portal layout at all.
		$db->sql_query('DELETE FROM ' . $prefix . 'bb_portal_modules WHERE guild_id = ' . self::TEST_GUILD_ID);
		$db->sql_query('INSERT INTO ' . $prefix . 'bb_portal_modules ' . $db->sql_build_array('INSERT', array(
			'guild_id'            => self::TEST_GUILD_ID,
			'module_classname'    => '\avathar\bbguild\portal\modules\roster',
			'module_column'       => 2,
			'module_order'        => 1,
			'module_name'         => 'BBGUILD_PORTAL_ROSTER',
			'module_image_src'    => '',
			'module_icon'         => '',
			'module_icon_size'    => 16,
			'module_image_width'  => 16,
			'module_image_height' => 16,
			'module_group_ids'    => '',
			'module_status'       => 1,
		)));
	}

	public function test_guild_view_renders_eq_roster_row()
	{
		$this->insert_guild_fixture();

		$this->login('admin');

		self::request('GET', 'app.php/guild/' . self::TEST_GUILD_ID, array(), false);

		$status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $status, 'guild view page should render successfully');

		$content = self::$client->getResponse()->getContent();

		$this->assertStringContainsString('Testwarrior', $content, 'roster module should render the seeded player row');

		$this->assertStringContainsString(
			'ext/avathar/bbguildeq/images/',
			$content,
			'class image should resolve under this plugin\'s own images/ path'
		);

		$this->assertStringContainsString(
			'class_images/eq_warrior.png',
			$content,
			'roster row should render the Warrior class image'
		);
	}
}
