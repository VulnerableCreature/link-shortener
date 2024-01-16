<?php

namespace App\Http\Models;

use App\Http\Interfaces\IUrlInterface;

/* Модель таблицы в базе данных для хранения коротких ссылок */
use Database\Database;


class Url implements IUrlInterface
{
	/**
	 * Функция Selecturls извлекает все полные и короткие URL -адреса из таблицы базы данных.
	 *
	 * @return array массив URLS
	 */
	public function selectUrls(): array
	{
		$database = new Database();
		$connect = $database->getConnect();

		$statement = $connect->query("SELECT full_url, short_url FROM urls");

		$urls = $statement->fetchAll();

		return $urls;
	}

	/**
	 * Функция Addurl вставляет полный URL и соответствующий короткий URL в базу данных.
	 *
	 * @param String fullUrl
	 * @param String shorturl
	 */
	public function addUrl(string $fullUrl, string $shortUrl): void
	{
		$database = new Database();
		$connect = $database->getConnect();

		$sql = 'INSERT INTO urls (full_url, short_url) VALUES (:full_url, :short_url)';

		$statement = $connect->prepare($sql);

		$statement->execute([
			':full_url' => $fullUrl,
			':short_url' => $shortUrl
		]);
	}
}
