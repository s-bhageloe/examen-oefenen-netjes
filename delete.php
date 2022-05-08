<?php
include_once 'database.php';

$db = new DB('localhost', 'root', '', 'oefenexamen', 'utf8mb4');

$reserveer = $db->deleteReservering($_GET['klantID_rs']);

?>