# bbGuild - EverQuest

**Current version:** 2.1.0

[![Tests](https://github.com/avatharbe/bbguildeq/actions/workflows/tests.yml/badge.svg)](https://github.com/avatharbe/bbguildeq/actions/workflows/tests.yml)

**Version:** [![Latest Stable Version](https://img.shields.io/github/v/release/avatharbe/bbguildeq)](https://github.com/avatharbe/bbguildeq/releases)

**Documentation:** [avatharbe.github.io/bbguildeq](https://avatharbe.github.io/bbguildeq/)

EverQuest is where guild-management tools like this one started in the first place — bbGuild itself was originally forked from EQDKP back in 2008, before it ever supported any other game, so this plugin is closer to bbGuild's roots than any other in the family. bbguildeq brings all 16 classes and 16 races into your guild's roster, with the Good/Evil/Neutral alignment system that's shaped EQ guild politics since 1999, and boss/zone links straight to EQ Allakhazam so raid planning doesn't mean tabbing out to another site. If your guild has been running progression or classic servers for years, this gives that roster a real home on the forum you already have.

## Features

- **EQ Classes** - 16 playable classes (Bard, Beastlord, Berserker, Cleric, Druid, Enchanter, Magician, Monk, Necromancer, Paladin, Ranger, Rogue, Shadowknight, Shaman, Warrior, Wizard) with color codes
- **EQ Races** - 16 playable races (Barbarian, Dark Elf, Drakkin, Dwarf, Erudite, Froglok, Gnome, Half Elf, Halfling, High Elf, Human, Iksar, Ogre, Troll, Vah Shir, Wood Elf)
- **Factions** - Good, Evil, and Neutral alignments
- **Allakhazam Links** - Boss and zone database URLs linked to EQ Allakhazam

## Requirements

- phpBB >= 3.3.0
- PHP >= 8.1.0
- **bbGuild core** (`avathar/bbguild`) must be installed and enabled

## Installation

1. Ensure bbGuild core (`avathar/bbguild`) is installed and enabled.
2. Copy the `bbguildeq` folder to `/ext/avathar/bbguildeq/`.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `bbGuild - EverQuest` under Disabled Extensions and click `Enable`.
5. Go to ACP > bbGuild > Games and install the **EverQuest** game.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Find `bbGuild - EverQuest` under Enabled Extensions and click `Disable`.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/avathar/bbguildeq` folder.

**Note:** Disabling the extension does not delete existing guild or player data. Your roster and player records remain intact in bbGuild core.

## Game Data

### Factions

| ID | Faction |
|----|---------|
| 1 | Good |
| 2 | Evil |
| 3 | Neutral |

### Classes (16)

| ID | Class | Armor |
|----|-------|-------|
| 0 | Unknown | Plate |
| 1 | Bard | Plate |
| 2 | Beastlord | Leather |
| 3 | Berserker | Leather |
| 4 | Cleric | Plate |
| 5 | Druid | Leather |
| 6 | Enchanter | Cloth |
| 7 | Magician | Cloth |
| 8 | Monk | Cloth |
| 9 | Necromancer | Cloth |
| 10 | Paladin | Plate |
| 11 | Ranger | Mail |
| 12 | Rogue | Mail |
| 13 | Shadowknight | Plate |
| 14 | Shaman | Mail |
| 15 | Warrior | Plate |
| 16 | Wizard | Cloth |

### Races (16)

Barbarian, Dark Elf, Drakkin, Dwarf, Erudite, Froglok, Gnome, Half Elf, Halfling, High Elf, Human, Iksar, Ogre, Troll, Vah Shir, Wood Elf

## License

[GNU General Public License v2](http://opensource.org/licenses/gpl-2.0.php)

## Links

- [bbGuild Core](https://github.com/avatharbe/bbguild)
- [EQ Allakhazam](http://everquest.allakhazam.com/)
- [Issue Tracker](https://github.com/avatharbe/bbguildeq/issues)
