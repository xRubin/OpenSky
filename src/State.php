<?php declare(strict_types=1);

namespace OpenSky;

class State implements StateInterface
{
    public function __construct(
        private readonly string            $icao24,
        private readonly ?string           $callsign,
        private readonly string            $origin_country,
        private readonly ?int              $time_position,
        private readonly int               $last_contact,
        private readonly ?float            $longitude,
        private readonly ?float            $latitude,
        private readonly ?float            $baro_altitude,
        private readonly bool              $on_ground,
        private readonly ?float             $velocity,
        private readonly float             $true_track,
        private readonly ?float            $vertical_rate,
        private readonly ?array            $sensors,
        private readonly ?float            $geo_altitude,
        private readonly ?string           $squawk,
        private readonly bool              $spi,
        private readonly PositionSource    $position_source,
        private readonly ?AircraftCategory $category
    )
    {
    }

    public function getIcao24(): string
    {
        return $this->icao24;
    }

    public function getCallsign(): ?string
    {
        return is_string($this->callsign) ? trim($this->callsign) : null;
    }

    public function getOriginCountry(): string
    {
        return $this->origin_country;
    }

    public function getTimePosition(): ?int
    {
        return $this->time_position;
    }

    public function getLastContact(): int
    {
        return $this->last_contact;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getBaroAltitude(): ?float
    {
        return $this->baro_altitude;
    }

    public function isOnGround(): bool
    {
        return $this->on_ground;
    }

    public function getVelocity(): ?float
    {
        return $this->velocity;
    }

    public function getTrueTrack(): float
    {
        return $this->true_track;
    }

    public function getVerticalRate(): ?float
    {
        return $this->vertical_rate;
    }

    public function getSensors(): ?array
    {
        return $this->sensors;
    }

    public function getGeoAltitude(): ?float
    {
        return $this->geo_altitude;
    }

    public function getSquawk(): ?string
    {
        return $this->squawk;
    }

    public function isSpi(): bool
    {
        return $this->spi;
    }

    public function getPositionSource(): PositionSource
    {
        return $this->position_source;
    }

    /**
     * Only with extended param
     * @return AircraftCategory|null
     */
    public function getCategory(): ?AircraftCategory
    {
        return $this->category;
    }
}