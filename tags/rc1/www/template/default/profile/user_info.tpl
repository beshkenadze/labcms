<form action="{$smarty.server.PHP_SELF}-update" method="post">
<p>
<fieldset>
    <legend>Не заполняйте, если не хотите сменить пароль</legend>
	<p>Новый пароль: <br /><input type="password" name="pass" value=""></p>
	<p>Повторите пароль: <br /><input type="password" name="pass1" value=""></p>
</fieldset>
</p>
<fieldset>
    <legend>Информация</legend>
	<p>e-mail:<br /><input type="text" name="email" value="{$user_info.email}"></p>
	<p>website:<br /><input type="text" name="website" value="{$user_info.website}"></p>
	<p>icq:<br /><input type="text" name="icq" value="{$user_info.icq}"></p>
	<p>Настоящее имя:<br /><input type="text" name="realname" value="{$user_info.realname}"></p>
</fieldset>
<p><input type="submit" value="Обновить"></p>
</form>