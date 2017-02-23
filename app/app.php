<?php

date_default_timezone_set('America/Los_Angeles');
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Cuisine.php';
require_once __DIR__.'/../src/Restaurant.php';

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), [ 'twig.path' => __DIR__ . '/../views/' ]);

$app['debug'] = true;

$server = 'mysql:host=localhost:8889;dbname=best_restaurant';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app->get('/', function() use ($app) {
    $cuisines = Cuisine::getAll();

    return $app['twig']->render('root.html.twig', array('cuisines' => $cuisines));
});

$app->post('/cuisines', function() use ($app) {
    $name = $_POST['name'];
    $new_cuisine = new Cuisine($name);
    $new_cuisine->save();

    return $app->redirect('/');
});

$app->post('/delete_cuisines', function() use ($app) {
    Cuisine::deleteAll();
    return $app->redirect('/');
});

$app->get('/cuisines/{id}', function($id) use ($app) {
    $cuisine = Cuisine::find($id);
    return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine));
});

$app->get('/cuisines/{id}/edit', function($id) use ($app) {
    $cuisine = Cuisine::find($id);
    return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
});

$app->patch('/cuisines/{id}', function($id) use ($app) {
    $name = $_POST['name'];
    $cuisine = Cuisine::find($id);
    $cuisine->update($name);
    return  $app->redirect("/cuisines/{$id}");
});

$app->post('/add_restaurant', function() use ($app) {
    $name = $_POST['name'];
    $cuisine_id = $_POST['cuisine'];

    $new_restaurant = new Restaurant($name, $cuisine_id);
    $new_restaurant->save();
    $restaurants = Restaurant::getAll();
    $cuisine = Cuisine::find($cuisine_id);

    return $app['twig']->render('restaurant.html.twig', array('restaurants' => $restaurants, 'cuisine' => $cuisine));
});

$app->delete('/cuisines/{id}', function($id) use ($app) {
    $cuisine = Cuisine::find($id);
    $cuisine->delete();
    return $app->redirect('/');
});

return $app;
?>
