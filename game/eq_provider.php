<?php
/**
 * EQ Game Provider
 *
 * @package   bbguildeq v2.0
 * @copyright 2018 avathar.be
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace avathar\bbguildeq\game;

use avathar\bbguild\model\games\game_provider_interface;
use avathar\bbguild\model\games\specialization_provider_interface;

class eq_provider implements game_provider_interface, specialization_provider_interface
{
	/** @var eq_installer */
	private $installer;

	/** @var \phpbb\extension\manager */
	private $ext_manager;

	public function __construct(eq_installer $installer, \phpbb\extension\manager $ext_manager)
	{
		$this->installer = $installer;
		$this->ext_manager = $ext_manager;
	}

	public function get_game_id(): string
	{
		return 'eq';
	}

	public function get_game_name(): string
	{
		return 'EverQuest';
	}

	public function get_installer(): \avathar\bbguild\model\games\game_install_interface
	{
		return $this->installer;
	}

	public function get_boss_base_url(): string
	{
		return 'http://everquest.allakhazam.com/db/npc.html?id=%s';
	}

	public function get_zone_base_url(): string
	{
		return 'http://everquest.allakhazam.com/db/zone.html?zstrat=%s';
	}

	public function get_images_path(): string
	{
		return $this->ext_manager->get_extension_path('avathar/bbguildeq', true) . 'images/';
	}

	public function has_api(): bool
	{
		return false;
	}

	public function get_api(): ?\avathar\bbguild\model\games\game_api_interface
	{
		return null;
	}

	public function get_regions(): array
	{
		return array(
			'us' => 'US',
			'eu' => 'EU',
		);
	}

	public function get_api_locales(): array
	{
		return array();
	}

	public function get_armor_types(): array
	{
		return array(
			'CLOTH'   => 'Cloth',
			'LEATHER' => 'Leather',
			'PLATE'   => 'Plate',
		);
	}

	/**
	 * Specialization catalog (issue #6), keyed by class_id (see
	 * game/eq_installer.php's install_classes() for the id map).
	 *
	 * Deliberately empty. Classic EverQuest (the game this plugin models —
	 * note the "Vah Shir"/"Iksar"/"Froglok"/"Drakkin" races and the
	 * Beastlord/Berserker classes added by the Luclin/Gates of Discord
	 * expansions, as opposed to EverQuest II or EverQuest Legends) has no
	 * named subclass/specialization layer above its 16 classes. Each
	 * class_id already IS the terminal build: a Cleric is a Cleric from
	 * character creation to level cap, with no Warden/Templar-style branch
	 * to choose. The Alternate Advancement (AA) system lets a character
	 * spend points across several ability lines, but those lines are not
	 * discrete named specs comparable to WoW talent specs or GW2 Elite
	 * Specializations — they don't redefine which class you are, and
	 * there's no canonical short list of "the AA specs for a Cleric" the
	 * way there is for GW2's elite specs. (EverQuest II — a different
	 * game — does have a Class → Subclass split, e.g. Druid → Warden/
	 * Fury; that is out of scope here since bbguildeq targets EQ1.)
	 *
	 * Returning [] here is the honest answer, not a placeholder: core's
	 * install_specs() seeding walks this map and inserts nothing when it's
	 * empty, which is exactly correct for this game.
	 *
	 * @return array<int, list<array{spec_name:string,role_id:int,spec_icon:string,spec_order:int}>>
	 */
	public static function spec_catalog(): array
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function get_spec_label(): string
	{
		return 'Specialization';
	}

	/**
	 * Interface implementation: delegates to the static catalog.
	 *
	 * @return array<int, list<array{spec_name:string,role_id:int,spec_icon:string,spec_order:int}>>
	 */
	public function get_specializations(): array
	{
		return self::spec_catalog();
	}
}
