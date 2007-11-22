{if $access_add}<a href="{$smarty.server.PHP_SELF}-add{$ext}">добавить</a>{/if}
<table>
{if $blocks}
<form action="{$smarty.server.PHP_SELF|ext:$ext}" method="post">
<tr><td><input type="submit" value="сохранить"></td></tr>
<tr><td>id</td><td>название</td><td>включен</td>{if $access_delete}<td>удаление</td>{/if}{/if}</tr>
{section name=b loop=$blocks}
<tr><td>{$blocks[b].block_id}</td><td>{if $access_edit}<a href="{$smarty.server.PHP_SELF}.{$blocks[b].block_id}{$ext}">{/if}{$blocks[b].name}{if $access_edit}</a>{/if}</td><td><input name="visible[{$blocks[b].block_id}]" type="checkbox"{if $blocks[b].visible} checked{/if}></td>{if $access_delete}<td><a href="{$smarty.server.PHP_SELF}-delete.{$blocks[b].block_id}{$ext}" onClick="if (!confirm('Уверен?\r\nПосле удаления блока придется править шаблоны.')) return false;">удалить</a></td>{/if}</tr>
{sectionelse}
<tr><td>Пока ни одного блока не создано</td></tr>
{/section}
{if $blocks}
<tr><td><input type="submit" value="сохранить"></td></tr>
</form>{/if}
</table>