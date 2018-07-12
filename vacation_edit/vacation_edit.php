<?php 
/*
 * Author:   A. Luedecke
 * Purpose:  Log on to edit vacation entries
 * Created:  Jul/12/2018
 */
    
  session_start(); 

  # Fix credentials
  $_credentials = '[
    {
      "name": "Corinna",
      "password": "Corinna?"
    },
    {
      "name": "Thomas",
      "password": "Thomas!002"
    },
    {
      "name": "ALuedecke",
      "password": "laydas"
    }   
  ]';

  if (isset($_POST["loginname"]) && isset($_POST["loginpw"])) {
    $logondata = json_decode($_credentials);
    foreach ($logondata as $logon) {
      if ($logon->name == $_POST["loginname"] &&
          $logon->password == $_POST["loginpw"]) {
        # Credentials are proper
        # keep Login
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
	
  # User is logged in
  include("vacation_get.php");
?>
