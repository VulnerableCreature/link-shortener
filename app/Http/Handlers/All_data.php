<?php
require_once('../../../vendor/autoload.php');

use App\Http\Models\Url;

$url = new Url();
$urls = $url->selectUrls();

header('Content-Type: application/json');
json_encode($urls);
