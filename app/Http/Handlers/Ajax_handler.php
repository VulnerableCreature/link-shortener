<?php
/* Здесь будем обрабатывать ajax-запросы приходящие с фронта */

require_once('../../../vendor/autoload.php');

use App\Http\Service\LinkShortener;
use App\Http\Models\Url;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    $linkShortener = new LinkShortener($url);
    $newUrl = $linkShortener->generateUrl();

    $urls = new Url();
    $urls->addUrl($url, $newUrl);

    echo json_encode(['url' => $newUrl]);
}
