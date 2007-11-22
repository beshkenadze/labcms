<form action="{url action=$smarty.get.action var1=$post_data.msg_id}" method="post">
{if $user_info.login && $smarty.get.action=='add'}
<p>{t}Имя{/t}*<br /><input type="text" name="{$catcher}" value="{$user_info.login|escape}" readonly /></p>
{elseif $post_data.login && $smarty.get.action=='edit'}
<p>{t}Имя{/t}*<br /><input type="text" name="{$catcher}" value="{$post_data.login|escape}" readonly /></p>
{else}
<input type="text" name="name" value="" class="catch">
<p>Имя*<br /><input type="text" name="{$catcher}" value="{$post_data.name|escape|default:$smarty.post.name|escape}"></p>
<p>Email<br /><input type="text" name="email" value="{$post_data.email|escape|default:$smarty.post.email|escape}"></p>
{/if}
<p>{t}Сообщение{/t}*<br />
<textarea name="msg" id="msg">{$post_data.msg|escape|default:$smarty.post.msg|escape}</textarea></p>

{if $post_data.msg_id} {* если указан идентификатор сообщения, то отображаем форму ответа *}
<p>{t}Ответ{/t}<br />

<textarea name="answer" id="answer">{$post_data.answer|escape|default:$smarty.post.answer|escape}</textarea></p>
{/if}
<p><input type="submit" value="Отправить" /></p>
</form>