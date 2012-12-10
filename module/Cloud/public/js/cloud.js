$(document).ready(function() {
    $.cookie("showRoot", null);
    $("#submenu-main_Dateien").click(function(){
        $.cookie("showRoot", true);
    });
});