{include file=forum/header.tpl}
{if $smarty.get.search}<div class="forum_search">Вы искали: <span class="forum_hl">{$smarty.get.search|escape}</span></div>{/if}
{if $no_result}
<div>К сожалению, ничего не найдено!</div>
{else}
<table cellpadding="0" cellspacing="0">
<tr class="header"><td style="text-align:left;">Тема</td><td style="width:60px">Автор</td><td style="width:40px">Сообщений</td><td style="width:120px">Последний ответ</td>{if !$forum_id}<td>Форум</td>{/if}{if access("moderator")}<td>удалить</td>{/if}</tr>
{section name=f loop=$themes}
<tr><td><a href="{$smarty.server.PHP_SELF}-theme.{$themes[f].theme_id}/1/{if $smarty.get.search}{$smarty.get.search|escape:"url"}{/if}{$ext}">{$themes[f].subject}</a></td><td class="center">{$themes[f].author}</td><td class="center">{$themes[f].total_posts}</td><td class="center"><a href="{$smarty.server.PHP_SELF}-theme.{$themes[f].theme_id}/999/{if $smarty.get.search}{$smarty.get.search|escape:"url"}{/if}{$ext}#last">{$themes[f].last_post}<br />{$themes[f].last_user}</a></td>{if $themes[f].forum_id}<td class="center"><a href="{$smarty.server.PHP_SELF}.{$themes[f].forum_id}{$ext}">{$themes[f].forum_name}</a></td>{/if}{if access("moderator")}<td class="center"><a href="{$smarty.server.PHP_SELF}-delete_theme.{$themes[f].theme_id}{$ext}">удалить</a></td>{/if}</tr>
{/section}
</table>
{/if}


{if $total>1}
<div class="navigate">
{section name=pages start=0 loop=$total step=1}
 {if ($smarty.section.pages.index+1)==$current_page}{$smarty.section.pages.index+1}
 {else}<a href="{$smarty.server.PHP_SELF}{if $smarty.get.action}_{$smarty.get.action}{/if}.{$forum_id}/{$smarty.section.pages.index+1}/{if $smarty.get.search}{$smarty.get.search|escape:"url"}{/if}{$ext}">{$smarty.section.pages.index+1}</a>{/if}
 {if ($smarty.section.pages.index+1)!=$total}|{/if}
{/section}
</div>
{/if}
{include file=forum/footer.tpl}