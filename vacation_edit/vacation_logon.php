<?php 
/*
 * Author:   A. Luedecke
 * Purpose:  Form for log on to edit vacation entries
 * Created:  Jun/26/2019
 */
  
   # Reset cookie for new User
   if (isset($_COOKIE["ThisUser"])) {
     setcookie("ThisUser", "", time() - 3600);
   }
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="Logon zur &Auml;nderung der Urlaubszeiten" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubszeiten, &Auml;nderung der Urlaubszeiten, Logon"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Vacation Edit - Version 1.3.0</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
    <link rel="stylesheet" media="screen" href="../styles/vacation_edit.css" type="text/css" />
</head>

<body>
  <form  class="logon" method="POST" action="vacation_modify.php">
    <table>
	  <tr>
	    <th>
		  <h3>Vacation Edit - Logon</h3>
		</th>
	  </tr>
	  <tr>
	    <td>
		  <table class="ctl">
		    <tr>
	          <td>Username:</td>
	          <td>
                <input name="loginname" type="text"
                  <?php 
                    if (isset($_POST["loginname"])) {
                        echo 'value="' . $_POST["loginname"] . '"';
                    }
                  ?> autofocus>
              </td>
	        </tr>
	        <tr>
	          <td>Passwort:</td>
	          <td>
                <input name="loginpw" type="password"
                <?php
                  if (isset($_POST["loginpw"])) {
                    echo 'value="' . $_POST["loginpw"] . '"';
                  }
                ?>>
              </td>
	        </tr>
		    <tr>
	          <td></td>
	          <td style="text-align:right">
			    <input class="btn" type="submit" name="submit" value="Anmelden">
                <input class="btn" type="button" name="exit" value="Beenden" onclick="JavaScript:self.close()">
              </td>
	        </tr>
		  </table>		  
		</td>
	  </tr>
	</table>
  </form>
  <div class="stamp">
      &copy; A. Luedecke 08/2018
  </div>
  <?php
    if (isset($_SESSION["login"])) {
	    if ($_SESSION["login"] != 1) {
	      echo '<div style="color:#A00000; font-weight:bold;"><br />Username/Passwort nicht korrekt!</div>';
      }
    }
  ?>
</body>

</html>
