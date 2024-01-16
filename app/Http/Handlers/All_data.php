<?php
require_once('../../../vendor/autoload.php');

use App\Http\Models\Url;

$url = new Url();
$urls = $url->selectUrls();

echo json_encode($urls);
