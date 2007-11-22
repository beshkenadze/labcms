{if $access_add}<span class="content_name"><a href="{$smarty.server.PHP_SELF}-add{$ext}">Добавить новую</a></span>{/if}
<table style="margin-left:25px">
{section name=art loop=$art_list}
<tr>
<td><a href="{$art_list[art].path}">{$art_list[art].art_name}</a></td>
{if $access_edit}<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-edit.{$art_list[art].art_id}{$ext}">редактировать</a></td>{/if}
{if $access_delete}<td><a href="{$smarty.server.PHP_SELF}-delete.{$art_list[art].art_id}{$ext}">удалить</a></td>{/if}
</tr>
{/section}
</table>
