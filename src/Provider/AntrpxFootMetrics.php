<?php

namespace Antrpx\OAuth2\Client\Provider;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class AntrpxFootMetrics
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new feet metrics.
     *
     * @param array $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Get metrics creation datetime.
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getValueByKey($this->response, 'created');
    }

    /**
     * Get left feet length.
     *
     * @return string|null
     */
    public function getLeftFeetLength()
    {
        return $this->getValueByKey($this->response, 'l_length');
    }

    /**
     * Get left feet width.
     *
     * @return string|null
     */
    public function getLeftFeetWidth()
    {
        return $this->getValueByKey($this->response, 'l_width');
    }

    /**
     * Get right feet length.
     *
     * @return string|null
     */
    public function getRightFeetLength()
    {
        return $this->getValueByKey($this->response, 'r_length');
    }

    /**
     * Get right feet width.
     *
     * @return string|null
     */
    public function getRightFeetWidth()
    {
        return $this->getValueByKey($this->response, 'r_width');
    }

    /**
     * Get maximum feet length value.
     *
     * @return string|null
     */
    public function getMaxFeetLength()
    {
        return max(
            $this->getLeftFeetLength(),
            $this->getRightFeetLength()
        );
    }

    /**
     * Get maximum feet width value.
     *
     * @return string|null
     */
    public function getMaxFeetWidth()
    {
        return max(
            $this->getLeftFeetWidth(),
            $this->getRightFeetWidth()
        );
    }

    /**
     * Return all of the metrics available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}