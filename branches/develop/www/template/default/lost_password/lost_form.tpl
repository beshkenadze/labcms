<form id="reg" action="{$smarty.server.PHP_SELF}-check" method="post">
<div class='mod_list'>
       Логин: <input type="text" name="user[{$catcher}]" value="" size="40" maxlength="40"/>
       <input type="hidden" name="user[login]" value="" class="catch">
	  <p>ИЛИ</p>
       Email: <input id="email" type="text" name="email[{$catcher}]" value="" size="40" maxlength="40"/> 
	   <input type="hidden" name="user[email]" value="" class="catch">
	   <br/><br/>
      <input type="submit" value="Восстановить" />
</div>

</form>