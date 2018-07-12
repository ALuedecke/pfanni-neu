<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="Logon zur &Auml;nderung der Urlaubszeiten" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin, Urlaubszeiten, &Auml;nderung der Urlaubszeiten, Logon"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Logon</title>
    <link rel="Shortcut Icon" type="../image/x-icon" href="favicon.ico" />
</head>

<body style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; width:320px; height:240px">
  <form method="POST" action="vacation_edit.php"> 
    <table style="border-style:solid; border-width:1px">
	  <tr style="background-color:#B0E0FF">
	    <th style="text-align:center">
		  <h3>Vacation Edit - Logon</h3>
		</th>
	  </tr>
	  <tr>
	    <td>
		  <table>
		    <tr>
	          <td>Username:</td>
	          <td>
                <input name="loginname"
                  <?php 
                    if (isset($_POST["loginname"])) {
                        echo 'value="' . $_POST["loginname"] . '"';
                    }
                  ?>>
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
			    <input type="submit" name="submit" value="Anmelden">
                <input type="button" name="exit" value="Beenden" onclick="JavaScript:self.close()">
              </td>
	        </tr>
		  </table>		  
		</td>
	  </tr>
	</table>
  </form>
  <?php
    if (isset($_SESSION["login"])) {
	  if ($_SESSION["login"] != 1) {
	    echo '<div style="color:#A00000; font-weight:bold;"><br />Username/Passwort nicht korrekt!</div>';
	  }
	}
  ?>
</body>

</html>
