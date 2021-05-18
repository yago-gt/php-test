<?php

namespace Live\Collection;

/**
 * Memory collection
 *
 * @package Live\Collection
 */
class MemoryCollection implements CollectionInterface
{
    const DEFAULT_TIME = 3600;

    /**
     * Collection data
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$this->has($index)) {
            return $defaultValue;
        }

        [$value, $time] = $this->data[$index];

        if ($time <= time()) {
            return $defaultValue;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value, int $time = null)
    {
        if ($time === null) {
            $time = time() + self::DEFAULT_TIME;
        }

        $this->data[$index] = [$value, $time];
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function clean()
    {
        $this->data = [];
    }
}
