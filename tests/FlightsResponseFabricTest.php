<?php declare(strict_types=1);

namespace tests;

use OpenSky\FlightFabricInterface;
use OpenSky\FlightsResponseFabric;
use PHPUnit\Framework\TestCase;

final class FlightsResponseFabricTest extends TestCase
{
    public function testCanOverwriteFlightFabric()
    {
        $fabric = new FlightsResponseFabric();
        $defaultFlightFabric = $fabric->getFlightFabric();
        $customFlightFabric = $this->createMock(FlightFabricInterface::class);
        $fabric->setFlightFabric($customFlightFabric);
        $this->assertInstanceOf($customFlightFabric::class, $fabric->getFlightFabric());
        $this->assertNotInstanceOf($defaultFlightFabric::class, $fabric->getFlightFabric());
    }
}
