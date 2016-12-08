<?php

namespace App\Content;

use Log;

trait FieldTypeTrait {


    /**
     * Validate theme config field.
     *
     * @param Array $mandatoryKeys
     * @param Array $field
     *
     * @return True if valid, false otherwise.
     */
    public function validateFieldType($mandatoryKeys, $field) {

        foreach ($mandatoryKeys as $key => $value) {

            if ($value == 'string') {
                 if (!array_has($field, $key) || strlen($field[$key]) == 0) {
                    return false;
                }
            } else if ($value == 'array') {
                if (!array_has($field, $key) || !is_array($field[$key]) || count($field[$key]) == 0) {
                    return false;
                }
            } else if ($value == 'boolean') {
                if (!array_has($field, $key) || !is_bool($field[$key])) {
                    return false;
                }
            } else if ($value == 'number') {
                if (!array_has($field, $key) || !is_int($field[$key])) {
                    return false;
                }
            }
        }
        return true;
    }


}


