USE DOINGSDONE;
ALTER TABLE project ADD id_user INT;
ALTER TABLE task ADD id_user INT;
ALTER TABLE task ADD project_id INT;
INSERT INTO project (project_name) VALUES ('Входящие'), ('Учеба'), ('Работа'), ('Домашние дела'), ('Авто') ;
INSERT INTO task (task_name, deadline, project_id, task_status) VALUES
('Собеседование в IT компании', '2019-12-01',3 , 0),
('Выполнить тестовое задание','2019-12-25', 3, 0),
('Сделать задание первого раздела', '2019-12-22',2, 1),
('Встреча с другом', '2019-12-22', 1, 0);
INSERT INTO task (task_name, project_id, task_status) VALUES ('Купить корм для кота', 4, 0), ('Заказать пиццу', 4, 0);
INSERT INTO cite_user (registration_date, email, username, password) VALUES
('2018-03-12', 'petrov1998@yandex.ru', 'Алексанндр','12345'),
('2017-09-08', 'svet999@gmail.com', 'Анастасия', '780000');
