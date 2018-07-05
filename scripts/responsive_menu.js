/*
 * Author:   A. Luedecke
 * Purpose:  Show/hide responsive menu
 * Created:  Jul/05/2018
 */


function showResMenu() {
    var x = document.getElementById("res_menu");
    
    if (x.className === "invisible responsive") {
        x.className = "visible responsive";
    } else {
        x.className = "invisible responsive";
    }
}