<?php

$sector = "X";

if (preg_match("/^[A-Za-z]$/", $sector)) {
    echo"Cumple";
} else {
    echo 'No cumple';
}