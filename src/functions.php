<?php
namespace Calendar;

function cartesian_product(array $set) : array
{
    if (!$set) {
        return array(array());
    }
    $subset = array_shift($set);
    $cartesianSubset = cartesian_product($set);
    $result = array();
    foreach ($subset as $value) {
        foreach ($cartesianSubset as $p) {
            array_unshift($p, $value);
            $result[] = $p;
        }
    }
    return $result;
}