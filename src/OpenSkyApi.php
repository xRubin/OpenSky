<?php declare(strict_types=1);

namespace OpenSky;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Query;
use Psr\Http\Message\ResponseInterface;

class OpenSkyApi
{
    private ?ClientInterface $client = null;
    private ?FlightsResponseFabricInterface $flightsResponseFabric = null;
    private ?StatesResponseFabricInterface $statesResponseFabric = null;
    private ?array $credentials = null;

    /**
     * @param string $username
     * @param string $password
     * @return void
     */
    public function setCredentials(string $username, string $password): void
    {
        $this->credentials = [$username, $password];
    }

    /**
     * @param ClientInterface|null $client
     * @return void
     */
    public function setClient(?ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        if (null === $this->client) {
            $this->client = new Client(['base_uri' => 'https://opensky-network.org/api']);
        }
        return $this->client;
    }

    public function setFlightsResponseFabric(?FlightsResponseFabricInterface $flightsResponseFabric): void
    {
        $this->flightsResponseFabric = $flightsResponseFabric;
    }

    /**
     * @return FlightsResponseFabricInterface
     */
    public function getFlightsResponseFabric(): FlightsResponseFabricInterface
    {
        if (null === $this->flightsResponseFabric) {
            $this->flightsResponseFabric = new FlightsResponseFabric();
        }
        return $this->flightsResponseFabric;
    }

    /**
     * @param StatesResponseFabricInterface|null $statesResponseFabric
     * @return void
     */
    public function setStatesResponseFabric(?StatesResponseFabricInterface $statesResponseFabric): void
    {
        $this->statesResponseFabric = $statesResponseFabric;
    }

    /**
     * @return StatesResponseFabricInterface
     */
    public function getStatesResponseFabric(): StatesResponseFabricInterface
    {
        if (null === $this->statesResponseFabric) {
            $this->statesResponseFabric = new StatesResponseFabric();
        }
        return $this->statesResponseFabric;
    }

    /**
     * @param int|null $time
     * @param string|array|null $icao24
     * @param BoundingBox|null $bBox
     * @param int $extended
     * @return StatesResponse
     */
    public function getStatesAll(?int $time = null, string|array|null $icao24 = null, ?BoundingBox $bBox = null, int $extended = 0): StatesResponse
    {
        $response = $this->getResponse(
            '/api/states/all',
            $this->buildQueryString([
                'time' => $time,
                'icao24' => is_null($icao24) ? null : (is_string($icao24) ? $icao24 : implode('&icao24=', $icao24)),
                'lamin' => $bBox?->getMinLatitude(),
                'lomin' => $bBox?->getMinLongitude(),
                'lamax' => $bBox?->getMaxLatitude(),
                'lomax' => $bBox?->getMaxLongitude(),
                'extended' => $extended
            ])
        );

        return $this->getStatesResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param int|null $time
     * @param string|array|null $icao24
     * @param int|array|null $serials
     * @return StatesResponse
     */
    public function getStatesOwn(?int $time = null, string|array|null $icao24 = null, int|array|null $serials = null): StatesResponse
    {
        $response = $this->getResponse(
            '/api/states/own',
            $this->buildQueryString([
                'time' => $time,
                'icao24' => is_null($icao24) ? null : (is_string($icao24) ? $icao24 : implode('&icao24=', $icao24)),
                'serials' => is_null($serials) ? null : (is_int($serials) ? $serials : implode('&serials=', $serials)),
            ])
        );

        return $this->getStatesResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param int $begin
     * @param int $end
     * @return FlightsResponse
     */
    public function getFlightsAll(int $begin, int $end): FlightsResponse
    {
        $response = $this->getResponse(
            '/api/flights/all',
            $this->buildQueryString([
                'begin' => $begin,
                'end' => $end,
            ])
        );

        return $this->getFlightsResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param string $icao24
     * @param int $begin
     * @param int $end
     * @return FlightsResponse
     */
    public function getFlightsAircraft(string $icao24, int $begin, int $end): FlightsResponse
    {
        $response = $this->getResponse(
            '/api/flights/aircraft',
            $this->buildQueryString([
                'icao24' => $icao24,
                'begin' => $begin,
                'end' => $end,
            ])
        );

        return $this->getFlightsResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param string $airport
     * @param int $begin
     * @param int $end
     * @return FlightsResponse
     */
    public function getFlightsArrival(string $airport, int $begin, int $end): FlightsResponse
    {
        $response = $this->getResponse(
            '/api/flights/arrival',
            $this->buildQueryString([
                'airport' => $airport,
                'begin' => $begin,
                'end' => $end,
            ])
        );

        return $this->getFlightsResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param string $airport
     * @param int $begin
     * @param int $end
     * @return FlightsResponse
     */
    public function getFlightsDeparture(string $airport, int $begin, int $end): FlightsResponse
    {
        $response = $this->getResponse(
            '/api/flights/departure',
            $this->buildQueryString([
                'airport' => $airport,
                'begin' => $begin,
                'end' => $end,
            ])
        );

        return $this->getFlightsResponseFabric()->build(
            json_decode((string)$response->getBody(), true)
        );
    }

    /**
     * @param array $params
     * @return string
     */
    protected function buildQueryString(array $params): string
    {
        return Query::build(array_filter($params, fn($val) => $val !== null || $val !== false), false);
    }

    /**
     * @param string $uri
     * @param string $query
     * @return ResponseInterface
     */
    protected function getResponse(string $uri = '', string $query = ''): ResponseInterface
    {
        try {
            $response = $this->getClient()->request('GET', $uri, [
                'query' => $query,
                'auth' => $this->credentials,
            ]);
            $response->getBody()->rewind();
            return $response;
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401)
                throw new UnauthorizedException("Unauthorized");

            if ($e->getResponse()->getStatusCode() === 429)
                throw new TooManyRequestsException("Too Many Requests");

            throw $e;
        }
    }
}