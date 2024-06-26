<?php declare(strict_types=1);

namespace OpenSky;

interface FlightFabricInterface
{
    public function buildOne(array $data): FlightInterface;

    /**
     * @param array<array> $data
     * @return FlightInterface[]
     */
    public function buildArray(array $data): array;
}