<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Andreas L&uuml;decke" />
    <meta name="description" content="Aktuelles - Ihr Kinderarzt Dr. med. Thomas Pfannschmidt - Kinderarztpraxis Berlin Altglienicke" />
    <meta name="keywords" content="Kinderarzt Altglienicke, Arzt Altglienicke, Kinderarztpraxis Altglienicke, Kinderarzt Berlin"  />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.4,maximum-scale=1.0" />
    <title>Kinderarztpraxis Dr. med. Thomas Pfannschmidt in Berlin Altglienicke</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" media="screen" href="styles/index_desktop.css" type="text/css" />
</head>

<body>
    <h2 class="title">
        <img class="icon" src="res/arzt_icon.jpg" alt="icon"> Kinderarztpraxis Dr. med. Thomas Pfannschmidt
    </h2>
    <div class="top-menu">
        <img src="res/menu_icon.jpg" alt="menu" onclick="showResMenu()">
        <ul class="reframe">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a href="impressum.html">Impressum</a>
            </li>
            <li>
                <a href="datenschutz.html">Datenschutz</a>
            </li>
        </ul>
        <ul class="invisible responsive" id="res_menu">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a href="impressum.html">Impressum</a>
            </li>
            <li>
                <a href="datenschutz.html">Datenschutz</a>
            </li>
            <li>
                <a href="wir.html">Wir stellen uns vor</a>
            </li>
            <li>
                <a href="">Aktuelles</a>
            </li>
            <li>
                <a href="angebot.html">Das k&ouml;nnen wir Ihnen bieten</a>
            </li>
        </ul>
    </div>
    <p>&nbsp;</p>
    <div class="dashboard">
        <nav id="dashboard">
            <ul class="reframe">
                <li>
                    <a href="index.html">Hauptseite</a>
                </li>
                <li>
                    <a href="wir.html">Wir stellen uns vor</a>
                </li>
                <li>
                    <a class="active" href="">Aktuelles</a>
                </li>
                <li>
                    <a href="angebot.html">Das k&ouml;nnen wir Ihnen bieten</a>
                </li>
            </ul>
        </nav>
    </div>
    <table style="width:100%">
        <tr>
            <td class="columnleft"></td>
            <td class="columnmid">
                <div id="main" class="text">
                    <div id="intro">
                        <br />
                        <h2 id="mainHeader" style="text-align:center">Aktuelles</h2>
                    </div>
                    <div id="content">
                        <blockquote style="text-align:left">
                            <p>&nbsp;</p>
                            <p style="color:#800000; font-weight:bold;">
                                Bitte beachten Sie, dass eine halbe Stunde vor Sprechstundenende die Patientenannahme schließt!</p>
                            <p>&nbsp;</p>
                            <?php include("scripts/vacation.php"); ?>
                        </blockquote>
                    </div>
                    <p>&nbsp;</p>
                </div>
            </td>
            <td style="width:25%"></td>
        </tr>
    </table>
    <script async type="text/javascript" src="scripts/responsive_menu.js"></script>
</body>

</html>