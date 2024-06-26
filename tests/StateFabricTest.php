<?php declare(strict_types=1);

namespace tests;

use OpenSky\StateFabric;
use OpenSky\StateInterface;
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

    public function testAssociativeStateShouldThrowException()
    {
        $fabric = new StateFabric();
        $this->expectException(UnknownFormatException::class);
        $fabric->buildArray([
            ['invalid' => 'data']
        ]);
    }

    public function testStateWith18KeysShouldThrowException()
    {
        $fabric = new StateFabric();
        $this->expectException(UnknownFormatException::class);
        $fabric->buildArray([
            ['a1' => 'a1', 'a2' => 'a2', 'a3' => 'a3', 'a4' => 'a4',
                'a5' => 'a1', 'a6' => 'a2', 'a7' => 'a3', 'a8' => 'a4',
                'a9' => 'a1', 'a10' => 'a2', 'a11' => 'a3', 'a12' => 'a4',
                'a13' => 'a1', 'a14' => 'a2', 'a15' => 'a3', 'a16' => 'a4',
                'a17' => 'a1', 'a18' => 'a2'],
        ]);
    }

    public function testStateWithUnknownPositionShouldWork()
    {
        $fabric = new StateFabric();
        $result = $fabric->buildArray([
            ['ab1644', 'UAL1254 ', 'United States', 1717424052, 1717424053, -103.6191, 37.9322, 10789.92, false, 252.05, 139.22, 7.48, null, 11186.16, '3533', false, 99],
        ]);
        $this->assertIsArray($result);
        $this->assertContainsOnlyInstancesOf(StateInterface::class, $result);
    }
}