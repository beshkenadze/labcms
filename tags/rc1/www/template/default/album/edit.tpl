{include file=album/header.tpl}
<form enctype=multipart/form-data action="{$smarty.server.PHP_SELF}-edit{if $img_id}.{$img_id}{/if}{$ext}" method="post">
<p>Альбом*<br />
<select name="album_id">
 {html_options options=$albums selected=$album_id|default:$smarty.post.album_id}
</select> </p>
<p>Изображение<br /><input type="file" name="file_name" size="67" /></p>
<p>Название<br /><input type="text" name="img_title" value="{$img_title|default:$smarty.post.img_title|escape}" /></p>
<p>Описание<br /><textarea name="img_descr">{$img_descr|default:$smarty.post.img_descr|escape}</textarea></p>
<p><input type="submit" class="button" value="Сохранить" /></p>
</form>

{if $errors}
Во время добавления произошли следующие ошибки:	
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}
{include file=album/footer.tpl}