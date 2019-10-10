<?php
session_start();
date_default_timezone_set("Europe/Paris");
if (!isset($_SESSION['id'])){
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">

    <title>WebMessenger</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="style/css/bootstrap.css">
    <link rel="stylesheet" href="style/css/bootstrap-grid.css">
    <link rel="stylesheet" href="style/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="style/css/style.css">

</head>
<body>
<div class="wrapper">
<?php
include ("menu.php");
?>
<div id="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            





