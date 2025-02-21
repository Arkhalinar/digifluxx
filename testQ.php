<?php
    // exec('tar -cvf superarchive.tar.gz .');
    // exit();
?>
<html>
    <header>
        <title>test</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    </header>
    <hr>
    <input type="text" name="amount">
    <hr>
    <button id="payButton">Оплатить</button>
    <script>
        $('#payButton').on('click', function(){

            const data = {
                    "login": "yawap70734@leafzie.com",
                    "amount": $('input[name=amount]').val(),
                    "paymentSystem": "visa",
                    "success_url": 'https://digifluxx.com/succStripe.php',
                    "response_url": 'https://digifluxx.com/testQ.php',
                    "fail_url": 'https://digifluxx.com/faiStripe.php'
                };

            // const data = {
            //         "login": "greep300",
            //         "amount": 200,
            //         "paymentSystem": "bitgo",
            //         "currency": "BTC"
            //     };

            const queryString = new URLSearchParams(data).toString();

            const options = {
                method: 'GET',
                headers: { 'content-type': 'application/x-www-form-urlencoded' },
                url: 'https://processing.si14.bet/depositInit?'+queryString,
            };
            axios(options).then(response => {
                console.log(response.data)
                document.location.href = response.data.link;
            });
        })
    </script>
</html>