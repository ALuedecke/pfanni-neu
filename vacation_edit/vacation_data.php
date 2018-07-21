<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Class module for read/write vacation data in json format
 * Created:  Jul/13/2018
 */

 class VacationData {
   # Methods
  function get_html($json_data) {
    $html          = '';
    $subst         = '';
    $subst_table   = '<table class="vacation"><tr>:subst:</tr></table>';
  
    if ($json_data->vacation->display == 1) {
      $html = '<b>' . $this->uml_replace($json_data->vacation->label) . '<br /><div style="font-family:Courier">';
    
      foreach ($json_data->vacation->times as $time) {
        $html = $html . $this->uml_replace($time) . '<br />';
      }
    
      $html = $html . '</div></b><br /><br />';
      
      foreach ($json_data->substitution as $substitute) {
        if ($substitute->display == 1) {
          $subst = $subst . '<td><b>' . $this->uml_replace($substitute->label) . '<br />';
          $subst = $subst . $this->uml_replace($substitute->time) . '<br /><br /><div style="font-family:Courier">';
          $subst = $subst . $this->uml_replace($substitute->name) . '<br />';
          $subst = $subst . $this->uml_replace($substitute->street) . '<br />';
          $subst = $subst . $this->uml_replace($substitute->location) . '<br /><br />';
          $subst = $subst . $this->uml_replace($substitute->phone) . '</div></b></td>';
        }
      }
    
      $subst_table = str_replace(":subst:", $subst, $subst_table);
      $html = $html .  $subst_table . '<br /><br />';
    }
      
    if ($json_data->note->display == 1) {
      $html = $html . '<b>' . $this->uml_replace($json_data->note->comment) . '</b><br />';
    }
    
    $html = $html . '<br />';

    return $html;
  }

  function get_json($file) {
    if (!file_exists($file)) {
      die("ERROR: File $file is not present!");
    }

    $data = file_get_contents($file);
    return json_decode($data);
  }

  function save_json($json_data, $file) {
    if ($fh = fopen($file, 'w')) {
        $locked = flock($fh, LOCK_EX);
  
        if ($locked) {
            fwrite($fh, json_encode($json_data));
        }
        flock($fh, LOCK_UN);
        fclose($fh);
    } else {
        die("ERROR: Can not open file $ip_log");
    }
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
