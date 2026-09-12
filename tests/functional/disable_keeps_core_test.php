<?php
/**
 * bbGuild EQ Extension — disabling this plugin must not break core
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Enables bbguild core + bbguildeq, then disables bbguildeq. Uses
 * bbguild core's own seeded "Test Guild" (guild_id=1, game_id='custom')
 * as the control — it does not depend on any other game plugin being
 * installed. Asserts:
 * - The control guild's page still renders 200 after bbguildeq is
 *   disabled
 * - bbguild core's ACP game list still loads
 *
 * This is the single most important guardrail for a non-flagship game
 * plugin: it catches shared service definitions accidentally moved into
 * the plugin, or event listeners that throw once the plugin is gone.
 *
 * @group functional
 */
class avathar_bbguildeq_disable_keeps_core_test extends phpbb_functional_test_case
{
	/** guild_id seeded by bbguild core's own migration data ("Test Guild", game_id='custom') */
	const CORE_CONTROL_GUILD_ID = 1;

	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	public function test_disabling_bbguildeq_keeps_core_guild_and_acp_alive()
	{
		$this->disable_ext('avathar/bbguildeq');

		// Core's control guild still renders.
		self::request('GET', 'app.php/guild/' . self::CORE_CONTROL_GUILD_ID, array(), false);
		$status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $status, "core's own control guild should still render after bbguildeq is disabled");

		// Core's ACP game list still loads.
		$this->login('admin');
		$this->admin_login();

		self::request(
			'GET',
			'adm/index.php?i=-avathar-bbguild-acp-game_module&mode=listgames&sid=' . $this->sid,
			array(),
			false
		);
		$acp_status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $acp_status, "bbguild core's ACP game list should still load after bbguildeq is disabled");

		$this->logout();

		// Re-enable so later tests in the same suite run see bbguildeq active again.
		$this->install_ext('avathar/bbguildeq');
	}
}
