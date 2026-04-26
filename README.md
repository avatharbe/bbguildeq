# bbGuild - EverQuest
[![Tests](https://github.com/avatharbe/bbguild_eq/actions/workflows/tests.yml/badge.svg)](https://github.com/avatharbe/bbguild_eq/actions/workflows/tests.yml)

**Version:** [![Latest Stable Version](https://img.shields.io/github/v/release/avatharbe/bbguild_eq)](https://github.com/avatharbe/bbguild_eq/releases)   
  
Game plugin that adds EverQuest support to [bbGuild](https://github.com/avandenberghe/bbguild).

## Features

- **EQ Classes** - 17 playable classes (Bard, Beastlord, Berserker, Cleric, Druid, Enchanter, Magician, Monk, Necromancer, Paladin, Ranger, Rogue, Shadowknight, Shaman, Warrior, Wizard) with color codes
- **EQ Races** - 17 playable races (Barbarian, Dark Elf, Drakkin, Dwarf, Erudite, Froglok, Gnome, Half Elf, Halfling, High Elf, Human, Iksar, Ogre, Troll, Vah Shir, Wood Elf)
- **Factions** - Good, Evil, and Neutral alignments
- **Allakhazam Links** - Boss and zone database URLs linked to EQ Allakhazam

## Requirements

- phpBB >= 3.3.0
- PHP >= 7.4.0
- **bbGuild core** (`avathar/bbguild`) must be installed and enabled

## Installation

1. Ensure bbGuild core (`avathar/bbguild`) is installed and enabled.
2. Copy the `bbguild_eq` folder to `/ext/avathar/bbguild_eq/`.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `bbGuild - EverQuest` under Disabled Extensions and click `Enable`.
5. Go to ACP > bbGuild > Games and install the **EverQuest** game.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Find `bbGuild - EverQuest` under Enabled Extensions and click `Disable`.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/avathar/bbguild_eq` folder.

**Note:** Disabling the extension does not delete existing guild or player data. Your roster and player records remain intact in bbGuild core.

## Game Data

### Factions

| ID | Faction |
|----|---------|
| 1 | Good |
| 2 | Evil |
| 3 | Neutral |

### Classes (17)

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

### Races (17)

Barbarian, Dark Elf, Drakkin, Dwarf, Erudite, Froglok, Gnome, Half Elf, Halfling, High Elf, Human, Iksar, Ogre, Troll, Vah Shir, Wood Elf

## License

[GNU General Public License v2](http://opensource.org/licenses/gpl-2.0.php)

## Links

- [bbGuild Core](https://github.com/avandenberghe/bbguild)
- [EQ Allakhazam](http://everquest.allakhazam.com/)
- [Issue Tracker](https://github.com/avandenberghe/bbguild/issues)
