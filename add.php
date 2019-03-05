<?php
require_once('functions.php');
require_once('init.php');
session_start();
if(isset($_SESSION['user'])) {
  $user_id = intval($_SESSION['user']);
  $user = get_user_data($con, $user_id);
  $arr = [$user_id];
  $projects = get_projects($con, $arr);
  $date = date('Y-m-d', strtotime('now'));
  if ($_SERVER['REQUEST_METHOD']
  == 'POST') {
    $errors = [];
    $name_task  = htmlspecialchars($_POST['name']);
    $id_project = htmlspecialchars($_POST['project']);
    $date = htmlspecialchars($_POST['date']);
    if (empty($name_task)) {
      $errors['name'] = 'Введите имя задачи';
    }
    if (!empty($id_project && !is_project_exist($con, $id_project, $user_id))) {
        $errors['project'] = 'Такого проекта не существует';
    }
    if (!empty($_POST['date']) && !validate_date($date)) {
        $errors['date'] = 'Дата не может быть в прошлом или неправильный формат даты';
    }
    if (!empty($errors)) {
      $add_page_content = include_template('add.php',['projects' => $projects, 'errors'=> $errors]);
    } else {
      if (!empty($_FILES['preview'])) {
        $uploadfile = "uploads/".$_FILES['preview']['name'];
        move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile);
      }

      $sql = "INSERT INTO task (date_create, task_name,task_status, project_id, deadline, task_file, id_user) VALUES (?, ? ,? , ? , ?, ?, ?)";
      $stmt = db_get_prepare_stmt($con, $sql, [$date ,$name_task, 0, $id_project, fetch_date_to_format($date), $uploadfile, $user_id]);
      mysqli_stmt_execute($stmt);
      header("Location: index.php");
    }
  } else {
    $add_page_content = include_template('add.php',['projects' => $projects]);
  }
  $layout_content = include_template(
    'layout.php', ['content' => $add_page_content, 'title' => 'Дела в порядке Главная', 'con' => $con, 'projects' => $projects, 'user' => $user]);
  print($layout_content);
} else {
  header("Location: index.php");
}
?>
