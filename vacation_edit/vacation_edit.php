<?php 
    session_start(); 

    $_logindaten[0]["name"]     = "Corinna";
    $_logindaten[0]["passwort"] = "Corinna?";
    $_logindaten[1]["name"]     = "Thomas";
    $_logindaten[1]["passwort"] = "Thomas!002";
    $_logindaten[2]["name"]     = "ALuedecke";
    $_logindaten[2]["passwort"] = "laydas";
	
	//ARRAY("name"=>"Corinna", "passwort"=>"Corinna?"); 

    if (isset($_POST["loginname"]) && isset($_POST["loginpw"])) {
        for ($i = 0; $i < 3; $i++) {
		  if ($_logindaten[$i]["name"] == $_POST["loginname"] && 
            $_logindaten[$i]["passwort"] == $_POST["loginpw"]) { 
            # Userdaten korrekt - User ist eingeloggt 
            # Login merken ! 
            $_SESSION["login"] = 1;
			break;
          } else {
			  $_SESSION["login"] = 0;
		  }
		}
    }

    if (isset($_SESSION["login"])) {
	    if ($_SESSION["login"] != 1) {
			include("logon_frm.php");
			exit;
        }
    } else {
		include("logon_frm.php");
        exit; 
	}
	
    # User ist eingeloggt 
	include("vacation_get.php");
?>
