<?php
/**
 * EQ Installer
 *
 * Installs EverQuest factions, classes, races, and roles.
 *
 * @package   bbguildeq v2.0
 * @copyright 2018 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace avathar\bbguildeq\game;

use avathar\bbguild\model\games\abstract_game_install;

class eq_installer extends abstract_game_install
{
	/**
	 * Installs EQ factions (Good, Evil, Neutral)
	 */
	protected function install_factions()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_factions_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'faction_id' => 1, 'faction_name' => 'Good');
		$sql_ary[] = array('game_id' => $this->game_id, 'faction_id' => 2, 'faction_name' => 'Evil');
		$sql_ary[] = array('game_id' => $this->game_id, 'faction_id' => 3, 'faction_name' => 'Neutral');
		$this->db->sql_multi_insert($this->table('bb_factions_table'), $sql_ary);
	}

	/**
	 * Installs EQ classes (English only)
	 */
	protected function install_classes()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_classes_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 0,  'class_faction_id' => 3, 'class_armor_type' => 'PLATE',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#DCD09A', 'imagename' => 'eq_unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 1,  'class_faction_id' => 3, 'class_armor_type' => 'PLATE',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FF8855', 'imagename' => 'eq_warrior');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 2,  'class_faction_id' => 3, 'class_armor_type' => 'LEATHER', 'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FFDD55', 'imagename' => 'eq_rogue');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 3,  'class_faction_id' => 3, 'class_armor_type' => 'LEATHER', 'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FFFF88', 'imagename' => 'eq_monk');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 4,  'class_faction_id' => 3, 'class_armor_type' => 'LEATHER', 'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#EEFF99', 'imagename' => 'eq_ranger');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 5,  'class_faction_id' => 3, 'class_armor_type' => 'PLATE',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FFBBCC', 'imagename' => 'eq_paladin');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 6,  'class_faction_id' => 3, 'class_armor_type' => 'PLATE',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FF1166', 'imagename' => 'eq_shadow_knight');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 7,  'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#00FFAA', 'imagename' => 'eq_bard');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 8,  'class_faction_id' => 3, 'class_armor_type' => 'LEATHER', 'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#00EE00', 'imagename' => 'eq_beastlord');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 9,  'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#00EEBB', 'imagename' => 'eq_cleric');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 10, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#00EECC', 'imagename' => 'eq_druid');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 11, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#00EEDD', 'imagename' => 'eq_shaman');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 12, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#CC00AA', 'imagename' => 'eq_enchanter');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 13, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#7700AA', 'imagename' => 'eq_wizard');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 14, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#AA00AA', 'imagename' => 'eq_necromancer');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 15, 'class_faction_id' => 3, 'class_armor_type' => 'CLOTH',   'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#CC0099', 'imagename' => 'eq_magician');
		$sql_ary[] = array('game_id' => $this->game_id, 'class_id' => 16, 'class_faction_id' => 3, 'class_armor_type' => 'LEATHER', 'class_min_level' => 1, 'class_max_level' => 100, 'colorcode' => '#FFBB55', 'imagename' => 'eq_berserker');
		$this->db->sql_multi_insert($this->table('bb_classes_table'), $sql_ary);
		unset($sql_ary);

		// class names (English only)
		$this->db->sql_query('DELETE FROM ' . $this->table('bb_language_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "' AND attribute='class' ");

		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'en', 'attribute' => 'class', 'name' => 'Unknown',       'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'en', 'attribute' => 'class', 'name' => 'Warrior',       'name_short' => 'Warrior');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'en', 'attribute' => 'class', 'name' => 'Rogue',         'name_short' => 'Rogue');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'en', 'attribute' => 'class', 'name' => 'Monk',          'name_short' => 'Monk');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'en', 'attribute' => 'class', 'name' => 'Ranger',        'name_short' => 'Ranger');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'en', 'attribute' => 'class', 'name' => 'Paladin',       'name_short' => 'Paladin');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'en', 'attribute' => 'class', 'name' => 'Shadow Knight', 'name_short' => 'Shadow Knight');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'en', 'attribute' => 'class', 'name' => 'Bard',          'name_short' => 'Bard');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'en', 'attribute' => 'class', 'name' => 'Beastlord',     'name_short' => 'Beastlord');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'en', 'attribute' => 'class', 'name' => 'Cleric',        'name_short' => 'Cleric');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'en', 'attribute' => 'class', 'name' => 'Druid',         'name_short' => 'Druid');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'en', 'attribute' => 'class', 'name' => 'Shaman',        'name_short' => 'Shaman');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'en', 'attribute' => 'class', 'name' => 'Enchanter',     'name_short' => 'Enchanter');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 13, 'language' => 'en', 'attribute' => 'class', 'name' => 'Wizard',        'name_short' => 'Wizard');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 14, 'language' => 'en', 'attribute' => 'class', 'name' => 'Necromancer',   'name_short' => 'Necromancer');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 15, 'language' => 'en', 'attribute' => 'class', 'name' => 'Magician',      'name_short' => 'Magician');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 16, 'language' => 'en', 'attribute' => 'class', 'name' => 'Berserker',     'name_short' => 'Berserker');
		$this->db->sql_multi_insert($this->table('bb_language_table'), $sql_ary);
	}

	/**
	 * Installs EQ races (English only)
	 */
	protected function install_races()
	{

		$this->db->sql_query('DELETE FROM ' . $this->table('bb_races_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "'");
		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 0,  'race_faction_id' => 2);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 1,  'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 2,  'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 3,  'race_faction_id' => 1);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 4,  'race_faction_id' => 1);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 5,  'race_faction_id' => 1);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 6,  'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 7,  'race_faction_id' => 2);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 8,  'race_faction_id' => 1);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 9,  'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 10, 'race_faction_id' => 2);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 11, 'race_faction_id' => 2);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 12, 'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 13, 'race_faction_id' => 2);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 14, 'race_faction_id' => 3);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 15, 'race_faction_id' => 1);
		$sql_ary[] = array('game_id' => $this->game_id, 'race_id' => 16, 'race_faction_id' => 3);
		$this->db->sql_multi_insert($this->table('bb_races_table'), $sql_ary);
		unset($sql_ary);

		// race names (English only)
		$this->db->sql_query('DELETE FROM ' . $this->table('bb_language_table') . " WHERE game_id = '" . $this->db->sql_escape($this->game_id) . "' AND attribute = 'race' ");

		$sql_ary = array();
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 0,  'language' => 'en', 'attribute' => 'race', 'name' => 'Unknown',   'name_short' => 'Unknown');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 1,  'language' => 'en', 'attribute' => 'race', 'name' => 'Gnome',     'name_short' => 'Gnome');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 2,  'language' => 'en', 'attribute' => 'race', 'name' => 'Human',     'name_short' => 'Human');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 3,  'language' => 'en', 'attribute' => 'race', 'name' => 'Barbarian', 'name_short' => 'Barbarian');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 4,  'language' => 'en', 'attribute' => 'race', 'name' => 'Dwarf',     'name_short' => 'Dwarf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 5,  'language' => 'en', 'attribute' => 'race', 'name' => 'High Elf',  'name_short' => 'High Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 6,  'language' => 'en', 'attribute' => 'race', 'name' => 'Half Elf',  'name_short' => 'Half Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 7,  'language' => 'en', 'attribute' => 'race', 'name' => 'Dark Elf',  'name_short' => 'Dark Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 8,  'language' => 'en', 'attribute' => 'race', 'name' => 'Wood Elf',  'name_short' => 'Wood Elf');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 9,  'language' => 'en', 'attribute' => 'race', 'name' => 'Vah Shir',  'name_short' => 'Vah Shir');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 10, 'language' => 'en', 'attribute' => 'race', 'name' => 'Troll',     'name_short' => 'Troll');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 11, 'language' => 'en', 'attribute' => 'race', 'name' => 'Ogre',      'name_short' => 'Ogre');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 12, 'language' => 'en', 'attribute' => 'race', 'name' => 'Froglok',   'name_short' => 'Froglok');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 13, 'language' => 'en', 'attribute' => 'race', 'name' => 'Iksar',     'name_short' => 'Iksar');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 14, 'language' => 'en', 'attribute' => 'race', 'name' => 'Erudite',   'name_short' => 'Erudite');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 15, 'language' => 'en', 'attribute' => 'race', 'name' => 'Halfling',  'name_short' => 'Halfling');
		$sql_ary[] = array('game_id' => $this->game_id, 'attribute_id' => 16, 'language' => 'en', 'attribute' => 'race', 'name' => 'Drakkin',   'name_short' => 'Drakkin');
		$this->db->sql_multi_insert($this->table('bb_language_table'), $sql_ary);
	}

	/**
	 * Installs EQ specializations (issue #6).
	 *
	 * Classic EverQuest has no named subclass/specialization layer above
	 * its 16 classes — see eq_provider::spec_catalog()'s docblock for why
	 * this is deliberately empty rather than an oversight. Mirrors
	 * gw2_installer::install_specs()'s structure for consistency even
	 * though there is nothing to insert here.
	 *
	 * Skipped if bb_specializations_table isn't wired in (older core
	 * installs that haven't run migration v200b4 yet).
	 */
	protected function install_specs(): void
	{
		if (!isset($this->table_names['bb_specializations_table']))
		{
			return;
		}

		$rows = [];
		foreach (eq_provider::spec_catalog() as $class_id => $specs)
		{
			foreach ($specs as $spec)
			{
				$rows[] = [
					'game_id'    => $this->game_id,
					'class_id'   => (int) $class_id,
					'role_id'    => (int) $spec['role_id'],
					'spec_name'  => (string) $spec['spec_name'],
					'spec_icon'  => (string) $spec['spec_icon'],
					'spec_order' => (int) $spec['spec_order'],
				];
			}
		}
		if (!$rows)
		{
			return;
		}
		$this->db->sql_multi_insert($this->table('bb_specializations_table'), $rows);
	}
}
