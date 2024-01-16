getUrls();
function generateUrl() {

    let data = {
        url: document.getElementById('uniqueUrl').value,
        message: document.getElementById('urlResult'),
    };

    const { url, message } = data;

    let btnCopy = document.getElementById('btn_copy');

    if (url == '') {
        console.log(" Input is Empty");
        message.innerText = 'Введите адрес';
        return;
    }
    console.log(url);

    btnCopy.classList.remove("hide");

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'app/Http/Handlers/Ajax_handler.php', false);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        try {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                const
                    response = JSON.parse(xhr.responseText);
                message.innerText = response.url;
            }
        } catch (err) {
            console.log(err);
        }
    };

    xhr.send('url=' + encodeURIComponent(url));
}

async function getUrls() {
    let response = await fetch('app/Http/Handlers/All_data.php', { method: 'GET' });
    let content = await response.json();
    console.log(content);

    let ul = document.querySelector('.list');

    for (let key in content) {
        ul.innerHTML += `<li><span>${content[key].short_url}</span> <a href="${content[key].full_url}" target="_blank">Перейти</a></li> `
    }
}