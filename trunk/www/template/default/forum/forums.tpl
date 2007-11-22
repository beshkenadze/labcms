{include file=forum/header.tpl}
{if $access_admin}<div><a href="{$smarty.server.PHP_SELF}-add_forum{$ext}">добавить форум</a></div>{/if}
<table cellpadding="0" cellspacing="0">
<tr class="header"><td style="text-align:left;">Форум</td><td style="width:20px">Тем</td><td style="width:40px">Сообщений</td><td style="width:120px">Последний ответ</td></tr>
{section name=f loop=$forums}
<tr><td><a href="{$smarty.server.PHP_SELF}.{$forums[f].forum_id}{$ext}" title="{$forums[f].descr}">{$forums[f].forum_name}</a>{if $access_admin} <a href="{$smarty.server.PHP_SELF}-edit_forum.{$forums[f].forum_id}{$ext}">редактировать</a> <a href="{$smarty.server.PHP_SELF}-delete_forum.{$forums[f].forum_id}{$ext}">удалить</a>{/if}</td><td class="center">{$forums[f].total_themes}</td><td class="center">{$forums[f].total_posts}</td><td class="center">{$forums[f].last_post}<br />{$forums[f].last_user}</td></tr>
{/section}
</table>
{include file=forum/footer.tpl}