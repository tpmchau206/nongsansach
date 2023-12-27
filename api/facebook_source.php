<?php
include 'Facebook/autoload.php';
include 'fbconfig.php';
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/nongsansach/api/fb-callback.php', $permissions);
