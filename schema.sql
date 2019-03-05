CREATE DATABASE DOINGSDONE;
USE DOINGSDONE;
CREATE TABLE project (
	project_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	project_name CHAR(40)
);

CREATE TABLE task (
	task_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	date_create TIMESTAMP NOT NULL,
	date_complete TIMESTAMP,
	task_status INT ,
	task_name CHAR(255),
	deadline TIMESTAMP,
	task_file VARCHAR(50)
	);
CREATE TABLE cite_user (
	user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	registration_date TIMESTAMP NOT NULL,
	email CHAR(40),
	username CHAR(40),
	password TEXT
);
CREATE UNIQUE INDEX id_project ON project(project_id);
CREATE INDEX name_project ON project(project_name);
CREATE UNIQUE INDEX id_task ON task(task_id);
CREATE INDEX create_date ON task(date_create);
CREATE INDEX complete_date ON task(date_complete);
CREATE INDEX status_task ON task(task_status);
CREATE INDEX name_task ON task(task_name(40));
CREATE INDEX dedl ON task(deadline);
CREATE INDEX file_task ON task(task_file);
CREATE UNIQUE INDEX id_user ON cite_user(user_id);
CREATE INDEX date_registration ON cite_user(registration_date);
CREATE INDEX user_email ON cite_user(email);
CREATE INDEX name ON cite_user(username);
CREATE INDEX passw ON cite_user(password(100));
