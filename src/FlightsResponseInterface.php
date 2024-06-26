<?php declare(strict_types=1);

namespace OpenSky;

interface FlightsResponseInterface
{
    /**
     * @return array<FlightsResponseInterface>
     */
    public function getFlights(): array;
}