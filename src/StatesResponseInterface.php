<?php declare(strict_types=1);

namespace OpenSky;

interface StatesResponseInterface
{
    public function getTime(): int;

    /**
     * @return array<StateInterface>
     */
    public function getStates(): array;
}