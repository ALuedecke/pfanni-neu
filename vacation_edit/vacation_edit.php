<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Edit vacations and holidays with HTML Form
 * Created:  Jul/21/2018
 */
  
  header("Content-type:text/html; charset=utf-8");
  include("vacation_data.php");
  $address_file = 'vacation_edit/vacation_subst_address.json';
  $vacation_file = 'vacation_edit/vacation.json';
  
  # check whether json files exist
  if (!file_exists($address_file)) {
    $address_file = 'vacation_subst_address.json';
    if (!file_exists($address_file)) {
      die("ERROR: File $address_file is not present!");
    }
  }
  if (!file_exists($vacation_file)) {
    $vacation_file = 'vacation.json';
    if (!file_exists($vacation_file)) {
      die("ERROR: File $vacation_file is not present!");
    }
  }

  # form button settings
  $buttons = array(
    "btn_refresh" => "disabled",
    "btn_reset"   => "disabled",
    "btn_save"    => "disabled"
  );
  # get vacation data and addresses from json files
  $data     = new VacationData();
  $json_adr = $data->get_json($address_file);
  $json     = $data->get_json($vacation_file);
  # index variables
  $idx_adr  = 0;
  $idx      = 0;

  # method to overwrite json with controls data
  function set_posted($json) {
    #ctl-index
    $idx = 0;

    # vacation data
    # label
    if (isset($_POST["txt_vac_lbl"])) {
      $json->vacation->label = $_POST["txt_vac_lbl"];
    }
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
    # label
    if (isset($_POST["txt_subst_lbl"])) {
      foreach($_POST["txt_subst_lbl"] as $val) {
        $json->substitution[$idx]->label = $val;
        $idx++;
      }
      # reset ctl-index
      $idx  = 0;
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

  # if form was submitted for refresh, overwrite json with controls data
  if (isset($_POST["btn_refresh"])) {
    set_posted($json);
    $buttons["btn_reset"] = "";
    $buttons["btn_save"]  = "";
  }
  # reset data if submitted for reset
  if (isset($_POST["btn_reset"])) {
    # do nothing
  }
  # save data if submitted for save
  if (isset($_POST["btn_save"])) {
    set_posted($json);
    $data->save_json($json, $vacation_file);
  }
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="&Auml;nderung der Abwesenheitszeiten" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubszeiten, &Auml;nderung der Urlaubszeiten"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <?php
      if (!isset($_COOKIE["ThisUser"])) {
        echo '<meta http-equiv="refresh" content="2"/>';
      }
      else {
        echo "<title> Vacation Edit - Version 1.3.0 - Logged on User: " .
        $_COOKIE["ThisUser"] . "</title>";
      }
    ?>
    <link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
    <link rel="stylesheet" media="screen" href="../styles/vacation_edit.css" type="text/css" />
</head>

<body onload="select_txt('txt_vac')">
    <script type="text/javascript">
        var subst = <?php echo $data->get_content($address_file); ?>;

        function handle_select_onchange(ctl_idx, adr_idx) {
            var frm      = document.getElementById("frm_edit");
            var location = frm.elements["txt_subst_location[]"];
            var name     = frm.elements["txt_subst_name[]"];
            var phone    = frm.elements["txt_subst_phone[]"];
            var street   = frm.elements["txt_subst_street[]"];
            
            location[ctl_idx].value = subst.address[adr_idx].location;
            name[ctl_idx].value     = subst.address[adr_idx].name;
            phone[ctl_idx].value    = subst.address[adr_idx].phone;
            street[ctl_idx].value   = subst.address[adr_idx].street;

            set_buttons(true, true, false);
        }

        function set_buttons(refresh, reset, save) {
            var frm = document.getElementById("frm_edit");
          
            if (frm.elements["btn_refresh"].disabled == refresh) {
                frm.elements["btn_refresh"].disabled = !refresh;
            }
            if (frm.elements["btn_reset"].disabled == reset) {
                frm.elements["btn_reset"].disabled = !reset;
            }
            if (frm.elements["btn_save"].disabled == save) {
                frm.elements["btn_save"].disabled = !save;
            }
        }

        function select_txt(ctl_name) {
            var frm = document.getElementById("frm_edit");

            frm.elements[ctl_name].focus();
            frm.elements[ctl_name].setSelectionRange(0, frm.elements[ctl_name].value.length);
        }
    </script>
    <form id="frm_edit" method="POST" action="vacation_edit.php">

    <fieldset>
        <legend>Abwensenheitsplanung</legend>
        <div>
            <input class="headline" type="text" name="txt_vac_lbl"
              <?php
                echo 'value="' . $json->vacation->label . '"';
              ?> onchange="set_buttons(true, true, false)">
            <input type="checkbox" id="chk_vac" name="chk_vac"
              <?php 
                if ($json->vacation->display == 1) {
                  echo 'value="1" checked';
                } else {
                    echo 'value="0"';
                }
              ?> onclick="set_buttons(true, true, false)">
            <label class="display" for="chk_vac">anzeigen</label>
        </div>
        <div>
            <textarea class="area"
                      id="txt_vac" name="txt_vac"
                      cols="35"
                      rows="3"
                      onchange="set_buttons(true, true, false)"
                      autofocus
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
        <div>
          <table class="ctls">
            <tr>
              <td class="editaddress">
                  <input type="button"
                         name="btn_address"
                         value="Adressen Bearbeiten"
                         onclick="popup('vacation_edit_subst_address.php', '')">
              </td>
            </tr>
          </table>
          <table class="ctls">
            <tr>
              <?php foreach($json->substitution as $subst): ?>
                <td>
                    <div>
                    <input class="headline" type="text" name="txt_subst_lbl[]"
                      <?php
                        echo 'value="' . $subst->label . '"';
                      ?> onchange="set_buttons(true, true, false)">
                        <input type="checkbox" name="chk_subst[]"
                        <?php
                          if ($subst->display == 1) {
                            echo 'value="' . $idx . '" checked';
                          } else {
                            echo 'value="' . $idx . '"';
                          }
                        ?> onclick="set_buttons(true, true, false)">
                        <label class="display" for="chk_subst[]">anzeigen</label>
                    </div>
                    <div class="address">
                        <input class="txt" type="text" name="txt_subst_time[]" 
                          <?php
                            echo 'value="' . $subst->time . '"';
                          ?> onchange="set_buttons(true, true, false)"><br />
                        <input class="invisible" type="text" name="txt_subst_name[]" 
                          <?php
                            echo 'value="' . $subst->name . '"';
                          ?>>
                        <select class="txt" name="cmb_subst_name[]" 
                                onchange=<?php echo '"handle_select_onchange(' .  $idx . ', this.value)"'?>>
                          <?php foreach($json_adr->address as $adr): ?>
                            <option
                              <?php
                                echo 'value="' . $idx_adr . '"';
                                if ($adr->name == $subst->name) {
                                  echo ' selected';
                                }
                              ?>><?php 
                                   echo $adr->name;
                                   $idx_adr++
                                 ?>
                            </option>
                          <?php endforeach; $idx_adr = 0; ?>
                        </select><br />
                        <input class="txt" type="text" name="txt_subst_street[]" 
                          <?php
                            echo 'value="' . $subst->street . '"';
                          ?> onchange="set_buttons(true, true, false)"><br />
                        <input class="txt" type="text" name="txt_subst_location[]" 
                          <?php
                            echo 'value="' . $subst->location . '"';
                          ?> onchange="set_buttons(true, true, false)"><br />
                        <input class="txt" type="text" name="txt_subst_phone[]" 
                          <?php
                            echo 'value="' . $subst->phone . '"';
                            $idx++;
                          ?> onchange="set_buttons(true, true, false)">
                    </div>
                </td>
              <?php endforeach; ?>
            </tr>
          </table>
        </div>
        <div>
            <label>Bemerkung:</label>
            <input type="checkbox" id="chk_note" name="chk_note"
              <?php
                if ($json->note->display == 1) {
                  echo 'value="1" checked';
                } else {
                    echo 'value="0"';
                }
              ?> onclick="set_buttons(true, true, false)">
              <label class="display" for="chk_note">anzeigen</label>
        </div>
        <div>
            <textarea class="note"
                      id="txt_note" name="txt_note"
                      cols="120"
                      rows="4"
                      onchange="set_buttons(true, true, false)"
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
        <input type="submit" name="btn_refresh" value="Aktualisieren" <?php echo $buttons["btn_refresh"] ?>>
        <input type="submit" name="btn_reset" value="Zurücksetzen" <?php echo $buttons["btn_reset"] ?>>
        <input type="submit" name="btn_save" value="Speichern" <?php echo $buttons["btn_save"] ?>>
        <input type="button" name="btn_exit" value="Beenden" onclick="JavaScript:self.close()">
    </div>
    
    </form>
    <div class="stamp">
        &copy; A. Luedecke 08/2018
    </div>
    <script async type="text/javascript" src="../scripts/popup.js"></script>
</body>

</html>
