<?php

namespace Database;

/* Класс конфигурации содержит константы для хоста базы данных, имени, пользователя и пароля. */

abstract class Config
{
	protected const DB_HOST = 'localhost';
	protected const DB_NAME = 'links';
	protected const DB_USER = 'root';
	protected const DB_PASS = 'root';
	protected const DB_PORT = '54331';
}
