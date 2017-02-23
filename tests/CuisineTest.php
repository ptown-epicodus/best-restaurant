<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Cuisine.php';

$server = 'mysql:host=localhost:8889;dbname=best_restaurant_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class CuisineTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Cuisine::deleteAll();
    }

    function test_getId()
    {
        //Arrange
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();

        //Act
        $result = $test_Cuisine->getId();

        //Assert
        $this->assertEquals(true, is_numeric($result));
    }

    function test_getName()
    {
        //Arrange
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();

        //Act
        $result = $test_Cuisine->getName();

        //Assert
        $this->assertEquals('Mexican', $result);
    }

    function test_save()
    {
        //Arrange
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();

        //Act
        $result = Cuisine::getAll();

        //Assert
        $this->assertEquals($test_Cuisine, $result[0]);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'Mexican';
        $name2 = 'Chinese';
        $test_Cuisine1 = new Cuisine($name1);
        $test_Cuisine1->save();
        $test_Cuisine2 = new Cuisine($name2);
        $test_Cuisine2->save();

        //Act
        $result = Cuisine::getAll();

        //Assert
        $this->assertEquals([$test_Cuisine1, $test_Cuisine2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'Mexican';
        $name2 = 'Chinese';
        $test_Cuisine1 = new Cuisine($name1);
        $test_Cuisine1->save();
        $test_Cuisine2 = new Cuisine($name2);
        $test_Cuisine2->save();

        //Act
        Cuisine::deleteAll();
        $result = Cuisine::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();

        //Act
        $result = Cuisine::find($test_Cuisine->getId());

        //Assert
        $this->assertEquals($test_Cuisine, $result);
    }

    function testUpdate()
    {
        //Arrange
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();

        $new_name = 'Chinese';

        //Act
        $test_Cuisine->update($new_name);

        //Assert
        $this->assertEquals('Chinese', $test_Cuisine->getName());
    }

    function testDelete()
    {
        //Arrange
        $name1 = 'Mexican';
        $test_Cuisine1 = new Cuisine($name1);
        $test_Cuisine1->save();

        $name2 = 'Chinese';
        $test_Cuisine2 = new Cuisine($name2);
        $test_Cuisine2->save();

        //Act
        $test_Cuisine1->delete();

        //Assert
        $this->assertEquals([$test_Cuisine2], Cuisine::getAll());
    }

    function test_getRestaurants()
    {
        $name = 'Mexican';
        $test_Cuisine = new Cuisine($name);
        $test_Cuisine->save();
        $test_c_id = $test_Cuisine->getId();

        $name2 = 'Chinese';
        $test_Cuisine2 = new Cuisine($name2);
        $test_Cuisine2->save();
        $test_c_id2 = $test_Cuisine2->getId();

        $restaurant = 'Cheddars';
        $test_restaurant = new Restaurant($restaurant, $test_c_id);
        $test_restaurant->save();

        $restaurant2 = 'Red Robin';
        $test_restaurant2 = new Restaurant($restaurant, $test_c_id);
        $test_restaurant2->save();

        $restaurant3 = 'Subway';
        $test_restaurant3 = new Restaurant($restaurant3, $test_c_id2);
        $test_restaurant3->save();

        $result = $test_Cuisine->getRestaurants();

        $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
    }
}
?>
