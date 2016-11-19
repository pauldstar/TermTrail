<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * | -------------------------------------------------------------------
 * | DATABASE CONNECTIVITY SETTINGS
 * | -------------------------------------------------------------------
 * | This file will contain the settings needed to access your database.
 * |
 * | For complete instructions please consult the 'Database Connection'
 * | page of the User Guide.
 * |
 * | -------------------------------------------------------------------
 * | EXPLANATION OF VARIABLES
 * | -------------------------------------------------------------------
 * |
 * | ['dsn'] The full DSN string describe a connection to the database.
 * | ['hostname'] The hostname of your database server.
 * | ['username'] The username used to connect to the database
 * | ['password'] The password used to connect to the database
 * | ['database'] The name of the database you want to connect to
 * | ['dbdriver'] The database driver. e.g.: mysqli.
 * | Currently supported:
 * | cubrid, ibase, mssql, mysql, mysqli, oci8,
 * | odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
 * | ['dbprefix'] You can add an optional prefix, which will be added
 * | to the table name when using the Query Builder class
 * | ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
 * | ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
 * | ['cache_on'] TRUE/FALSE - Enables/disables query caching
 * | ['cachedir'] The path to the folder where cache files should be stored
 * | ['char_set'] The character set used in communicating with the database
 * | ['dbcollat'] The character collation used in communicating with the database
 * | NOTE: For MySQL and MySQLi databases, this setting is only used
 * | as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
 * | (and in table creation queries made with DB Forge).
 * | There is an incompatibility in PHP with mysql_real_escape_string() which
 * | can make your site vulnerable to SQL injection if you are using a
 * | multi-byte character set and are running versions lower than these.
 * | Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
 * | ['swap_pre'] A default table prefix that should be swapped with the dbprefix
 * | ['encrypt'] Whether or not to use an encrypted connection.
 * |
 * | 'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
 * | 'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
 * |
 * | 'ssl_key' - Path to the private key file
 * | 'ssl_cert' - Path to the public key certificate file
 * | 'ssl_ca' - Path to the certificate authority file
 * | 'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
 * | 'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
 * | 'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
 * |
 * | ['compress'] Whether or not to use client compression (MySQL only)
 * | ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
 * | - good for ensuring strict SQL while developing
 * | ['ssl_options'] Used to set various SSL options that can be used when making SSL connections.
 * | ['failover'] array - A array with 0 or more data for connections if the main should fail.
 * | ['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
 * | NOTE: Disabling this will also effectively disable both
 * | $this->db->last_query() and profiling of DB queries.
 * | When you run a query, with this setting set to TRUE (default),
 * | CodeIgniter will store the SQL statement for debugging purposes.
 * | However, this may cause high memory usage, especially if you run
 * | a lot of SQL queries ... disable this to avoid that problem.
 * |
 * | The $active_group variable lets you choose which connection group to
 * | make active. By default there is only one group (the 'default' group).
 * |
 * | The $query_builder variables lets you determine whether or not to load
 * | the query builder class.
 */
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn' => '', 
    'hostname' => 'localhost', 
    'username' => 'pauldstar2', 
    'password' => 'B2pDAaJhPw5R9uX6', 
    'database' => 'termtrail', 
    'dbdriver' => 'mysqli', 
    'dbprefix' => '', 
    'pconnect' => FALSE, 
    'db_debug' => (ENVIRONMENT !== 'production'), 
    'cache_on' => FALSE, 
    'cachedir' => '', 
    'char_set' => 'utf8', 
    'dbcollat' => 'utf8_general_ci', 
    'swap_pre' => '', 
    'encrypt' => FALSE, 
    'compress' => FALSE, 
    'stricton' => FALSE, 
    'failover' => array(), 
    'save_queries' => TRUE);

// Table names and structure
// The tables are ordered in a steadily ascending order of foreign key references
// config[table_name] = "structure";
config['user'] = "user_id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        scope VARCHAR(7) NOT NULL,
        password_hash CHAR(60) NOT NULL,
        email VARCHAR(255) NOT NULL,
		profile_view_count INT UNSIGNED NOT NULL,
		account_balance MEDIUMINT DEFAULT 0,
        sign_up_time BIGINT UNSIGNED NOT NULL,
        last_login_time BIGINT UNSIGNED NOT NULL,
        has_notification CHAR(1) DEFAULT 'N',
        INDEX(username),
        PRIMARY KEY(user_id)";

config['subscription'] = "user INT UNSIGNED NOT NULL,
        start_date BIGINT UNSIGNED NOT NULL,
        end_date BIGINT UNSIGNED NOT NULL,
		cost TINYINT UNSIGNED NOT NULL,
        FOREIGN KEY(user) REFERENCES user(user_id),
        PRIMARY KEY(user)";

config['activity'] = "active_user INT UNSIGNED NOT NULL,
        passive_user INT UNSIGNED NOT NULL,
		time_added BIGINT UNSIGNED NOT NULL,
		message TEXT NOT NULL,
        has_been_viewed CHAR(1) DEFAULT 'N',
        FOREIGN KEY(active_user) REFERENCES user(user_id),
        FOREIGN KEY(passive_user) REFERENCES user(user_id),
        PRIMARY KEY(active_user, passive_user, time_added)";

config['course'] = "owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
        course_title VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
        time_added BIGINT UNSIGNED NOT NULL,
		course_view_count INT UNSIGNED NOT NULL,
        course_type CHAR(6) NOT NULL,
		category VARCHAR(50) NOT NULL,
		education_level VARCHAR(10) NOT NULL,
		INDEX(course_title),
		INDEX(course_type),
		INDEX(category),
		INDEX(education_level),
        FOREIGN KEY(owner_id) REFERENCES user(user_id),
        PRIMARY KEY(course_id, owner_id)";

config['course_import'] = "importer_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
        origin_owner_id INT UNSIGNED NOT NULL,
        origin_course_id SMALLINT UNSIGNED NOT NULL,
		cost SMALLINT UNSIGNED DEFAULT 0,
        FOREIGN KEY(importer_id) REFERENCES course(owner_id),
        FOREIGN KEY(course_id) REFERENCES course(course_id),
        FOREIGN KEY(origin_owner_id) REFERENCES course(owner_id),
        FOREIGN KEY(origin_course_id) REFERENCES course(course_id),
        PRIMARY KEY(importer_id, course_id)";

config['access_course'] = "visitor INT UNSIGNED NOT NULL,
		course_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		access_request_state VARCHAR(8) DEFAULT 'pending',
		permission CHAR(4) NOT NULL,
        FOREIGN KEY(visitor) REFERENCES user(user_id),
        FOREIGN KEY(course_owner_id) REFERENCES course(owner_id),
        FOREIGN KEY(course_id) REFERENCES course(course_id),
        PRIMARY KEY(visitor, course_id, course_owner_id)";

config['trail'] = "owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
        trail_title VARCHAR(50) NOT NULL,
        scope VARCHAR(7) NOT NULL,
		mode CHAR(8) DEFAULT 'building',
        time_added BIGINT UNSIGNED NOT NULL,
		trail_view_count INT UNSIGNED NOT NULL,
		trail_type CHAR(6) NOT NULL,
		preview_length_time SMALLINT DEFAULT 1800,
        FOREIGN KEY(owner_id) REFERENCES course(owner_id),
        FOREIGN KEY(course_id) REFERENCES course(course_id),
        PRIMARY KEY(trail_id, course_id, owner_id)";

config['trail_import'] = "importer_id INT UNSIGNED NOT NULL,
		course_id SMALLINT UNSIGNED NOT NULL,
        trail_id TINYINT UNSIGNED NOT NULL,
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
        PRIMARY KEY(trail_id, course_id, importer_id)";

config['access_trail'] = "visitor INT UNSIGNED NOT NULL,
		course_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		access_request_state VARCHAR(8) DEFAULT 'pending',
		permission CHAR(7) NOT NULL,
		preview_time TINYINT DEFAULT 0,
		preview_finished CHAR(1) DEFAULT 'N',
        FOREIGN KEY(visitor) REFERENCES user(user_id),
        FOREIGN KEY(course_owner_id) REFERENCES trail(owner_id),
        FOREIGN KEY(course_id) REFERENCES trail(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(visitor, trail_id, course_id, course_owner_id)";

config['session'] = "trail_owner_id INT UNSIGNED NOT NULL,
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
        PRIMARY KEY(session_id, trail_id, trail_course_id, trail_owner_id)";

config['chapter'] = "owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
		chapter_title VARCHAR(50) NOT NULL,
		chapter_position SMALLINT UNSIGNED NOT NULL,
        FOREIGN KEY(owner_id) REFERENCES trail(owner_id),
        FOREIGN KEY(course_id) REFERENCES trail(course_id),
        FOREIGN KEY(trail_id) REFERENCES trail(trail_id),
        PRIMARY KEY(chapter_id, trail_id, course_id, owner_id)";

config['term'] = "owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED NOT NULL,
		term_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
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
        PRIMARY KEY(term_id, chapter_id, trail_id, course_id, owner_id)";

config['term_comment'] = "author_id INT UNSIGNED NOT NULL,
		term_owner_id INT UNSIGNED NOT NULL,
        course_id SMALLINT UNSIGNED NOT NULL,
		trail_id TINYINT UNSIGNED NOT NULL,
		chapter_id TINYINT UNSIGNED NOT NULL,
		term_id SMALLINT UNSIGNED NOT NULL,
		comment TEXT NOT NULL,
		resolved CHAR(1) DEFAULT 'N',
		last_edit_time BIGINT UNSIGNED NOT NULL,
        FOREIGN KEY(author_id) REFERENCES user(user_id),
        FOREIGN KEY(term_owner_id) REFERENCES term(owner_id),
        FOREIGN KEY(course_id) REFERENCES term(course_id),
        FOREIGN KEY(trail_id) REFERENCES term(trail_id),
        FOREIGN KEY(chapter_id) REFERENCES term(chapter_id),
        FOREIGN KEY(term_id) REFERENCES term(term_id),
        PRIMARY KEY(author_id, term_id, chapter_id, trail_id, course_id, term_owner_id)";
