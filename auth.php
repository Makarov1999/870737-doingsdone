<?php
require_once('init.php');
require_once('functions.php');
session_start();
$title = 'Страница входа';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $errors = [];
  if (empty($email)) {
    $errors['email'] = 'Пожалуйста заполните e-mail';
  } else {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (!is_email_exist($con, $email)) {
        $errors['email'] = 'E-mail введён некорректно';
      } else {
        $sql = 'SELECT * FROM cite_user WHERE email = ?';
        $stmt = db_get_prepare_stmt($con, $sql, [$email]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user_arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (password_verify($password, $user_arr[0]['password'])) {
          $_SESSION['user'] = $user_arr[0]['user_id'] ;
          header("Location: index.php");
        } else {
          $errors['password'] = 'Неверный пароль';
        }
      }
    }
  }
  if (!empty($errors)) {
    $content = include_template('auth.php',['errors' => $errors]);
  }
} else {
  $content = include_template('auth.php',[]);
}
$layout_content = include_template('layout.php', ['content' => $content,'title' => $title, 'is_auth' => 1]);
print($layout_content);
 ?>
