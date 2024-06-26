<?php declare(strict_types=1);

namespace OpenSky;

class Flight implements FlightInterface
{
    /**
     * @param string $icao24
     * @param int $firstSeen
     * @param string|null $estDepartureAirport
     * @param int $lastSeen
     * @param string|null $estArrivalAirport
     * @param string|null $callsign
     * @param int|null $estDepartureAirportHorizDistance
     * @param int|null $estDepartureAirportVertDistance
     * @param int|null $estArrivalAirportHorizDistance
     * @param int|null $estArrivalAirportVertDistance
     * @param int $departureAirportCandidatesCount
     * @param int $arrivalAirportCandidatesCount
     */
    public function __construct(
        private readonly string  $icao24,
        private readonly int     $firstSeen,
        private readonly ?string  $estDepartureAirport,
        private readonly int     $lastSeen,
        private readonly ?string $estArrivalAirport,
        private readonly ?string  $callsign,
        private readonly ?int     $estDepartureAirportHorizDistance,
        private readonly ?int     $estDepartureAirportVertDistance,
        private readonly ?int    $estArrivalAirportHorizDistance,
        private readonly ?int    $estArrivalAirportVertDistance,
        private readonly int     $departureAirportCandidatesCount,
        private readonly int     $arrivalAirportCandidatesCount
    )
    {
    }

    /**
     * @return string
     */
    public function getIcao24(): string
    {
        return $this->icao24;
    }

    /**
     * @return int
     */
    public function getFirstSeen(): int
    {
        return $this->firstSeen;
    }

    /**
     * @return string|null
     */
    public function getEstDepartureAirport(): ?string
    {
        return $this->estDepartureAirport;
    }

    /**
     * @return int
     */
    public function getLastSeen(): int
    {
        return $this->lastSeen;
    }

    /**
     * @return string|null
     */
    public function getEstArrivalAirport(): ?string
    {
        return $this->estArrivalAirport;
    }

    /**
     * @return string|null
     */
    public function getCallsign(): ?string
    {
        return $this->callsign;
    }

    /**
     * @return int|null
     */
    public function getEstDepartureAirportHorizDistance(): ?int
    {
        return $this->estDepartureAirportHorizDistance;
    }

    /**
     * @return int|null
     */
    public function getEstDepartureAirportVertDistance(): ?int
    {
        return $this->estDepartureAirportVertDistance;
    }

    /**
     * @return int|null
     */
    public function getEstArrivalAirportHorizDistance(): ?int
    {
        return $this->estArrivalAirportHorizDistance;
    }

    /**
     * @return int|null
     */
    public function getEstArrivalAirportVertDistance(): ?int
    {
        return $this->estArrivalAirportVertDistance;
    }

    /**
     * @return int
     */
    public function getDepartureAirportCandidatesCount(): int
    {
        return $this->departureAirportCandidatesCount;
    }

    /**
     * @return int
     */
    public function getArrivalAirportCandidatesCount(): int
    {
        return $this->arrivalAirportCandidatesCount;
    }
}