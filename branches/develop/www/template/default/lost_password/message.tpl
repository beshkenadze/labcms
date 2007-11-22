<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Восстановление пароля</title>
</head>
<body>
<h1>Внимание!</h1>
<p>Если вы не запрашивали восстановление пароля, то не переходите по ссылке восстановления!</p>
<ul>
{foreach from=$retrive item=user}
<li>
Для пользователя {$user.login}, запрощено восстановление пароля. <br/>
Сгенерирован новый пароль: <b>{$user.new_pass}</b>.<br/>
Ссылка для восстановление 
<a href="http://{$smarty.server.HTTP_HOST}{$smarty.server.PHP_SELF}-retrive.{$user.login}/{$user.key}">
http://{$smarty.server.HTTP_HOST}{$smarty.server.PHP_SELF}-retrive.{$user.login}/{$user.key}</a>
</li>
{/foreach}
</ul>
</body>
</html>