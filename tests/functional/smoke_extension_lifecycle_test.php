<?php
/**
 * bbGuild EQ Extension — extension lifecycle smoke test
 *
 * @package   bbguildeq v2.0
 * @copyright 2026 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

/**
 * Disables and re-enables bbguildeq and asserts the enable/disable HTTP
 * flow completes cleanly (no PHP fatals, phpbb_ext.ext_active flips as
 * expected). Catches the class of regression that breaks every install:
 * missing migrations, broken services.yml, autoload misses, listener
 * subscription errors.
 *
 * @group smoke
 */
class avathar_bbguildeq_smoke_extension_lifecycle_test extends phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('avathar/bbguild', 'avathar/bbguildeq');
	}

	private function is_active($extension): bool
	{
		$db = $this->get_db();
		$sql = 'SELECT ext_active
			FROM ' . EXT_TABLE . "
			WHERE ext_name = '" . $db->sql_escape($extension) . "'";
		$result = $db->sql_query($sql);
		$status = (bool) $db->sql_fetchfield('ext_active');
		$db->sql_freeresult($result);

		return $status;
	}

	public function test_disable_and_reenable_bbguildeq()
	{
		$this->assertTrue($this->is_active('avathar/bbguildeq'), 'bbguildeq should already be active from setup_extensions()');

		$this->disable_ext('avathar/bbguildeq');
		$this->assertFalse($this->is_active('avathar/bbguildeq'));

		$this->install_ext('avathar/bbguildeq');
		$this->assertTrue($this->is_active('avathar/bbguildeq'));
	}
}
