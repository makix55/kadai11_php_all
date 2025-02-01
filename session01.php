<?php
session_start();
//$name = 'maki';
//$age = 12;
//echo $name . $age;
//$_SESSION['name'] = $name;
//$_SESSION['age'] = $age;

$sid = session_id();
echo $sid;