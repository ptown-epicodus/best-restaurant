<?php

date_default_timezone_set('America/Los_Angeles');
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Cuisine.php';
require_once __DIR__.'/../src/Restaurant.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), [ 'twig.path' => __DIR__ . '/../views/' ]);

$app['debug'] = true;

$server = 'mysql:host=loclhost:8889;dbname=best_restaurant';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

$app->get('/', function() use ($app) {
    return $app['twig']->render('root.html.twig');
});

$app->post('/add_restaurant', function() use ($app) {
    $name = $_POST['name'];
    $cuisine_id = $_POST['cuisine'];

    $new_Restaurant = new Restaurant($name, $cuisine_id);

    return $app['twig']->render('root.html.twig', array('restaurant' => $restaurant));
});

return $app;
?>
