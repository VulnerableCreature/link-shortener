function copyToClickBoard() {
    let content = document.getElementById('urlResult').innerHTML;
    const message = document.getElementById('copyMessage');
  
    navigator.clipboard.writeText(content)
        .then(() => {
            console.log('Text copied to clipboard...');
            message.innerText = 'Текст успешно скопирован!';
        })
        .catch(err => {
          console.log('Something went wrong', err);
          message.innerText = 'Error: ' + err;
        });
  }