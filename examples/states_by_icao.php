<?php
require __DIR__ . '/../vendor/autoload.php';

$openSkyApi = new \OpenSky\OpenSkyApi();

echo "ICAO\tLongitude\tLatitude\n";
foreach ($openSkyApi->getStatesAll(icao24: 'a6d83c')->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}

echo "-------------------------\n";

foreach ($openSkyApi->getStatesAll(icao24: ['a6d83c', '4bce16'])->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}