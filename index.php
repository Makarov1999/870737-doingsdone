<?php
require_once('functions.php');
require_once('data.php');

$main_page_content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template(
  'layout.php',
   ['content' => $main_page_content, 'title' => 'Дела в порядке Главная', 'tasks' => $tasks, 'projects' => $projects ]);
print($layout_content);
?>
