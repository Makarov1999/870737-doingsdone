<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$con  = mysqli_connect('127.0.0.1','root', '', 'DOINGSDONE');
if (!$con) {
  print('Ошибка подключения MySQL:'.mysqli_connect_error());
  exit();
}
mysqli_set_charset($con, 'utf-8');

 ?>
