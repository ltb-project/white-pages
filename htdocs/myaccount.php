<?php

$return_url = "index.php";

if ($_SESSION["userdn"]) {
    $return_url = "index.php?page=display&dn=".urlencode($_SESSION["userdn"]);
}

header("location: $return_url");
