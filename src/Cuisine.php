<?php
class Cuisine
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
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

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO cuisines (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE cuisines SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
    }

    function getRestaurants()
    {
        $restaurants = array();
        $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
        foreach ($returned_restaurants as $restaurant) {
            $name = $restaurant['name'];
            $cuisine_id = $restaurant['cuisine_id'];
            $id = $restaurant['id'];
            $new_restaurant = new Restaurant($name, $cuisine_id, $id);
            array_push($restaurants, $new_restaurant);
        }
        return $restaurants;
    }

    static function getAll()
    {
        $returned_cuisines = $GLOBALS['DB']->query('SELECT * FROM cuisines;');
        $cuisines = [];
        foreach($returned_cuisines as $cuisine) {
            $name = $cuisine['name'];
            $id = $cuisine['id'];
            $new_cuisine = new Cuisine($name, $id);
            array_push($cuisines, $new_cuisine);
        }
        return $cuisines;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec('DELETE FROM cuisines');
    }

    static function find($search_id)
    {
        $found_cuisine = null;
        $cuisines = self::getAll();
        foreach($cuisines as $cuisine) {
            $cuisine_id = $cuisine->getId();
            if ($cuisine_id == $search_id) {
                $found_cuisine = $cuisine;
            }
        }
        return $found_cuisine;
    }
}
?>
