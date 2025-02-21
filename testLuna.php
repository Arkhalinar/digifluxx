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
    <button id="payButton">Оплатить</button>
    <hr>
    <hr>
    <hr>
    <div id="payment-form"></div><br><br>
    <script id="forTest">
        (function(d, t) {
            var n = d.getElementById('forTest'), s = d.createElement(t);
            s.type = 'text/javascript';
            s.charset = 'utf-8';
            s.async = true;
            s.src = 'https://plugins.lunu.io/packages/widget-ui/alpha.js?t=' + 1 * new Date();
            n.parentNode.insertBefore(s, n);
        })(document, 'script');
    </script>

    <script>
        $('#payButton').on('click', function(){

            const data = {
                    "login": "test@mail.ru",
                    "amount": 150,
                    "paymentSystem": "luna"
                };

            const queryString = new URLSearchParams(data).toString();

            const options = {
                method: 'GET',
                headers: { 'content-type': 'application/x-www-form-urlencoded' },
                url: 'https://processing.si14.bet/depositInit?'+queryString,
            };
            axios(options).then(response => {
                console.log(response.data)
                new window.Lunu.widgets.Payment(
                document.getElementById('payment-form'),
                {
                    overlay: true,
                    confirmation_token: response.data.token,
                    // Token that must be received from the Processing Service before making a payment
                    // Required parameter

                    callbacks: {
                    init_error: function(error) {
                        // Handling initialization errors
                    },
                    init_success: function() {
                        // Handling a Successful Initialization
                    },
                    payment_paid: function(params) {
                        // Handling a successful payment event
                        var handleSuccess = window.LUNU_PAYMENT_SUCCESS_CALLBACK;
                        handleSuccess && handleSuccess(params);
                        window.location.href = 'https://digifluxx.com/succStripe.php';
                    },
                    payment_cancel: function() {
                        // Handling a payment cancellation event
                        var handleCancel = window.LUNU_PAYMENT_CANCEL_CALLBACK;
                        handleCancel && handleCancel();
                        window.location.href = 'https://digifluxx.com/faiStripe.php';
                    },
                    payment_close: function() {
                        // Handling the event of closing the widget window
                    }
                    }
                }
                );
            });
        })
    </script>
</html>