<!DOCTYPE html>
<html lang="{$lang}">
<head>
    <title>{$msg_title}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="LDAP Tool Box" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/font-awesome/css/all.min.css" />
    <!-- include v4-shims.min.css for compatibility with older icon names, typically: fa-check-square-o -->
    <link rel="stylesheet" type="text/css" href="vendor/font-awesome/css/v4-shims.min.css" />
{if $use_datatables}
    <link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/datatables/buttons.bootstrap5.min.css" />
{/if}
{if $hover_effect}
    <link rel="stylesheet" type="text/css" href="vendor/hover/css/hover-min.css" />
{/if}
{if $with_leaflet}
    <link rel="stylesheet" href="vendor/leaflet/leaflet.css" />
    <link rel="stylesheet" href="vendor/leaflet.markercluster/MarkerCluster.css" />
    <link rel="stylesheet" href="vendor/leaflet.markercluster/MarkerCluster.Default.css" />
{/if}
    <link rel="stylesheet" type="text/css" href="css/white-pages.css" />
{if $custom_css}
    <link rel="stylesheet" type="text/css" href="{$custom_css}" />
{/if}
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
    <link href="images/favicon.ico" rel="shortcut icon" />
{if $background_image}
     <style>
       html, body {
         background: url({$background_image}) no-repeat center fixed;
         background-size: cover;
       }
  </style>
{/if}

</head>
<body>

<div class="container">
