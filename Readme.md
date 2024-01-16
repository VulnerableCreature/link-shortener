# IQ Media

1. Посетитель сайта вводит любой оригинальный URL-адрес в поле ввода.
2. Нажимает кнопку submit.

3. Страница делает ajax-запрос на сервер и получает уникальный короткий URL-адрес.
4. Сгенерированный URL-адрес отображается на странице в ответном сообщении.
5. Посетитель может скопировать короткий URL-адрес и повторить процесс с другой ссылкой.

`Использовать классы.` Не использовать фреймворк.
Короткий URL должен уникальным и перенаправлять на ссылку привязанную к данному URL.

Приветствуется:
Реализация авторизации, где пользователь, создавший короткую ссылку может посмотреть статистику переходов по ней.

## Tasks

- [x] Форма ввода
- [x] Класс для обработки коротких ссылок
- [x] Обработчик запроса (Ajax)
- [x] Отображение короткой ссылки
- [x] Посетитель может скопировать

# Что читал для реализации

> [XMLHttpRequest](https://learn.javascript.ru/xmlhttprequest)

> [Что такое сокращение ссылок](https://proglib.io/p/a-mozhno-pokoroche-kak-rabotayut-sokrashchateli-ssylok-2020-02-24)

> [Полезно (Задача собеседования)](https://habr.com/ru/articles/746602/)

> [Алгоритм](https://stackoverflow.com/questions/742013/how-do-i-create-a-url-shortener)

> [Object URL JavaScript](https://learn.javascript.ru/url)

# Реализация

> ## Начал описывать класс LinkShortener

Написал функцию для генерации случайной строки. Решил простестировать вызвав её в index.php и получил ошибку.

```bash
127.0.0.1:54029 [200]: GET / - Uncaught Error: Class "App\Http\Service\LinkShortener" not found in C:\!Projects\link-shortener\index.php:67
Stack trace:
#0 {main}
  thrown in C:\!Projects\link-shortener\index.php on line 67
```

- Ошибка связана с тем, что он не видит этот файл

> Решение:

Можно использовать переменную `__DIR__` или `composer`

> Выбрал composer. Описал файл `composer.json` и выполнил команду `composer install`

> В файл index.php подключил файл автозагрузчика `require_once('vendor/autoload.php');`

И следующим шагом указал, что будем использовать namespace: `use App\Http\Service\LinkShortener;`

> Генерация коротких ссылок

Создал функцию `genarteUrl(): string` в ней буду обрабатывать входящую ссылку и возвращать новую сгенирированную короткую ссылку.

```bash
public function generateUrl(): string
{
	$shortUrl = $this->generateRandomString();
	$shortUrl = $this->originalUrl . $shortUrl;

	return $shortUrl;
}
```

Проверяю работу.
В `index.php`

```bash
$shortener = new LinkShortener('fkwfjkwe');
$random = $shortener->generateUrl();
echo $random;
```

Получаю вот такой результат:

> `fkwfjkweAH2UDi`

> ## Ajax-запрос

Информацию об этом читал отсюда [Link](https://learn.javascript.ru/xmlhttprequest)

Изменил функцию `generateUrl()` добавив в неё Ajax-запрос.

```bash
const xhr = new XMLHttpRequest();
xhr.open('POST', 'app/Http/Handlers/Ajax_handler.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onreadystatechange = function() {
if (xhr.readyState === 4 && xhr.status === 200) {
    const response = JSON.parse(xhr.responseText);
    document.getElementById('shortUrlResult').innerText = 'Короткая ссылка: ' + response.url;
}
};
xhr.send('url=' + encodeURIComponent(url));
```

Создал объект для возможности отправлять HTTP запросы;
Отправляю запрос 'POST' на обработчик запросов `Ajax_handler.php` в нем указываю моковую реализацию для возврата ответа.

```bash
<?php
/* Здесь будем обрабатывать ajax-запросы приходящие с фронта */

echo json_encode(['url' => 'Answer']);
```

Добавляю HTTP-заголовки, указываю что это данные будут в формате `json`

Отправляю данные на сервер в закодированном виде используя функцию `encodeURIComponent(url)` - url ссылка которую мы передаём

Про данную функцию прочитал тут: [Link](https://www.geeksforgeeks.org/how-to-encode-and-decode-a-url-in-javascript/)

Далее проверяю состояние запроса: если состояние === 4(запрос завершен) и сетевой статус === 200 получаю данные с сервера и вывожу на страницу новую сгенированную ссылку.

> ## Описываю Handler

Написал вот такую реализацию

```bash
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    $linkShortener = new LinkShortener($url);
    $newUrl = $linkShortener->generateUrl();

    echo json_encode(['url' => 'asd']);
}
```

Но с ней получаю ошибку

```bash
VM669:1 Uncaught SyntaxError: Unexpected token '<', "<br />
<b>"... is not valid JSON
    at JSON.parse (<anonymous>)
    at xhr.onreadystatechange ((индекс):87:39)
xhr.onreadystatechange	@	(индекс):87
Объект XMLHttpRequest.send (асинхронный)
generateUrl	@	(индекс):92
onclick
```

> Описание проблемы: при отправке формы на сервер(обработчик) возникает данная ошибка (Пока непонятно по чему)

> Решение проблемы: ошибка заключался в том, что я отправлял данные в формате `json` - это было указано в HTTP-заголовке `xhr.setRequestHeader('Content-Type', 'application/json');`, но мы то отправляем форму на сервер, а оттуда получаем данные в формате `json`. Поэтому необходимо заменить в заголовке `application/json` на `x-www-form-urlencoded`

Информацию вычитал здесь: [Link](https://zdrons.ru/veb-programmirovanie/application-x-www-form-urlencoded-php-osobennosti-i-primery-ispolzovaniya/)

В результате получаем следующее

```bash
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    // $linkShortener = new LinkShortener($url);
    // $newUrl = $linkShortener->generateUrl();

    echo json_encode(['url' => 'asd']);
}
```

```bash
Короткая ссылка: asd
```

После возвращения кода для генерации коротких ссылок, ошибка вновь вернулась она была связана с тем, что в `Ajax-handler` он не понимал, что за класс `LinkShortener`, выяснил это путем печати лога в консоль
`console.log(xhr.responseText);`

> Печать лога в консоль по которому стала ясна проблема.

```bash
<br />
<b>Fatal error</b>:  Uncaught Error: Class &quot;App\Http\Service\LinkShortener&quot; not found in C:\!Projects\link-shortener\app\Http\Handlers\Ajax_handler.php:11
Stack trace:
#0 {main}
  thrown in <b>C:\!Projects\link-shortener\app\Http\Handlers\Ajax_handler.php</b> on line <b>11</b><br />
```

Для решения добавляем эту строчку `require_once('../../../vendor/autoload.php');` в `Ajax-handler` и всё работает.

```bash
Короткая ссылка: 123123R9EaTi
```

Попробовал сократить ссылку и получил вот такой результат:

> исходная ссылка

```bash
https://learn.javascript.ru/xmlhttprequest#sostoyaniya-zaprosa
```

> результат

```bash
Короткая ссылка: https://learn.javascript.ru/xmlhttprequest#sostoyaniya-zaprosaJ5p6gC
```

> !!!В результате ссылка не сократилась, а стала больше. (Не тот результат, который должен быть) - ссылка работает и переходит на сайт.

> ## Решение проблемы с сокращением ссылки

Информацию взял отсюда: [Link](https://nomadphp.com/blog/64/creating-a-url-shortener-application-in-php-mysql)

Для решения проблемы будем использовать следующий трюк.

> Необходимо изменить класс `LinkShortener` слудующим образом:

1. Добавляем поле `private const BASE_URL = 'http://127.0.0.1:8000/'`
2. Изменяем метод для генерации коротких ссылок, строчку `$shortUrl = $this->originalUrl . $shortUrl;` на `self::BASE_URL . $shortUrl`

В результате этого действия получаем следующий результат:

```bash
Короткая ссылка: http://127.0.0.1:8000/qLBk4N
```

## Копирование в буфер обмена

Информацию по копированию в буфер читал тут: [Link](https://www.delftstack.com/howto/javascript/javascript-copy-to-clipboard/#:~:text=Using%20the%20document.execCommand('copy')%20method%2C%20we,Using%20Clipboard%20API%20in%20JavaScript)

