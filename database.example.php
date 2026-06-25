<?php
/**
 * Database connection template for the public forms application.
 *
 * Setup:
 *   1. Copy this file to database.php in the same directory:
 *        copy database.example.php database.php
 *   2. Set your local/production MySQL credentials below.
 *
 * database.php is gitignored and must exist on every server.
 */

class Database
{

	private static $connection = null;

	private $query_type;
	private $columns;
	private $values;
	private $where;
	private $limit;


	public function __construct() {
		$conn = $this->Conn();
		self::$connection = $conn;
	}

	public function Conn()
	{
		$hostname = 'localhost';
		$username = 'your_db_username';
		$password = 'your_db_password';
		$database = 'hospice_forms';

		$conn = new mysqli($hostname, $username, $password, $database);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

}
