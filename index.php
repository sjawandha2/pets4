<?php
/**
 *index.php
 *
 */

//Start session
session_start();

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors;', TRUE);

//Require the autoload file
require_once('vendor/autoload.php');

require_once('model/validation-functions.php');


//Create an instance of the Base class
$f3 = Base::instance();

$f3->set('colors', array('pink','green','blue'));
$f3->set('petname', array('Bella','Oscer','Ruby','Coco','Daisy','Max','Alfie'));


//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function()
{
    echo"<h1>my Pets</h1><br><p><a href='order'>Order a pet</a></p>";

});

$f3->route('GET|POST /order', function($f3)
{
        $_SESSION = array();
         $isValid = true;
        if(!empty($_POST)) {

            //get data from form
            $animal = $_POST['animal'];
            $qty = $_POST['qty'];

            //add data to hive
            $f3->set('qty', $qty);
            $f3->set('animal', $animal);

                if (validString($animal))
                {
                    $_SESSION['animal'] = $animal;
                }
                else
                {
                    $f3->set("errors['animal']","Please enter an animal");
                    $isValid = false;

                }

                if (validQty($qty)) //if data is valid
                {
                    $_SESSION['qty'] = $qty;
                    print_r($qty);

                }
                else
                {
                    $f3->set("errors['qty']","Please enter the quantity");
                    $isValid = false;

                }
            if ($isValid)
            {
                //redirect to next form
                $f3->reroute('/order2');
            }

        }
    //Display a view
    $view = new Template();
    echo $view->render('views/form1.html');

});

$f3->route('GET|POST /order2', function($f3)
{
    $isValid = true;
    if(!empty($_POST))
    {

        $color = $_POST['color'];
        $pname = $_POST['pname'];

    //add data to hive
    $f3->set('color', $color);
    $f3->set('pname', $pname);
        if (validColor($color))
        {
            $_SESSION['color'] = $color;
        }
        else
        {
            $f3->set("errors['color']","Please enter a valid color");
            $isValid = false;

        }

        if (validName($pname))
        {
            $_SESSION['pname'] = $pname;
            if (empty($pname)) {
                $_SESSION['pname'] = "No Names selected";
            }
            else {
                $_SESSION['pname'] = implode(', ', $pname);
            }
        }
        else
        {
            $f3->set("errors['pname']","Invalid Choice");
            $isValid = false;

        }

        if($isValid)
        {
            //redirect to next form
            $f3->reroute('/results');
        }

    }
    $view = new Template();
    echo $view->render('views/form2.html');

});
//Define a Lunch route with a parameter
$f3->route('GET /@animal', function($f3,$params)
{
    $animal = $params['animal'];
    switch($animal)
    {
        case 'chicken':
            echo "Cluck!";
            break;

        case 'dog':
            echo "Wuff!";
            break;

        case 'Cat':
            echo "Meow!";
            break;

        case 'pig':
            echo "Oink!";
            break;

        case 'wolf':
            echo "Ouuuuu!";
            break;

        default:
            $f3->error(404);
    }
});

$f3->route('GET|POST /results', function()
{
    //Display a view
    $view = new Template();
    echo $view->render('views/results.html');

});

//Run fat free
$f3->run();