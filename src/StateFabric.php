<?php declare(strict_types=1);

namespace OpenSky;

class StateFabric implements StateFabricInterface
{
    public function buildOne(array $data): StateInterface
    {
        $keys = array_keys($data);
        if (!in_array(count($keys), [17, 18]))
            throw new UnknownFormatException("Unknown State format");

        if ($keys !== range(0, count($data) - 1))
            throw new UnknownFormatException("Unknown State format");

        $data[16] = array_key_exists(16, $data) ? PositionSource::tryFrom($data[16]) : null;
        if ($data[16] === null)
            $data[16] = PositionSource::from(0);

        $data[17] = array_key_exists(17, $data) ? AircraftCategory::tryFrom($data[17]) : null;

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