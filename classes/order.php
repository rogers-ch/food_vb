<?php

//Note: file name and class name do not have to be the same - different from Java!

class Order
{

    //Declare instance variables
    private $_food;     //private variables have an underscore - this is part of pair standards
    private $_meal;
    private $_condiments;

    /** Default constructor  ***NOTE: name of constructor very different from Java
     */
    public function __construct($food = "scrambled eggs",    //have to use __construct to define constructor
                                $meal = "breakfast",
                                $condiments = array("salt", "pepper"))   //***NOTE: for classes and functions curly braces line up, but for decisions and loops they offset
    {
        /*
         * ex:
         * if (example) {
         *
         * }
         */

        // you have to use the 'this' reference here, b/c the instance variables don't have global scope
        $this->setFood($food);   //this arrow is the php equivalent of the java '.' variable, but you don't put the $ before the actual variable!!
        $this->_meal = $meal;
        $this->_condiments = $condiments;

    }

    /** Set the food
     * @param $food the food
     */
    public function setFood($food)
    {
        $this->_food = $food;

    }

    /** Get the food
     *  @return the food
     */
    public function getFood()
    {
        return $this->_food;
    }


    /**
     * @return string
     */
    public function getMeal()
    {
        return $this->_meal;
    }

    /**
     * @param string $meal
     */
    public function setMeal($meal)
    {
        $this->_meal = $meal;
    }

    /**
     * @return array
     */
    public function getCondiments()
    {
        return $this->_condiments;
    }

    /**
     * @param array $condiments
     */
    public function setCondiments($condiments)
    {
        $this->_condiments = $condiments;
    }



    /** toString() returns a String representation
     * of an order object
     * @return
     */
    public function toString()      //NOTE: don't have to have a return type b/c php is loosely typed
    {
        $out = $this->_food . ", ";
        $out .= $this->_meal . ", ";

        if (!empty($this->_condiments)) {
            $out .= implode(" & ", $this->_condiments);
        }

        return $out;
    }


}

