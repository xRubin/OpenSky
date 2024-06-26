<?php declare(strict_types=1);

namespace OpenSky;

interface FlightsResponseFabricInterface
{
    public function build(array $data): FlightsResponseInterface;
}