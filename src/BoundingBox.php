<?php declare(strict_types=1);

namespace OpenSky;

/**
 * Represents a bounding box of WGS84 coordinates (decimal degrees) that encompasses a certain area. It is defined
 * by a lower and upper bound for latitude and longitude.
 */
class BoundingBox
{
    /**
     * @param float $minLatitude
     * @param float $maxLatitude
     * @param float $minLongitude
     * @param float $maxLongitude
     */
    public function __construct(
        private readonly float $minLatitude,
        private readonly float $maxLatitude,
        private readonly float $minLongitude,
        private readonly float $maxLongitude,
    )
    {
    }

    /**
     * @return float
     */
    public function getMinLatitude(): float
    {
        return $this->minLatitude;
    }

    /**
     * @return float
     */
    public function getMaxLatitude(): float
    {
        return $this->maxLatitude;
    }

    /**
     * @return float
     */
    public function getMinLongitude(): float
    {
        return $this->minLongitude;
    }

    /**
     * @return float
     */
    public function getMaxLongitude(): float
    {
        return $this->maxLongitude;
    }
}
