<?php
/*
 * Author:   A. Kapella
 * Purpose:  Class module for read/write A9G data in json format
 * Created:  Oct/04/2019
 */

 class A9GData {
  # Methods
  function get_content($file) {
    if (!file_exists($file)) {
      die("ERROR: File $file is not present!");
    }

    return file_get_contents($file);
  }

  function get_html($json_data) {
    $html         = '<div>:table:</div>';
    $data         = '';
    $table  = '<table>:data:</table>';
  
    $data = '<tr><td class="head">Latitude</td><td class="data">'. $json_data->latitude . '</td></tr>';
    $data = $data . '<tr><td class="head">Longitude</td><td class="data">'. $json_data->longitude . '</td></tr>';
    $data = $data . '<tr><td class="head">Satellites</td><td class="data">'. $json_data->satellites . '</td></tr>';
    $data = $data . '<tr><td class="head">Precision</td><td class="data">'. $json_data->precision . '</td></tr>';
    $data = $data . '<tr><td class="head">Characters</td><td class="data">'. $json_data->characters . '</td></tr>';
    $data = $data . '<tr><td class="head">Sentences</td><td class="data">'. $json_data->sentences . '</td></tr>';
    $data = $data . '<tr><td class="head">Errors</td><td class="data">'. $json_data->errors . '</td></tr>';
	
    $table = str_replace(":data:", $data, $table);
    $html = str_replace(":table:", $table, $html);

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
        die("ERROR: Can not open file $file");
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
    $retval = str_replace("ß", "&szlig;", $retval);

    return $retval;
  }
}
?> 
