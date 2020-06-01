<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Require data-layer file
require_once('model/data-layer.php');

//require_once('model/validate.php');     //validation belongs in the model!  anything to do with data belongs in model
//require_once('classes/order.php');  don't need this now b/c we updated composer

//Start a session   ***!!!DO this after the autoload so the classes will be loaded!!!
session_start();

//$order = new Order("tacos", "burgers", ["beers"]);
//echo $order->toString();



//Instantiate the F3 Base class
$f3 = Base::instance();   //Base is a class; instance() is a static method in the Base class
                          // this becomes the object we use to run fatfree
                          //PHP uses double colon to call static methods

//Instantiate a Validate object
$validator = new Validate;

//Instantiate a Controller object
$controller = new Controller($f3, $validator);

//Instantiate a Database object
$db = new Database();

//Define a default route
$f3->route('GET /', function() {
    $GLOBALS['controller']->home();
});

//Breakfast route
$f3->route('GET /breakfast', function() {
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/bfast.html');    //filename and route name don't have to be the same!
});

//Breakfast - green eggs & ham route
$f3->route('GET /breakfast/green-eggs', function() {
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/greenEggsAndHam.html');    //filename and route name don't have to be the same!
                                                        // you can match any route to any page
});

//Lunch route
$f3->route('GET /lunch', function() {
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/lunchView.html');    //filename and route name don't have to be the same!
    // you can match any route to any page
});

//Lunch - turkey panini route
$f3->route('GET /lunch/turkey-panini', function() {
    //echo '<h1>Welcome to my Breakfast Page</h1>';

    $view = new Template();
    echo $view->render('views/turkeysandwich.html');    //filename and route name don't have to be the same!
    // you can match any route to any page
});

//Order route
$f3->route('GET|POST /order', function(){      // |POST tells f3 it can access the order route via the Post method
                                                    // as well as the GET method.  And you can make a different route for
                                                    // POST /order if you want to.
    $GLOBALS['controller']->order();

});

//Order2 route
$f3->route('GET|POST /orderTwo', function(){

    $GLOBALS['controller']->orderTwo();

});



//Summary route
$f3->route('GET /summary', function() {

    $GLOBALS['controller']->summary();

});

//Display route
$f3->route('GET /display', function() {

    $GLOBALS['controller']->display();

});

//Run F3
$f3->run();               // -> to run instance methods





