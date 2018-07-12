<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Display vacations and holidays
 * Created:  Jul/11/2018
 */

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

  $html          = '';
  $subst         = '';
  $subst_table   = '<table class="vacation"><tr>:subst:</tr></table>';
  $vacation_file = 'vacation_edit/vacation.json';
  
  if (!file_exists($vacation_file)) {
    $vacation_file = 'vacation.json';
    if (!file_exists($vacation_file)) {
      die("ERROR: File $vacation_file is not present!");
    }
  }

  $data = file_get_contents($vacation_file);
  $json_data = json_decode($data);
  
  if ($json_data->vacation->display == 1) {
    $html = '<b>' . uml_replace($json_data->vacation->label) . '</b><br />';

    foreach ($json_data->vacation->times as $time) {
      $html = $html . uml_replace($time) . '<br />';
    }

    $html = $html . '<br /><br />';
  
    foreach ($json_data->substitution as $substitute) {
      if ($substitute->display == 1) {
        $subst = $subst . '<td><b>' . uml_replace($substitute->label) . '<br />';
        $subst = $subst . uml_replace($substitute->time) . '</b><br /><br />';
        $subst = $subst . uml_replace($substitute->name) . '<br />';
        $subst = $subst . uml_replace($substitute->street) . '<br />';
        $subst = $subst . uml_replace($substitute->location) . '<br /><br />';
        $subst = $subst . uml_replace($substitute->phone) . '<br /></td>';
      }
    }

    $subst_table = str_replace(":subst:", $subst, $subst_table);
    $html = $html .  $subst_table . '<br /><br />';
  }
  
  if ($json_data->note->display == 1) {
    $html = $html . '<b>' . uml_replace($json_data->note->comment) . '</b><br />';
  }

  $html = $html . '<br />';

  echo $html;
?>
