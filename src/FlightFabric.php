<?php declare(strict_types=1);

namespace OpenSky;

class FlightFabric implements FlightFabricInterface
{
    public function buildOne(array $data): FlightInterface
    {
        return new Flight(
            $data['icao24'],
            $data['firstSeen'],
            $data['estDepartureAirport'],
            $data['lastSeen'],
            $data['estArrivalAirport'],
            $data['callsign'] ? trim($data['callsign']) : null,
            $data['estDepartureAirportHorizDistance'],
            $data['estDepartureAirportVertDistance'],
            $data['estArrivalAirportHorizDistance'],
            $data['estArrivalAirportVertDistance'],
            $data['departureAirportCandidatesCount'],
            $data['arrivalAirportCandidatesCount'],
        );
    }

    /**
     * @inheritDoc
     */
    public function buildArray(array $data): array
    {
        return array_map([$this, 'buildOne'], $data);
    }
}