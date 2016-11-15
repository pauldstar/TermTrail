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
        sign_up_time BIGINT UNSIGNED NOT NULL,
        last_login_time BIGINT UNSIGNED NOT NULL,
        has_notification CHAR(1) DEFAULT 'N',
        INDEX(username),
        PRIMARY KEY(user_id)");
    Setup::create_table(
        "course", "
        owner_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_name VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
        time_added BIGINT UNSIGNED NOT NULL,
        course_type CHAR(6) NOT NULL,
        FOREIGN KEY(owner_id) REFERENCES user(user_id),
        PRIMARY KEY(course_id, owner_id)");
    Setup::create_table(
        "course_import", "
        importer_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
        origin_owner_id INT UNSIGNED NOT NULL,
        origin_course_id TINYINT UNSIGNED NOT NULL,
        FOREIGN KEY(importer_id) REFERENCES user(user_id),
        FOREIGN KEY(course_id) REFERENCES user(course_id),
        FOREIGN KEY(origin_owner_id) REFERENCES user(user_id),
        FOREIGN KEY(origin_course_id) REFERENCES user(course_id),
        PRIMARY KEY(importer_id, course_id, origin_owner_id, origin_course_id)");
    
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