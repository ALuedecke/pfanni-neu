<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Display vacations and holidays
 * Created:  Jun/23/2018
 */
  $idx           = 0;
  $note          = false;
  $print         = false;
  $subst1        = false;
  $subst1_txt    = '';
  $subst2        = false;
  $subst2_txt    = '';
  $subst3        = false;
  $subst3_txt    = '';
  $subst_table   = '<table class="vacation"><tr><td>:subst1:</td><td>:subst2:</td><td>:subst3:</td></tr></table>';
  $vacation      = false;
  $vacation_file = 'vacation.txt';
  
  if (!file_exists($vacation_file)) {
    die("ERROR: File $vacation_file is not present!");
  }

  $out = file($vacation_file);
  $size = sizeof($out);

  for ($i = 0; $i < $size; $i++) {
	  $txt = str_replace("\r\n", "\n", $out[$i]);
	  $txt = str_replace("\n", "", $txt);
	
	  /* Urlaub */
	  if ($txt == "#Urlaub") {
	    $vacation = true;
	  }
	  if ($vacation && $txt == "#x") {
	    $print = true;
	    $idx = $i + 1;
	  }
	  if ($vacation && $print) {
	    if ($i == $idx) {
	      echo '<b>' . $txt . '</b><br />';
	    }
	    if ($txt == "") {
	  	  echo '<br />';
	    }
	  }
    /* Urlaubsvertretung 1 */
	  if ($txt == "#Vertretung1") {
	    $print = false;
	    $vacation = false;
 	    $subst1 = true;
	  }
	  if ($subst1 && $txt == "#x") {
	    $print = true;
	    $idx = $i + 1;
	  }
	  if ($subst1 && $print) {
	    if ($i == $idx || $i == $idx + 1) {
	      $subst1_txt = $subst1_txt . '<b>' . $txt . '</b><br />';
	    } else {
		    if ($txt != "#Vertretung2" && $txt != "#x") {
	        $subst1_txt = $subst1_txt . $txt . '<br />';
		    }
	    }
	  }
    /* Urlaubsvertretung 2 */
	  if ($txt == "#Vertretung2") {
	    if ($subst1_txt != '') {
	      $subst_table = str_replace(":subst1:", $subst1_txt, $subst_table);
	    }
	    $print = false;
 	    $subst1 = false;
 	    $subst2 = true;
	  }
	  if ($subst2 && $txt == "#x") {
	    $print = true;
	    $idx = $i + 1;
	  }
	  if ($subst2 && $print) {
	    if ($i == $idx || $i == $idx + 1) {
	      $subst2_txt = $subst2_txt . '<b>' . $txt . '</b><br />';
	    } else {
		    if ($txt != "#Vertretung3" && $txt != "#x") {
	        $subst2_txt = $subst2_txt . $txt . '<br />';
		    }
	    }
	  }
    /* Urlaubsvertretung 3 */
	  if ($txt == "#Vertretung3") {
	    if ($subst1_txt != '' && $subst2_txt != '') {
	      $subst_table = str_replace(":subst2:", $subst2_txt, $subst_table);
	    }
	    if ($subst1_txt == '' && $subst2_txt != '') {
		    $subst_table = str_replace(":subst1:", $subst2_txt, $subst_table);
	    }
	    $print = false;
 	    $subst2 = false;
 	    $subst3 = true;
	  }
	  if ($subst3 && $txt == "#x") {
	    $print = true;
	    $idx = $i + 1;
	  }
	  if ($subst3 && $print) {
	    if ($i == $idx || $i == $idx + 1) {
	      $subst3_txt = $subst3_txt . '<b>' . $txt . '</b><br />';
	    } else {
		    if ($txt != "#Bemerkung" && $txt != "#x") {
	        $subst3_txt = $subst3_txt . $txt . '<br />';
		    }
	    }
	  }
    /* Bemerkung */
	  if ($txt == "#Bemerkung") {
	    if ($subst1_txt != '' && $subst2_txt != '' && $subst3_txt != '') {
  	    $subst_table = str_replace(":subst3:", $subst3_txt, $subst_table);
	    }
	    if ($subst1_txt == '' && $subst2_txt != '' && $subst3_txt != '') {
		    $subst_table = str_replace(":subst2:", $subst3_txt, $subst_table);
	    }
	    if ($subst1_txt == '' && $subst2_txt == '' && $subst3_txt != '') {
		    $subst_table = str_replace(":subst1:", $subst3_txt, $subst_table);
	    }
	    if ($subst1_txt != '' && $subst2_txt == '' && $subst3_txt != '') {
		    $subst_table = str_replace(":subst2:", $subst3_txt, $subst_table);
	    }
	    $subst_table = str_replace(":subst1:", '', $subst_table);
	    $subst_table = str_replace(":subst2:", '', $subst_table);
	    $subst_table = str_replace(":subst3:", '', $subst_table);
	    echo $subst_table;
	    $print = false;
 	    $subst3 = false;
	    $note = true;
	  }
	  if ($note && $txt == "#x") {
	    $print = true;
	    $idx = $i + 1;
	  }
	  if ($note && $print) {
	    if ($i == $idx) {
	      echo '<b>' . $txt . '</b><br />';
	    }
	    if ($txt == "") {
		    echo '<br />';
	    }
	  }
	}
?>
