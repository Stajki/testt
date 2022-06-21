jQuery(document).ready(function() {
    jQuery("body").append('<div id="snackbar"></div>');
});

window.showSnackbar = function(message) {
    var x = document.getElementById("snackbar");
    x.innerHTML = message;
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
