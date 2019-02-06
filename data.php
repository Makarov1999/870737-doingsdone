<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$tasks = [
  [
    "task_name" => "Собеседование в IT компании",
    "task_date" => "01.12.2019" ,
    "task_category" => 2 ,
    "task_finish" => false
    ] ,
  [
    "task_name" => "Выполнить тестовое задание",
    "task_date" => "25.12.2019" ,
    "task_category" => 2 ,
    "task_finish" => false
    ] ,
  [
    "task_name" => "Сделать задание первого раздела",
    "task_date" => "21.12.2019" ,
    "task_category" => 1 ,
    "task_finish" => true
    ] ,
  [
    "task_name" => "Встреча с другом",
    "task_date" => "22.12.2019" ,
    "task_category" => 0 ,
    "task_finish" => false
    ] ,
  [
    "task_name" => "Купить корм для кота",
    "task_date" => "Нет" ,
    "task_category" => 3 ,
    "task_finish" => false
    ] ,
  [
    "task_name" => "Заказать пиццу",
    "task_date" => "Нет" ,
    "task_category" => 3 ,
    "task_finish" => false
  ]
];
?>
