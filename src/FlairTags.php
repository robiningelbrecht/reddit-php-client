<?php


namespace Reddit;

final class FlairTags
{

    const ASSASSINS_CREED = '3a74a4e4-1386-11eb-bad5-0e53b2f36f2f';
    const AVENGERS = 'ca7b9b14-2683-11eb-aba6-0e73d60166f3';
    const BIOMUTANT = 'c0ea5426-baff-11eb-9f19-0e68a877affd';
    const BATMAN_ARKHAM = '9cab069e-1386-11eb-ab3e-0e5bf7b4c1f5';
    const CONTROL = '6c2c4b86-1386-11eb-a32d-0ecf1d66cec3';
    const DEATH_STRANDING = '98671802-1386-11eb-83b5-0e623984dfdf';
    const DEMONS_SOULS = 'e12a0d08-3008-11eb-9936-0eb51f0b2353';
    const FAR_CRY = '9f3c0e44-1386-11eb-bc3b-0eb683ee1559';
    const FORZA = '6c4c880e-142d-11eb-b1c7-0e4566b792d3';
    const GHOST_OF_TSUSHIMA = '6fed40fe-1386-11eb-af38-0e7cd2b87a4d';
    const GOD_OF_WAR = '73b0d796-1386-11eb-a931-0e4c63158eb1';
    const GRAN_TURISMO = '7c6ff626-142d-11eb-9404-0ed65ba41e01';
    const GTA = '6d27757a-16fa-11eb-a9ba-0e0da4f1aeff';
    const HORIZON_ZERO_DAWN = '7729344a-1386-11eb-a013-0e0104ae1b8f';
    const IMMORTALS_FENYX_RISNG = '75fe7364-3870-11eb-8c60-0e8009e4a0a5';
    const INFAMOUS = 'a17499d8-1386-11eb-970f-0eca7d5ae0df';
    const JEDI_FALLEN_ORDER = '8e723b1e-bb25-11eb-940e-0ea02b5f16df';
    const DBZ_KAKAROT = '7b45a914-1386-11eb-9945-0ee605b6d05f';
    const MAFIA = '7e070558-1386-11eb-afe8-0e1e31d786d7';
    const NEED_FOR_SPEED = 'a3d23474-1386-11eb-9dfe-0e588699d08d';
    const RED_DEAD_REDEMPTION = '826dc208-1386-11eb-ba93-0e0ddd231c49';
    const SEKIRO_SHADOWS_DIE_TWICE = '8f3f3958-1386-11eb-9cb2-0e8cfc42ca87';
    const SPIDERMAN = '91c27f96-1386-11eb-ac48-0ef1d74cb6ab';
    const STEEP = 'a905d2f2-1386-11eb-ad9c-0e4041179f95';
    const THE_CREW = 'a6b76100-1386-11eb-bad5-0e53b2f36f2f';
    const THE_LAST_OF_US = '859fa4a0-1386-11eb-bb7d-0e9e3d44b775';
    const THE_WITCHER = '8962a290-1386-11eb-a6fb-0e9a6f313aa9';
    const UNCHARTED = '8bb8574c-1386-11eb-8027-0ed11268cf8d';

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::ASSASSINS_CREED => 'Assassin\'s Creed',
            self::AVENGERS => 'Avengers',
            self::BIOMUTANT => 'Biomutant',
            self::BATMAN_ARKHAM => 'Batman Arkham',
            self::CONTROL => 'Control',
            self::DEATH_STRANDING => 'Death Stranding',
            self::DEMONS_SOULS => 'Demon\'s Souls',
            self::FAR_CRY => 'Far Cry',
            self::FORZA => 'Forza',
            self::GHOST_OF_TSUSHIMA => 'Ghost of Tsushima',
            self::GOD_OF_WAR => 'God of War',
            self::GRAN_TURISMO => 'Gran Turismo',
            self::GTA => 'GTA',
            self::HORIZON_ZERO_DAWN => 'Horizon Zero Dawn',
            self::IMMORTALS_FENYX_RISNG => 'Immortals Fenyx Rising',
            self::INFAMOUS => 'Infamous',
            self::JEDI_FALLEN_ORDER => 'Jedi: Fallen Order',
            self::DBZ_KAKAROT => 'DBZ Kakarot',
            self::MAFIA => 'Mafia',
            self::NEED_FOR_SPEED => 'Need for Speed',
            self::RED_DEAD_REDEMPTION => 'Red Dead Redemption',
            self::SEKIRO_SHADOWS_DIE_TWICE => 'Sekiro: Shadows Die Twice',
            self::SPIDERMAN => 'Spiderman',
            self::STEEP => 'Steep',
            self::THE_CREW => 'The Crew',
            self::THE_LAST_OF_US => 'The Last of Us',
            self::THE_WITCHER => 'The Witcher',
            self::UNCHARTED => 'Uncharted',
        ];
    }

    /**
     * @return array
     */
    public static function allAsSlug(): array
    {
        $all = [];

        foreach (self::all() as $flair_id => $label) {
            $all[$flair_id] = self::labelToSlug($label);
        }

        return $all;
    }

    public static function getFlairIdBySlug($slug): ?string
    {
        foreach (self::allAsSlug() as $flair_id => $s) {
            if ($slug == $s) {
                return $flair_id;
            }
        }

        return null;
    }

    /**
     * @param $label
     * @return string
     */
    public static function labelToSlug($label): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $label);;
    }

}