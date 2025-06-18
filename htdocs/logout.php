<?php

$return_url = $logout_link ? $logout_link : "index.php?page=welcome";

$_SESSION = array();
session_destroy();

header("location: $return_url");
