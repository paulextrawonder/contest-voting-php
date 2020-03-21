<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Vote {{ $contestant->name }} - PaulHack Beauty Contest</title>

        <!-- CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <link rel="stylesheet" href="/assets/css/vote.css">

    </head>
    <body>

        <div class="container">
            <div style="padding-bottom: 1rem;font-size: 2rem">
                <a href="/home">PaulHack Beauty Contest</a>
            </div>
            <div class="paragraphs">
                <div class="row">
                    <div class="span4">
                        <img style="float:left" src="{{ $contestant->image }}">
                        <div class="content-heading">
                            <h3>{{ $contestant->name }}</h3>
                        </div>
                        <div class="descr">
                            {{ $contestant->info }}
                        </div>
                        <hr>
                        Number of Votes: {{ $votes }} <br>
                        <button class="btn btn-primary" onclick="payWithPaystack()">Vote {{ $contestant->name }}</button>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        <script src="/assets/js/app.js"></script>
        <script>

            function payWithPaystack() {

                var handler = PaystackPop.setup({ 
                    key: 'pk_test_2898f4adde7e663db7938f05d3e4680646dd0f75', //put your public key here
                    email: 'paulhack@gmail.com', //put your customer's email here
                    amount: 370000, //amount the customer is supposed to pay
                    metadata: {
                        custom_fields: [
                            {
                                display_name: "Mobile Number",
                                variable_name: "mobile_number",
                                value: "+2348012345678" //customer's mobile number
                            }
                        ]
                    },
                    callback: function (response) {
                        //after the transaction have been completed
                        //make post call  to the server with to verify payment 
                        //using transaction reference as post data
                        $.post(
                            "verifypayment/{{ $contestant->slug }}",
                            {
                                reference: response.reference,
                                "_token": "{{ csrf_token() }}",
                            },
                            function(status){
                                if(status == true) {
                                    window.location.reload(true);
                                } else {
                                    //transaction failed
                                    alert(response);
                                }
                            }
                        );
                    },
                    onClose: function () {
                        //when the user close the payment modal
                        alert('Transaction cancelled');
                    }
                });
                handler.openIframe(); //open the paystack's payment modal
            }

        </script>

    </body>
</html>
