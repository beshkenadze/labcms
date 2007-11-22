{if $login_secsess}
  Привет!
{elseif $login_logged}
  Вы зашли как: {$user_info.login}
  <br/><a href="{$smarty.server.PHP_SELF}-logout{$ext}">выйти</a>
{else}
 {if $login_deny}
  Вали отседа!<br />
 {/if}
  <form action="{$login_action}" method="post">
   <label>Логин<br />
   <input type="text" name="login" value="{$smarty.post.login|escape|default:$smarty.cookies.login}"></label>
   <label>Пароль<br />
   <input type="password" name="pass"></p>
   <label><input class="button" type="submit" value="Войти"></label>
  </form>
{/if}
