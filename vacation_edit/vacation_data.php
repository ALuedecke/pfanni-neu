<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Class module for read/write
 *           vacation data in json format
 * Created:  Jul/13/2018
 */

class VacationData {
  # Class members
  var $html          = '';
  var $subst         = '';
  var $subst_table   = '<table class="vacation"><tr>:subst:</tr></table>';
  var $vacation_file = 'vacation_edit/vacation.json';
  
  # Constructor
  function VacationData($filename) {
    $vacation_file = $filename;
  }

  # Methods
  function getJson() {
    if (!file_exists($vacation_file)) {
        die("ERROR: File $vacation_file is not present!");
    }

    $data = file_get_contents($vacation_file);
    return json_decode($data);
  }

  function uml_replace($str) {
    $retval = str_replace(" ", "&nbsp;", $str);
    $retval = str_replace("Ä", "&Auml;", $retval);
    $retval = str_replace("Ö", "&Ouml;", $retval);
    $retval = str_replace("Ü", "&Uuml;", $retval);
    $retval = str_replace("ä", "&auml;", $retval);
    $retval = str_replace("ö", "&ouml;", $retval);
    $retval = str_replace("ü", "&uuml;", $retval);

    return $retval;
  }

}
?>
