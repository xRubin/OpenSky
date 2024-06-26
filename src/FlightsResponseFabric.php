<?php declare(strict_types=1);

namespace OpenSky;

class FlightsResponseFabric implements FlightsResponseFabricInterface
{
    private ?FlightFabricInterface $flightFabric = null;

    public function setFlightFabric(?FlightFabricInterface $flightFabric): void
    {
        $this->flightFabric = $flightFabric;
    }

    public function getFlightFabric(): ?FlightFabricInterface
    {
        if (null === $this->flightFabric) {
            $this->flightFabric = new FlightFabric();
        }
        return $this->flightFabric;
    }

    public function build(array $data): FlightsResponseInterface
    {
        return new FlightsResponse(
            $this->getFlightFabric()->buildArray($data)
        );
    }
}