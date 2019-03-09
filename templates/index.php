
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item <?=empty($date_task) ? ' tasks-switch__item--active':''; ?>">Все задачи</a>
        <a href="/?date_task=tod" class="tasks-switch__item <?=(!empty($date_task) && $date_task === 'tod') ? ' tasks-switch__item--active':''; ?>">Повестка дня</a>
        <a href="/?date_task=tom" class="tasks-switch__item <?=(!empty($date_task) && $date_task === 'tom') ? ' tasks-switch__item--active':''; ?>">Завтра</a>
        <a href="/?date_task=dead" class="tasks-switch__item <?=(!empty($date_task) && $date_task === 'dead') ? ' tasks-switch__item--active':''; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?=($show_complete_tasks  === 1 ) ? ' checked': '';?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
  <?php foreach ($tasks as $task): ?>
      <tr class="tasks__item task <?=$task['task_status'] === 1 ? 'task--completed ': ''; ?><?=is_task_important($task['deadline']) ? ' task--important': ''; ?> <?=($show_complete_tasks === 0 && $task['task_status'] === 1) ? ' tasks__item--hide':''?>">

          <td class="task__select">
              <label class="checkbox task__checkbox">
                  <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$task['task_id']?>" <?=$task["task_status"] === 1 ? ' checked' :""; ?>>
                  <span class="checkbox__text"><?=strip_tags($task["task_name"]);?></span>
              </label>
          </td>
          <td class="task__file">
            <?php if (!empty($task['task_file'])): ?>
              <a class="download-link" href="<?=$task['task_file'];?>"><?=str_replace('uploads/', '', strip_tags($task['task_file'])) ;?></a>
            <?php endif; ?>
          </td>
          <td class="task__date"><?=$task["deadline"] ? htmlspecialchars( date('d.m.Y',strtotime($task['deadline']))) : "Нет";?></td>
    </tr>
  <?php endforeach; ?>
</table>
