<?php 

session_start();

/*
 * Allow edition of an entry
 */

$entry_attributes = array (

    "title" => "",

    "telephonenumber" => "",
    "telephoneassistant" => "",
    "mobile" => "",

    "physicaldeliveryofficename" => "",
    "description" => ""
);

$psswrd = "";

$errProfilePicture = "";
$profilePicture = NULL;

$thumbnailPhoto_state = "";
$modify_state = "";
$submit_state = "";
$readonly = "";

// Checking photo
if($_FILES['thumbnailPhoto']['size'] != 0) {    

    if($_FILES["thumbnailPhoto"]['size'] > 100000){ // Size
        $errProfilePicture = "L'image est trop volumineuse, elle ne doit pas dépasser 100ko. ";
    }

    $allowed = array('jpeg', 'jpg');    
    $ext = pathinfo($_FILES['thumbnailPhoto']['name'], PATHINFO_EXTENSION);
    
    if (!in_array($ext, $allowed)) {    // Extension
        $errProfilePicture += "Mauvais format utilisé, l'image doit être au format jpg ou jpeg.";
    }

    if($errProfilePicture === ""){      // If no error get the photo

        $profilePicture = file_get_contents($_FILES['thumbnailPhoto']['tmp_name']);
    }
}



if(isset($_POST["submitedit"])) {   // Saving datas

    $distname = $_SESSION['distname']; // Get infos
    $psswrd = $_SESSION['password'];
    $sn = $_POST["sn"];
    $givenname = $_POST["givenname"];
    $mail = $_POST["mail"];

    $ldap_connection = wp_ldap_connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw);

    $ldap = $ldap_connection[0];

    if ($ldap) {    

        $errors = array(); 
        
        $errors[] = ldap_bind($ldap, $distname, $psswrd);

        foreach($entry_attributes as $attribute => $value){

            $entry_attributes[$attribute] = $_POST[$attribute];

            if($entry_attributes[$attribute] === ""){
                $entry_attributes[$attribute] = array();
            }         
        }

        if($profilePicture != NULL){
            $entry_attributes['thumbnailphoto'] = $profilePicture;
        }

        $errors[] = ldap_modify($ldap, $distname, $entry_attributes);   // Modify data

        $modify_state = "visibility:block;";    // Checking mode
        $submit_state = "visibility:hidden;";
        $readonly = "readonly";
        $thumbnailPhoto_state = "disabled";

        
    }
}
else{

    $_SESSION['password'] = $password;    // Get infos after authentication
    $_SESSION['distname'] = $dn;
    $distname = $dn;
    $sn = $entry[0]["sn"][0];
    $givenname = $entry[0]["givenname"][0];
    $mail = $entry[0]["mail"][0];

    foreach($entry_attributes as $attribute => $value){

        $entry_attributes[$attribute] = $entry[0][$attribute][0];

    }

    $modify_state = "visibility:hidden;";
    $submit_state = "visibility:block;";
    $readonly = "";

}



$smarty->assign("errProfilePicture", $errProfilePicture);

$smarty->assign("modify_state", $modify_state);
$smarty->assign("submit_state", $submit_state);
$smarty->assign("readonly", $readonly);

$smarty->assign("distname", $distname);

$smarty->assign("thumbnailPhoto_state", $thumbnailPhoto_state);

$smarty->assign("sn", $sn);
$smarty->assign("givenname", $givenname);
$smarty->assign("title", $entry_attributes["title"]);

$smarty->assign("mail", $mail);
      
$smarty->assign("telephoneassistant", $entry_attributes["telephoneassistant"]);
$smarty->assign("telephonenumber", $entry_attributes["telephonenumber"]);  

$smarty->assign("mobile", $entry_attributes["mobile"]);

$smarty->assign("physicaldeliveryofficename", $entry_attributes["physicaldeliveryofficename"]);
$smarty->assign("description", $entry_attributes["description"]);
?>
