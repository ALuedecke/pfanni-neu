<?php
/*
 * Author:   A. Luedecke
 * Purpose:  Edit/Add substitution addresses
 * Created:  Aug/08/2018
 */
  
  header("Content-type:text/html; charset=utf-8");
  include("vacation_data.php");
  $address_file = 'vacation_edit/vacation_subst_address.json';

  # check whether json file exist
  if (!file_exists($address_file)) {
    $address_file = 'vacation_subst_address.json';
    if (!file_exists($address_file)) {
      die("ERROR: File $address_file is not present!");
    }
  }
  
  # form button settings
  $buttons = array(
    "btn_delete" => "",
    "btn_reset"  => "disabled",
    "btn_save"   => "disabled"
  );
  # get addresses from json file
  $data     = new VacationData();
  $json_adr = $data->get_json($address_file);
  # index variable
  $idx_adr  = 0;
  
  # method to overwrite json with controls data
  function set_posted($json_adr, $idx_adr) {
    # check whether we have a new entry
    if ($idx_adr == count($json_adr->address)) {
      $json_adr->address[$idx_adr] = new stdClass();
    }
    #name
    if (isset($_POST["txt_name"])) {
      $json_adr->address[$idx_adr]->name = $_POST["txt_name"];
    }
    #street
    if (isset($_POST["txt_str"])) {
      $json_adr->address[$idx_adr]->street = $_POST["txt_str"];
    }
    #location
    if (isset($_POST["txt_location"])) {
      $json_adr->address[$idx_adr]->location = $_POST["txt_location"];
    }
    #phone
    if (isset($_POST["txt_phone"])) {
      $json_adr->address[$idx_adr]->phone = $_POST["txt_phone"];
    }
  }

  # if form was submitted any way, set current address index
  if (isset($_POST["txt_idx"])) {
    $idx_adr = intval($_POST["txt_idx"]);
  }
  # delete data if submitted for delete
  if (isset($_POST["btn_del"])) {
    if ($idx_adr > 0) {
      array_splice($json_adr->address, $idx_adr, 1);
      if ($idx_adr == count($json_adr->address)) {
        --$idx_adr;
      }
    }
    $data->save_json($json_adr, $address_file);
  }
  # save data if submitted for save
  if (isset($_POST["btn_save"])) {
    set_posted($json_adr, $idx_adr);
    $data->save_json($json_adr, $address_file);
  }
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="&Auml;nderung der Abwesenheitsvertretungen" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubsvertretungen, &Auml;nderung der Urlaubsvertretungen"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Vacation Edit - Version 1.3.0</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
    <link rel="stylesheet" media="screen" href="../styles/vacation_subst_edit.css" type="text/css" />
</head>

<body onload=<?php
               if ($idx_adr == 0) {
                 echo '"set_active_row(1); set_ctls(1);"';
               } else {
                   echo '"set_active_row(' . $idx_adr . '); set_ctls(' . $idx_adr . ');"';
                  $idx_adr = 0;
               }
             ?>>
    <script type="text/javascript">
        // property
        var is_dirty = false;
        // getter
        function get_dirty() {
            return is_dirty;
        }
        // setter
        function set_dirty(dirty) {
            is_dirty = dirty;
        }

        // methods
        function check_dirty() {
            if (get_dirty()) {
                if (confirm("Änderung(en) verwerfen?")) {
                    popup("vacation_edit.php");
                }
            } else {
                popup("vacation_edit.php");
            }
        }

        function confirm_action(text) {
            return confirm(text);
        }

        function get_sel_idx() {
            var idx = 0;
            var tbl = document.getElementById("grid_subst");
            var row = tbl.getElementsByTagName('TR');
            
            // find row where class = selected
            for (var i = 0; i < row.length; i++) {
                if (row[i].className == "selected") {
                    idx = i;
                    break;
                }
            }
            return i;
        }

        function handle_tr_onclick(adr_idx) {
            if (adr_idx == 0) {
                set_new();
                set_buttons(false, true, false);
            } else {
                set_active_row(adr_idx);
                set_ctls(adr_idx);
                set_buttons(true, false, false);
            }
        }

        function handle_txt_onchange() {
            is_dirty = true;
            set_buttons(true, true, true);
        }

        function reset_form() {
            set_ctls(get_sel_idx());
            set_buttons(true, false, false);
            set_dirty(false);
        }

        function set_active_row(adr_idx) {
            var tbl = document.getElementById("grid_subst");
            var row = tbl.getElementsByTagName('TR');
            
            // reset all rows first
            for (var i = 0; i < row.length; i++) {
                row[i].className = "";
            }
            // then set selected row
            row[adr_idx].className = "selected";
        }

        function set_ctls(adr_idx) {
            var tbl = document.getElementById("grid_subst");
            var row = tbl.getElementsByTagName('TR');
            var frm = document.getElementById("frm_edit");

            for (var i = 0; i < row[adr_idx].cells.length; i++) {
                switch (i) {
                    case 0:
                        frm.elements["txt_name"].value = row[adr_idx].cells[i].innerHTML;
                        break;
                    case 1:
                        frm.elements["txt_str"].value = row[adr_idx].cells[i].innerHTML;
                        break;
                    case 2:
                        frm.elements["txt_location"].value = row[adr_idx].cells[i].innerHTML;
                        break;
                    case 3:
                        frm.elements["txt_phone"].value = row[adr_idx].cells[i].innerHTML;
                        break;
                }
            }
            
            frm.elements["txt_idx"].value = adr_idx;
            frm.elements["txt_name"].focus();
            frm.elements["txt_name"].setSelectionRange(0, frm.elements["txt_name"].value.length);
        }

        function set_buttons(del, reset, save) {
            var frm = document.getElementById("frm_edit");
          
            if (frm.elements["btn_del"].disabled == del) {
                frm.elements["btn_del"].disabled = !del;
            }
            if (frm.elements["btn_reset"].disabled == reset) {
                frm.elements["btn_reset"].disabled = !reset;
            }
            if (frm.elements["btn_save"].disabled == save) {
                frm.elements["btn_save"].disabled = !save;
            }
        }

        function set_new() {
            if (get_dirty()) {
                if (!confirm("Änderung(en) verwerfen?")) {
                    return false;
                }
            }

            var tbl = document.getElementById("grid_subst");
            var row = tbl.getElementsByTagName('TR');
            var frm = document.getElementById("frm_edit");

            frm.elements["txt_idx"].value = row.length;
            frm.elements["txt_location"].value = "";
            frm.elements["txt_name"].value = "";
            frm.elements["txt_name"].focus();
            frm.elements["txt_phone"].value = "";
            frm.elements["txt_str"].value = "";

            set_buttons(false, true, false);
            set_dirty(false);

            return true;
        }
    </script>
    <form id="frm_edit" method="POST" action="vacation_edit_subst_address.php">
    
    <fieldset>
        <legend>Vertretungsregelung - Adressen</legend>
        <div>
            <input class="invisible" name="txt_idx" value="0">
            <table class="ctls">
                <tr>
                    <td class="lbl"><label for="txt_name">Name:</label></td>
                    <td><input autofocus
                               class="txt" 
                               name="txt_name"
                               placeholder="Name"
                               required
                               type="text"
                               value=""
                               onchange="handle_txt_onchange();"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="lbl"><label for="txt_str">Stra&szlig;e:</label></td>
                    <td><input class="txt"
                               name="txt_str"
                               placeholder="Stra&szlig;e"
                               required
                               type="text"
                               value=""
                               onchange="handle_txt_onchange();"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="lbl"><label for="txt_location">PLZ Ort:</label></td>
                    <td><input class="txt"
                               name="txt_location"
                               type="text"
                               placeholder="PLZ Ort"
                               required
                               value=""
                               onchange="handle_txt_onchange();"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="lbl"><label for="txt_phone">Telefon:</label></td>
                    <td><input class="txt"
                               name="txt_phone"
                               type="text"
                               placeholder="Tel. Vorw. Nummer"
                               required
                               value=""
                               onchange="handle_txt_onchange();"></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </fieldset><br />
    <div class="head">
        <table>
            <tr>
                <td>Name</td>
                <td>Stra&szlig;e</td>
                <td>PLZ Ort</td>
                <td>Telefon</td>
            </tr>
        </table>
    </div>
    <div class="grid">
        <table id="grid_subst" name="grid_subst">
          <?php foreach($json_adr->address as $adr): ?>
            <tr name="row_subst[]"
                onclick=<?php echo '"handle_tr_onclick(' . $idx_adr++ . ');"' ?>>
               <td><?php echo $adr->name;     ?></td>
               <td><?php echo $adr->street;   ?></td>
               <td><?php echo $adr->location; ?></td>
               <td><?php echo $adr->phone;    ?></td>
            </tr>
          <?php endforeach; $idx_adr = 0; ?>
        </table>
    </div>
    <div class="buttons">
        <input type="button" name="btn_new" value="Neu" onclick="set_new();">
        <input type="submit" name="btn_del" value="L&ouml;schen" onclick="return confirm_action('Eintrag wirklich l&ouml;schen?');" <?php echo $buttons["btn_delete"] ?>>
        <input type="button" name="btn_reset" value="Zurücksetzen" onclick="reset_form();" <?php echo $buttons["btn_reset"] ?>>
        <input type="submit" name="btn_save" value="Speichern" onclick="set_dirty(false);" <?php echo $buttons["btn_save"] ?>>
        <input type="button" name="btn_exit" value="Schlie&szlig;en" onclick="check_dirty();">
    </div>
    
    </form>
    <div class="stamp">
        &copy; A. Luedecke 08/2018
    </div>
    <script async type="text/javascript" src="../scripts/popup.js"></script>
</body>

</html>