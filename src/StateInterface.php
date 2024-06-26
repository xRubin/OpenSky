<?php declare(strict_types=1);

namespace OpenSky;

interface StateInterface
{
    /**
     * Unique ICAO 24-bit address of the transponder in hex string representation.
     * @return string
     */
    public function getIcao24(): string;

    /**
     * Callsign of the vehicle (8 chars). Can be null if no callsign has been received.
     * @return string|null
     */
    public function getCallsign(): ?string;

    /**
     * Country name inferred from the ICAO 24-bit address.
     * @return string
     */
    public function getOriginCountry(): string;

    /**
     * Unix timestamp (seconds) for the last position update. Can be null if no position report was received
     * by OpenSky within the past 15s.
     * @return int|null
     */
    public function getTimePosition(): ?int;

    /**
     * Unix timestamp (seconds) for the last update in general. This field is updated for any new, valid message
     * received from the transponder.
     * @return int
     */
    public function getLastContact(): int;

    /**
     * WGS-84 longitude in decimal degrees. Can be null.
     * @return float|null
     */
    public function getLongitude(): ?float;

    /**
     * WGS-84 latitude in decimal degrees. Can be null.
     * @return float|null
     */
    public function getLatitude(): ?float;

    /**
     * Barometric altitude in meters. Can be null.
     * @return float|null
     */
    public function getBaroAltitude(): ?float;

    /**
     * Boolean value which indicates if the position was retrieved from a surface position report.
     * @return bool
     */
    public function isOnGround(): bool;

    /**
     * Velocity over ground in m/s. Can be null.
     * @return float|null
     */
    public function getVelocity(): ?float;

    /**
     * True track in decimal degrees clockwise from north (north=0°). Can be null.
     * @return float
     */
    public function getTrueTrack(): float;

    /**
     * Vertical rate in m/s. A positive value indicates that the airplane is climbing, a negative value
     * indicates that it descends. Can be null.
     * @return float|null
     */
    public function getVerticalRate(): ?float;

    /**
     * IDs of the receivers which contributed to this state vector. Is null if no filtering
     * for sensor was used in the request.
     * @return array|null
     */
    public function getSensors(): ?array;

    /**
     * Geometric altitude in meters. Can be null.
     * @return float|null
     */
    public function getGeoAltitude(): ?float;

    /**
     * The transponder code aka Squawk. Can be null.
     * @return string|null
     */
    public function getSquawk(): ?string;

    /**
     * Whether flight status indicates special purpose indicator.
     * @return bool
     */
    public function isSpi(): bool;

    /**
     * Origin of this state’s position.
     * @return PositionSource
     */
    public function getPositionSource(): PositionSource;

    /**
     * Aircraft category.
     * Only with extended param
     * @return AircraftCategory|null
     */
    public function getCategory(): ?AircraftCategory;
}