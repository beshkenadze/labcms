<div id="nav_bar">
{foreach name=nav_bar key=key item=nav from=$path}
{if !$smarty.foreach.nav_bar.first}&gt;{/if} {if !$smarty.foreach.nav_bar.last}<a href="{$nav}">{$name.$key}</a>{else}<span>{$name.$key}</span>{/if} 
{/foreach}
</div>