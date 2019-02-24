<?php
$arr = [1];
$show_complete_tasks = rand(0, 1);
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
function count_tasks($con, $project_key) {
  $sql = "SELECT task_id FROM task WHERE project_id = $project_key";
  $query = mysqli_query($con, $sql);
  $result = mysqli_num_rows($query);
  return $result;
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
function get_projects($con, $arr) {
  $sql = "SELECT p.project_name, p.project_id FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id AND p.id_user = ?";
  $stmt = db_get_prepare_stmt($con, $sql, $arr);
  mysqli_stmt_execute($stmt);
  $result_projects = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  $projects = mysqli_fetch_all($result_projects, MYSQLI_ASSOC);
  return $projects;
}
function is_project_exist($con, $projects_id) {
  $sql = "SELECT project_id FROM project WHERE project_id = ? AND id_user = ?";
  $project_arr = [$projects_id, 1];
  $stmt = db_get_prepare_stmt($con, $sql, $project_arr);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  $project_exist = mysqli_fetch_all($result, MYSQLI_ASSOC);
  if(!empty($project_exist)) {
    return true;
  }
  return false;
}
function validate_date($date) {
  if (strtotime($date) < strtotime("now")) {
    return 0;
  } else {
    if (date("d.m.Y", strtotime($date))) {
      return 1;
    } else {
      return 1;
    }
  }
}
function fetch_date_to_format($date) {
  $new_date = date( "Y-m-d",strtotime($date));
  return $new_date;
}
?>
