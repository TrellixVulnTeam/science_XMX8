<?php
namespace App\Database;

use PDO;

class DbRepair{
    private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $dbName = "db_repair";

	protected $pdo;

	function __construct() {
		$this->pdo = $this->connect();
	}

	protected function connect() {
		$dsn = "mysql:host={$this->host};dbname={$this->dbName}";
		$pdo = new PDO($dsn, $this->user, $this->password);
		$pdo->exec("set names utf8");
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		date_default_timezone_set('Asia/Bangkok');
		return $pdo;
	}
    
}
?>