<?php declare(strict_types=1);

namespace tests;

use OpenSky\StateFabric;
use OpenSky\StateInterface;
use OpenSky\UnauthorizedException;
use OpenSky\UnknownFormatException;
use PHPUnit\Framework\TestCase;

final class StateFabricTest extends TestCase
{
    public function testCanBuildArrayOfStates()
    {
        $fabric = new StateFabric();
        $result = $fabric->buildArray([
            ['ab1644', 'UAL1254 ', 'United States', 1717424052, 1717424053, -103.6191, 37.9322, 10789.92, false, 252.05, 139.22, 7.48, null, 11186.16, '3533', false, 0]
        ]);
        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf(StateInterface::class, $result);
    }

    public function testInvalidStateShouldThrowException()
    {
        $fabric = new StateFabric();
        $this->expectException(UnknownFormatException::class);
        $fabric->buildArray([
            ['invalid', 'data']
        ]);
    }
}