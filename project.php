<?php
require_once('init.php');
require_once('functions.php');
session_start();
if(isset($_SESSION['user'])) {
  $user_id = intval($_SESSION['user']);
  $user = get_user_data($con, $user_id);
  $arr = [$user_id];
  $projects = get_projects($con, $arr);
  $tasks = get_tasks($con, $arr);
  $title = 'Добавление проекта';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = htmlspecialchars($_POST['name']);
    $errors = [];
    if (empty($project_name)) {
      $errors['name'] = 'Введите название проекта';
    } else {
      if (is_project_exist($con, $project_name, $user_id)) {
        $errors['name'] = 'Данный проект существует';
      }
    }
    if (empty($errors)) {
      $sql = 'INSERT INTO project (project_name, id_user) VALUES (?, ?)';
      $stmt = db_get_prepare_stmt($con, $sql, [$project_name, $user_id]);
      mysqli_stmt_execute($stmt);
      header('Location: index.php');
    } else {
      $content = include_template('project.php', ['errors' => $errors]);
    }
  } else {
    $content = include_template('project.php', []);
  }
  $layout_content = include_template('layout.php', ['content' => $content,'projects' => $projects, 'title' => $title, 'user' => $user, 'tasks' => $tasks, 'con' => $con]);
  print($layout_content);
} else {
  header('Location: index.php');
}

?>
