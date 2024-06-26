<?php declare(strict_types=1);

namespace OpenSky;

interface StateFabricInterface
{
    public function buildOne(array $data): StateInterface;

    /**
     * @param array<array> $data
     * @return StateInterface[]
     */
    public function buildArray(array $data): array;
}