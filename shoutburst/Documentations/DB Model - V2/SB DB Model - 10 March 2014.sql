--
-- CREATE TABLE: access_levels
--
CREATE TABLE IF NOT EXISTS access_levels
(
	acc_id INT NOT NULL AUTO_INCREMENT,
	acc_title VARCHAR(20) CHARACTER SET utf8,
	CONSTRAINT PRIMARY KEY (acc_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: campaigns
--
CREATE TABLE IF NOT EXISTS campaigns
(
	camp_id INT NOT NULL AUTO_INCREMENT,
	camp_name VARCHAR(255),
	created DATE,
	last_change DATE,
	status TINYINT(1) DEFAULT 1,
	CONSTRAINT PRIMARY KEY (camp_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: companies
--
CREATE TABLE IF NOT EXISTS companies
(
	comp_id INT NOT NULL AUTO_INCREMENT,
	comp_name VARCHAR(255) CHARACTER SET utf8,
	created DATE,
	last_change DATE,
	logo VARCHAR(255) CHARACTER SET utf8,
	platform VARCHAR(255) CHARACTER SET utf8,
	transcribe TINYINT(1) NOT NULL DEFAULT 0,
	status TINYINT(1) NOT NULL DEFAULT 1,
	CONSTRAINT PRIMARY KEY (comp_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: users
--
CREATE TABLE IF NOT EXISTS users
(
	user_id INT NOT NULL AUTO_INCREMENT,
	full_name VARCHAR(255) CHARACTER SET utf8,
	user_name VARCHAR(255) CHARACTER SET utf8,
	email VARCHAR(32) CHARACTER SET utf8,
	password VARCHAR(32) CHARACTER SET utf8,
	user_pin VARCHAR(20),
	created DATE,
	photo VARCHAR(255),
	status TINYINT(1) NOT NULL DEFAULT 1,
	CONSTRAINT PRIMARY KEY (user_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: company_campaings
--
CREATE TABLE IF NOT EXISTS company_campaings
(
	comp_id INT NOT NULL,
	camp_id INT NOT NULL,
	CONSTRAINT PRIMARY KEY (comp_id, camp_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_1
--
ALTER TABLE company_campaings ADD 
	FOREIGN KEY (camp_id)
		REFERENCES campaigns (camp_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_4
--
ALTER TABLE company_campaings ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);

--
-- CREATE TABLE: dashboards
--
CREATE TABLE IF NOT EXISTS dashboards
(
	db_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	comp_id INT NOT NULL,
	acc_id INT NOT NULL,
	db_type VARCHAR(20),
	db_query TEXT,
	CONSTRAINT PRIMARY KEY (db_id, user_id, comp_id, acc_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_5
--
ALTER TABLE dashboards ADD 
	FOREIGN KEY (user_id)
		REFERENCES users (user_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_9
--
ALTER TABLE dashboards ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_11
--
ALTER TABLE dashboards ADD 
	FOREIGN KEY (acc_id)
		REFERENCES access_levels (acc_id);

--
-- CREATE TABLE: surveys
--
CREATE TABLE IF NOT EXISTS surveys
(
	sur_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	camp_id INT NOT NULL,
	date_time DATETIME,
	score_q_1 INT,
	score_q_2 INT,
	score_q_3 INT,
	score_q_4 INT,
	score_q_5 INT,
	total_score INT,
	http_icon VARCHAR(255),
	action VARCHAR(20),
	audio_file VARCHAR(255),
	ftp_path VARCHAR(255),
	comments TEXT,
	CONSTRAINT PRIMARY KEY (sur_id, user_id, camp_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_3
--
ALTER TABLE surveys ADD 
	FOREIGN KEY (user_id)
		REFERENCES users (user_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_2
--
ALTER TABLE surveys ADD 
	FOREIGN KEY (camp_id)
		REFERENCES campaigns (camp_id);

--
-- CREATE TABLE: tags
--
CREATE TABLE IF NOT EXISTS tags
(
	tag_id INT NOT NULL AUTO_INCREMENT,
	tag_name VARCHAR(255) CHARACTER SET utf8,
	camp_ids TEXT(32) CHARACTER SET utf8,
	details VARCHAR(255) CHARACTER SET utf8,
	data_set VARCHAR(255) CHARACTER SET utf8,
	status TINYINT(1) NOT NULL DEFAULT 1,
	CONSTRAINT PRIMARY KEY (tag_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: tags_group
--
CREATE TABLE IF NOT EXISTS tags_group
(
	tg_id INT NOT NULL AUTO_INCREMENT,
	tg_name VARCHAR(255) CHARACTER SET utf8,
	tag_ids TEXT CHARACTER SET utf8,
	CONSTRAINT PRIMARY KEY (tg_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: target_setup
--
CREATE TABLE IF NOT EXISTS target_setup
(
	comp_id INT NOT NULL,
	survey_per_day INT,
	avg_total_score INT,
	incorrpletes_per_day INT,
	nps_score INT,
	max_per_day INT,
	day_start_time DATETIME,
	day_end_time DATETIME,
	CONSTRAINT PRIMARY KEY (comp_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_10
--
ALTER TABLE target_setup ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);

--
-- CREATE TABLE: user_companies
--
CREATE TABLE IF NOT EXISTS user_companies
(
	user_id INT NOT NULL,
	comp_id INT NOT NULL,
	acc_id INT NOT NULL,
	CONSTRAINT PRIMARY KEY (user_id, comp_id, acc_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_6
--
ALTER TABLE user_companies ADD 
	FOREIGN KEY (user_id)
		REFERENCES users (user_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_7
--
ALTER TABLE user_companies ADD 
	FOREIGN KEY (acc_id)
		REFERENCES access_levels (acc_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_8
--
ALTER TABLE user_companies ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);

