/*
 * Author:   A. Luedecke
 * Purpose:  Hide context menue to prevent downloads
 * Created:  Sep/29/2016
 */

function right_click(e) {
    if (!e) {
        e = window.event;
    }
    
    if ((e.type   && e.type   == "contextmenu") || 
        (e.button && e.button == 2) || 
        (e.which  && e.which  == 3)) {
         window.alert(
             "Das Laden von Bildern auf eigene Geräte ist strengstens untersagt!\n" +
             "Um nicht erwünschte Bilder von der Seite entfernen zu lassen,\n" +
             "wenden Sie sich bitte an praxis@dr-pfannschmidt.de\n" +
             "---\n" +
             "Loading images to your own devices is strictly prohibited!\n" +
             "For removing unrequested images, please contact praxis@dr-pfannschmidt.de"
         );
         
         return false;
    }
}

if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
}
      
document.onmousedown = right_click;
document.oncontextmenu = right_click;