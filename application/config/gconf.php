<?php

/* Google App Client Id */
define('GCLIENT_ID', '');

/* Google App Client Secret */
define('GCLIENT_SECRET', '');
/* Google App Redirect Url */
define('GCLIENT_REDIRECT_URL', 'http://localhost:8100/' . ROOT . '/googleoauth');

define('GOOGLELINK', 'https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me&redirect_uri=http://localhost:8100/camaphp/googleoauth&response_type=code&client_id=' . GCLIENT_ID . '&access_type=online');

?>
