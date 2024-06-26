<?php declare(strict_types=1);

namespace OpenSky;

class StateFabric implements StateFabricInterface
{
    public function buildOne(array $data): StateInterface
    {
        $data[16] = PositionSource::from($data[16]);
        $data[17] = array_key_exists(17, $data) ? AircraftCategory::from($data[17]) : null;
        return new State(...$data);
    }

    /**
     * @inheritDoc
     */
    public function buildArray(array $data): array
    {
        return array_map([$this, 'buildOne'], $data);
    }
}