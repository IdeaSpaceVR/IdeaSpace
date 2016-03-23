<?php

function nearest_power_of_two($value) {

    return pow(2, round(log($value) / M_LN2));
}


function is_power_of_two($value) {
    return ($value & ($value - 1)) === 0 && $value !== 0;
}


