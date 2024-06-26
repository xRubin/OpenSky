<?php declare(strict_types=1);

namespace tests;

use OpenSky\AircraftCategory;
use PHPUnit\Framework\TestCase;

final class AircraftCategoryTest extends TestCase
{
    public function testCheckCorrectLabels()
    {
        $this->assertEquals('No information at all', AircraftCategory::NO_INFORMATION_AT_ALL->label());
        $this->assertEquals('No ADS-B Emitter Category Information', AircraftCategory::NO_ADSB_INFORMATION->label());
        $this->assertEquals('Light (< 15500 lbs)', AircraftCategory::LIGHT->label());
        $this->assertEquals('Small (15500 to 75000 lbs)', AircraftCategory::SMALL->label());
        $this->assertEquals('Large (75000 to 300000 lbs)', AircraftCategory::LARGE->label());
        $this->assertEquals('High Vortex Large (aircraft such as B-757)', AircraftCategory::HIGH_VORTEX_LARGE->label());
        $this->assertEquals('Heavy (> 300000 lbs)', AircraftCategory::HEAVY->label());
        $this->assertEquals('High Performance (> 5g acceleration and 400 kts)', AircraftCategory::HIGH_PERFORMANCE->label());
        $this->assertEquals('Rotorcraft', AircraftCategory::ROTORCRAFT->label());
        $this->assertEquals('Glider / sailplane', AircraftCategory::GLIDER->label());
        $this->assertEquals('Lighter-than-air', AircraftCategory::LIGHTER_THAN_AIR->label());
        $this->assertEquals('Parachutist / Skydiver', AircraftCategory::PARACHUTIST->label());
        $this->assertEquals('Ultralight / hang-glider / paraglider', AircraftCategory::ULTRALIGHT->label());
        $this->assertEquals('Reserved', AircraftCategory::RESERVED->label());
        $this->assertEquals('Unmanned Aerial Vehicle', AircraftCategory::UNMANNED_AERIAL_VEHICLE->label());
        $this->assertEquals('Space / Trans-atmospheric vehicle', AircraftCategory::TRANS_ATMOSPHERIC_VEHICLE->label());
        $this->assertEquals('Surface Vehicle – Emergency Vehicle', AircraftCategory::SURFACE_VEHICLE_EMERGENCY->label());
        $this->assertEquals('Surface Vehicle – Service Vehicle', AircraftCategory::SURFACE_VEHICLE_SERVICE->label());
        $this->assertEquals('Point Obstacle (includes tethered balloons)', AircraftCategory::PONT_OBSTACLE->label());
        $this->assertEquals('Cluster Obstacle', AircraftCategory::CLUSTER_OBSTACLE->label());
        $this->assertEquals('Line Obstacle', AircraftCategory::LINE_OBSTACLE->label());
    }
}