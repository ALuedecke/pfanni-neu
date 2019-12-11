<?php
/*
 * Author:   A. Kapella
 * Purpose:  Write A9G date to json file
 * Created:  Oct/04/2019
 */
  
  include("a9g_data.php");
  $a9g_file = 'a9g_data.json';

  # check whether json file exist
  if (!file_exists($a9g_file)) {
    $a9g_file = 'a9g_data.json';
    if (!file_exists($a9g_file)) {
      die("ERROR: File $a9g_file is not present!");
    }
  }
  # get A9G data from json file
  $data     = new A9GData();
  $json_a9g = $data->get_json($a9g_file);

  # method to overwrite json with url data
  function set_getted($json_data) {
	# characters
	if (isset($_GET["chars"])) {
	  $json_data->characters = $_GET["chars"]; 
	} else {
	  $json_data->characters = 0;
	}
	# sentences
	if (isset($_GET["sent"])) {
	  $json_data->sentences = $_GET["sent"]; 
	} else {
	  $json_data->sentences = 0;
	}
	# errors
	if (isset($_GET["err"])) {
	  $json_data->errors = $_GET["err"]; 
	} else {
	  $json_data->errors = 0;
	}
	# latitude
	if (isset($_GET["lat"])) {
	  $json_data->latitude = $_GET["lat"]; 
	} else {
	  $json_data->latitude = 0.0;
	}
	# longitude
	if (isset($_GET["lon"])) {
	  $json_data->longitude = $_GET["lon"]; 
	} else {
	  $json_data->longitude = 0.0;
	}
	# satellites
	if (isset($_GET["sat"])) {
	  $json_data->satellites = $_GET["sat"]; 
	} else {
	  $json_data->satellites = 0;
	}
	# precision
	if (isset($_GET["prec"])) {
	  $json_data->precision = $_GET["prec"];
	} else {
	  $json_data->precision = 0;
	}
  }
  
  set_getted($json_a9g);
  $data->save_json($json_a9g, $a9g_file);
?>
