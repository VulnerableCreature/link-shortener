<?php

namespace App\Http\Service;

/* Класс LinkShortener отвечает за генерацию и получение коротких ссылок */

class LinkShortener
{
	private string $originalUrl;

	public function __construct(string $url)
	{
		$this->originalUrl = $url;
	}

	/**
	 * Функция генерирует случайную строку длиной 6 символов строчных и верхних букв, цифр.
	 * 
	 * 	@param int $length [Необзательный параметр]
	 *
	 * Возвращает: случайную строку длиныой 6 символов.
	 */
	public function generateRandomString(int $length = 6): string
	{
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters)) - 1];
		}

		return $randomString;
	}
}