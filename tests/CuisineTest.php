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

}
?>
