<?php

namespace App\Http\Interfaces;

interface IUrlInterface
{
	public function addUrl(string $fullUrl, string $shortUrl): void;
	public function selectUrls(): array;
}
