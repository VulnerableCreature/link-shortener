<?php

namespace Database;

use PDO;
use PDOException;

/* Класс базы данных подключается к базе данных PostgreSQL, используя предоставленные значения конфигурации. */

class Database extends Config
{
	public function getConnect(): PDO
	{
		$host = self::DB_HOST;
		$db = self::DB_NAME;
		$port = self::DB_PORT;
		$user = self::DB_USER;
		$password = self::DB_PASS;

		$dsn = "pgsql:host=$host;port=$port;dbname=$db;";

		try {
			return new PDO(
				$dsn,
				$user,
				$password,
			);
		} catch (PDOException $exception) {
			die($exception->getMessage());
		}
	}
}
