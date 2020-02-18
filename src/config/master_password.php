<?php

 return [
     /*
      * The actual master password in plain text or hash.
      */
     'MASTER_PASSWORD' => env('MASTER_PASSWORD', false),
     /*
      * The session key used to store the user's way of logging in.
      *
      */
     'session_key' => env('MASTER_PASSWORD_SESSION_KEY', 'isLoggedInByMasterPass'),
 ];
