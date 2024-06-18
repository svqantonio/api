<?php

    function fieldError($field, $type) {
        if ($type == 'repeated') {
            $error = array(
                "status" => "error",
                "message" => $field . " already exists!"
            );
        } else if ($type == 'empty') {
            $error = array(
                "status" => "error",
                "message" => $field . " cant be empty!",
            );
        } else if ($type == 'notValid') {
            $error = array(
                "status" => "error",
                "message" => $field . " not valid.",
            );
        }
        return $error;
    }