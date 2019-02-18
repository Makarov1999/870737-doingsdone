<?php
require_once('functions.php');
$show_complete_tasks = rand(0, 1);
$con  = mysqli_connect('127.0.0.1','root', '', 'DOINGSDONE');
if (!$con) {
  print('Ошибка подключения MySQL:'.mysqli_connect_error());
}
mysqli_set_charset($con, 'utf-8');
$arr = [1];
$sql1 = "SELECT p.project_name, p.project_id FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id AND p.id_user = ?";
$stmt1 = db_get_prepare_stmt($con, $sql1, $arr);
mysqli_stmt_execute($stmt1);
$result_projects = mysqli_stmt_get_result($stmt1);
mysqli_stmt_close($stmt1);
$projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);

if (isset($_GET['project_id'])) {
  if (!(consist_array($_GET['project_id'], $projects))) {
    http_response_code(404);
    print('Ошибка 404');
  } else {
    $arr[] = $_GET['project_id'];
    $sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ? AND t.project_id = ?";
    $stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
    mysqli_stmt_execute($stmt2);
    $result_tasks = mysqli_stmt_get_result($stmt2);
    mysqli_stmt_close($stmt2);
    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
    $main_page_content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
    $layout_content = include_template(
      'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'tasks' => $tasks, 'projects' => $projects]);
    print($layout_content);
  }
} else {
  $sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ?";
  $stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
  mysqli_stmt_execute($stmt2);
  $result_tasks = mysqli_stmt_get_result($stmt2);
  mysqli_stmt_close($stmt2);
  $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
  $main_page_content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
  $layout_content = include_template(
    'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'tasks' => $tasks, 'projects' => $projects]);
  print($layout_content);

}

/*if (isset($_GET['project_id'])) {

  $arr[] = $_GET['project_id'];
  $sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ? AND t.project_id = ?";
} else {
  $sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ?";
}
$stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
mysqli_stmt_execute($stmt2);
$result_tasks = mysqli_stmt_get_result($stmt2);
mysqli_stmt_close($stmt2);
$tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
$main_page_content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template(
  'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'tasks' => $tasks, 'projects' => $projects]);
print($layout_content);*/

?>
