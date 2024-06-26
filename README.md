# OpenSky REST API

PHP implementation for the [OpenSky Network](https://opensky-network.org/) REST API.
This library is based on the [REST API docs](https://opensky-network.org/apidoc/rest.html).

## Installation

With composer:
```
composer require rubin/opensky
```

## Usage

Create API connector:
```php
$openSkyApi = new \OpenSky\OpenSkyApi();
```

Set credentials (optional):
```php
$openSkyApi->setCredentials('{username}', '{password}');
```

Refer to the [limitations](https://opensky-network.org/apidoc/rest.html#limitations), to see why/when a user account would be preferred.

## Examples

Example query with time and aircraft: https://opensky-network.org/api/states/all?time=1458564121&icao24=3c6444
```php
echo "ICAO\tLongitude\tLatitude\n";
foreach ($openSkyApi->getStatesAll(time: 1458564121, icao24: '3c6444')->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}
```

Example query with bounding box covering Switzerland: https://opensky-network.org/api/states/all?lamin=45.8389&lomin=5.9962&lamax=47.8229&lomax=10.5226
```php
echo "ICAO\tLongitude\tLatitude\n";
foreach ($openSkyApi->getStatesAll(bBox: new \OpenSky\BoundingBox(45.8389, 47.8229, 5.9962, 10.5226))->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}
```

Retrieve states of two particular airplanes: https://opensky-network.org/api/states/all?icao24=3c6444&icao24=3e1bf9
```php
echo "ICAO\tLongitude\tLatitude\n";
foreach ($openSkyApi->getStatesAll(icao24: ['3c6444', '3e1bf9'])->getStates() as $state) {
    printf(
        "%s\t%f\t%f\n",
        $state->getIcao24(),
        $state->getLongitude(),
        $state->getLatitude()
    );
}
```

Get flights from 12pm to 1pm on Jan 29 2018: https://opensky-network.org/api/flights/all?begin=1517227200&end=1517230800
```php
echo "ICAO\tDep  - Arr\n";
foreach ($openSkyApi->getFlightsAll(begin: 1517227200, end: 1517230800)->getFlights() as $flight) {
    printf(
        "%s\t%s - %s\n",
        $flight->getIcao24(),
        $flight->getEstDepartureAirport() ?: '----',
        $flight->getEstArrivalAirport() ?: '----'
    );
}
```

Get flights for D-AIZZ (3c675a) on Jan 29 2018: https://opensky-network.org/api/flights/aircraft?icao24=3c675a&begin=1517184000&end=1517270400
```php
echo "ICAO\tDep  - Arr\n";
foreach ($openSkyApi->getFlightsAircraft(icao24: '3c675a', begin: 1517227200, end: 1517230800)->getFlights() as $flight) {
    printf(
        "%s\t%s - %s\n",
        $flight->getIcao24(),
        $flight->getEstDepartureAirport() ?: '----',
        $flight->getEstArrivalAirport() ?: '----'
    );
}
```

Get all flights arriving at Frankfurt International Airport (EDDF) from 12pm to 1pm on Jan 29 2018: https://opensky-network.org/api/flights/arrival?airport=EDDF&begin=1517227200&end=1517230800
```php
echo "ICAO\tDep  - Arr\n";
foreach ($openSkyApi->getFlightsArrival(airport: 'EDDF', begin: 1517227200, end: 1517230800)->getFlights() as $flight) {
    printf(
        "%s\t%s - %s\n",
        $flight->getIcao24(),
        $flight->getEstDepartureAirport() ?: '----',
        $flight->getEstArrivalAirport() ?: '----'
    );
}
```

Get all flights departing at Frankfurt International Airport (EDDF) from 12pm to 1pm on Jan 29 2018: https://opensky-network.org/api/flights/departure?airport=EDDF&begin=1517227200&end=1517230800
```php
echo "ICAO\tDep  - Arr\n";
foreach ($openSkyApi->getFlightsDeparture(airport: 'EDDF', begin: 1517227200, end: 1517230800)->getFlights() as $flight) {
    printf(
        "%s\t%s - %s\n",
        $flight->getIcao24(),
        $flight->getEstDepartureAirport() ?: '----',
        $flight->getEstArrivalAirport() ?: '----'
    );
}
```
