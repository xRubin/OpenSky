<?php declare(strict_types=1);

namespace OpenSky;

class StatesResponseFabric implements StatesResponseFabricInterface
{
    private ?StateFabricInterface $stateFabric = null;

    public function setStateFabric(?StateFabricInterface $stateFabric): void
    {
        $this->stateFabric = $stateFabric;
    }

    public function getStateFabric(): ?StateFabricInterface
    {
        if (null === $this->stateFabric) {
            $this->stateFabric = new StateFabric();
        }
        return $this->stateFabric;
    }

    public function build(array $data): StatesResponseInterface
    {
        return new StatesResponse(
            $data['time'],
            $this->getStateFabric()->buildArray($data['states'] ?: [])
        );
    }
}