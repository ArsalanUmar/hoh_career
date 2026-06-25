<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Database connection template for the CodeIgniter admin panel (manage/).
 *
 * Setup:
 *   1. Copy this file to database.php in the same directory:
 *        copy database.example.php database.php
 *   2. Set your local/production MySQL credentials in $db['default'] below.
 *
 * database.php is gitignored and must exist on every server.
 */

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'your_db_username',
	'password' => 'your_db_password',
	'database' => 'hospice_forms',
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
	'save_queries' => TRUE
);
