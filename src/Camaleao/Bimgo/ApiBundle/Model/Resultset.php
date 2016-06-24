<?php

namespace Camaleao\Bimgo\ApiBundle\Model;
use JMS\Serializer\Annotation\Type;

class Resultset
{
    /**
     * @var int
     * @Type("integer")
     */
    private $count;

    /**
     * @var int
     * @Type("integer")
     */
    private $offset;

    /**
     * @var int
     * @Type("integer")
     */
    private $limit;


    /**
     * Resultset constructor.
     * @param int $count
     * @param int $offset
     * @param int $limit
     */
    public function __construct($count, $offset, $limit)
    {
        $this->count = $count;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}
