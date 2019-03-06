<?php
require_once('functions.php');
require_once('init.php');
session_start();

if (isset($_SESSION['user'])) {
  $user_id = intval($_SESSION['user']);
  $user = get_user_data($con, $user_id);
  $arr = [$user_id];
  $projects = get_projects($con, $arr);
  $show_complete_tasks = 0;
  if (!empty($_GET)) {
    if (isset($_GET['show_completed'])) {
      $show_complete_tasks = intval($_GET['show_completed']);
      $sql = "SELECT * FROM task WHERE id_user = ?";
      $stmt = db_get_prepare_stmt($con,$sql,$arr);
      mysqli_stmt_execute($stmt);
      $result_tasks = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
    if (isset($_GET['project_id'])) {
      if (!(consist_array($_GET['project_id'], $projects))) {
        header("Location: 404.php");
      } else {
        $arr[] = $_GET['project_id'];
        $sql = "SELECT * FROM task WHERE id_user = ? AND project_id = ?";
        $stmt = db_get_prepare_stmt($con,$sql,$arr);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);
      }
    }
    if (isset($_GET['date_task'])) {
      $date_task = htmlspecialchars($_GET['date_task']);
      if ($date_task === 'tod') {
        $sql = "SELECT * FROM task WHERE  id_user = ? AND DAY(NOW()) = DAY(deadline)";
        $stmt = db_get_prepare_stmt($con,$sql,$arr);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);
      }
      if ($date_task === 'tom') {
        $sql = "SELECT * FROM task WHERE  id_user = ? AND DAY(NOW())+1 = DAY(deadline)";
        $stmt = db_get_prepare_stmt($con,$sql,$arr);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);
      }
      if ($date_task === 'dead') {
        $sql = "SELECT * FROM task WHERE  id_user = ? AND DAY(NOW()) > DAY(deadline)";
        $stmt = db_get_prepare_stmt($con,$sql,$arr);
        mysqli_stmt_execute($stmt);
        $result_tasks = mysqli_stmt_get_result($stmt);
      }
    }
    if (isset($_GET['task_id']) && isset($_GET['check'])) {
      $task_id = intval($_GET['task_id']);
      $check= intval($_GET['check']);
      $arr2 = [$task_id];
      if ($check === 1) {
        $sql = "UPDATE task SET task_status = 1, date_complete = NOW() WHERE task_id = ?";
        $stmt = db_get_prepare_stmt($con,$sql,$arr2);
        mysqli_stmt_execute($stmt);
      } else {
        $sql = "UPDATE task SET task_status = 0  WHERE task_id = ?";
        $stmt = db_get_prepare_stmt($con,$sql,$arr2);
        mysqli_stmt_execute($stmt);
      }
      header('Location: index.php');
    }
  } else {
    $sql = "SELECT * FROM task WHERE id_user = ?";
    $stmt = db_get_prepare_stmt($con,$sql,$arr);
    mysqli_stmt_execute($stmt);
    $result_tasks = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
  }
  $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
  $main_page_content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks, 'date_task' => $date_task]);
  $layout_content = include_template(
    'layout.php', ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'con' => $con, 'projects' => $projects, 'user' => $user]);

} else {
  $content = include_template('guest.php', []);
  $layout_content = include_template('layout.php', ['content' => $content, 'is_sidebar' => 1]);
}
print($layout_content);

?>
