<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Table names and structure. The tables are ordered in a steadily ascending order of foreign
 * key references: e.g. $config[table_name] = "structure";
 */
 
$config['user'] = "
	user_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	username VARCHAR(50) NOT NULL UNIQUE,
	scope VARCHAR(7) NOT NULL,
	password_hash CHAR(60) NOT NULL,
	email VARCHAR(255) NOT NULL,
	profile_view_count INT UNSIGNED DEFAULT 0,
	account_balance MEDIUMINT DEFAULT 0,
	sign_up_time BIGINT UNSIGNED NOT NULL,
	last_login_time BIGINT UNSIGNED NOT NULL,
	has_notification CHAR(1) DEFAULT 'N',
	CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private')),
	CONSTRAINT has_notification_constraint CHECK(has_notification IN ('Y', 'N')),
	INDEX(username),
	PRIMARY KEY(user_id)";
	
/*
 * $config['subscription'] = "user INT UNSIGNED NOT NULL,
 * start_date BIGINT UNSIGNED NOT NULL,
 * end_date BIGINT UNSIGNED NOT NULL,
 * cost TINYINT UNSIGNED NOT NULL,
 * FOREIGN KEY(user) REFERENCES user(user_id),
 * PRIMARY KEY(user)";
 *
 * $config['activity'] = "active_user INT UNSIGNED NOT NULL,
 * passive_user INT UNSIGNED NOT NULL,
 * time_added BIGINT UNSIGNED NOT NULL,
 * subject VARCHAR(50) NOT NULL,
 * message TEXT NOT NULL,
 * has_been_viewed CHAR(1) DEFAULT 'N',
 * FOREIGN KEY(active_user) REFERENCES user(user_id),
 * FOREIGN KEY(passive_user) REFERENCES user(user_id),
 * PRIMARY KEY(active_user, passive_user, time_added)";
 */

$config['school'] = "
	owner_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	school_title VARCHAR(50) NOT NULL,
	scope VARCHAR(7) NOT NULL,
	time_added BIGINT UNSIGNED NOT NULL,
	school_view_count INT UNSIGNED DEFAULT 0,
	school_type CHAR(6) NOT NULL,
	education_level VARCHAR(10) NOT NULL,
	CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private')),
	CONSTRAINT school_type_constraint CHECK(school_type IN ('origin', 'import')),
	CONSTRAINT education_level_constraint CHECK(education_level IN ('primary', 'secondary', 'tertiary')),
	INDEX(school_title),
	INDEX(school_type),
	INDEX(education_level),
	FOREIGN KEY(owner_id) REFERENCES user(user_id),
	PRIMARY KEY(school_id, owner_id)";
	
$config['course'] = "
	owner_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	course_id SMALLINT UNSIGNED NOT NULL,
	course_title VARCHAR(50) NOT NULL,
	scope VARCHAR(7) NOT NULL,
	time_added BIGINT UNSIGNED NOT NULL,
	course_view_count INT UNSIGNED DEFAULT 0,
	course_type CHAR(6) NOT NULL,
	category VARCHAR(50) NOT NULL,
	CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private')),
	CONSTRAINT course_type_constraint CHECK(course_type IN ('origin', 'import')),
	INDEX(course_title),
	INDEX(course_type),
	INDEX(category),
	FOREIGN KEY(owner_id) REFERENCES user(user_id),
	FOREIGN KEY(school_id) REFERENCES school(school_id),
	PRIMARY KEY(course_id, school_id, owner_id)";
	
/*
 * $config['course_import'] = "importer_id INT UNSIGNED NOT NULL,
 * course_id SMALLINT UNSIGNED NOT NULL,
 * origin_owner_id INT UNSIGNED NOT NULL,
 * origin_course_id SMALLINT UNSIGNED NOT NULL,
 * cost SMALLINT UNSIGNED DEFAULT 0,
 * FOREIGN KEY(importer_id) REFERENCES course(owner_id),
 * FOREIGN KEY(course_id) REFERENCES course(course_id),
 * FOREIGN KEY(origin_owner_id) REFERENCES course(owner_id),
 * FOREIGN KEY(origin_course_id) REFERENCES course(course_id),
 * PRIMARY KEY(importer_id, school_id, course_id)";
 */
 
/*
 * ACCESS COURSE TABLE
 * access_request_state: pending/accepted
 * permission: part/full
 */
/*
 * $config['access_course'] = "accessor_id INT UNSIGNED NOT NULL,
 * course_owner_id INT UNSIGNED NOT NULL,
 * course_id SMALLINT UNSIGNED NOT NULL,
 * access_request_state VARCHAR(8) DEFAULT 'pending',
 * permission CHAR(4) NOT NULL,
 * FOREIGN KEY(accessor_id) REFERENCES user(user_id),
 * FOREIGN KEY(course_owner_id) REFERENCES course(owner_id),
 * FOREIGN KEY(course_id) REFERENCES course(course_id),
 * PRIMARY KEY(accessor_id, course_id, school_id, course_owner_id)";
 */
 
$config['bank'] = "
	owner_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	course_id SMALLINT UNSIGNED NOT NULL,
	bank_id TINYINT UNSIGNED NOT NULL,
	bank_title VARCHAR(50) NOT NULL,
	scope VARCHAR(7) NOT NULL,
	mode CHAR(8) DEFAULT 'building',
	time_added BIGINT UNSIGNED NOT NULL,
	bank_view_count INT UNSIGNED DEFAULT 0,
	bank_type CHAR(6) NOT NULL,
	rating TINYINT UNSIGNED DEFAULT 0,
	CONSTRAINT scope_constraint CHECK(scope IN ('public', 'private')),
	CONSTRAINT mode_constraint CHECK(mode IN ('building', 'revision')),
	CONSTRAINT bank_type_constraint CHECK(bank_type IN ('origin', 'import')),
	FOREIGN KEY(owner_id) REFERENCES course(owner_id),
	FOREIGN KEY(school_id) REFERENCES school(school_id),
	FOREIGN KEY(course_id) REFERENCES course(course_id),
	PRIMARY KEY(bank_id, course_id, school_id, owner_id)";
	
/*
 * $config['bank_import'] = "importer_id INT UNSIGNED NOT NULL,
 * course_id SMALLINT UNSIGNED NOT NULL,
 * bank_id TINYINT UNSIGNED NOT NULL,
 * origin_owner_id INT UNSIGNED NOT NULL,
 * origin_course_id SMALLINT UNSIGNED NOT NULL,
 * origin_bank_id TINYINT UNSIGNED NOT NULL,
 * cost SMALLINT UNSIGNED DEFAULT 0,
 * FOREIGN KEY(importer_id) REFERENCES bank(owner_id),
 * FOREIGN KEY(course_id) REFERENCES bank(course_id),
 * FOREIGN KEY(bank_id) REFERENCES bank(bank_id),
 * FOREIGN KEY(origin_owner_id) REFERENCES bank(owner_id),
 * FOREIGN KEY(origin_course_id) REFERENCES bank(course_id),
 * FOREIGN KEY(origin_bank_id) REFERENCES bank(bank_id),
 * PRIMARY KEY(bank_id, course_id, school_id, importer_id)";
 */
 
/*
 * ACCESS BANK TABLE
 * access_request_state: pending/accepted
 * preview_finished: Y/N
 */
/*
 * $config['access_bank'] = "accessor_id INT UNSIGNED NOT NULL,
 * course_owner_id INT UNSIGNED NOT NULL,
 * course_id SMALLINT UNSIGNED NOT NULL,
 * bank_id TINYINT UNSIGNED NOT NULL,
 * access_request_state VARCHAR(8) DEFAULT 'pending',
 * permission CHAR(7) NOT NULL,
 * preview_time TINYINT DEFAULT 0,
 * preview_finished CHAR(1) DEFAULT 'N',
 * FOREIGN KEY(accessor_id) REFERENCES user(user_id),
 * FOREIGN KEY(course_owner_id) REFERENCES bank(owner_id),
 * FOREIGN KEY(course_id) REFERENCES bank(course_id),
 * FOREIGN KEY(bank_id) REFERENCES bank(bank_id),
 * PRIMARY KEY(accessor_id, bank_id, course_id, school_id, course_owner_id)";
 */
 
/*
 * REVISION TABLE
 * mode: sequential/random
 */
/* $config['revision'] = "
	bank_owner_id INT UNSIGNED NOT NULL,
	bank_course_id SMALLINT UNSIGNED NOT NULL,
	bank_id TINYINT UNSIGNED NOT NULL,
	revision_id SMALLINT UNSIGNED NOT NULL,
	start_time BIGINT UNSIGNED NOT NULL,
	elapsed_time BIGINT UNSIGNED,
	stop_time BIGINT UNSIGNED DEFAULT 0,
	confidence_score INT UNSIGNED DEFAULT 0,
	mode VARCHAR(10) NOT NULL,
	FOREIGN KEY(bank_owner_id) REFERENCES bank(owner_id),
	FOREIGN KEY(bank_course_id) REFERENCES bank(course_id),
	FOREIGN KEY(bank_id) REFERENCES bank(bank_id),
	PRIMARY KEY(revision_id, bank_id, bank_course_id, bank_owner_id)"; */

$config['chapter'] = "
	owner_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	course_id SMALLINT UNSIGNED NOT NULL,
	bank_id TINYINT UNSIGNED NOT NULL,
	chapter_id TINYINT UNSIGNED NOT NULL,
	chapter_title VARCHAR(50) NOT NULL,
	chapter_position SMALLINT UNSIGNED NOT NULL,
	chapter_type CHAR(6) NOT NULL,
	CONSTRAINT chapter_type_constraint CHECK(chapter_type IN ('origin', 'import')),
	FOREIGN KEY(owner_id) REFERENCES bank(owner_id),
	FOREIGN KEY(school_id) REFERENCES school(school_id),
	FOREIGN KEY(course_id) REFERENCES bank(course_id),
	FOREIGN KEY(bank_id) REFERENCES bank(bank_id),
	PRIMARY KEY(chapter_id, bank_id, course_id, school_id, owner_id)";

$config['question'] = "
	owner_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	course_id SMALLINT UNSIGNED NOT NULL,
	bank_id TINYINT UNSIGNED NOT NULL,
	chapter_id TINYINT UNSIGNED NOT NULL,
	question_id SMALLINT UNSIGNED NOT NULL,
	author_id INT UNSIGNED NOT NULL,
	question_position SMALLINT UNSIGNED NOT NULL,
	question_type CHAR(6) NOT NULL,
	question TEXT NOT NULL,
	answer TEXT,
	hint TEXT,
	revision_state VARCHAR(7) DEFAULT 'pending',
	confidence_score INT UNSIGNED,
	last_edit_time BIGINT UNSIGNED NOT NULL,
	CONSTRAINT revision_state_constraint CHECK(revision_state IN ('pending', 'done')),
	CONSTRAINT question_type_constraint CHECK(question_type IN ('origin', 'import')),
	FOREIGN KEY(owner_id) REFERENCES chapter(owner_id),
	FOREIGN KEY(school_id) REFERENCES school(school_id),
	FOREIGN KEY(course_id) REFERENCES chapter(course_id),
	FOREIGN KEY(bank_id) REFERENCES chapter(bank_id),
	FOREIGN KEY(chapter_id) REFERENCES chapter(chapter_id),
	PRIMARY KEY(question_id, chapter_id, bank_id, course_id, school_id, owner_id)";
	
/* QUESTION_COMMENT TABLE
 * resolved: Y/N
 */
/* $config['question_comment'] = "
	author_id INT UNSIGNED NOT NULL,
	school_id SMALLINT UNSIGNED NOT NULL,
	question_owner_id INT UNSIGNED NOT NULL,
	course_id SMALLINT UNSIGNED NOT NULL,
	bank_id TINYINT UNSIGNED NOT NULL,
	chapter_id TINYINT UNSIGNED NOT NULL,
	question_id SMALLINT UNSIGNED NOT NULL,
	comment TEXT NOT NULL,
	resolved CHAR(1) DEFAULT 'N',
	last_edit_time BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY(author_id) REFERENCES user(user_id),
	FOREIGN KEY(question_owner_id) REFERENCES question(owner_id),
	FOREIGN KEY(school_id) REFERENCES school(school_id),
	FOREIGN KEY(course_id) REFERENCES question(course_id),
	FOREIGN KEY(bank_id) REFERENCES question(bank_id),
	FOREIGN KEY(chapter_id) REFERENCES question(chapter_id),
	FOREIGN KEY(question_id) REFERENCES question(question_id),
	PRIMARY KEY(author_id, question_id, chapter_id, bank_id,  
							course_id, school_id, question_owner_id)"; */