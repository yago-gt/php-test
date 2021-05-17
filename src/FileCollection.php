<?php

namespace Live\Collection;

/**
 * File Collection
 * 
 * @package Live\Collection
 */
class FileCollection implements CollectionInterface
{
    /**
     * Collection file path
     */
    protected $file, $data;

    /**
     * Save data to disk
     */
    protected function save()
    {
        fwrite($this->file, serialize($this->data));
    }

    /**
     * Constructor
     */
    public function __construct(string $filename)
    {
        if (file_exists($filename)) {
            $serialData = file_get_contents($filename);
        } else {
            $serialData = serialize([]);
            file_put_contents($filename, $serialData);
        }

        $this->data = unserialize($serialData);
        $this->file = fopen($filename, "w");
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        fclose($this->file);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$this->has($index)) {
            return $defaultValue;
        }

        return $this->data[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value)
    {
        $this->data[$index] = $value;
        $this->save();
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
        $this->save();
    }
}