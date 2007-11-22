	<ul class='mod_list'>
	<h2>Список модулей:</h2>
	{foreach from=$modules item=item key=key}
	    <li>
	    {if $item.name} <a href="{$smarty.server.PHP_SELF}-show.module/{$key}{$ext}">
	    <b>{$item.name}</b></a> - [<a href="{$smarty.server.PHP_SELF}-reinstall.{$key}{$ext}" onClick="if (!confirm('При переустановке будет потеряна вся информация модуля!\r\n Продолжить')) return false;">переустановить</a>]
	    {if $item.disable}[<a href="{$smarty.server.PHP_SELF}-disable.off/{$item.module_id}{$ext}">включить</a>]{else}[<a href="{$smarty.server.PHP_SELF}-disable.on/{$item.module_id}{$ext}">отключить</a>]{/if}
	    {elseif $item.info}<b>{$item.info.default.name}</b> (<a href="{$smarty.server.PHP_SELF}-install.{$key}{$ext}" >установить</a>)
	    {else}{$key}[<a href="{$smarty.server.PHP_SELF}-install.{$key}{$ext}" >установить</a>] {/if}<li>
	{/foreach}
	</ul>
	<ul class='group_list'>
	<h2>Список групп:</h2>
	{foreach from=$groups item=group}
	    <li><a href="{$smarty.server.PHP_SELF}-show.{$group.group_id}{$ext}">{$group.name}</a> [<a href="{$smarty.server.PHP_SELF}-delete.group/{$group.group_id}{$ext}">x</a>]<li>
	{/foreach}
	    <hr/>
	    <li><a href="{$smarty.server.PHP_SELF}-add.group/new{$ext}">Добавить новую группу</a><li>
	</ul>