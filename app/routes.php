<?php

// default route
$app->mount("/", new MyCvApp\Controllers\HomeController());

$app->mount("/cnx", new MyCvApp\Controllers\pictureController());