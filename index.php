<?php
require_once('vendor/autoload.php');

use App\Http\Service\LinkShortener;

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Shortener | IQ Media</title>
    <style>
    .form-request {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-request form {
        margin: 0 auto;
    }

    .form-request form>input[type="text"] {
        padding: 6px 8px 6px 8px;
        width: 500px;
        border: 1px solid #c8c8c8;
        border-radius: 4px;
    }

    .form-request form>input[type="text"]:focus {
        outline-color: #217aff;
    }

    .form-request form>button {
        padding: 6px 8px 6px 8px;
        width: 200px;
        border: 1px solid #c8c8c8;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-style: italic;
    }

    .form-request form>button:hover {
        background-color: black;
        color: white;
        transition: all 0.1s ease-out;
        transition-duration: 0.5s;
    }

    .result {
        margin-top: 10px;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-decoration: underline;
        color: red;
    }
    </style>
</head>

<body>
    <?php
	$shortener = new LinkShortener('fkwfjkwe');
	$random = $shortener->generateUrl();
	echo $random;
	?>
    <div class="form-request">
        <form id="UrlForm">
            <input type="text" name="url" id="uniqueUrl">
            <button type="button" onClick="generateUrl();">Сократить ссылку</button>
        </form>
        <div class="result" id="urlResult"></div>
    </div>
    <script>
    function generateUrl() {
        const url = document.getElementById('uniqueUrl').value;
        const message = document.getElementById('urlResult');


        if (url == '') {
            console.log("Input is Empty");
            message.innerText = 'Введите адрес';
            return;
        }

        console.log(url);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'app/Http/Handlers/Ajax_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            try {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    const response = JSON.parse(xhr.responseText);
                    message.innerText = 'Короткая ссылка: ' + response.url;
                }
            } catch (err) {
                console.log(err);
            }
        };

        xhr.send('url=' + encodeURIComponent(url));
    }
    </script>
</body>

</html>