<!DOCTYPE html>
<html>
   <head>
      <title>Easy Notes - Вход</title>
      <meta charset="utf-8">
      <link rel="icon" href="/favicon.ico" type="image/x-icon">
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
      <link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.css">
      <link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.css">      
      <script src="jquery-1.12.3.js"></script>
      <script src="bootstrap-3.3.2-dist/js/bootstrap.js"></script>
      <script src="login.js"></script>
      <style>
         body{
            background-color:#eee;
         }
      </style>
   </head>
   <body>
   	<nav class="navbar navbar-inverse">
         <span  class="navbar-brand" style="cursor:pointer; font-size:160%">EasyNotes</span>    
      </nav>
      <div class="container">
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
               <form class="well well-lg" role="form" style="margin-top:35%" onsubmit="SubmitLogin(); return false;">
                  <h1>Авторизация</h1>
                  <div class="form-group">
                     <label for="LoginEmail">E-mail</label>
                     <input type="email" id="LoginEmail" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label for="LoginPassword">Пароль</label>
                     <input type="password" id="LoginPassword" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <button type="submit" class="btn btn-primary">Войти</button>
               </form>
            </div>
            
            <div class="col-md-2"></div>
            
            <div class="col-md-4">
               <form class="well well-lg" style="margin-top:15%" onsubmit="SubmitRegister(); return false;">
                  <h1>Регистрация</h1>
                  <div class="form-group">
                     <label for="RegisterName">Имя</label>
                     <input id="RegisterName" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label for="RegisterEmail">E-mail</label>
                     <input type="email" id="RegisterEmail" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label for="RegisterPassword">Пароль</label>
                     <input type="password" id="RegisterPassword"  placeholder="Не менее 6 символов" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label for="RegisterRepeatPassword">Повторите пароль</label>
                     <input type="password" id="RegisterRepeatPassword" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
               </form>
            </div>  
            <div class="col-md-1"></div>
         </div>
      </div>
   </body>
</html>