<?php
    // exec('tar -cvf superarchive.tar.gz .');
    // exit();
?>
<html>
    <header>
        <title>test</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
    </header>
    <button id="payButton">Оплатить</button>
    <script>
        $('#payButton').on('click', function(){

            const data = {
                    "login": "greep23",
                    "amount": 122,
                    "paymentSystem": "stripe",
                    "successUrl": "https://digifluxx.com/succStripe.php",
                    "failUrl": "https://digifluxx.com/faiStripe.php"
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
                // console.log(response.data)
                var stripe = Stripe('pk_test_51GvrF5F8dJN0cDdxxOQS8NZfIJ6BNvELcvxOF27TePtuJIou2n1FYPbik84wav2W5HTjA8q50vUdpvQ3yRBzGyIu00zv9lOInq');
                stripe.redirectToCheckout({
                    sessionId: response.data.paymentId
                }).then(function (result) {
                    console.log(result);
                });
            });
        })
    </script>
</html>