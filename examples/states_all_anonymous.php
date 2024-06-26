<?php
require __DIR__ . '/../vendor/autoload.php';

$openSkyApi = new \OpenSky\OpenSkyApi();

echo "ICAO\tLongitude\tLatitude\n";
foreach ($openSkyApi->getStatesAll()->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}