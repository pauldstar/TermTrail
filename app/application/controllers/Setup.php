<?php

class Setup extends CI_Controller {

  public function create_database($passcode = '') {
    // later, add a passcode to prevent unauthorised database creation
    $this->load->database();
    $this->load->view("templates/header.php");
    Setup::create_table(
        "user", "
        user_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        username VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
        password_hash CHAR(60) NOT NULL,
        email VARCHAR(255) NOT NULL,
		account_balance MEDIUMINT DEFAULT 0,
        sign_up_time BIGINT UNSIGNED NOT NULL,
        last_login_time BIGINT UNSIGNED NOT NULL,
        has_notification CHAR(1) DEFAULT 'N',
        INDEX(username),
        PRIMARY KEY(user_id)");
    Setup::create_table(
        "course", "
        owner_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_title VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
        time_added BIGINT UNSIGNED NOT NULL,
        course_type CHAR(6) NOT NULL,
		category VARCHAR(50) NOT NULL,
		education_level VARCHAR(10) NOT NULL,
		INDEX(course_title),
        FOREIGN KEY(owner_id) REFERENCES user(user_id),
        PRIMARY KEY(course_id, owner_id)");
    Setup::create_table(
        "course_import", "
        importer_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
        origin_owner_id INT UNSIGNED NOT NULL,
        origin_course_id TINYINT UNSIGNED NOT NULL,
		cost SMALLINT UNSIGNED DEFAULT 0,
        FOREIGN KEY(importer_id) REFERENCES course(owner_id),
        FOREIGN KEY(course_id) REFERENCES course(course_id),
        FOREIGN KEY(origin_owner_id) REFERENCES course(owner_id),
        FOREIGN KEY(origin_course_id) REFERENCES course(course_id),
        PRIMARY KEY(importer_id, course_id, origin_owner_id, origin_course_id)");
	Setup::create_table(
        "access_course", "
		visitor INT UNSIGNED NOT NULL,
		course_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		access_request_state VARCHAR(8) DEFAULT 'pending',
		permission CHAR(4) NOT NULL,
        FOREIGN KEY(visitor) REFERENCES user(user_id),
        FOREIGN KEY(course_owner_id) REFERENCES term(owner_id),
        FOREIGN KEY(course_id) REFERENCES term(course_id),
        PRIMARY KEY(visitor, course_id, course_owner_id)");
	Setup::create_table(
        "trail", "
		owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
        trail_title VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
		mode CHAR(8) DEFAULT 'building',
        time_added BIGINT UNSIGNED NOT NULL,
		trail_type CHAR(6) NOT NULL,
		preview_length_time SMALLINT DEFAULT 1800,
        FOREIGN KEY(owner_id) REFERENCES course(owner_id),
        FOREIGN KEY(course_id) REFERENCES course(course_id),
        PRIMARY KEY(trail_id, course_id, owner_id)");
	Setup::create_table(
        "trail_import", "
		importer_id INT UNSIGNED NOT NULL,
		course_id SMALLINT UNSIGNED NOT NULL,
        trail_id TINYINT NOT NULL,
		origin_owner_id INT UNSIGNED NOT NULL,
		origin_course_id SMALLINT UNSIGNED NOT NULL,
		origin_trail_id TINYINT UNSIGNED NOT NULL,
		cost SMALLINT UNSIGNED DEFAULT 0,
        FOREIGN KEY(importer_id) REFERENCES trail(owner_id),
        FOREIGN KEY(course_id) REFERENCES trail(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        FOREIGN KEY(origin_owner_id) REFERENCES trail(owner_id),
        FOREIGN KEY(origin_course_id) REFERENCES trail(course_id),
        FOREIGN KEY(origin_trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(trail_id, course_id, owner_id)");
	Setup::create_table(
        "access_trail", "
		visitor INT UNSIGNED NOT NULL,
		course_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT NOT NULL,
		access_request_state VARCHAR(8) DEFAULT 'pending',
		permission CHAR(7) NOT NULL,
		preview_time TINYINT DEFAULT 0,
		preview_finished CHAR(1) DEFAULT 'N',
        FOREIGN KEY(visitor) REFERENCES user(user_id),
        FOREIGN KEY(course_owner_id) REFERENCES term(owner_id),
        FOREIGN KEY(course_id) REFERENCES term(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(visitor, trail_id, course_id, course_owner_id)");
	Setup::create_table(
        "chapter", "
		owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED NOT NULL,
		chapter_title VARCHAR(50) NOT NULL,
		chapter_position SMALLINT UNSIGNED NOT NULL,
        FOREIGN KEY(owner_id) REFERENCES trail(owner_id),
        FOREIGN KEY(course_id) REFERENCES trail(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(chapter_id, trail_id, course_id, owner_id)");
	Setup::create_table(
        "term", "
		owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED NOT NULL,
		term_id SMALLINT UNSIGNED NOT NULL,
		author_id INT UNSIGNED NOT NULL,
		term_position SMALLINT UNSIGNED NOT NULL,
		content TEXT NOT NULL,
		answer TEXT,
		hint TEXT,
		session_state VARCHAR(7) DEFAULT 'pending',
		confidence_score INT UNSIGNED,
		last_edit_time BIGINT UNSIGNED NOT NULL,
        FOREIGN KEY(owner_id) REFERENCES chapter(owner_id),
        FOREIGN KEY(course_id) REFERENCES chapter(course_id),
        FOREIGN KEY(trail_id) REFERENCES chapter(trail_id),
        FOREIGN KEY(chapter_id) REFERENCES chapter(chapter_id),
        PRIMARY KEY(term_id, chapter_id, trail_id, course_id, owner_id)");
	Setup::create_table(
        "term_comment", "
		author_id INT UNSIGNED NOT NULL,
		term_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED NOT NULL,
		term_id SMALLINT UNSIGNED NOT NULL,
		comment TEXT NOT NULL,
		resolved CHAR(1) DEFAULT 'N',
		last_edit_time BIGINT UNSIGNED NOT NULL,
        FOREIGN KEY(author_id) REFERENCES user(user_id),
        FOREIGN KEY(owner_id) REFERENCES term(owner_id),
        FOREIGN KEY(course_id) REFERENCES term(course_id),
        FOREIGN KEY(trail_id) REFERENCES term(trail_id),
        FOREIGN KEY(chapter_id) REFERENCES term(chapter_id),
        FOREIGN KEY(term_id) REFERENCES term(term_id),
        PRIMARY KEY(author_id, term_id, chapter_id, trail_id, course_id, owner_id)");
	Setup::create_table(
        "activity", "
        active_user INT UNSIGNED NOT NULL,
        passive_user INT UNSIGNED NOT NULL,
		message TEXT NOT NULL,
        has_been_viewed CHAR(1) DEFAULT 'N',
		time_added BIGINT UNSIGNED NOT NULL,
        FOREIGN KEY(active_user) REFERENCES user(user_id),
        FOREIGN KEY(passive_user) REFERENCES user(user_id),
        PRIMARY KEY(active_user, time_added)");
	Setup::create_table(
        "subscription", "
        user INT UNSIGNED NOT NULL,
        start_date BIGINT UNSIGNED NOT NULL,
        end_date BIGINT UNSIGNED NOT NULL,
		cost TINYINT UNSIGNED NOT NULL,
        FOREIGN KEY(user) REFERENCES user(user_id),
        PRIMARY KEY(user)");
	Setup::create_table(
        "session", "
		trail_owner_id INT UNSIGNED NOT NULL,
        trail_course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		session_id SMALLINT UNSIGNED NOT NULL,
		start_time BIGINT UNSIGNED NOT NULL,
		elapsed_time BIGINT UNSIGNED,
		stop_time BIGINT UNSIGNED,
		confidence_score INT UNSIGNED DEFAULT 0,
        mode VARCHAR(10) DEFAULT 'sequential',
		FOREIGN KEY(trail_owner_id) REFERENCES trail(owner_id),
        FOREIGN KEY(trail_course_id) REFERENCES trail(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(session_id, trail_id, trail_course_id, trail_id)");
	
    /*
     * create_table('link',
     * '
     * url VARCHAR(500) NOT NULL,
     * client INT NOT NULL,
     * linkType VARCHAR(20) NOT NULL,
     * clicked BIGINT UNSIGNED DEFAULT 0,
     * timeAdded BIGINT UNSIGNED NOT NULL,
     * rate TINYINT UNSIGNED DEFAULT 0,
     * FOREIGN KEY(client) REFERENCES user(userID),
     * PRIMARY KEY(url, client)');
     *
     * createTable('click',
     * '
     * clickID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
     * timeAdded BIGINT UNSIGNED NOT NULL,
     * clickerType VARCHAR(20) NOT NULL,
     * user INT,
     * clickType VARCHAR(20) NOT NULL,
     * url VARCHAR(500) NOT NULL,
     * owner INT NOT NULL,
     * referredBy INT,
     * FOREIGN KEY(url, owner) REFERENCES link(url, client),
     * FOREIGN KEY(user) REFERENCES user(userID),
     * FOREIGN KEY(referredBy) REFERENCES user(userID),
     * PRIMARY KEY(clickID)');
     *
     * createTable('accountActivity',
     * '
     * timeAdded BIGINT UNSIGNED NOT NULL,
     * user INT NOT NULL,
     * actionType VARCHAR(20) NOT NULL,
     * penniesUsed MEDIUMINT NOT NULL,
     * FOREIGN KEY(user) REFERENCES user(userID),
     * PRIMARY KEY(user, timeAdded)');
     *
     * createTable('subscription',
     * '
     * discoverer INT NOT NULL,
     * subscriber INT NOT NULL,
     * timeAdded BIGINT UNSIGNED NOT NULL,
     * FOREIGN KEY(discoverer) REFERENCES user(userID),
     * FOREIGN KEY(subscriber) REFERENCES user(userID),
     * PRIMARY KEY(discoverer, subscriber)');
     *
     * createTable('referral',
     * '
     * signUpCode VARCHAR(50) NOT NULL,
     * referrer INT NOT NULL,
     * newUser INT,
     * timeAdded BIGINT UNSIGNED NOT NULL,
     * FOREIGN KEY(referrer) REFERENCES user(userID),
     * FOREIGN KEY(newUser) REFERENCES user(userID),
     * PRIMARY KEY(signUpCode)');
     * echo "</ul></div></div>";
     */
    $this->load->view("templates/footer.php");
  }

  private function create_table($name, $query) {
    $query_successful = $this->db->query(
        "CREATE TABLE IF NOT EXISTS $name($query) ENGINE InnoDB");
    if ($query_successful) {
      $data['name'] = $name;
      $this->load->view("setup/text_table_created", $data);
    } else
      show_error("Can't create table '$name'");
  }

  private function drop_table($name) {
    $query_successful = $this->db->query("DROP TABLE IF EXISTS $name");
    if ($query_successful) {
      $data['name'] = $name;
      $this->load->view("setup/text_table_dropped", $data);
    } else
      show_error("Can't drop table '$name'");
  }
}