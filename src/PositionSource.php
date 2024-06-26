<?php declare(strict_types=1);

namespace OpenSky;

enum PositionSource: int
{
    case ADSB = 0;
    case ASTERIX = 1;
    case MLAT = 2;
    case FLARM = 3;

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::ADSB => 'ADS-B',
            self::ASTERIX => 'ASTERIX',
            self::MLAT => 'MLAT',
            self::FLARM => 'FLARM',
        };
    }
}
