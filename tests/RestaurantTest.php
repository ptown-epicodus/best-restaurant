<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Restaurant.php';

$server = 'mysql:host=localhost:8889;dbname=best_restaurant_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class RestaurantTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
    }

    function test_getName()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name = 'Cheddars';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant = new Restaurant($name, $cuisine_id);
        $test_Restaurant->save();

        $result = $test_Restaurant->getName();

        $this->assertEquals('Cheddars', $result);
    }

    function test_getId()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name = 'Cheddars';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant = new Restaurant($name, $cuisine_id);
        $test_Restaurant->save();

        $result = $test_Restaurant->getId();

        $this->assertEquals(true, is_numeric($result));
    }

    function test_save()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name = 'Cheddars';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant = new Restaurant($name, $cuisine_id);
        $test_Restaurant->save();

        $result = Restaurant::getAll();

        $this->assertEquals($test_Restaurant, $result[0]);

    }

    function test_find()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name = 'Cheddars';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant = new Restaurant($name, $cuisine_id);
        $test_Restaurant->save();

        $result = Restaurant::find($test_Restaurant->getId());

        $this->assertEquals($test_Restaurant, $result);
    }

    function test_getAll()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name1 = 'Cheddars';
        $name2 = 'Red Robin';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant1 = new Restaurant($name1, $cuisine_id);
        $test_Restaurant2 = new Restaurant($name2, $cuisine_id);
        $test_Restaurant1->save();
        $test_Restaurant2->save();

        $result = Restaurant::getAll();

        $this->assertEquals([$test_Restaurant1, $test_Restaurant2], $result);
    }

    function test_deleteAll()
    {
        $cuisine_name = 'Mexican';
        $test_Cuisine = new Cuisine($cuisine_name);
        $test_Cuisine->save();

        $name1 = 'Cheddars';
        $name2 = 'Red Robin';
        $cuisine_id = $test_Cuisine->getId();
        $test_Restaurant1 = new Restaurant($name1, $cuisine_id);
        $test_Restaurant2 = new Restaurant($name2, $cuisine_id);
        $test_Restaurant1->save();
        $test_Restaurant2->save();

        Restaurant::deleteAll();
        $result = Restaurant::getAll();

        $this->assertEquals([], $result);
    }
}



?>
