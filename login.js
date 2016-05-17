var LogEmail, LogPassw, RegEmail, RegPassw, RegRepPassw;
document.addEventListener("DOMContentLoaded", function() {
   LogEmail = LoginEmail.parentElement;
   LogPassw = LoginPassword.parentElement;
   RegEmail = RegisterEmail.parentElement;
   RegPassw = RegisterPassword.parentElement;
   RegRepPassw = RegisterRepeatPassword.parentElement;
   AddOnFocus();
});

function SubmitLogin()
{
   var login = LogEmail.children[1].value;
   var password = LogPassw.children[1].value;
   $.get("index.php", {type:"login", email:login, password:password}, function(result) {
      if (result == "OK")
      {
         LogEmail.classList.add("has-success");
         LogPassw.classList.add("has-succes");
         location.reload();
      }

      else if (result == "Ошибка. Неверный пароль.")
      {
         LogPassw.classList.add("has-error");
         LogPassw.children[2].textContent = result;
      }
      else if (result == "Ошибка. Этот e-mail не зарегистрирован.")
      {
         LogEmail.classList.add("has-error");
         LogEmail.children[2].textContent = result;
      }
      else alert("Неизвестная ошибка. Обновите страницу и повторите ввод.");
   });
   return false;
}

function SubmitRegister()
{
   var login = RegEmail.children[1].value;
   var password = RegPassw.children[1].value;            
   var repassword = RegRepPassw.children[1].value;
   var name = $("#RegisterName")[0].value;
   if (password.length < 6)
   {
      RegPassw.classList.add("has-error");
      RegPassw.children[2].textContent = "Ошибка. Пароль должен быть не менее 6 символов.";
      return;                              
   }
   if (password != repassword)
   {
      RegRepPassw.classList.add("has-error");
      RegRepPassw.children[2].textContent = "Ошибка. Пароли не совпадают.";
      return;
   }

   $.get("index.php", {type:"register", email:login, password:password, name:name}, function(result) {
      if (result == "OK")
      {
         RegEmail.classList.add("has-success");
         RegPassw.classList.add("has-succes");                  
         RegRepPassw.classList.add("has-succes");
         location.reload();
      }

      else if (result == "Ошибка. Этот e-mail уже зарегистрирован.")
      {
         RegEmail.classList.add("has-error");
         RegEmail.children[2].textContent = result;
      }
      else alert("Неизвестная ошибка. Обновите страницу и повторите ввод.");
   });
   return false;
}

function AddOnFocus()
{
   var arr = document.getElementsByTagName("input");
   for (var i = 0; i < arr.length; i++)
      {
      arr[i].onfocus = function(){
         this.parentElement.className = 'form-group';
         this.nextElementSibling.textContent = "";
      }}
}