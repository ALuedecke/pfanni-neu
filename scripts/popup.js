/*
 * Author:   A. Luedecke
 * Purpose:  Handle pop up windows
 * Created:  Jul/10/2018
 */

var pop      = null;
      
function popup(url, properties) {
    if (pop && !pop.closed) {
        pop.close();
    }

    pop = window.open(url, 'newwindow', properties + ', resizable=0, left=200, top=20');
    pop.focus();
        
    return (pop) ? false : true;
}
