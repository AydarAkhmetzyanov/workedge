function logIn(){
$.post(
  "/login_ajax/login",
  $("#logInForm").serialize(),
  onLogIn,
  "text"
);
		return false;
}

function onLogIn(data)
{
    oresult = JSON.parse(data);
    switch(oresult.error)
{
case 0:
 window.location="/";
  break;
case 1:
  alert("Email не найден");
  break;
case 2:
  alert("Введите верный пароль");
  break;
default:
  alert("Ошибка, попробуйте позже или обратитесь в техническую поддержку");
}
}

$(document).ready(function() {

});
