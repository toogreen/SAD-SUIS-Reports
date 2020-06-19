<?php
$class_id = $_POST['class_id'];
$interim = $_POST['interim'];
$syear = $_POST['syear'];
header("location:reports.php?class_id=$class_id&interim=$interim&syear=$syear");
?>