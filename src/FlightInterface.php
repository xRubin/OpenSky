<?php declare(strict_types=1);

namespace OpenSky;

interface FlightInterface
{
    public function getIcao24(): string;

    public function getFirstSeen(): int;

    public function getEstDepartureAirport(): ?string;

    public function getLastSeen(): int;

    public function getEstArrivalAirport(): ?string;

    public function getCallsign(): ?string;

    public function getEstDepartureAirportHorizDistance(): ?int;

    public function getEstDepartureAirportVertDistance(): ?int;

    public function getEstArrivalAirportHorizDistance(): ?int;

    public function getEstArrivalAirportVertDistance(): ?int;

    public function getDepartureAirportCandidatesCount(): int;

    public function getArrivalAirportCandidatesCount(): int;
}