<?php declare(strict_types=1);

namespace tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use OpenSky\OpenSkyApi;
use OpenSky\StatesResponse;
use OpenSky\State;
use OpenSky\StatesResponseInterface;
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
        $this->assertEquals(new StatesResponse(1458564121, []), $openSkyApi->getStatesAll(1458564121));
    }

    public function testCanParseSingleStateResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['time' => 1458564121, 'states' => [["3c6444", "DLH9LF  ", "Germany", 1458564120, 1458564120, 6.1546, 50.1964, 9639.3, false, 232.88, 98.26, 4.55, null, 9547.86, "1000", false, 0]]])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));
        $response = $openSkyApi->getStatesAll(1458564121, icao24: "3c6444");
        $this->assertInstanceOf(StatesResponseInterface::class, $response);
        $states = $response->getStates();
        $this->assertIsArray($states);

        $state = array_shift($states);
        $this->assertInstanceOf(State::class, $state);

        $this->assertIsString($state->getIcao24());
        $this->assertEquals("3c6444", $state->getIcao24());

        $this->assertIsString($state->getCallsign());
        $this->assertEquals("DLH9LF", $state->getCallsign());

        $this->assertIsFloat($state->getLongitude());
        $this->assertIsFloat($state->getLatitude());
    }

    public function testCanParseMultipleStatesResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['time' => 1717424054, 'states' => [
                ["e49406", "GLO1730 ", "Brazil", 1717424053, 1717424053, -40.2792, -20.2613, -83.82, true, 25.21, 171.56, null, null, null, null, false, 0],
                ["4b1815", "SWR252H ", "Switzerland", 1717423722, 1717424053, 34.0327, 32.4949, 2042.16, false, 218.62, 229.68, -3.25, null, 4686.3, "3010", false, 0],
                ["ab1644", "UAL1254 ", "United States", 1717424052, 1717424053, -103.6191, 37.9322, 10789.92, false, 252.05, 139.22, 7.48, null, 11186.16, "3533", false, 0]
            ]])),
        ]);

        $openSkyApi = new OpenSkyApi();
        $openSkyApi->setClient(new Client(['handler' => HandlerStack::create($mock)]));

        $response = $openSkyApi->getStatesAll();
        $this->assertInstanceOf(StatesResponseInterface::class, $response);
        $states = $response->getStates();
        $this->assertIsArray($states);

        $state = array_shift($states);
        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals("e49406", $state->getIcao24());

        $state = array_shift($states);
        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals("4b1815", $state->getIcao24());

        $state = array_shift($states);
        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals("ab1644", $state->getIcao24());
    }

    public function testUnauthorizedAccessShouldReturnException()
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
}