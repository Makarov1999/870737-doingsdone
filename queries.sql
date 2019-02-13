USE DOINGSDONE;
ALTER TABLE project ADD id_user INT;
ALTER TABLE task ADD id_user INT;
ALTER TABLE task ADD project_id INT;
INSERT INTO project (project_name) VALUES ('Входящие');
INSERT INTO project (project_name) VALUES ('Учеба');
INSERT INTO project (project_name) VALUES ('Работа');
INSERT INTO project (project_name) VALUES ('Домашние дела');
INSERT INTO project (project_name) VALUES ('Авто');
INSERT INTO task (task_name, deadline, project_id, task_status) VALUES ('Собеседование в IT компании', '2019-12-01',3 , 0);
INSERT INTO task (task_name, deadline, project_id, task_status) VALUES ('Выполнить тестовое задание','2019-12-25', 3, 0);
INSERT INTO task (task_name, deadline, project_id, task_status) VALUES ('Сделать задание первого раздела', '2019-12-22',2, 1);
INSERT INTO task (task_name, deadline, project_id, task_status) VALUES ('Встреча с другом', '2019-12-22', 1, 0);
INSERT INTO task (task_name, project_id, task_status) VALUES ('Купить корм для кота', 4, 0);
INSERT INTO task (task_name, project_id, task_status) VALUES ('Заказать пиццу', 4, 0);
INSERT INTO cite_user (registration_date, email, username, password) VALUES ('2018-03-12', 'petrov1998@yandex.ru', 'Алексанндр','12345');
INSERT INTO cite_user (registration_date, email, username, password) VALUES ('2017-09-08', 'svet999@gmail.com', 'Анастасия', '780000');
UPDATE task SET id_user = 1 WHERE task_id < 5
UPDATE task SET id_user = 2 WHERE task_id > 5;
UPDATE task SET id_user = 2 WHERE task_id = 5;
UPDATE project SET id_user = 1 WHERE project_id < 6;
/*Получаем список проектов для одного пользователя*/
SELECT p.project_name, c.username FROM project p INNER JOIN cite_user c ON p.id_user = c.user_id;
/*Получаем список из всех задач для одного проекта(Домашние дела);*/
SELECT t.task_name, p.project_name FROM task t INNER JOIN project p ON p.project_id = t.project_id AND p.project_id = 4;
/*Пометим задачу как выпоненную "Заказать пиццу"*/
UPDATE task SET task_status = 1 WHERE task_name = 'Заказать пиццу';
/*Обновим название задачи по ее идентификатору*/
UPDATE task SET task_name = 'Заказать пиццу с грибами' WHERE task_id = 8;
