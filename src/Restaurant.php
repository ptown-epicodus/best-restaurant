<?php

require_once __DIR__.'/../src/Cuisine.php';

class Restaurant
{
    private $name;
    private $cuisine_id;
    private $id;

    function __construct($name, $cuisine_id, $id = null)
    {
        $this->name = $name;
        $this->cuisine_id = $cuisine_id;
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getCuisineId()
    {
        return $this->cuisine_id;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
    }


    static function getAll()
    {
        $returned_restaurants = $GLOBALS['DB']->query('SELECT * FROM restaurants;');

        $restaurants_array = [];
        foreach ($returned_restaurants as $restaurant) {
            $name = $restaurant['name'];
            $cuisine_id = $restaurant['cuisine_id'];
            $id = $restaurant['id'];
            $new_Restaurant = new Restaurant($name, $cuisine_id, $id);
            array_push($restaurants_array, $new_Restaurant);
        }
        return $restaurants_array;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec('DELETE FROM restaurants;');
    }

    static function find($search_id)
    {
        $return_restaurant = null;
        $results = Restaurant::getAll();
        foreach ($results as $result) {
            $restaurant_id = $result->getId();
            if ($restaurant_id == $search_id) {
                $return_restaurant = $result;
            }
        }
        return $return_restaurant;
    }
}




?>
