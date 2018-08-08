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
  
  # get addresses from json file
  $data     = new VacationData();
  $json_adr = $data->get_json($address_file);

  # index variables
  $idx_adr  = 0;
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="&Auml;nderung der Urlaubszeiten" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubsvertretungen, &Auml;nderung der Urlaubsvertretungen"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Substitutions Edit - Version 1.0.0</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
    <link rel="stylesheet" media="screen" href="../styles/vacation_subst_edit.css" type="text/css" />
</head>

<body>
    <script type="text/javascript">
        function handle_tr_onclick(adr_idx) {
            var tbl = document.getElementById("grid_subst");
            var row = tbl.getElementsByTagName('TR');
            
            // reset all rows first
            for (var i = 0; i < row.length; i++) {
                row[i].className = "";
            }
            // then set selected row
            row[adr_idx].className = "selected";
        }
    </script>
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
                onclick=<?php echo '"handle_tr_onclick(' . $idx_adr++ . ')"' ?>>
                <td><?php echo $adr->name;     ?></td>
                <td><?php echo $adr->street;   ?></td>
                <td><?php echo $adr->location; ?></td>
                <td><?php echo $adr->phone;    ?></td>
            </tr>
          <?php endforeach; $idx_adr = 0; ?>
        </table>
    </div>
</body>

</html>