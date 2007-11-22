{if $access_add}
<div><a href="{$smarty.server.PHP_SELF}-add.part">Добавить раздел</a></div>
{/if}
{foreach from=$sections item=part key=key}
	    <li>
	    <a href="{$smarty.server.PHP_SELF}.{$part.todo_id}">{$part.name}</a>
	    {if $access_edit}<a class="edit" href="{$smarty.server.PHP_SELF}-edit.part/{$part.todo_id}">[e]</a>{/if}
	     {if $access_delete}<a class="doDelete" href="{$smarty.server.PHP_SELF}-delete.part/{$part.todo_id}">[x]</a>{/if}
	    <li>
{/foreach}
