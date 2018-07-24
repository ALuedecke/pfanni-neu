<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Edit vacations and holidays
 *           with HTML Form
 * Created:  Jul/21/2018
 */

  header("Content-type:text/html; charset=utf-8");
  include("vacation_data.php");
  $vacation_file = 'vacation_edit/vacation.json';
  
  if (!file_exists($vacation_file)) {
    $vacation_file = 'vacation.json';
    if (!file_exists($vacation_file)) {
      die("ERROR: File $vacation_file is not present!");
    }
  }

  # get vacation data from json file
  $data = new VacationData();
  $json = $data->get_json($vacation_file);
  $idx  = 0;

  # function to overwrite json with controls data
  function set_posted($json) {
    #ctl-index
    $idx = 0;

    # vacation data
    # display
    if (isset($_POST["chk_vac"])) {
      $json->vacation->display = 1;
    } else {
        $json->vacation->display = 0;
    }
    # times
    if (isset($_POST["txt_vac"])) {
      $text = explode(PHP_EOL, $_POST["txt_vac"]);
      # reset times array first
      $json->vacation->times = array();
      # fill posted lines into times
      foreach($text as $line) {
        $json->vacation->times[$idx] = rtrim($line);
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }

    # substitution data
    # reset all checkboxes first
    foreach ($json->substitution as $subst) {
      $subst->display = 0;
    }
    # display
    if (isset($_POST["chk_subst"])) {
      # set checkboxes with posted data
      foreach($_POST["chk_subst"] as $val) {
        $json->substitution[intval($val)]->display = 1;
      }  
    }
    # time
    if (isset($_POST["txt_subst_time"])) {
      foreach($_POST["txt_subst_time"] as $val) {
        $json->substitution[$idx]->time = $val;
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }
    # name
    if (isset($_POST["txt_subst_name"])) {
      foreach($_POST["txt_subst_name"] as $val) {
        $json->substitution[$idx]->name = $val;
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }
    # street
    if (isset($_POST["txt_subst_street"])) {
      foreach($_POST["txt_subst_street"] as $val) {
        $json->substitution[$idx]->street = $val;
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }
    # location
    if (isset($_POST["txt_subst_location"])) {
      foreach($_POST["txt_subst_location"] as $val) {
        $json->substitution[$idx]->location = $val;
        $idx++;
      }
       # reset ctl-index
       $idx  = 0;
    }
    # phone
    if (isset($_POST["txt_subst_phone"])) {
      foreach($_POST["txt_subst_phone"] as $val) {
        $json->substitution[$idx]->phone = $val;
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }

    # note
    if (isset($_POST["chk_note"])) {
      $json->note->display = 1;
    } else {
        $json->note->display = 0;
    }
    # comments
    if (isset($_POST["txt_note"])) {
      $text = explode(PHP_EOL, $_POST["txt_note"]);
      # reset comments array first
      $json->note->comments = array();
      # fill posted lines into comments
      foreach($text as $line) {
        $json->note->comments[$idx] = rtrim($line);
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
    }  
  }

  # if form was submitted overwrite json with controls data
  if (isset($_POST["refresh"])) {
    set_posted($json);
  }
  # save data if submitted for save
  if (isset($_POST["save"])) {
    set_posted($json);
    $data->save_json($json, $vacation_file);
  }
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="&Auml;nderung der Urlaubszeiten" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubszeiten, &Auml;nderung der Urlaubszeiten"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Vacation Edit - Version 1.0.0</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
    <link rel="stylesheet" media="screen" href="../styles/vacation_edit.css" type="text/css" />
</head>

<body>
    <form method="POST" action="vacation_edit.php">

    <fieldset>
        <legend>Urlaubsplanung</legend>
        <div>
            <label>Urlaub:</label>
            <input type="checkbox" id="chk_vac" name="chk_vac"
              <?php 
                if ($json->vacation->display == 1) {
                  echo 'value="1" checked';
                } else {
                    echo 'value="0"';
                }
              ?>>
            <label class="display" for="chk_vac">anzeigen</label>
        </div>
        <div>
            <textarea class="area"
                      id="txt_vac" name="txt_vac"
                      cols="35"
                      rows="3"
            ><?php
               $first = true;
               foreach ($json->vacation->times as $time) {
                 if ($first) {
                   echo $time;
                   $first = false;
                 } else {
                     echo PHP_EOL . $time;
                 }
               }
             ?></textarea>
        </div>
        <table>
            <tr>
                <?php foreach($json->substitution as $subst): ?>
                <td>
                    <div>
                        <label>Urlaubsvertretung <?php echo $idx + 1 ?>:</label>
                        <input type="checkbox" name="chk_subst[]"
                        <?php
                          if ($subst->display == 1) {
                            echo 'value="' . $idx. '" checked';
                          } else {
                            echo 'value="' . $idx. '"';
                          }
                        ?>>
                        <label class="display" for="chk_subst[]">anzeigen</label>
                    </div>
                    <div class="address">
                        <input class="txt" type="text" name="txt_subst_time[]" 
                          <?php
                            echo 'value="' . $subst->time . '"';
                          ?>><br />
                        <input class="txt" type="text" name="txt_subst_name[]" 
                          <?php
                            echo 'value="' . $subst->name . '"';
                          ?>><br />
                        <input class="txt" type="text" name="txt_subst_street[]" 
                          <?php
                            echo 'value="' . $subst->street . '"';
                          ?>><br />
                        <input class="txt" type="text" name="txt_subst_location[]" 
                          <?php
                            echo 'value="' . $subst->location . '"';
                          ?>><br />
                        <input class="txt" type="text" name="txt_subst_phone[]" 
                          <?php
                            echo 'value="' . $subst->phone . '"';
                            $idx++;
                          ?>>
                    </div>
                </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <div>
            <label>Bemerkung:</label>
            <input type="checkbox" id="chk_note" name="chk_note"
              <?php
                if ($json->note->display == 1) {
                  echo 'value="1" checked';
                } else {
                    echo 'value="0"';
                }
              ?>>
              <label class="display" for="chk_note">anzeigen</label>
        </div>
        <div>
            <textarea class="note"
                      id="txt_note" name="txt_note"
                      cols="120"
                      rows="4"
            ><?php
               $first = true;
               foreach ($json->note->comments as $comment) {
                 if ($first) {
                   echo $comment;
                   $first = false;
                 } else {
                     echo PHP_EOL . $comment;
                 }
               }
             ?></textarea>
        </div>
    </fieldset>
    <div class="output">
        <blockquote>
            <br />
            <h2>V O R S C H A U</h2>
            <br />
            <?php echo $data->get_html($json); ?>
            <br />
        </blockquote>
    </div>
    <div class="buttons">
        <input type="submit" name="refresh" value="Aktualisieren">
        <input type="submit" name="save" value="Speichern">
        <input type="button" name="exit" value="Beenden" onclick="JavaScript:self.close()">
    </div>
    
    </form>
</body>

</html>
