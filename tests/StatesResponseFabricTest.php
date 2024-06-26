<?php declare(strict_types=1);

namespace tests;

use OpenSky\StateFabricInterface;
use OpenSky\StatesResponseFabric;
use PHPUnit\Framework\TestCase;

final class StatesResponseFabricTest extends TestCase
{
    public function testCanOverwriteStateFabric()
    {
        $fabric = new StatesResponseFabric();
        $defaultStateFabric = $fabric->getStateFabric();
        $customStateFabric = $this->createMock(StateFabricInterface::class);
        $fabric->setStateFabric($customStateFabric);
        $this->assertInstanceOf($customStateFabric::class, $fabric->getStateFabric());
        $this->assertNotInstanceOf($defaultStateFabric::class, $fabric->getStateFabric());
    }
}
