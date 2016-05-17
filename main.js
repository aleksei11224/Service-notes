function logout()
{
	$.get("index.php", "type=logout", function(result){
		if (result == "OK") location.reload();
		else alert("Произошла неизвестная ошибка. Повторите операцию.");
	});
}

function removeNote(target)
{
	var note = target.parentElement.parentElement;
	$.get("index.php", {type:"remove", id:note.id.slice(2)}, function(result){
		if (result == "OK") 
			note.parentElement.removeChild(note);
		else alert("Произошла неизвестная ошибка. Повторите операцию.");
	});
}

function save(note)
{
	var text = note.children[1].children[0];
	var area = text.nextElementSibling.nextElementSibling;

	var titletext = note.children[0].children[0];
	var titleinput = note.children[0].children[1];

	var icon = titleinput.nextElementSibling.nextElementSibling;

	var MAX_TITLE_SIZE = 25;
	var MAX_TEXT_SIZE = 200;
	if (titleinput.value.length > MAX_TITLE_SIZE) 
	{
		editError("Длина заголовка не должна превышать "+MAX_TITLE_SIZE+" символов.");
		return;
	}
	if (area.value.length > MAX_TEXT_SIZE) 
	{
		editError("Длина заметки не должна превышать "+MAX_TEXT_SIZE+" символов.");
		return;
	}

	icon.style.top="1px";
	icon.previousElementSibling.style.top="1px";

	icon.className = "glyphicon glyphicon-pencil";

	$(text).show();
	$(area.previousElementSibling).remove();
	$(area).hide();

	$(titletext).show();
	$(titleinput).hide();

	text.textContent = area.value;

	titletext.textContent = titleinput.value;  

	$.get("index.php", {
		type:"update", 
		id:note.id.slice(2), 
		title:titletext.textContent, 
		text:text.textContent
	}, function(result){
		note.children[2].lastElementChild.textContent = "Изменено: "+result;										
	});
}

function edit(note)
{
	var text = note.children[1].children[0];
	var area = text.nextElementSibling;

	var titletext = note.children[0].children[0];
	var titleinput = note.children[0].children[1];

	var icon = titleinput.nextElementSibling.nextElementSibling;
	if (icon.classList.contains("glyphicon-ok"))
	{
		save(note);
		return ;
	}

	icon.className = "glyphicon glyphicon-ok";
	icon.style.top="-31px";
	icon.previousElementSibling.style.top="-31px";

	$(text).hide();
	$(area).show();
	$(titletext).hide();
	$(titleinput).show();

	$(area).autoResize();
	area.value = text.textContent;

	titleinput.value = titletext.textContent;
}

function editError(message)
{
	ErrorMsg.textContent = message;
	$("#Error").modal();
}

function add()
{
	$.get("index.php",{type:"add"},function(result) { 
		var id = result.split('@')[0];
		var date = result.split('@')[1];
		var htmlcode = `
			<div id='id`+id+`' class='note panel panel-success'>
				<div class='panel-heading'>
					<span></span>
					<input placeholder='Введите название' required class='form-control' style='display:none; width:80%'>      
					<span onclick = 'removeNote(this);' class='glyphicon glyphicon-remove'></span>
					<span onclick = 'edit(this.parentElement.parentElement);' class='glyphicon glyphicon-pencil'></span>
				</div>
				<div class='panel-body'>
					<p></p>
					<textarea placeholder='Введите текст заметки' required class='form-control' style='display:none;'></textarea>
				</div>
				<div class='panel-footer'>
					<span>Создано: `+date+`</span>
					<br>
					<span>Изменено: `+date+`</span>
				</div>
			</div>`;
		$("div.content")[0].insertAdjacentHTML("beforeEnd", htmlcode);
		setTimeout(function(idn){edit(document.getElementById("id"+idn));},50,id);
	});
}

function changeName()
{
	var name = NewName.value;
	$.get("index.php",{type:"changeName", name:name},function(result){
		if (result == "OK")
		{
			NewName.nextElementSibling.textContent = "Имя успешно изменено.";
			NewName.parentElement.classList.add("has-success");
			$("nav>div>button")[0].textContent = name;							
		}
		else alert("Произошла неизвестная ошибка. Повторите операцию.");
	});
}

function changePassword()
{
	var NewPassw = NewPassword.parentElement;
   var NewRepPassw = RepeatNewPassword.parentElement;
		
	var password = NewPassword.value;            
   var repassword = RepeatNewPassword.value;
	
   if (password.length < 6)
   {
      NewPassw.classList.add("has-error");
      NewPassw.children[2].textContent = "Ошибка. Пароль должен быть не менее 6 символов.";
      return;                              
   }
   if (password != repassword)
   {
      NewRepPassw.classList.add("has-error");
      NewRepPassw.children[2].textContent = "Ошибка. Пароли не совпадают.";
      return;
   }
	$.get("index.php",{type:"changePassword", password:password},function(result){
		if (result == "OK")
		{
			NewPassw.classList.add("has-success");
      	NewPassw.children[2].textContent = "Пароль успешно изменен.";	
			NewRepPassw.classList.add("has-success");
		}
		else alert("Произошла неизвестная ошибка. Повторите операцию.");
	});
}

$(function(){
   NewPassword.onfocus = function(){
		this.parentElement.className = 'form-group';
		this.nextElementSibling.textContent = "";
	}
	RepeatNewPassword.onfocus = function(){
		this.parentElement.className = 'form-group';
		this.nextElementSibling.textContent = "";
	}
	
});

function reset()
{
   NewName.nextElementSibling.textContent = "";
	NewName.parentElement.className="form-group";	
	NewName.value = "";
	
	NewPassword.nextElementSibling.textContent = "";
	NewPassword.parentElement.className="form-group";
	NewPassword.value = "";
	
	RepeatNewPassword.nextElementSibling.textContent = "";
	RepeatNewPassword.parentElement.className="form-group";
	RepeatNewPassword.value = "";
}