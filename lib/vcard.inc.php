<?php

function print_vcard($entry, $attributes_map, $vcard_map, $vcard_version) {
   if (count($entry) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   echo "BEGIN:VCARD\n";
   echo "VERSION:$vcard_version\n";
   foreach ($vcard_map as $id => $item) {
     if ($id == "MEMBER") {
       if (isset($entry['member_mailto'])) {
	 foreach ($entry['member_mailto'] as $mbr) {
	   echo $id.":".$mbr."\n";
	 }
       }
     } else {
       $attribute = $attributes_map[$item]["attribute"];
       if (isset($entry[$attribute])) {
	 echo $id.":".$entry[$attribute][0]."\n";
       }
     }
   }
   echo "END:VCARD\n";
   fclose($df);
   return ob_get_clean();
}

function download_vcard_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: text/vcard");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

?>
