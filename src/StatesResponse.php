<?php declare(strict_types=1);

namespace OpenSky;

class StatesResponse implements StatesResponseInterface
{
    /**
     * @param int $time
     * @param array<StateInterface> $states
     */
    public function __construct(
        private readonly int   $time,
        private readonly array $states = []
    )
    {
    }

    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @inheritdoc
     */
    public function getStates(): array
    {
        return $this->states;
    }
}