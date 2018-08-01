<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Display vacations and holidays
 * Created:  Jul/11/2018
 */
  
  include("vacation_data.php");
  
  $vacation_file = 'vacation_edit/vacation.json';
  
  if (!file_exists($vacation_file)) {
    $vacation_file = 'vacation.json';
    if (!file_exists($vacation_file)) {
      die("ERROR: File $vacation_file is not present!");
    }
  }

  $data = new VacationData();
  
  echo $data->get_html($data->get_json($vacation_file));
?>
