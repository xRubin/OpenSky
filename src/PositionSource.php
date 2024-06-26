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
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            static::ADSB => 'ADS-B',
            static::ASTERIX => 'ASTERIX',
            static::MLAT => 'MLAT',
            static::FLARM => 'FLARM',
        };
    }
}
