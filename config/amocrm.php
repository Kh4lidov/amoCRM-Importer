<?php

return [
    'uri' => env('AMOCRM_URI'),
    'client_id' => env('AMOCRM_CLIENT_ID'),
    'secret' => env('AMOCRM_SECRET'),
    'token_path' => base_path(env('AMOCRM_TOKEN_FILE')),
];
