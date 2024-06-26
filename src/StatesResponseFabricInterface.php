<?php declare(strict_types=1);

namespace OpenSky;

interface StatesResponseFabricInterface
{
    public function build(array $data): StatesResponseInterface;
}