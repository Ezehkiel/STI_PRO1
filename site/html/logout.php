<?php

session_start();
session_destroy();

$_POST = array();
header('location: login.php');

