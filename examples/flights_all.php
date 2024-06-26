<?php
require __DIR__ . '/../vendor/autoload.php';

$openSkyApi = new \OpenSky\OpenSkyApi();

echo "ICAO\tDep  - Arr\n";
foreach ($openSkyApi->getFlightsAll(1517227200, 1517230800)->getFlights() as $flight) {
    printf(
        "%s\t%s - %s\n",
        $flight->getIcao24(),
        $flight->getEstDepartureAirport() ?: '----',
        $flight->getEstArrivalAirport() ?: '----'
    );
}