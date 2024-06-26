<?php declare(strict_types=1);

namespace OpenSky;

enum AircraftCategory: int
{
    case NO_INFORMATION_AT_ALL = 0;
    case NO_ADSB_INFORMATION = 1;
    case LIGHT = 2;
    case SMALL = 3;
    case LARGE = 4;
    case HIGH_VORTEX_LARGE = 5;
    case HEAVY = 6;
    case HIGH_PERFORMANCE = 7;
    case ROTORCRAFT = 8;
    case GLIDER = 9;
    case LIGHTER_THAN_AIR = 10;
    case PARACHUTIST = 11;
    case ULTRALIGHT = 12;
    case RESERVED = 13;
    case UNMANNED_AERIAL_VEHICLE = 14;
    case TRANS_ATMOSPHERIC_VEHICLE = 15;
    case SURFACE_VEHICLE_EMERGENCY = 16;
    case SURFACE_VEHICLE_SERVICE = 17;
    case PONT_OBSTACLE = 18;
    case CLUSTER_OBSTACLE = 19;
    case LINE_OBSTACLE = 20;

    /**
     * @return string
     */
    public function label(): string
    {
        return self::getLabel($this);
    }

    /**
     * @param self $value
     * @return string
     */
    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NO_INFORMATION_AT_ALL => 'No information at all',
            self::NO_ADSB_INFORMATION => 'No ADS-B Emitter Category Information',
            self::LIGHT => 'Light (< 15500 lbs)',
            self::SMALL => 'Small (15500 to 75000 lbs)',
            self::LARGE => 'Large (75000 to 300000 lbs)',
            self::HIGH_VORTEX_LARGE => 'High Vortex Large (aircraft such as B-757)',
            self::HEAVY => 'Heavy (> 300000 lbs)',
            self::HIGH_PERFORMANCE => 'High Performance (> 5g acceleration and 400 kts)',
            self::ROTORCRAFT => 'Rotorcraft',
            self::GLIDER => 'Glider / sailplane',
            self::LIGHTER_THAN_AIR => 'Lighter-than-air',
            self::PARACHUTIST => 'Parachutist / Skydiver',
            self::ULTRALIGHT => 'Ultralight / hang-glider / paraglider',
            self::RESERVED => 'Reserved',
            self::UNMANNED_AERIAL_VEHICLE => 'Unmanned Aerial Vehicle',
            self::TRANS_ATMOSPHERIC_VEHICLE => 'Space / Trans-atmospheric vehicle',
            self::SURFACE_VEHICLE_EMERGENCY => 'Surface Vehicle – Emergency Vehicle',
            self::SURFACE_VEHICLE_SERVICE => 'Surface Vehicle – Service Vehicle',
            self::PONT_OBSTACLE => 'Point Obstacle (includes tethered balloons)',
            self::CLUSTER_OBSTACLE => 'Cluster Obstacle',
            self::LINE_OBSTACLE => 'Line Obstacle',
        };
    }
}
