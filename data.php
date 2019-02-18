<?php
// показывать или нет выполненные  задачи
$show_complete_tasks = rand(0, 1);
$con  = mysqli_connect('127.0.0.1','root', '', 'DOINGSDONE');
if (!$con) {
  print('Ошибка подключения MySQL:'.mysqli_connect_error());
}
mysqli_set_charset($con, 'utf-8');
$arr = [1];
$sql1 = "SELECT p.project_name, p.project_id FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id AND p.id_user = ?";
$sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ?";
// $result_projects = mysqli_query($con, "SELECT p.project_name, p.project_id FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id AND p.id_user = 1");
//$result_tasks  = mysqli_query($con, "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = 1");
$stmt1 = db_get_prepare_stmt($con, $sql1, $arr);
mysqli_stmt_execute($stmt1);
$result_projects = mysqli_stmt_get_result($stmt1);
mysqli_stmt_close($stmt1);
$stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
mysqli_stmt_execute($stmt2);
$result_tasks = mysqli_stmt_get_result($stmt2);
mysqli_stmt_close($stmt2);
$tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
$projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);

?>
