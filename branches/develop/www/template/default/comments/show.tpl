<div id="comments">
{if $mode!="edit"}
	{if $comments}
			{section name=comments loop=$comments}
					<h2>{if $comments[comments].email}{mailto text="@" address=$comments[comments].email encode="javascript"}{/if}{$comments[comments].name}{if access("moderator")} ({$comments[comments].ip}){/if}</h2>
					<div class="descr">{$comments[comments].date}{$comments[comments].putdate|date_format:"%H:%M %d/%m/%Y"}</div>
					<p>{$comments[comments].msg}</p>
					<p>
					{if $comments[comments].access_edit}&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-comment_edit.{$comments[comments].id}{$ext}?return={$smarty.server.REQUEST_URI|escape:url}">Редактировать</a>{/if}
					{if $comments[comments].access_delete}&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-comment_delete.{$comments[comments].id}{$ext}?return={$smarty.server.REQUEST_URI|escape:url}">Удалить</a>   {/if}
					</p>
			{/section}
	{else}
	Пока нет комментариев
	{/if}
{/if}
<hr/>
{if $access_add || $access_edit}
	<form name="comment" method="post" action="">
		<input type="hidden" name="return" value="{$smarty.request.return|default:$smarty.server.REQUEST_URI|escape}" />
		{if $user_info.login}
			<p>Имя*<br /><input type="text" name="{$catcher}" value="{$user_info.login|escape}" readonly /></p>
		{elseif $user_info.login && $mode=="edit"}
			<p>Имя*<br /><input type="text" name="{$catcher}" value="{$name|escape}" readonly /></p>
		{else}
			<input type="text" name="name" class="catch">
			<p>Имя*<br /><input type="text" name="{$catcher}" value="{$name|default:$smarty.post.name|escape}" /></p>
			<p>E-mail<br /><input type="text" name="email" value="{$email|default:$smarty.post.email|escape}" /></p>
		{/if}
		<p>Комментарий*<br />
		<!-- tinyMCE -->
	<script language="javascript" type="text/javascript" src="http://{$smarty.server.HTTP_HOST}/js/tiny_mce/tiny_mce.js"></script>
	{literal}
	<script type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "none",
		plugins : "bbcode",
		theme_advanced_buttons1 : "bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "bottom",
		theme_advanced_toolbar_align : "center",
		theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
		content_css : "css/bbcode.css",
		entity_encoding : "raw",
		add_unload_trigger : false,
		remove_linebreaks : false
	});
	</script>
	{/literal}
	<!-- /tinyMCE -->
		<textarea name="msg" cols="50" rows="5" id="msg">{$msg|default:$smarty.post.msg|escape}</textarea></p>
		<p><a href="JavaScript:tinyMCE.execCommand('mceToggleEditor',false,'msg');">[Toggle WYSIWYG]</a></p>
		<p><input type="submit" class="button" value="Отправить"></p>
	</form>
	{if $errors}
		Во время добавления произошли следующие ошибки:
		{foreach from=$errors item=error_msg}
			{$error_msg}<br/>
		{/foreach}
	{/if}
{/if}
</div>