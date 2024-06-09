document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('domain-rank-api-submit');
    let validated = true;

    if(!submitButton){

        return
    }

    submitButton.addEventListener('click', function(e) {
        e.preventDefault();
        validated = true;
        let apiKeyInput = document.querySelector('input[name="domain-rank-api-key"]');
        if(apiKeyInput.value === ''){
            validated = false;
            apiKeyInput.classList.add('error');

            return;
        }

        if(validated){
            const data = {
                    action: 'process_api_key',
                    api_key: apiKeyInput.value
                };

            fetch(ajax_object.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    apiKeyInput.value = '';
                    apiKeyInput.placeholder = data.data.api_key;
                } else {
                    console.log('Error:', data);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
