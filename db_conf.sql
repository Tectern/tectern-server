-- CREATE DB
CREATE DATABASE epiTest;

-- CREATE TABLES
CREATE TABLE epiTest.users (
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
	cuid INT(9) NOT NULL,
	first VARCHAR(20),
	last VARCHAR(20),
	PRIMARY KEY (id)
);
CREATE TABLE epiTest.lectern_prefs (
	id MEDIUMINT NOT NULL AUTO_INCREMENT,
	height DECIMAL(4,3) NOT NULL,
	user_id MEDIUMINT NOT NULL,
	PRIMARY KEY (id)
);

-- DB SEED BEGIN
INSERT INTO epiTest.users (cuid,first,last) VALUES (584419020,'Antonio','MalvaGomes');
INSERT INTO epiTest.lectern_prefs (height,user_id) VALUES (4.83,1);
-- DB SEED END
