function generateUrl() {
    const url = document.getElementById('uniqueUrl').value;
    const message = document.getElementById('urlResult');
    let btnCopy = document.getElementById('btn_copy');


    if (url == '') {
        console.log(" Input is Empty");
        message.innerText = 'Введите адрес';
        return;
    }
    console.log(url);

    btnCopy.classList.remove("hide");

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'app/Http/Handlers/Ajax_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
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