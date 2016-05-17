<!DOCTYPE html>
<html>
   <head>
      <link rel="shortcut icon" href="http://keepgoogle/favicon.ico" type="image/x-icon">
      <title>Easy Notes - Главная</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.css">
      <link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.css">          
      <link rel="stylesheet" href="jquery-ui.css">    
      <script src="jquery-1.12.3.js"></script>
      <script src="jquery-ui.js"></script>
      <script src="autoresize.jquery.js"></script>
      <script src="bootstrap-3.3.2-dist/js/bootstrap.js"></script>
      <script src="main.js"></script>
      <style>
         .navbar-right{
            margin-right:15px;
         }
         button.dropdown-toggle{
            font-size:130%;
            text-decoration:none !important;
         }
         .note{
            vertical-align:top;
            display:inline-block;
            width:300px;
            margin-left: 15px;
            margin-right:15px;   
         }
         .panel-heading>span.glyphicon{
            float:right; 
            cursor:pointer;
            margin-left: 10px;
         }
         textarea{
            width:100%;
            height:auto;
            background-color:transparent;
            border:1px solid gray;
         }
			.panel-heading{
				min-height:40px;
			}
      </style>
   </head>
   <body style="background-color:lemonchiffon; min-height:768px">            
      <?php 
         function cmp($a, $b)
         {
            return $a[lastUpd]<$b[lastUpd];
         }

         $info = getUserInfo();
         $notes = $info['notes'];
         $notes.uasort($notes, 'cmp');
      ?>     
     
      <nav class="navbar navbar-inverse">
         <span  class="navbar-brand" style="cursor:pointer; font-size:160%">EasyNotes</span>
         <button title="Новая заметка" onclick="add();" class="btn btn-link navbar-btn" style="padding:0 !important; margin-top:10px;"><span style="font-size:200%;" class="glyphicon glyphicon-plus-sign"></span></button>
         <div class="btn-group navbar-right dropdown" >
           <button class="btn navbar-btn btn-link dropdown-toggle" data-toggle="dropdown"><? echo $info['name'] ?> <span class="caret"></span></button>
           <ul class="dropdown-menu">
             <li><a onclick="reset();" data-toggle="modal" data-target="#Name" href="#">Изменить имя</a></li>
             <li><a onclick="reset();" data-toggle="modal" data-target="#Password" href="#">Изменить пароль</a></li>
             <li class="divider"></li>
             <li><a href="" onclick="logout(); return false;">Выйти</a></li>
           </ul>
         </div>
      </nav>
      
      <div class="content" style="height:inherit">
         <?php
            foreach($notes as $n)
            {?>
               <div id='id<? echo $n[id] ?>' class='note panel panel-success'>
                  <div class='panel-heading'>
                     <span><? echo $n[title] ?></span>
                     <input required class="form-control" style="display:none; width:80%">                     
                     <span onclick = "removeNote(this);" class='glyphicon glyphicon-remove'></span>
                     <span onclick = "edit(this.parentElement.parentElement);" class='glyphicon glyphicon-pencil'></span>
                  </div>
                  <div class='panel-body'>
                     <p><? echo $n[text] ?></p>
                     <textarea required class="form-control" style="display:none;"></textarea>
                  </div>
                  <div class='panel-footer'>
                     <span>Создано: <? echo date('Y-m-d H:i',$n[created]+0) ?> </span>
                     <br>
                     <span>Изменено: <? echo date('Y-m-d H:i',$n[lastUpd]+0) ?> </span>
                  </div>
               </div>
            <?
            }
         ?>
      </div>
           
      <div id="Name" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
			 <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <h3 class="modal-title">Изменить имя</h3>
				</div>
				<div class="modal-body">
				  <form id="form1" onsubmit="changeName(); return false;">
				     <div class="form-group">
				     	  <label for="NewName">Новое имя</label>
                    <input id="NewName" required class="form-control">                    
						  <span class="help-block"></span>
				     </div>			
				  </form>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
				  <button type="submit" form="form1" class="btn btn-primary">Сохранить изменения</button>
				</div>
			 </div>
		  </div>
		</div>
		<div id="Password" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
			 <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <h3 class="modal-title">Изменить пароль</h3>
				</div>
				<div class="modal-body">
				  <form id="form2" onsubmit="changePassword(); return false;">	
				     <div class="form-group">
                     <label for="NewPassword">Новый пароль</label>
                     <input type="password" id="NewPassword"  placeholder="Не менее 6 символов" required class="form-control">
                     <span class="help-block"></span>
                  </div>
                  <div class="form-group">
                     <label for="RepeatNewPassword">Повторите новый пароль</label>
                     <input type="password" id="RepeatNewPassword" required class="form-control">
                     <span class="help-block"></span>
                  </div>					  
				  </form>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
				  <button type="submit" form="form2" class="btn btn-primary">Сохранить изменения</button>
				</div>
			 </div>
		  </div>
		</div>
		<div id="Error" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
			 <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <h3 class="modal-title">Ошибка</h3>
				</div>
				<div class="modal-body">
				  <h5 id="ErrorMsg"></h5>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
			 </div>
		  </div>
		</div>

   </body>
</html>