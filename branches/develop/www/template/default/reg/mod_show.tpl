<form id="reg" action="{$smarty.server.PHP_SELF}-insert" method="post">
<div class='mod_list'>
       <p> Логин*: <br/><input type="text" id="reg_login" name="user[{$catcher}]" value="{$user.login}" size="40" maxlength="40"/> <a href="javascript:check()">Проверить</a>
	   <span class="message" id="chLogin"></span>
	   <input type="text" name="user[login]" value="" class="catch"></p>
       <p>Пароль*: <br/><input type="password" id="password" name="user[pass]" value="" size="40" maxlength="40"/> </p>
	   <p>Ввести повторно: <br/><input type="password"  id="re_password"  name="user[pass1]" value="" size="40" maxlength="40"/> 
       <span class="message" id="passMsg"></span></p>
	   <p>email*: <br/><input id="email" type="text" name="user[email]" value="{$user.email}" size="40" maxlength="40"/> 
	   <span class="message" id="emailMsg"></span></p>
	   <p>icq: <br/><input type="text" name="user[icq]" value="{$user.icq}" size="40" maxlength="40"/> </p>
	   <p>www: <br/><input type="text" name="user[website]" value="{$user.website}" size="40" maxlength="40"/> </p>
	   <p>aim: <br/><input type="text" name="user[aim]" value="{$user.aim}" size="40" maxlength="40"/> </p>
	   <p>jabber: <br/><input type="text" name="user[jabber]" value="{$user.jabber}" size="40" maxlength="40"/> </p>
	   <p>msn: <br/><input type="text" name="user[msnm]" value="{$user.msnm}" size="40" maxlength="40"/> </p>
	   <p>skype: <br/><input type="text" name="user[skype]" value="{$user.skype}" size="40" maxlength="40"/> </p>
	   <p>realname: <br/><input type="text" name="user[realname]" value="{$user.realname}" size="40" maxlength="40"/> </p>
	  <input type="submit" value="Сохранить" />
</div>

</form>
{literal}
<script>
function check(){
	$.ajax({
   type: "POST",
   url: {/literal}"{$smarty.server.PHP_SELF}-check"{literal},
   data: "login="+$("#reg_login").val(),
   success: function(msg){
    $("#chLogin").html(msg);
   }
 });
}
function checkPass(){
	  if($("#password").val() != $("#re_password").val() || $("#password").val() == ""){
   		$('#passMsg').html("<div class='error'> Пароли не совпадают </div>");
	   }else{
	   	    $('#passMsg').html("<div class='ok'> Пароли совпадают </div>");
	   }
	   return $("#password").val() != $("#re_password").val();
}
$("#password").bind("change", function(){
 checkPass()
 });
 $("#re_password").bind("change", function(){
 checkPass()
 });
  $("#email").bind("change", function(){
 	chekcEmail()
 });
 function chekcEmail(){
 	if(isEmail($("#email").val())){
   		$('#emailMsg').html("<div class='ok'> Email правильный </div>");
	   }else{
	   	 $('#emailMsg').html("<div class='error'> Email не правильный  </div>");
	   }
	return isEmail($("#email").val());
 }
 function isEmail(email){
	  var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	  return filter.test(email);
}

</script>
{/literal}