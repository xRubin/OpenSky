<?php declare(strict_types=1);

namespace OpenSky;

class FlightsResponse implements FlightsResponseInterface
{
    /**
     * @param array $flights
     */
    public function __construct(
        private readonly array $flights = []
    )
    {
    }

    public function getFlights(): array
    {
        return $this->flights;
    }
}