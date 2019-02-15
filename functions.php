<?php
date_default_timezone_set('Europe/Moscow');
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';
    if (!is_readable($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require $name;
    $result = ob_get_clean();

    return $result;
}
function count_tasks( $tasks_array, $project_key) {
  $quantity = 0;
  foreach ($tasks_array as $task) {
      if ($project_key === $task["project_id"]) {
        $quantity++;
      }
  }
  return $quantity;
}
?>
