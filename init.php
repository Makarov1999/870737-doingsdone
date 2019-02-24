<?php 
$con  = mysqli_connect('127.0.0.1','root', '', 'DOINGSDONE');
if (!$con) {
  print('Ошибка подключения MySQL:'.mysqli_connect_error());
  exit();
}
mysqli_set_charset($con, 'utf-8');

 ?>
