<?php

namespace Neoan3\Model;

use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\MockDatabaseWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest
 * @package Neoan3\Model
 */
class {{name}}Test extends TestCase
{
    /**
     * @var Database|MockDatabaseWrapper
     */
    private Database $mockDb;


    function setUp(): void
    {
        $this->mockDb = new MockDatabaseWrapper(['name'=>'test']);

    }


    /**
     * Test retrieval
     */
    public function testGet()
    {
        $model = $this->mockGet();
        {{name}}Model::init($this->mockDb);
        $res = {{name}}Model::get($model['id']);
        $this->assertIsArray($res);
        $this->assertSame($model, $res);
    }

    /**
     * Test update
     */
    public function testUpdate()
    {
        $model = $this->mockDb->mockModel('{{name.lower}}');
        $model[array_keys($model)[0]] = 'abc';
        $this->mockUpdate($model);
        {{name}}Model::init($this->mockDb);
        $result = {{name}}Model::update($model);
        $this->assertSame($result[array_keys($model)[0]], 'abc');
    }

    /**
     * Test creation
     */
    public function testCreate()
    {
        $model = $this->mockDb->mockModel('{{name.lower}}');
        $this->mockDb->registerResult([['id' => '123456789']]);
        $inserted = $this->mockUpdate($model);
        {{name}}Model::init($this->mockDb);
        $created = {{name}}Model::create($model);
        $this->assertSame($inserted, $created);
    }

    /**
     * @param null $entity
     * @return array|mixed
     */
    private function mockGet($entity=null)
    {
        $model = $this->mockDb->mockModel('{{name.lower}}');
        if($entity){
            $this->mockDb->registerResult([$entity]);
        } else {
            $this->mockDb->registerResult([$model]);
        }
        foreach ($model as $key => $value){
            if(is_array($value)){
                if($entity){
                    $this->mockDb->registerResult($entity[$key]);
                } else {
                    $this->mockDb->registerResult($model[$key]);
                }

            }
        }
        return $entity ? $entity : $model;
    }

    /**
     * @param $entity
     * @return array|mixed
     */
    private function mockUpdate($entity)
    {
        foreach ($entity as $potential => $values){
            if(is_array($values)){
                for($i = 0; $i < count($values); $i++){
                    $this->mockDb->registerResult('update');
                }
            }
        }
        $this->mockDb->registerResult('update main');

        return $this->mockGet($entity);
    }

}
