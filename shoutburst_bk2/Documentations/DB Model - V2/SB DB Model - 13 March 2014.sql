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
-- CREATE TABLE: reports
--
CREATE TABLE IF NOT EXISTS reports
(
	r_id INT NOT NULL AUTO_INCREMENT,
	r_title VARCHAR(255) CHARACTER SET utf8,
	created DATETIME,
	last_change DATETIME,
	CONSTRAINT PRIMARY KEY (r_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: tags
--
CREATE TABLE IF NOT EXISTS tags
(
	tag_id INT NOT NULL AUTO_INCREMENT,
	tag_name VARCHAR(255) CHARACTER SET utf8,
	created DATE,
	last_change DATE,
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
	created DATE,
	last_change DATE,
	CONSTRAINT PRIMARY KEY (tg_id)
)
	ENGINE = InnoDB;
--
-- CREATE TABLE: teams
--
CREATE TABLE IF NOT EXISTS teams
(
	t_id INT NOT NULL AUTO_INCREMENT,
	t_title VARCHAR(225) CHARACTER SET utf8,
	CONSTRAINT PRIMARY KEY (t_id)
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
-- CREATE TABLE: reports_map
--
CREATE TABLE IF NOT EXISTS reports_map
(
	r_id INT,
	r_type VARCHAR(20) CHARACTER SET utf8
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_12
--
ALTER TABLE reports_map ADD 
	FOREIGN KEY (r_id)
		REFERENCES reports (r_id);

--
-- CREATE TABLE: surveys
--
CREATE TABLE IF NOT EXISTS surveys
(
	sur_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	camp_id INT NOT NULL,
	date_time DATETIME,
	q1 INT,
	q2 INT,
	q3 INT,
	q4 INT,
	q5 INT,
	total_score INT,
	average_score INT,
	http_icon VARCHAR(255),
	action VARCHAR(20),
	audio_file VARCHAR(255),
	ftp_path VARCHAR(255),
	comments TEXT,
	cli VARCHAR(20),
	servicenumber VARCHAR(20),
	plan VARCHAR(255),
	processed TINYINT(1) NOT NULL DEFAULT 0,
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
-- CREATE TABLE: tag_group_map
--
CREATE TABLE IF NOT EXISTS tag_group_map
(
	tg_id INT NOT NULL,
	tag_id INT NOT NULL,
	comp_id INT NOT NULL,
	CONSTRAINT PRIMARY KEY (tg_id, tag_id, comp_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_18
--
ALTER TABLE tag_group_map ADD 
	FOREIGN KEY (tg_id)
		REFERENCES tags_group (tg_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_17
--
ALTER TABLE tag_group_map ADD 
	FOREIGN KEY (tag_id)
		REFERENCES tags (tag_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_20
--
ALTER TABLE tag_group_map ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);

--
-- CREATE TABLE: tag_map
--
CREATE TABLE IF NOT EXISTS tag_map
(
	comp_id INT NOT NULL,
	tag_id INT NOT NULL,
	data_set VARCHAR(255) CHARACTER SET utf8,
	details VARCHAR(255) CHARACTER SET utf8,
	CONSTRAINT PRIMARY KEY (comp_id, tag_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_16
--
ALTER TABLE tag_map ADD 
	FOREIGN KEY (comp_id)
		REFERENCES companies (comp_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_19
--
ALTER TABLE tag_map ADD 
	FOREIGN KEY (tag_id)
		REFERENCES tags (tag_id);

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
-- CREATE TABLE: team_map
--
CREATE TABLE IF NOT EXISTS team_map
(
	t_id INT NOT NULL,
	user_id INT NOT NULL,
	comp_id INT NOT NULL,
	CONSTRAINT PRIMARY KEY (t_id, user_id, comp_id)
)
	ENGINE = InnoDB;

--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_13
--
ALTER TABLE team_map ADD 
	FOREIGN KEY (t_id)
		REFERENCES teams (t_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_14
--
ALTER TABLE team_map ADD 
	FOREIGN KEY (user_id)
		REFERENCES users (user_id);


--
-- CREATE FOREIGN KEY CONSTRAINT: Relation_15
--
ALTER TABLE team_map ADD 
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
	user_pin VARCHAR(20),
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

