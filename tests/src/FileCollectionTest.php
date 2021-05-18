<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;

class FileCollectionTest extends TestCase
{
    const FILENAME = "test.collection";

    protected function tearDown(): void
    {
        unlink(self::FILENAME);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function objectCanBeConstructed()
    {
        $collection = new FileCollection(self::FILENAME);
        return $collection;
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @doesNotPerformAssertions
     */
    public function dataCanBeAdded()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);
        $collection->set('index4', 6.5);
        $collection->set('index5', ['data']);
    }

     /**
     * @test
     * @depends dataCanBeAdded
     */
    public function dataCanBeRetrieved()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index1', 'value');

        $this->assertEquals('value', $collection->get('index1'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function inexistentIndexShouldReturnDefaultValue()
    {
        $collection = new FileCollection(self::FILENAME);

        $this->assertNull($collection->get('index1'));
        $this->assertEquals('defaultValue', $collection->get('index1', 'defaultValue'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function newCollectionShouldNotContainItems()
    {
        $collection = new FileCollection(self::FILENAME);
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function collectionWithItemsShouldReturnValidCount()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index1', 'value');
        $collection->set('index2', 5);
        $collection->set('index3', true);

        $this->assertEquals(3, $collection->count());
    }

    /**
     * @test
     * @depends collectionWithItemsShouldReturnValidCount
     */
    public function collectionCanBeCleaned()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index', 'value');
        $this->assertEquals(1, $collection->count());

        $collection->clean();
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function addedItemShouldExistInCollection()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index', 'value');

        $this->assertTrue($collection->has('index'));
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function dataShouldBePersistent()
    {
        $collection = new FileCollection(self::FILENAME);
        $collection->set('index', 'value');

        $collection = new FileCollection(self::FILENAME);
        $this->assertEquals($collection->get('index'), 'value');
    }
}
