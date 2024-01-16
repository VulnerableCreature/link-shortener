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
- [ ] Класс для обработки коротких ссылок
- [ ] Обработчик запроса (Ajax)
- [ ] База данных
- [ ] Модель таблицы
- [ ] Вывод ссылок
- [ ] Реализация авторизации

# Что читал для реализации

> [XMLHttpRequest](https://learn.javascript.ru/xmlhttprequest)

> [Что такое сокращение ссылок](https://proglib.io/p/a-mozhno-pokoroche-kak-rabotayut-sokrashchateli-ssylok-2020-02-24)

> [Полезно (Задача собеседования)](https://habr.com/ru/articles/746602/)

> [Алгоритм](https://stackoverflow.com/questions/742013/how-do-i-create-a-url-shortener)

> [Object URL JavaScript](https://learn.javascript.ru/url)

# Реализация

> 1. Начал описывать класс LinkShortener

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

> 2. Ajax-запрос

Информацию об этом читал отсюда [Link](https://learn.javascript.ru/xmlhttprequest)

Изменил функцию `generateUrl()` добавив в неё Ajax-запрос.

```bash
const xhr = new XMLHttpRequest();
xhr.open('POST', 'app/Http/Handlers/Ajax_handler.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onreadystatechange = function() {
if (xhr.readyState === 4 && xhr.status === 200) {
    const response = JSON.parse(xhr.responseText);
    document.getElementById('shortUrlResult').innerText = 'Short URL: ' + response.url;
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
