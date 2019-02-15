<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$con  = mysqli_connect('127.0.0.1','root', '', 'DOINGSDONE');
if (!$con) {
  print('Ошибка подключения MySQL:'.mysqli_connect_error());
}
mysqli_set_charset($con, 'utf-8');
$result_projects = mysqli_query($con, "SELECT p.project_name, p.project_id FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id AND p.id_user = 1");
$result_tasks  = mysqli_query($con, "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = 1");
if (!$result_projects) {
  $error = mysqli_error($con);
  print('Ошибка MySQL: '.$error);
} else {
  $projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
}
$tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

// $tasks = [
//   [
//     "task_name" => "Собеседование в IT компании",
//     "task_date" => "01.12.2019" ,
//     "task_category" => 2 ,
//     "task_finish" => false
//     ] ,
//   [
//     "task_name" => "Выполнить тестовое задание",
//     "task_date" => "25.12.2019" ,
//     "task_category" => 2 ,
//     "task_finish" => false
//     ] ,
//   [
//     "task_name" => "Сделать задание первого раздела",
//     "task_date" => "21.12.2019" ,
//     "task_category" => 1 ,
//     "task_finish" => true
//     ] ,
//   [
//     "task_name" => "Встреча с другом",
//     "task_date" => "22.12.2019" ,
//     "task_category" => 0 ,
//     "task_finish" => false
//     ] ,
//   [
//     "task_name" => "Купить корм для кота",
//     "task_date" => "Нет" ,
//     "task_category" => 3 ,
//     "task_finish" => false
//     ] ,
//   [
//     "task_name" => "Заказать пиццу",
//     "task_date" => "Нет" ,
//     "task_category" => 3 ,
//     "task_finish" => false
//   ]
// ];
?>
