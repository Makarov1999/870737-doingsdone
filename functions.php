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
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}
function consist_array($element, $projects_array) {
  foreach ($projects_array as $project) {
    if ($project['project_id'] == $element) {
      return true;
    }
  }
  return false;
}
?>
