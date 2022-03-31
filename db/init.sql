CREATE TABLE IF NOT EXISTS Resume(
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name	TEXT NOT NULL,
	role TEXT NOT NULL,
	start_date INTEGER NOT NULL,
	description TEXT NOT NULL
);

INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (1,'Alibaba', 'Software Developer Intern',2021,'Applied newly learned deep learning algorithms for search, recommendation, and forecasting systems to built auto-regressive recurrent neural network tool to support sales forecasting team, achieving only 5% error');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (2,'Hubel Labs', 'Software Developer',2020,'Deployed OCR, NLP & TTS to build a program that after scanning Chinese book images, returns a speech recording, translation, and pronunciation per unique word. Developed entire backend framework for Maomi (App), managed a NoSQL database, and built a web-based data collection service and an automatic periodic update-email feature.');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (3,'Cornell Data Science', 'Executive Board Member',2021,'Completed onboarding program covering the fundamentals of machine learning.');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (4,'Cornell Cayuga Capital', 'Algo Trading Team Member',2020,'Completed education series covering DCFs, comparable analyses, stochastic processes, and market simulation');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (5,'Cornell-ZJU Student Council', 'Vice President of Social Life',2020,'Organized weekly games, entertainment, and activities');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (6,'HBS Summer Program in Finance, Economics, and Innovation','Teaching Assistant',2019,'Invited to serve as 1 of 2 TAs. Hosted office hours to help students understand course concepts and mentored students to develop and refine their research projects for publication');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (7,'Fintech Research', 'Research Assistant',2021,'Assisting Prof. William Cong in his publications on forecasting asset prices with deep learning methods');
INSERT INTO `Resume` (id,name,role,start_date,description) VALUES (8,'Antistatic Architecture', 'Research Assistant',2021,'Developing machine learning models for generative design');


CREATE TABLE IF NOT EXISTS Tags( 
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, 
	tag_name TEXT NOT NULL
);

INSERT INTO `Tags` (id,tag_name) VALUES (1, 'Machine Learning');
INSERT INTO `Tags` (id,tag_name) VALUES (2, 'Software Engineering');
INSERT INTO `Tags` (id,tag_name) VALUES (3, 'Finance');
INSERT INTO `Tags` (id,tag_name) VALUES (4, 'Leadership');
INSERT INTO `Tags` (id,tag_name) VALUES (5, 'Design');

CREATE TABLE IF NOT EXISTS User_tag_rel(
 id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 user_id INTEGER NOT NULL,
 tag_id INTEGER NOT NULL,

 FOREIGN KEY(user_id) REFERENCES Resume(id),
 FOREIGN KEY(tag_id) REFERENCES Tags(id)
);

INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (1,1,1);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (2,2,2);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (3,3,1);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (4,3,2);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (5,3,4);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (6,4,3);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (7,5,4);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (8,6,3);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (9,6,4);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (10,7,1);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (11,7,3);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (12,8,2);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (13,8,5);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (14,9,2);
INSERT INTO `User_tag_rel` (id,user_id, tag_id) VALUES (15,9,5);

-- Users & Sessions & Groups---
CREATE TABLE IF NOT EXISTS members(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL,
	username TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS sessions(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	member_id INTEGER NOT NULL,
	session TEXT NOT NULL UNIQUE,
    last_login   TEXT NOT NULL,

    FOREIGN KEY(member_id) REFERENCES members(id)
);

CREATE TABLE groups(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	name TEXT NOT NULL UNIQUE
);
INSERT INTO groups (id, name) VALUES (1, 'admin');
INSERT INTO groups (id, name) VALUES (2, 'user');

CREATE TABLE memberships(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  group_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,

  FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES members(id)
);

CREATE TABLE info(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  request TEXT NOT NULL,

  FOREIGN KEY(user_id) REFERENCES members(id)
);


INSERT INTO members (id, name, username, password) VALUES (1, 'Johann', 'johanl', 'johanl');
INSERT INTO memberships (group_id, user_id) VALUES (1, 1);
INSERT INTO info (id, user_id, request) VALUES (1, 1, 'testing');