<?php

// validate a color
function validColor($color)
{
    global  $f3;
    return in_array($color,$f3->get('colors'));
}

function validString($animal)
{
    return ($animal!= null && ctype_alpha($animal));
}


function validQty($qty)
{
    return !empty($qty) && ctype_digit($qty) && $qty >= 1;
}

/* Validate petName Checkboxes
 *
 * @param String petName
 * @return boolean
 */
function validName($petname)
{
    global $f3;
    //names are optional
    if (empty($petname)) {
        return true;
    }
    //But if there are names, we need to make sure they're valid
    foreach ($petname as $pname) {
        if (!in_array($pname, $f3->get('petname'))) {
            return false;
        }
    }
    //If we're still here, then we have valid names
    return true;
}