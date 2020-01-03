<?php

include '../../db/conexion.php';

$semana=$_POST['semana'];
$date = new DateTime($semana);
$week = $date->format("W");
$year = date("Y", strtotime($semana)); 

$dto = new DateTime();

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');

echo $week.','.$ret['week_start'].' - '.$ret['week_end'];
?>