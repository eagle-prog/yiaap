function showDiv ( thisUnhide, doRes ){
    if(doRes == '1') {
        $("#"+thisUnhide).slideDown(250, function() {
            resizeDelimiter();
        });
    } else { $("#"+thisUnhide).slideDown(250); }
}
function hideDiv ( thisHide, doRes ){
    if(doRes == '1') {
        $("#"+thisHide).slideUp(250, function() {
            resizeDelimiter();
        });
    } else { $("#"+thisHide).slideUp(250); }
}
function reverseDiv( thisUnhide, thisHide ) {
    hideDiv ( thisHide );
    showDiv ( thisUnhide );
}
function toggleDiv ( divName ) {
    $("#"+divName).animate({"height": "toggle"}, { duration: 250 });
}
function openDiv ( divID ) { document.getElementById ( divID ).style.display = 'block'; resizeDelimiter(); }
function closeDiv ( divID ) { document.getElementById ( divID ).style.display = 'none'; resizeDelimiter(); }
function simpleReverseDiv ( divID, obj ) {
    if ( document.getElementById ( divID ).style.display == 'block' ){
        closeDiv(divID);
        if(typeof(obj) !== 'undefined'){
            obj.parent().removeClass("sort-down");
        }
    } else if ( document.getElementById ( divID ).style.display == 'none' ){
        openDiv(divID);
        if(typeof(obj) != 'undefined'){
            obj.parent().addClass("sort-down");
        }
    }
}
function enterSubmit(input_name, button_name) {
    $(input_name).bind("keydown", function(e) {
        if (e.keyCode == 13) {
            $(button_name).click();
            return false;
        }
    });
}
function resizeDelimiter(){}