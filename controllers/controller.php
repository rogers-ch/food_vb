<?php

/**
 * Class Controller
 * @author Corey Rogers
 * @version 1.0
 */
class Controller
{
    private $_f3; //router
    private $_validator;

    /**
     * Controller constructor.
     * @param $f3
     * @param $validator
     */
    public function __construct($f3, $validator)
    {
        $this->_f3 = $f3;
        $this->_validator = $validator;
    }

    /**
     * Display the default route
     */
    public function home()
    {
        //echo '<h1>Welcome to my Food Page</h1>';

        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Process the order route
     */
    public function order()
    {
        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);
            //array(2) { ["food"]=> string(5) "tacos" ["meal"]=> string(5) "lunch" }

            //validate food

            //EX: global $validator;
            if (!$this->_validator->validFood($_POST['food'])) {    //another way to get the variable is to declare global before the if statement
                // GLOBALS array has all the variables with class scope - to a variable with class scope in a function,
                // you can get it from the GLOBALS array or declare global _______ within the function (see Ex above)


                //Set an error variable in the F3 hive
                $this->_f3->set("errors['food']", "Invalid food item");

            }
            //validate meal
            if (!$this->_validator->validMeal($_POST['meal'])) {

                //Set an error variable in the F3 hive
                $this->_f3->set('errors["meal"]', "Invalid meal");

            }

            /*
            if(empty($_POST['food']) || !in_array($_POST['meal'], $meals)) {
                echo"<p>Please enter a food and select a meal</p>";
            }

            */

            //data is valid
            if(empty($this->_f3->get('errors'))) {

                /*
                //Store the data in the session array - b/c this form is posting to self, and you don't want to lose data
                // when you go to the summary page
                $_SESSION['food'] = $_POST['food'];
                $_SESSION['meal'] = $_POST['meal'];


                */

                //Create an order object
                $order = new Order();
                $order->setFood($_POST['food']);
                $order->setMeal($_POST['meal']);

                //Store the object in the session array
                $_SESSION['order'] = $order;

                //Redirect to Order Two page
                $this->_f3->reroute('orderTwo');

            }

        }



        //add meals array to hive
        $this->_f3->set('meals', getMeals());
        $this->_f3->set('food', $_POST['food']);
        $this->_f3->set('selectedMeal', $_POST['meal']);


        $view = new Template();
        echo $view->render("views/order.html");
    }

    /**
     * Process the second order page
     */
    public function orderTwo()
    {
        //create a condiments array
        $condiments = getCondiments();

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);
            //array(2) { ["food"]=> string(5) "tacos" ["meal"]=> string(5) "lunch" }

            //validate the data
            //echo"<p>Order form two data valid.</p>";


            //data is valid - I haven't added validation yet


            /*
            //Store the data in the session array - b/c this form is posting to self, and you don't want to lose data
            // when you go to the summary page
            $_SESSION['condiments'] = $_POST['condiments'];
            */

            //Add the data to the object in the session array
            $_SESSION['order']->setCondiments($_POST['condiments']);


            //var_dump($_SESSION['condiments']);

            //Redirect to summary page
            $this->_f3->reroute('summary');


        }


        //add meals array to hive
        $this->_f3->set('condiments', $condiments);

        $view = new Template();
        echo $view->render("views/order2.html");

    }

    /**
     * Display the summary page and destroy the session
     */
    public function summary()
    {
        //echo '<h1>Welcome to my summary</h1>';

        $view = new Template();
        echo $view->render('views/summary.html');

        session_destroy();   //to make sure we're starting with a blank slate the next time someone comes to place an order
        //any site shared on one domain shares the same session, so it's important to destroy the session when
        // you are done with it so you don't run into old data or data from a different app.
    }

}