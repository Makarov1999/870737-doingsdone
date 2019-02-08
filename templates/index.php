<?php require_once('functions.php');?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $show_complete_tasks === 1 ? 'checked' : "" ;?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
  <?php foreach ($tasks as $key => $value): ?>
    <?php if ($show_complete_tasks === 1): ?>
      <tr class="tasks__item task <?=$value['task_finish'] ? 'task--completed ': ''; ?><?=is_task_urgent($value['task_date']) ? 'task--important': '';?>">
          <td class="task__select">
              <label class="checkbox task__checkbox">
                  <input class="checkbox__input visually-hidden" type="checkbox"<?=isset($value["task_finish"]) ? $value["task_finish"] ? 'checked' : "" :""; ?>>
                  <span class="checkbox__text"><?=isset($value["task_name"]) ? strip_tags($value["task_name"]) :"";?></span>
              </label>
          </td>
          <td class="task__date"><?=isset($value["task_date"]) ? $value["task_date"] : "";?></td>
          <td class="task__controls">
          </td>
    </tr>
  <?php elseif (!$value['task_finish']):?>
    <tr class="tasks__item task <?=is_task_urgent($value['task_date']) ? 'task--important': '';?>">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden" type="checkbox">
                <span class="checkbox__text"><?=isset($value["task_name"]) ? strip_tags($value["task_name"]) :"";?></span>
            </label>
        </td>
        <td class="task__date"><?=isset($value["task_date"]) ? $value["task_date"] : "";?></td>
        <td class="task__controls">
        </td>
  </tr>
  <?php endif; ?>
  <?php endforeach; ?>
</table>
