<?php
require_once('functions.php');
require_once('init.php');
session_start();
if(isset($_SESSION['user'])) {
  $user_id = intval($_SESSION['user']);
  $user = get_user_data($con, $user_id);
  $projects = get_projects($con, [$user_id]);
  if ($_SERVER['REQUEST_METHOD']
  == 'POST') {
    $errors = [];
    $name_task  = htmlspecialchars($_POST['name']);

    if (empty($name_task)) {
      $errors['name'] = 'Введите имя задачи';
    }
    $arr = [$name_task, 0, $user_id];
    if (isset($_POST['project']) && !empty($_POST['project'])) {
      if (!is_project_exist($con, $_POST['project'], $user_id)) {
          $errors['project'] = 'Такого проекта не существует';
      }
      else {
        $id_project = intval($_POST['project']);
        $columns = ", project_id";
        $questions = ", ?";
        $arr[] = $id_project;
      }
    }
    if (isset($_POST['date']) && !empty($_POST['date'])) {
      if(validate_date($_POST['date'])) {
        $columns .= ", deadline";
        $questions .= ", ?";
        $date = fetch_date_to_format($_POST['date']);
        $arr[] = $date;
      }
      else {
        $errors['date'] = 'Дата не может быть в прошлом или неправильный формат даты';
      }
    }

    if (!empty($errors)) {
      $add_page_content = include_template('add.php',['projects' => $projects, 'errors'=> $errors, 'name_task' => $name_task, 'id_project' => $id_project, 'date' => $date]);
    } else {
      if (!empty($_FILES['preview']['name'])) {
        $columns .= ", task_file";
        $questions .= ", ?";
        $uploadfile = "uploads/".$_FILES['preview']['name'];
        move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile);
        $arr[] = $uploadfile;
      }

      $sql = "INSERT INTO task (date_create, task_name, task_status, id_user $columns) VALUES (NOW(), ?, ?, ? $questions)";
      $stmt = db_get_prepare_stmt($con, $sql, $arr);
      mysqli_stmt_execute($stmt);
      header("Location: index.php");
    }
  } else {
    $add_page_content = include_template('add.php',['projects' => $projects]);
  }
  $layout_content = include_template(
    'layout.php', ['content' => $add_page_content, 'title' => 'Дела в порядке Добавление задачи', 'con' => $con, 'projects' => $projects, 'user' => $user]);
  print($layout_content);
} else {
  header("Location: index.php");
}
?>
