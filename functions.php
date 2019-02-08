<?php

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
  foreach ($tasks_array as $key => $value) {
      if ($project_key === $value["task_category"]) {
        $quantity++;
      }
  }
  return $quantity;
}
function is_task_urgent ($date) {
  date_default_timezone_set('Europe/Moscow');
  if ($date === 'Нет') {
    return false;
  }
  $current = strtotime("now");
  $next = strtotime ($date);
  if ($next  - $current < 86400) {
    return true;
  }
  return false;
}
?>
