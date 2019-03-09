<?php
require_once('functions.php');
require_once('init.php');
$title = 'Страница регистрации';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = [];
  $email  = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $name = htmlspecialchars($_POST['name']);

  if (empty($email)) {
    $errors['email'] = 'Пожалуйста заполните e-mail';
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Некорректный e-mail';
    } else {
      if (is_email_exist($con,$email)) {
        $errors['email'] = 'Данный e-mail занят';
      }
    }
  }
  if (empty($password)) {
    $errors['password'] = 'Пожалуйста заполните пароль';
  } else {
    $password = password_hash($password,  PASSWORD_DEFAULT);
  }
  if (empty($name))
    $errors['name'] = 'Пожалуйста введите имя';
    if (empty($errors)) {
      $date = date("Y-m-d", strtotime("now"));
      $sql = "INSERT INTO cite_user (registration_date, email, username, password) VALUES (?, ?, ?, ?)";
      $stmt = db_get_prepare_stmt($con, $sql, [$date, $email, $name, $password]);
      mysqli_stmt_execute($stmt);
      header("Location: auth.php");
    } else {
      $content = include_template('register.php', ['errors' => $errors]);
    }
  } else {
   $content = include_template('register.php', []);
 }
 $layout_content = include_template('layout.php', ['content' => $content, 'title' => $title, 'is_register' => 0 ]);
print($layout_content);
