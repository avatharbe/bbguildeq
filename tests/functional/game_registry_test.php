<?php
/**
 * bbGuild EQ Extension — game registry test
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * After enabling, requests bbguild core's ACP "edit game" page for
 * game_id=eq. That page (controller/admin_games.php::showgame()) resolves
 * the game's provider via the tagged bbguild.game_provider service
 * (avathar.bbguild.game_registry) and, when a provider is found, points
 * the game image path at the provider's own get_images_path() instead of
 * core's generic fallback — so a GAMEPATH containing
 * "bbguildeq/images/eq.png" is only possible if eq_provider is actually
 * registered and reachable. It also renders an "Enable armory" checkbox
 * only when the provider's has_api() is true; asserting its absence here
 * locks down eq_provider::has_api() === false (unlike bbguildwow).
 *
 * Catches: bbguild.game_provider tag missing in services.yml, broken
 * provider class, has_api() drifting to true by accident.
 *
 * @group functional
 */
class avathar_bbguildeq_game_registry_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	public function test_eq_provider_registered_with_no_api()
	{
		$this->login('admin');
		$this->admin_login();

		$crawler = self::request(
			'GET',
			'adm/index.php?i=-avathar-bbguild-acp-game_module&mode=editgames&game_id=eq&sid=' . $this->sid,
			array(),
			false
		);

		$status = (int) self::$client->getResponse()->getStatus();
		$this->assertSame(200, $status, 'ACP edit-game page for eq should render successfully');

		$content = self::$client->getResponse()->getContent();

		$this->assertStringContainsString(
			'bbguildeq/images/eq.png',
			$content,
			'edit-game page should resolve the game image through eq_provider::get_images_path(), proving the provider is registered'
		);

		$this->assertStringNotContainsString(
			'name="enable_armory"',
			$content,
			'eq_provider::has_api() is false, so no armory-enable checkbox should render'
		);

		$this->logout();
	}
}
