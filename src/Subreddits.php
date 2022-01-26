<?php


namespace Reddit;

use Reddit\Query\FlairQuery;
use Reddit\Query\NewestQuery;
use Reddit\Query\QueryInterface;
use Reddit\Query\SearchQuery;

final class Subreddits
{

    const ASSASSINS_CREED = 'assassinscreed';
    const ASSASSINS_CREED_ODYSSEY = 'AssassinsCreedOdyssey';
    const ASSASSINS_CREED_ORIGINS = 'AssassinsCreedOrigins';
    const ASSASSINS_CREED_VALHALLA = 'AssassinsCreedValhala';
    const BIOMUTANT = 'biomutant';
    const BATMAN_ARKHAM = 'BatmanArkham';
    const CONTROL = 'controlgame';
    const DEATH_STRANDING = 'DeathStranding';
    const DEMONS_SOULS = 'demonssouls';
    const FAR_CRY = 'farcry';
    const FORZA = 'forza';
    const FORZA_HOTIZON = 'ForzaHorizon';
    const GHOST_OF_TSUSHIMA = 'ghostoftsushima';
    const GHOST_OF_TSUSHIMA_PHOTO = 'ghostoftsushimaphoto';
    const GOD_OF_WAR = 'GodofWar';
    const GRAN_TURISMO = 'granturismo';
    const GTA_V_PC = 'GrandTheftAutoV_PC';
    const HORIZON = 'horizon';
    const HORIZON_SCREENSHOTS = 'HorizonScreenshots';
    const FALLEN_ORDER = 'FallenOrder';
    const FENYX_RISING = 'FenyxRising';
    const INFAMOUS = 'infamous';
    const DBZ_KAKAROT = 'kakarot';
    const MAFIA = 'MafiaTheGame';
    const NEED_FOR_SPEED = 'needforspeed';
    const PLAY_AVENGERS = 'PlayAvengers';
    const RED_DEAD_REDEMPTION_2 = 'reddeadredemption2';
    const SEKIRO = 'Sekiro';
    const SPIDERMAN_PS4 = 'SpidermanPS4';
    const STEEP = 'Steep';
    const THE_CREW = 'The_Crew';
    const THE_LAST_OF_US = 'thelastofus';
    const THE_LAST_OF_US_2 = 'lastofuspart2';
    const THE_WITCHER_3 = 'thewitcher3';
    const WITCHER = 'witcher';
    const UNCHARTED = 'uncharted';

    public static function get($id): ?Subreddit
    {
        $subreddits = self::all();

        foreach ($subreddits as $subreddit) {
            if ($subreddit->getId() == $id) {
                return $subreddit;
            }
        }

        return null;
    }

    public static function all()
    {
        return [
            new Subreddit(self::ASSASSINS_CREED, [new FlairQuery('// Photo Mode')], FlairTags::ASSASSINS_CREED),
            new Subreddit(self::ASSASSINS_CREED_ODYSSEY, [new FlairQuery('Photo Mode')], FlairTags::ASSASSINS_CREED),
            new Subreddit(self::ASSASSINS_CREED_ORIGINS, [new FlairQuery('Image')], FlairTags::ASSASSINS_CREED),
            new Subreddit(self::ASSASSINS_CREED_VALHALLA, [new FlairQuery('Screenshot', QueryInterface::T_HOUR)], FlairTags::ASSASSINS_CREED),
            new Subreddit(self::BIOMUTANT, [new FlairQuery('Screenshot')], FlairTags::BIOMUTANT),
            new Subreddit(self::BATMAN_ARKHAM, [new FlairQuery('Screenshot')], FlairTags::BATMAN_ARKHAM),
            new Subreddit(self::CONTROL, [new SearchQuery('title:screenshot')], FlairTags::CONTROL),
            new Subreddit(self::DEATH_STRANDING, [new FlairQuery('Photo mode')], FlairTags::DEATH_STRANDING),
            new Subreddit(self::DEMONS_SOULS, [new FlairQuery('Screenshot')], FlairTags::DEMONS_SOULS),
            new Subreddit(self::FAR_CRY, [new SearchQuery('title:screenshot')], FlairTags::FAR_CRY),
            new Subreddit(self::FENYX_RISING, [
                new FlairQuery('Screenshot/Video'),
                new FlairQuery('Media'),
            ], FlairTags::IMMORTALS_FENYX_RISNG),
            new Subreddit(self::FALLEN_ORDER, [new FlairQuery('Screenshot')], FlairTags::JEDI_FALLEN_ORDER),
            new Subreddit(self::FORZA, [new FlairQuery('Photo', QueryInterface::T_HOUR)], FlairTags::FORZA),
            new Subreddit(self::GHOST_OF_TSUSHIMA, [new SearchQuery('title:screenshot')], FlairTags::GHOST_OF_TSUSHIMA),
            new Subreddit(self::GHOST_OF_TSUSHIMA_PHOTO, [new FlairQuery('Picture')], FlairTags::GHOST_OF_TSUSHIMA),
            new Subreddit(self::GOD_OF_WAR, [new FlairQuery('Photo Mode')], FlairTags::GOD_OF_WAR),
            new Subreddit(self::GRAN_TURISMO, [new FlairQuery('GTS Photo/Video', QueryInterface::T_HOUR)], FlairTags::GRAN_TURISMO),
            new Subreddit(self::GTA_V_PC, [new FlairQuery('Image')], FlairTags::GTA),
            new Subreddit(self::HORIZON, [new SearchQuery('title:screenshot')], FlairTags::HORIZON_ZERO_DAWN),
            new Subreddit(self::HORIZON_SCREENSHOTS, [new NewestQuery()], FlairTags::HORIZON_ZERO_DAWN),
            new Subreddit(self::INFAMOUS, [new SearchQuery('title:screenshot')], FlairTags::INFAMOUS),
            new Subreddit(self::DBZ_KAKAROT, [new FlairQuery('screenshot')], FlairTags::DBZ_KAKAROT),
            new Subreddit(self::MAFIA, [new SearchQuery('title:screenshot')], FlairTags::MAFIA),
            new Subreddit(self::NEED_FOR_SPEED, [new FlairQuery('In Game Photo')], FlairTags::NEED_FOR_SPEED),
            new Subreddit(self::PLAY_AVENGERS, [new FlairQuery('Photomode')], FlairTags::AVENGERS),
            new Subreddit(self::RED_DEAD_REDEMPTION_2, [new SearchQuery('title:screenshot')], FlairTags::RED_DEAD_REDEMPTION),
            new Subreddit(self::SEKIRO, [new SearchQuery('title:screenshot')], FlairTags::SEKIRO_SHADOWS_DIE_TWICE),
            new Subreddit(self::SPIDERMAN_PS4, [
                new FlairQuery('Photo Mode'),
                new FlairQuery('Photo Mode/Screenshot'),
            ], FlairTags::SPIDERMAN),
            new Subreddit(self::STEEP, [new FlairQuery('Screenshot')], FlairTags::STEEP),
            new Subreddit(self::THE_CREW, [new FlairQuery('Photo')], FlairTags::THE_CREW),
            new Subreddit(self::THE_LAST_OF_US, [new FlairQuery('PT2 PHOTO MODE')], FlairTags::THE_LAST_OF_US),
            new Subreddit(self::THE_LAST_OF_US_2, [new SearchQuery('title:screenshot')], FlairTags::THE_LAST_OF_US),
            new Subreddit(self::THE_WITCHER_3, [new FlairQuery('Screenshot')], FlairTags::THE_WITCHER),
            new Subreddit(self::WITCHER, [new FlairQuery('Screenshot')], FlairTags::THE_WITCHER),
            new Subreddit(self::UNCHARTED, [new SearchQuery('title:screenshot')], FlairTags::UNCHARTED),
        ];
    }

}