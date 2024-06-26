<?php declare(strict_types=1);

namespace tests;

use OpenSky\FlightFabric;
use OpenSky\FlightInterface;
use PHPUnit\Framework\TestCase;

final class FlightFabricTest extends TestCase
{
    public function testCanBuildArrayOfFlights()
    {
        $fabric = new FlightFabric();
        $result = $fabric->buildArray([
            [
                'icao24' => '84630c',
                'firstSeen' => 1517229441,
                'estDepartureAirport' => null,
                'lastSeen' => 1517230681,
                'estArrivalAirport' => null,
                'callsign' => 'JJP120  ',
                'estDepartureAirportHorizDistance' => null,
                'estDepartureAirportVertDistance' => null,
                'estArrivalAirportHorizDistance' => null,
                'estArrivalAirportVertDistance' => null,
                'departureAirportCandidatesCount' => 0,
                'arrivalAirportCandidatesCount' => 0
            ]
        ]);
        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf(FlightInterface::class, $result);
    }
}