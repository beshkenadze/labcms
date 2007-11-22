Внимание!
Если вы не запрашивали восстановление пароля, то не переходите по ссылке восстановления!
{foreach from=$retrive item=user}

Для пользователя {$user.login}, запрощено восстановление пароля.
Сгенерирован новый пароль: {$user.new_pass}
Ссылка для восстановление http://{$smarty.server.HTTP_HOST}{$smarty.server.PHP_SELF}-retrive.{$user.login}/{$user.key}
{/foreach}