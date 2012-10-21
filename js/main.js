$(document).ready(function() {
    $('.renderTip').tooltip();


});

function logOut(){
$.post(
  "/login_ajax/logout",
  onlogOut, 
  'json'
);
		return false;
}

function onlogOut(sresult)
{
  window.location="/";
}

function in_array( needle, haystack) {
    for(var key in haystack){
        if (haystack[key] === needle){
            return true;
        }
    }
     return false;
}

