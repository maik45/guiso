<?php

$fecha=$_POST['fecha'];

$date = new DateTime($fecha);
$week = $date->format("W");
$year = date("Y", strtotime($fecha)); 

$dto = new DateTime();

$dias='';

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+0 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+1 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+2 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+3 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+4 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+5 days')->format('Y-m-d');

$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$dias.=','.$ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');

echo $dias;
?>