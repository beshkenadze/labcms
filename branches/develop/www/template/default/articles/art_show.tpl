{if $access_add}<span class="content_name"><a href="{$smarty.server.PHP_SELF}-add{$ext}">Добавить новую</a></span>{/if}
{if $access_edit}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-edit.{$art_id}{$ext}">редактировать</a>{/if}
{if $access_delete}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-delete.{$art_id}{$ext}">удалить</a>{/if}

<div><h1>{$art_name}</h1>{$art_data}</div>
