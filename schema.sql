CREATE DATABASE DOINGSDONE;
USE DOINGSDONE;
CREATE TABLE project (
	project_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	project_name CHAR(40)
);

CREATE TABLE task (
	task_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	date_create TIMESTAMP,
	date_complete TIMESTAMP,
	task_status BOOL ,
	task_name TEXT, 
	deadline TIMESTAMP
	);  
CREATE TABLE cite_user (
	user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	registration_date TIMESTAMP,
	email CHAR(40),
	username CHAR(40),
	password TEXT
);	



