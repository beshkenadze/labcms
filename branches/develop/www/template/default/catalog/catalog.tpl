{if $show_item}
	{foreach from=$items item=item}
       <li>
       		Автор: <a href="{$smarty.server.PHP_SELF}-dowload.{$item.id}{$ext}">{$item.name}</a> {if $item.descr} - {$item.descr} {/if}
	   </li>
	{/foreach}
{else}
<ul>{if $parent} <ol> <a href="{$smarty.server.PHP_SELF}.{$parent.id}{$ext}">{$parent.name}</a>  <ol>{/if}
{foreach from=$catalog item=item}
       <li>
       		Версия: <a href="{$smarty.server.PHP_SELF}.{if $parent}{$parent.id}/{$item.id}{else}{$item.id}{/if}{$ext}">{$item.name}</a> {if $item.descr} - {$item.descr} {/if}
	   </li>
{/foreach}
</ul>
{/if}