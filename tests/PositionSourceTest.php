<?php declare(strict_types=1);

namespace tests;

use OpenSky\PositionSource;
use PHPUnit\Framework\TestCase;

final class PositionSourceTest extends TestCase
{
    public function testCheckCorrectLabels()
    {
        $this->assertEquals('ADS-B', PositionSource::ADSB->label());
        $this->assertEquals('ASTERIX', PositionSource::ASTERIX->label());
        $this->assertEquals('MLAT', PositionSource::MLAT->label());
        $this->assertEquals('FLARM', PositionSource::FLARM->label());
    }
}