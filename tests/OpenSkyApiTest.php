<?php declare(strict_types=1);

namespace tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use OpenSky\FlightInterface;
use OpenSky\FlightsResponseFabricInterface;
use OpenSky\FlightsResponseInterface;
use OpenSky\OpenSkyApi;
use OpenSky\PositionSource;
use OpenSky\StateInterface;
use OpenSky\StatesResponse;
use OpenSky\StatesResponseFabricInterface;
use OpenSky\StatesResponseInterface;
use OpenSky\TooManyRequestsException;
use OpenSky\UnauthorizedException;
use PHPUnit\Framework\TestCase;

final class OpenSkyApiTest extends TestCase
{
    public function testCanParseEmptyResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['time' => 1458564121, 'states' => null])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));
        $this->assertEquals(new StatesResponse(time: 1458564121), $openSkyApi->getStatesAll(1458564121));
    }

    public function testCanParseSingleStateResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['time' => 1458564121, 'states' => [['3c6444', 'DLH9LF  ', 'Germany', 1458564120, 1458564120, 6.1546, 50.1964, 9639.3, false, 232.88, 98.26, 4.55, null, 9547.86, '1000', false, 0]]])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));
        $response = $openSkyApi->getStatesAll(time: 1458564121, icao24: '3c6444');
        $this->assertInstanceOf(StatesResponseInterface::class, $response);
        $states = $response->getStates();
        $this->assertIsArray($states);

        $state = array_shift($states);
        $this->assertInstanceOf(StateInterface::class, $state);

        $this->assertIsString($state->getIcao24());
        $this->assertEquals('3c6444', $state->getIcao24());

        $this->assertIsString($state->getCallsign());
        $this->assertEquals('DLH9LF', $state->getCallsign());

        $this->assertEquals('Germany', $state->getOriginCountry());
        $this->assertEquals(1458564120, $state->getTimePosition());
        $this->assertEquals(1458564120, $state->getLastContact());

        $this->assertIsFloat($state->getLongitude());
        $this->assertIsFloat($state->getLatitude());

        $this->assertEquals(9639.3, $state->getBaroAltitude());
        $this->assertFalse($state->isOnGround());
        $this->assertEquals(232.88, $state->getVelocity());
        $this->assertEquals(98.26, $state->getTrueTrack());
        $this->assertEquals(4.55, $state->getVerticalRate());
        $this->assertNull($state->getSensors());
        $this->assertEquals(9547.86, $state->getGeoAltitude());
        $this->assertEquals('1000', $state->getSquawk());
        $this->assertFalse($state->isSpi());
        $this->assertEquals(PositionSource::ADSB, $state->getPositionSource());
        $this->assertNull($state->getCategory());

    }

    public function testCanParseMultipleStatesResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['time' => 1717424054, 'states' => [
                ['e49406', 'GLO1730 ', 'Brazil', 1717424053, 1717424053, -40.2792, -20.2613, -83.82, true, 25.21, 171.56, null, null, null, null, false, 0],
                ['4b1815', 'SWR252H ', 'Switzerland', 1717423722, 1717424053, 34.0327, 32.4949, 2042.16, false, 218.62, 229.68, -3.25, null, 4686.3, '3010', false, 0],
                ['ab1644', 'UAL1254 ', 'United States', 1717424052, 1717424053, -103.6191, 37.9322, 10789.92, false, 252.05, 139.22, 7.48, null, 11186.16, '3533', false, 0]
            ]])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getStatesOwn();
        $this->assertInstanceOf(StatesResponseInterface::class, $response);
        $this->assertEquals(1717424054, $response->getTime());
        $states = $response->getStates();
        $this->assertIsArray($states);

        $state = array_shift($states);
        $this->assertInstanceOf(StateInterface::class, $state);
        $this->assertEquals('e49406', $state->getIcao24());

        $state = array_shift($states);
        $this->assertInstanceOf(StateInterface::class, $state);
        $this->assertEquals('4b1815', $state->getIcao24());

        $state = array_shift($states);
        $this->assertInstanceOf(StateInterface::class, $state);
        $this->assertEquals('ab1644', $state->getIcao24());
    }

    public function testCanParseMultipleFlightsResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                ['icao24' => '84630c', 'firstSeen' => 1517229441, 'estDepartureAirport' => null, 'lastSeen' => 1517230681, 'estArrivalAirport' => null, 'callsign' => 'JJP120  ', 'estDepartureAirportHorizDistance' => null, 'estDepartureAirportVertDistance' => null, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 0, 'arrivalAirportCandidatesCount' => 0],
                ['icao24' => '800547', 'firstSeen' => 1517227477, 'estDepartureAirport' => 'VGTJ', 'lastSeen' => 1517228618, 'estArrivalAirport' => null, 'callsign' => 'JAI273  ', 'estDepartureAirportHorizDistance' => 6958, 'estDepartureAirportVertDistance' => 655, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 1, 'arrivalAirportCandidatesCount' => 0],
                ['icao24' => 'a403ca', 'firstSeen' => 1517228212, 'estDepartureAirport' => null, 'lastSeen' => 1517229651, 'estArrivalAirport' => null, 'callsign' => null, 'estDepartureAirportHorizDistance' => null, 'estDepartureAirportVertDistance' => null, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 0, 'arrivalAirportCandidatesCount' => 0],
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getFlightsAll(begin: 1517227200, end: 1517230800);
        $this->assertInstanceOf(FlightsResponseInterface::class, $response);
        $flights = $response->getFlights();
        $this->assertIsArray($flights);

        $flight = array_shift($flights);
        $this->assertInstanceOf(FlightInterface::class, $flight);
        $this->assertEquals('84630c', $flight->getIcao24());
        $this->assertEquals(1517229441, $flight->getFirstSeen());
        $this->assertNull($flight->getEstDepartureAirport());
        $this->assertEquals(1517230681, $flight->getLastSeen());
        $this->assertNull($flight->getEstArrivalAirport());
        $this->assertEquals('JJP120', $flight->getCallsign());
        $this->assertNull($flight->getEstDepartureAirportHorizDistance());
        $this->assertNull($flight->getEstDepartureAirportVertDistance());
        $this->assertNull($flight->getEstArrivalAirportHorizDistance());
        $this->assertNull($flight->getEstArrivalAirportVertDistance());
        $this->assertEquals(0, $flight->getDepartureAirportCandidatesCount());
        $this->assertEquals(0, $flight->getArrivalAirportCandidatesCount());
    }

    public function testCanParseFlightsAircraftResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                ['icao24' => '84630c', 'firstSeen' => 1517229441, 'estDepartureAirport' => null, 'lastSeen' => 1517230681, 'estArrivalAirport' => null, 'callsign' => 'JJP120  ', 'estDepartureAirportHorizDistance' => null, 'estDepartureAirportVertDistance' => null, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 0, 'arrivalAirportCandidatesCount' => 0],
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getFlightsAircraft(icao24: '84630c', begin: 1517227200, end: 1517230800);
        $this->assertInstanceOf(FlightsResponseInterface::class, $response);
        $flights = $response->getFlights();
        $this->assertIsArray($flights);
    }

    public function testCanParseFlightsArrivalResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                ['icao24' => '800547', 'firstSeen' => 1517227477, 'estDepartureAirport' => 'VGTJ', 'lastSeen' => 1517228618, 'estArrivalAirport' => 'EDDB', 'callsign' => 'JAI273  ', 'estDepartureAirportHorizDistance' => 6958, 'estDepartureAirportVertDistance' => 655, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 1, 'arrivalAirportCandidatesCount' => 1],
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getFlightsArrival(airport: 'EDDB', begin: 1517227200, end: 1517230800);
        $this->assertInstanceOf(FlightsResponseInterface::class, $response);
        $flights = $response->getFlights();
        $this->assertIsArray($flights);
    }

    public function testCanParseFlightsDepartureResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                ['icao24' => '800547', 'firstSeen' => 1517227477, 'estDepartureAirport' => 'VGTJ', 'lastSeen' => 1517228618, 'estArrivalAirport' => 'EDDB', 'callsign' => 'JAI273  ', 'estDepartureAirportHorizDistance' => 6958, 'estDepartureAirportVertDistance' => 655, 'estArrivalAirportHorizDistance' => null, 'estArrivalAirportVertDistance' => null, 'departureAirportCandidatesCount' => 1, 'arrivalAirportCandidatesCount' => 1],
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getFlightsDeparture(airport: 'VGTJ', begin: 1517227200, end: 1517230800);
        $this->assertInstanceOf(FlightsResponseInterface::class, $response);
        $flights = $response->getFlights();
        $this->assertIsArray($flights);
    }

    public function testUnauthorizedAccessShouldThrowException()
    {
        $mock = new MockHandler([
            new Response(401, [], json_encode([
                'timestamp' => time(),
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Bad credentials',
                'path' => '/states/all'
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));
        $openSkyApi->setCredentials('{username}', '{password}');

        $this->expectException(UnauthorizedException::class);
        $openSkyApi->getStatesAll();
    }

    public function testTooManyRequestsAccessShouldThrowException()
    {
        $mock = new MockHandler([
            new Response(429, [], json_encode([
                'timestamp' => time(),
                'status' => 429,
                'error' => 'Too Many Requests',
                'message' => 'Too Many Requests',
                'path' => '/states/all'
            ])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $this->expectException(TooManyRequestsException::class);
        $openSkyApi->getStatesAll();
    }

    public function testApiMissShouldThrowClientException()
    {
        $mock = new MockHandler([
            new Response(404, [], 'Not found' ),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $this->expectException(ClientException::class);
        $openSkyApi->getStatesAll();
    }

    public function testCanOverwriteClient()
    {
        $openSkyApi = new OpenSkyApi();
        $defaultClient = $openSkyApi->getClient();
        $customClient = $this->createMock(ClientInterface::class);
        $openSkyApi->setClient($customClient);
        $this->assertInstanceOf($customClient::class, $openSkyApi->getClient());
        $this->assertNotInstanceOf($defaultClient::class, $openSkyApi->getClient());
    }

    public function testCanOverwriteFlightsResponseFabric()
    {
        $openSkyApi = new OpenSkyApi();
        $defaultFlightsResponseFabric = $openSkyApi->getFlightsResponseFabric();
        $customFlightsResponseFabric = $this->createMock(FlightsResponseFabricInterface::class);
        $openSkyApi->setFlightsResponseFabric($customFlightsResponseFabric);
        $this->assertInstanceOf($customFlightsResponseFabric::class, $openSkyApi->getFlightsResponseFabric());
        $this->assertNotInstanceOf($defaultFlightsResponseFabric::class, $openSkyApi->getFlightsResponseFabric());
    }

    public function testCanOverwriteStatesResponseFabric()
    {
        $openSkyApi = new OpenSkyApi();
        $defaultStatesResponseFabric = $openSkyApi->getStatesResponseFabric();
        $customStatesResponseFabric = $this->createMock(StatesResponseFabricInterface::class);
        $openSkyApi->setStatesResponseFabric($customStatesResponseFabric);
        $this->assertInstanceOf($customStatesResponseFabric::class, $openSkyApi->getStatesResponseFabric());
        $this->assertNotInstanceOf($defaultStatesResponseFabric::class, $openSkyApi->getStatesResponseFabric());
    }
}
