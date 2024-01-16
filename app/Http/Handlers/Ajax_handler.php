<?php
/* Здесь будем обрабатывать ajax-запросы приходящие с фронта */

require_once('../../../vendor/autoload.php');

use App\Http\Service\LinkShortener;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    $linkShortener = new LinkShortener($url);
    $newUrl = $linkShortener->generateUrl();

    echo json_encode(['url' => $newUrl]);
}