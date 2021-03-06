<?php

/**
 * Class Validate
 * Contains the validatoin methods for my app
 * @author Corey Rogers
 * @version 1.0
 */
class Validate
{

    /*  Return a value indicating if food parameter is valid
        Valid foods are not empty and do not contain anything except letters
        @param String $food
        @return boolean
    */
    function validFood($food)
    {
        $food = str_replace(' ', '', $food);
        return !empty($food) && ctype_alpha($food);
    }

    /* for testing purposes only
    echo validFood("french fries") ? "yes<br>" : "no<br>";
    echo validFood("pizza") ? "yes<br>" : "no<br>";
    echo validFood("7-layer dip") ? "yes<br>" : "no<br>";
    echo validFood("") ? "yes<br>" : "no<br>";
    */

    /*  Return a value indicating if meal is valid
        Valid meals are breakfast, lunch, and dinner
        @param String $meal
        @return boolean
    */
    function validMeal($meal)
    {
        $meals = getMeals();
        return in_array($meal, $meals);
    }

    /* Return a value indicating if every value in
    the $selectedCondiments array is in the list of
    valid condiments.
    @param String[] $selectedCondiments
    @return boolean
     */
    function validCondiments($selectedCondiments)
    {
        $condiments = getCondiments();
        //print_r($selectedCondiments);
        //print_r($condiments);

        //We need to check each condiment in our array
        foreach ($selectedCondiments as $selected) {
            if (!in_array($selected, $condiments)) {
                return false;
            }
        }
        return true;
    }

    /*
    //for testing purposes only
    echo validMeal("breakfast") ? "yes<br>" : "no<br>";
    echo validMeal("") ? "yes<br>" : "no<br>";
    echo validMeal("dessert") ? "yes<br>" : "no<br>";
    echo validMeal("lunch") ? "yes<br>" : "no<br>";
    */

}