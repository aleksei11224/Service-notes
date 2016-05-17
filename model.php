<?php
$db = (new MongoClient())->test->users;


class User 
{
   var $name;
   var $password;
   var $email;
   var $lastId=0;

   function User($e, $p, $n=null)
   {
      $this->email = $e;
      $this->password = $p;
      $this->name = $n;
   }
}

class Note
{
   var $title;
   var $text;
   var $created;
   var $lastUpd;
   var $id=-1;//если -1, то нужно выделить новый id, если >=0, то изменить существующий
     
   function Note ($newTitle, $newText)//создание новой заметки
   {
      $this->title = $newTitle;
      $this->text = $newText;
      $this->created = time();
      $this->lastUpd = time();
   }
}


function getUserInfo()
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";
   $notes = $db->findOne(array(email => $_SESSION[email]));
   return $notes;
}

function createUser($u)
{
   global $db;
   $number = $db->count(array(email=>$u->email));
   if ($number == 1) return "Ошибка. Этот e-mail уже зарегистрирован.";
   $newUser = array(
      "email"=>$u->email,
      "password"=>$u->password,
      "name"=>$u->name,
      "notes"=>array(),
      "lastId"=>$u->lastId,
   );
   $db->insert($newUser);
   return "OK";
};

function checkLogin($u)
{
   global $db;
   $foundUser = $db->findOne(array(email=>$u->email));
   if ($foundUser == null) return "Ошибка. Этот e-mail не зарегистрирован.";
   if ($foundUser[password] == $u->password) return "OK";
   return "Ошибка. Неверный пароль.";
}

function updateUserName($newName)
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";
   $curUser = array(email => $_SESSION[email]);
   $change = array('$set' => array(name => $newName));
   $db->update($curUser, $change);
   return "OK";
};

function updatePassword($newPassword)
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";
   $curUser = array(email => $_SESSION[email]);
   $change = array('$set' => array(password => $newPassword));
   $db->update($curUser, $change);
   return "OK";
};

function getNewNoteId()
{
   global $db;
   $curUser = $db->findOne(array(email=>$_SESSION[email]));//нужный пользователь
   $id = $curUser[lastId];//получаем текущий lastId
   $id++;
   $db->update(array(email => $_SESSION[email]), array('$set' => array(lastId => $id)));//изменяем lastId
   return $id;
}

function addNote($note)//объект заметки
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";//не залогинен 
   if ($note->id == -1) 
      $note->id = getNewNoteId();//если -1, то новая заметка, иначе с обозначенным id
   $curUser = array(email => $_SESSION[email]); //нужный документ
   $newNote = array(
      "id" => $note->id,
      "title" => $note->title,
      "text" => $note->text,
      "created" => $note->created,
      "lastUpd" => $note->lastUpd
   );//новая заметка
   $db->update($curUser, array('$push' => array(notes => $newNote)));//добавляем
   return $note->id;
};

function deleteNote($id)
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";//не залогинен 
   $curUser = array(email => $_SESSION[email]); //нужный документ
   $change = array('$pull' => array(notes => array(id => $id))); //удаляемое поле
   $db->update($curUser, $change);//удаляем
   return "OK";
};

function updateNote($changeNote)//получаем объект заметки (новое название, текст, [lastUpd автоматически] id заметки)
{
   global $db;
   if ($_SESSION[email] == null) return "Ошибка доступа. Войдите в систему и повторите операцию.";//не залогинен 
   //получаем старую заметку по id:
   $a = $db->findOne(array(email => $_SESSION[email]), array("notes" => array('$elemMatch' => array(id => $changeNote->id))));
   $changeNote->created = $a[notes][0][created];//получаем ее дату создания
   deleteNote($changeNote->id);//удаляем старую по id
   addNote($changeNote);//создаем новую с тем же id и crated
   return "OK";
};
?>