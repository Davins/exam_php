<?php


$phone = $_POST['to_phone'];
$message = $_POST['message'];
$url = 'https://fatsms.com/send-sms';
$data = array('to_phone' => $phone, 'message' => $message, 'api_key' => '6483be05-058d-4bb8-9e3e-17ce9103412d');


$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exercise.css" />
    <title>Document</title>
</head>

<body>
    <form class="sup" onsubmit="return false">
        <label for="to_phone">Number</label>
        <input type="number" name="to_phone" id="to_phone" min="8" required>
        <label for="message">Message</label>
        <input type="text" name="message" id="message" required>
        <button onclick="send()">Send Sms</button>
        <p class="response"></p>
    </form>
   
</body>


<script>
    function send() {
        const to_phone = document.querySelector('#to_phone');
        const message = document.querySelector('#message');
        const response = document.querySelector('.response');
        const form = document.querySelector("form");
        if(to_phone.value.length < 8){
        
            response.textContent = "number minimum 8 characters"
            return false;
        }
        if(form.checkValidity()){
        form.checkValidity();
        form.reportValidity();
        }
        const formData = new FormData();
        formData.append('to_phone', to_phone.value);
        formData.append('message', message.value);


        fetch('data.php', {
            mode: "no-cors",
            method: "POST",
            body: formData
        }).then(res => {
            try {
                return res.text();
            } catch (err) {
                throw err;
            }
        }).then(data => response.innerHTML = `Sms succesfully sent to <span class="numberino"> ${to_phone.value}</span>`);
    }
</script>




</html>