	<ul class='mod_list'>
	<h2>Список ползователей:</h2>
	{foreach from=$users item=item key=key}
	    {if $item.user_id > 0}<li><a href="{$smarty.server.PHP_SELF}-show.{$item.user_id}">{$item.login}</a> [<a href="{$smarty.server.PHP_SELF}-delete.{$item.user_id}">X</a>]</li>{/if}
	{/foreach}
	<li><hr/></li>
	<li><a href="{$smarty.server.PHP_SELF}-add/">Добавить нового пользователя</a><li>
	</ul>
	<ul class='group_list'>
	<h2>Список групп:</h2>
		<li><a href="{$smarty.server.PHP_SELF}-show.group/0/">Не зарегистрированные</a><li>
	{foreach from=$groups item=group}
	    <li><a href="{$smarty.server.PHP_SELF}-show.group/{$group.group_id}/">{$group.group_name}</a> {if $group.group_id > 1}[<a href="{$smarty.server.PHP_SELF}-delete.group/{$group.group_id}/">x</a>]{/if}<li>
	{/foreach}
		
	    <hr/>
	    <li><a href="{$smarty.server.PHP_SELF}-add.group">Добавить новую группу</a><li>
	</ul>
	