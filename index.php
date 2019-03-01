<?php
require_once('functions.php');
require_once('init.php');
session_start();

if (isset($_SESSION['user'])) {
  $user_id = intval($_SESSION['user']);
  $user = get_user_data($con, $user_id);
  $arr = [$user_id];
  $projects = get_projects($con, $arr);
  if (isset($_GET['show_completed'])) {
    $show_complete_tasks = intval($_GET['show_completed']);
  }
  if (isset($_GET['project_id'])) {
    if (!(consist_array($_GET['project_id'], $projects))) {
      header("Location: 404.php");
    } else {
      $arr[] = $_GET['project_id'];
      $sql2 = "SELECT t.task_name, t.deadline, t.project_id, t.task_status FROM task t INNER JOIN cite_user c ON t.id_user = c.user_id AND t.id_user = ? AND t.project_id = ?";
      $stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
      mysqli_stmt_execute($stmt2);
      $result_tasks = mysqli_stmt_get_result($stmt2);
      mysqli_stmt_close($stmt2);
      $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
      $main_page_content = include_template('index.php', ['tasks' => $tasks]);
      $layout_content = include_template(
        'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'con' => $con, 'projects' => $projects, 'user' => $user]);
    }
  } else {
    $sql2 = "SELECT * FROM task WHERE id_user = ?";
    $stmt2 = db_get_prepare_stmt($con,$sql2,$arr);
    mysqli_stmt_execute($stmt2);
    $result_tasks = mysqli_stmt_get_result($stmt2);
    mysqli_stmt_close($stmt2);
    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
    $main_page_content = include_template('index.php', ['tasks' => $tasks]);
    $layout_content = include_template(
      'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'con' => $con, 'projects' => $projects, 'user' => $user]);
  }
} else {
  $content = include_template('guest.php', []);
  $layout_content = include_template('layout.php', ['content' => $content, 'is_sidebar' => 1]);
}
print($layout_content);
?>
