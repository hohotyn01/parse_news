<?php

class Connect
{
    public static function mysqli() :object
    {
        $mysqli = new mysqli("mysql", "root", "mayor", "parser");

        if ($mysqli->connect_errno) {
            return "Error connected note valid: " . $mysqli->connect_error;
        }

        return $mysqli;
    }
}
