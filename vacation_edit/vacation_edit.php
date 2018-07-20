<?php 
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

      # if form was submitted overwrite json with controls data
      if (isset($_POST["refresh"])) {
        if (isset($_POST["chk_vac"])) {
            $json->vacation->display = 1;
        } else {
            $json->vacation->display = 0;
        }
        
        if (isset($POST_["chk_subst"][0])) {
          $json->substitution[0]->display = 1;
        } else {
            $json->substitution[0]->display = 0;
        }
        

        if (isset($_POST["chk_note"])) {
            $json->note->display = 1;
        } else {
            $json->note->display = 0;
        }

        if (isset($_POST["txt_note"])) {
            $json->note->comment = $_POST["txt_note"];
        }

        # reset ctl-index
        $idx  = 0;
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
    <title>Vacation Edit</title>
    <link rel="Shortcut Icon" type="../image/x-icon" href="favicon.ico" />
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
                      rows="2"><?php
                                 $first = true;
                                 foreach ($json->vacation->times as $time) {
                                   if ($first) {
                                     echo $time;
                                     $first = false;
                                   } else {
                                       echo PHP_EOL . $time;
                                   }
                                 }
                               ?>
            </textarea>
        </div>
        <table>
            <tr>
                <?php foreach($json->substitution as $subst): ?>
                <td>
                    <div>
                        <label>Urlaubsvertretung <?php echo $idx + 1 ?>:</label>
                        <input type="checkbox" 
                        <?php
                          echo 'name="chk_subst[' . $idx . ']" '; 
                          if ($subst->display == 1) {
                            echo 'value="1" checked';
                          } else {
                            echo 'value="0"';
                          }
                        ?>>
                        <label class="display" 
                          <?php 
                            echo 'for="chk_subst"';
                          ?>>anzeigen</label>
                    </div>
                    <div class="address">
                        <input class="txt" type="text" 
                          <?php
                            echo 'name="txt_subst_time'. $idx . '" value="' . $subst->time . '"';
                          ?>><br />
                        <input class="txt" type="text" 
                          <?php
                            echo 'name="txt_subst_name' . $idx . '" value="' . $subst->name . '"';
                          ?>><br />
                        <input class="txt" type="text" 
                          <?php
                            echo 'name="txt_subst_street' . $idx . '" value="' . $subst->street . '"';
                          ?>><br />
                        <input class="txt" type="text" 
                          <?php
                            echo 'name="txt_subst_location' . $idx . '" value="' . $subst->location . '"';
                          ?>><br />
                        <input class="txt" type="text" 
                          <?php
                            echo 'name="txt_subst_phone' . $idx . '" value="' . $subst->phone . '"';
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
            <input class="note" type="text" name="txt_note" 
              <?php
                echo 'value="' . $json->note->comment . '"';
              ?>>
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
        <input type="button" name="save" value="Speichern" onclick="JavaScript:self.close()">
        <input type="button" name="exit" value="Beenden" onclick="JavaScript:self.close()">
    </div>
    
    </form>
</body>

</html>
