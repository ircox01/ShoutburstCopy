<?php

interface SB_PT
{
    const PT_FIFO = 1;
    const PT_LIFO = 2;
    const PT_CUSTOM = 3;
}

class SB_Priority
{
    const start = 1000;

    private $type = SB_PT::PT_FIFO;

    private $next = self::start;
    private $items = array();

    public function __construct()
    {
    }

    private function incNext()
    {
        switch ($this->type)
        {
            case SB_PT::PT_FIFO:
                $this->next++;
                break;

            case SB_PT::PT_LIFO:
                $this->next--;
                break;

            default:
                $this->next++;
        }

        return $this->next;
    }

    public function add($name, $value = null)
    {
        if ( $value && ($this->type == SB_PT::PT_CUSTOM) )
        {
            $this->items[$name] = self::start + $value;
        }
        else
        {
            if ($this->type == SB_PT::PT_CUSTOM) $this->next = $this->max();

            $this->items[$name] = $this->incNext();
        }
    }

    public function get($name)
    {
        return $this->items[$name];
    }

    public function items()
    {
        return $this->items;
    }

    public function clear()
    {
        $this->items = array();
    }

    public function min()
    {
        return empty($this->items) ? self::start : min(array_values($this->items));
    }

    public function max()
    {
        return empty($this->items) ? self::start : max(array_values($this->items));
    }

    public function getChain()
    {
        $chain = $this->items;
        asort($chain);
        return array_keys($chain);
    }

    public function setType($value)
    {
        if ($value == $this->type) return;

        switch ($value)
        {
            case SB_PT::PT_FIFO:
                $this->next = $this->max();
                break;
            case SB_PT::PT_LIFO:
                $this->next = $this->min();
                break;
            case SB_PT::PT_CUSTOM:

                break;
        }
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }
}
