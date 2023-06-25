<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    {{-- data-client_id="151763870074-picik688docasjl184ooimiuh4aiphpu.apps.googleusercontent.com"
    data-login_uri="{{ route('onetap') }}"
    data-_token="{{csrf_token()}}"
    data-method="post"
    data-ux_mode="redirect"
    data-auto_prompt="true" --}}
    <h1>Google Onetap Login</h1>
    {{-- @php
        session_start();
    @endphp --}}
    @if (!isset($_SESSION["user"]))
        <div id="g_id_onload"
            data-client_id="151763870074-picik688docasjl184ooimiuh4aiphpu.apps.googleusercontent.com"
            data-context="signup"
            data-callback="googleLoginEndpoint"
            data-close_on_tap_outside="false">
        </div>
        <script src="https://accounts.google.com/gsi/client" async defer></script>
    @endif
    <script>
        // callback function that will be called when the user is successfully logged-in with Google
        function googleLoginEndpoint(googleUser) {
            console.log('object')
            // get user information from Google
            console.log(googleUser);

            // send an AJAX request to register the user in your website
            var ajax = new XMLHttpRequest();

            // path of server file
            ajax.open("POST", "{{ route('onetap') }}", true);

            // callback when the status of AJAX is changed
            ajax.onreadystatechange = function () {

                // when the request is completed
                if (this.readyState == 4) {

                    // when the response is okay
                    if (this.status == 200) {
                        console.log(this.responseText);
                    }

                    // if there is any server error
                    if (this.status == 500) {
                        console.log(this.responseText);
                    }
                }
            };
            console.log(googleUser.credential)
            // send google credentials in the AJAX request
            var formData = new FormData();
            formData.append("id_token", googleUser.credential);
            formData.append("_token", "{{ csrf_token() }}")
            ajax.send(formData);
        }
    </script>
</body>
</html>
