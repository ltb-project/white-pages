<?php 

/*
 * Authentication before entry edition
 */


$err_log = false;
$err_ldap = false;
$username = "";
$successConnect = "";
$login = false;
$userDN = "";

if (isset($_POST["submit"])) {
   
    $username = $_POST["identifiant"];
    $password = $_POST["password"];

    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];

    if ($ldap) {
        
        $filter = '(sAMAccountName='.$username.')';
        $attributes = array("name", "samaccountname", "distinguishedname");
        $result = ldap_search($ldap, $ldap_user_base, $filter, $attributes);

        $entries = ldap_get_entries($ldap, $result);  
        $userDN = $entries[0]["name"][0]; 
        $dn = $entries[0] ["distinguishedname"][0];

        $login = ldap_bind($ldap, $userDN, $password);

        if($login and $userDN != ""){
            
            # Search attributes
            $attributes = array();
            $search_items = $display_items;
            foreach( $search_items as $item ) {
                $attributes[] = $attributes_map[$item]['attribute'];
            }
            $attributes[] = $attributes_map[$display_title]['attribute'];

            if ($use_vcard and $_GET["vcard"] and $vcard_file_identifier) {
                $attributes[] = $attributes_map[$vcard_file_identifier]['attribute'];
            }

            # Search entry
            $ldap_filter = "(&(objectCategory=Person))";

            $search = ldap_read($ldap, $dn, $ldap_filter, $attributes);
            $entry = ldap_get_entries($ldap, $search);


            # Sort attributes values
            foreach ($entry[0] as $attr => $values) {
                if ( $values['count'] > 1 ) {
                    asort($values);
                }
                if ( isset($values['count']) ) {
                    unset($values['count']);
                }
                $entry[0][$attr] = $values;
            }
    
            

            $page = "editentry";
            include("editentry.php");

        }
        else{
            
            $err_log = true;
        }
    }
    else{

        $err_ldap = true;
    }
}

if(isset($_GET["dn"])){  // If we come from a displayed profile, get the profile picture and id
    
    $userDN = $_GET["dn"];

    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];

    if ($ldap) {

        $attributes = array("samaccountname");
        $search = ldap_read($ldap, $userDN, $ldap_user_filter, $attributes);
        $entries = ldap_get_entries($ldap, $search); 
        $username = $entries[0]["samaccountname"][0];
    }
}




$smarty->assign("userDN", $userDN);
$smarty->assign("err_log", $err_log);
$smarty->assign("err_ldap", $err_ldap);
$smarty->assign("username", $username);