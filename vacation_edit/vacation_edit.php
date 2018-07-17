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
    <?php 
      include("vacation_data.php");
      $vacation_file = 'vacation_edit/vacation.json';
  
      if (!file_exists($vacation_file)) {
        $vacation_file = 'vacation.json';
        if (!file_exists($vacation_file)) {
          die("ERROR: File $vacation_file is not present!");
        }
      }

      $data = new VacationData();
      $json = $data->get_json($vacation_file);
    ?>
    <fieldset>
        <legend>Urlaubsplanung</legend>
        <br />
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
            <label for="chk_vac">anzeigen</label>
        </div>
        <div>
            <textarea class="txt"
                      id="txt_vac" name="txt_vac"
                      rows="3"><?php
                                 foreach ($json->vacation->times as $time) {
                                   echo $time . "\r";
                                 }
                               ?>
            </textarea>
        </div>

    </fieldset>
    <div class="output">
        <blockquote>
            <br /><br />
            <?php echo $data->get_html($json); ?>
            <br />
        </blockquote>
    </div>
</body>

</html>
