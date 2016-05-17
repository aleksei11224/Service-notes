<?php
checkRequest();
function checkRequest()
{
   switch ($_GET['type']) {
      case "login": login(); break;
      case "register": register(); break;
      case "logout": closeSession(); break; 
      case "remove": deleteN(); break;
      case "update": updateN(); break;
		case "add": addN();break;
		case "changeName":changeName(); break;
		case "changePassword":changePassword(); break;
      default: checkSession();
   }   
}

function checkSession()
{
   if ($_SESSION[email] == null) loadLogin();
   else loadMain();
}

function closeSession()
{
   unset($_SESSION[email]);
   session_destroy();
   echo "OK";
}

function register()
{
   $user = new User($_GET['email'], md5($_GET['password']), $_GET['name']);
   $answer = createUser($user);
   if ($answer == "OK") 
   {
      $_SESSION[email]=$_GET['email'];
      echo "OK";
   }
   else echo "$answer";
}

function login()
{
   //проверяем checkLogin(), если ОК, то $_SESSION[email] = email, на фронт-енд перезагружаем   
   $user = new User($_GET['email'], md5($_GET['password']));
   $answer = checkLogin($user);
   if ($answer == "OK") 
   {
      $_SESSION[email]=$_GET['email'];
      echo "OK";
   }
   else echo "$answer";
}

function deleteN()
{
   $answer = deleteNote((int)$_GET['id']);
   echo $answer;
}

function updateN()
{
   $note = new Note($_GET['title'], $_GET['text']);
	$note->id = (int)$_GET['id'];
	updateNote($note);
	echo date(' Y-m-d H:i',time());
}

function addN()
{
	$note = new Note("","");
	echo addNote($note)."@".date('Y-m-d H:i',time());
}

function changeName()
{
	echo updateUserName($_GET['name']);	
}

function changePassword()
{
	echo updatePassword(md5($_GET['password']));	
}
?>
