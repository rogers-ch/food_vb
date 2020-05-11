<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');     //validation belongs in the model!  anything to do with data belongs in model

//Require data-layer file
require_once('model/data-layer.php');

//Instantiate the F3 Base class
$f3 = Base::instance();   //Base is a class; instance() is a static method in the Base class
                          // this becomes the object we use to run fatfree
                          //PHP uses double colon to call static methods

//Define a default route
$f3->route('GET /', function() {
    //echo '<h1>Welcome to my Food Page</h1>';

    $view = new Template();
    echo $view->render('views/home.html');
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
$f3->route('GET|POST /order', function($f3){      // |POST tells f3 it can access the order route via the Post method
                                                    // as well as the GET method.  And you can make a different route for
                                                    // POST /order if you want to.


    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);
        //array(2) { ["food"]=> string(5) "tacos" ["meal"]=> string(5) "lunch" }

        //validate food
        if (!validFood($_POST['food'])) {

            //Set an error variable in the F3 hive
            $f3->set("errors['food']", "Invalid food item");

        }
        //validate meal
        if (!validFood($_POST['meal'])) {

            //Set an error variable in the F3 hive
            $f3->set('errors["meal"]', "Invalid meal");

        }

        /*
        if(empty($_POST['food']) || !in_array($_POST['meal'], $meals)) {
            echo"<p>Please enter a food and select a meal</p>";
        }

        */

        //data is valid
        if(empty($f3->get('errors'))) {
            //Store the data in the session array - b/c this form is posting to self, and you don't want to lose data
            // when you go to the summary page
            $_SESSION['food'] = $_POST['food'];
            $_SESSION['meal'] = $_POST['meal'];

            //Redirect to summary page
            $f3->reroute('orderTwo');

        }

    }



    //add meals array to hive
    $f3->set('meals', getMeals());
    $f3->set('food', $_POST['food']);
    $f3->set('selectedMeal', $_POST['meal']);


    $view = new Template();
    echo $view->render("views/order.html");


});

//Order2 route
$f3->route('GET|POST /orderTwo', function($f3){

    //create a condiments array
    $condiments = getCondiments();

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);
        //array(2) { ["food"]=> string(5) "tacos" ["meal"]=> string(5) "lunch" }

        //validate the data
        //echo"<p>Order form two data valid.</p>";


        //data is valid - I haven't added validation yet


        //Store the data in the session array - b/c this form is posting to self, and you don't want to lose data
        // when you go to the summary page
        $_SESSION['condiments'] = $_POST['condiments'];

        //var_dump($_SESSION['condiments']);

        //Redirect to summary page
        $f3->reroute('summary');


    }


    //add meals array to hive
    $f3->set('condiments', $condiments);

    $view = new Template();
    echo $view->render("views/order2.html");


});



//Summary route
$f3->route('GET /summary', function() {
    //echo '<h1>Welcome to my summary</h1>';

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();   //to make sure we're starting with a blank slate the next time someone comes to place an order
    //any site shared on one domain shares the same session, so it's important to destroy the session when
    // you are done with it so you don't run into old data or data from a different app.

});


//Run F3
$f3->run();               // -> to run instance methods





