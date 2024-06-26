<?php declare(strict_types=1);

namespace tests;

use OpenSky\BoundingBox;
use PHPUnit\Framework\TestCase;

final class BoundingBoxTest extends TestCase
{
    public function testCanConstructBoundingBox()
    {
        $bb = new BoundingBox(45.8389, 47.8229, 5.9962, 10.5226);
        $this->assertEquals(45.8389, $bb->getMinLatitude());
        $this->assertEquals(47.8229, $bb->getMaxLatitude());
        $this->assertEquals(5.9962, $bb->getMinLongitude());
        $this->assertEquals(10.5226, $bb->getMaxLongitude());
    }
}