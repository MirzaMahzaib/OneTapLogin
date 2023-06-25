<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;

class OnetapController extends Controller
{
    public function index(Request $request){
        session_start();
        // set google client ID
        $google_oauth_client_id = "151763870074-picik688docasjl184ooimiuh4aiphpu.apps.googleusercontent.com";

        // create google client object with client ID
        $client = new Google_Client([
            'client_id' => $google_oauth_client_id
        ]);

        // verify the token sent from AJAX
        $id_token = $_POST["id_token"];

        $payload = $client->verifyIdToken($id_token);
        if ($payload && $payload['aud'] == $google_oauth_client_id)
        {
            // get user information from Google
            $user_google_id = $payload['sub'];

            $name = $payload["name"];
            $email = $payload["email"];
            $picture = $payload["picture"];

            // login the user
            $_SESSION["user"] = $user_google_id;

            // send the response back to client side
            return true;
            dd("Successfully logged in. " . $user_google_id . ", " . $name . ", " . $email . ", " . $picture);
        }
        else
        {
            // token is not verified or expired
            return false;
            dd("Failed to login.");
        }
        dd($request->all());
    }
}
