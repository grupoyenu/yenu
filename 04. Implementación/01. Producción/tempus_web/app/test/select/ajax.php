<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['filter']) && $_GET['filter'] == 'yes') {
    $filter = [];

    $filter[] = array('id' => "1", 'text' => "Emanuel");
    $filter[] = array('id' => "2", 'text' => "Oconell");
    $filter[] = array('id' => "3", 'text' => "Reybo");
}
echo json_encode($filter);
