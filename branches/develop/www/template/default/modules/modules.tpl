	<ul class='mod_list'>
	<h2>Список модулей:</h2>
	{foreach from=$modules item=item key=key}
	    <li>{if $item.name} <a href="{$smarty.server.PHP_SELF|ext:$ext}?module_id={$item.module_id}">{$item.name}</a> (установлен) {else} {$key} (неустановлен) {/if}<li>
	{/foreach}
	</ul>
	<ul class='group_list'>
	<h2>Список групп:</h2>
	{foreach from=$groups item=group}
	    <li><a href="{$smarty.server.PHP_SELF|ext:$ext}?group_id={$group.group_id}">{$group.name}</a> [<a href="{$smarty.server.PHP_SELF|ext:$ext}?group_id={$group.group_id}&action=edit">e</a>] [<a href="{$smarty.server.PHP_SELF|ext:$ext}?group_id={$group.group_id}&action=delete">x</a>]<li>
	{/foreach}
	    <hr/>
	    <li><a href="{$smarty.server.PHP_SELF|ext:$ext}?group_id=0">Добавить новую группу</a><li>
	</ul>