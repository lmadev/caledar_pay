<?php


namespace Lma;


class Iterator implements \Iterator
{
    /**
     * @var int
     */
    protected int $position;

    /**
     * @var array
     */
    public array $pay;

    /**
     * Iterator constructor.
     *
     */
    public function __construct()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->pay[$this->position];
    }

    public function prev()
    {
        --$this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->pay[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}