@if (!is_null($userBooked) && $snapToken != '')
    <script>
        $(document).ready(() => {
            const payButton = document.querySelector('#pay-button');
            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                snap.pay("{{ $snapToken }}", { // snaptoken ada di controller bookingController.php
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log(result)
                    }
                });
            });
        })
    </script>
@endif
