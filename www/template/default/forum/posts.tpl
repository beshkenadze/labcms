{include file=forum/header.tpl}
{if $smarty.get.search}<div class="forum_search">Вы искали: <span class="forum_hl">{$smarty.get.search|escape}</span></div>{/if}
<table class="forum_p">
<tr>
 <td colspan="2"><h1>{$subject}</h1></td>
</tr>
{section name=f loop=$posts}
<tr>
 <td valign="top" style="width:100px">
 {if $smarty.section.f.last}<a name="last"></a>{/if}
 {$posts[f].user_name}<br />
{if $posts[f].email}
 {mailto address=$posts[f].email text="email" encode="javascript"}<br />
{/if}
</td>
<td>
<div class="smalltext">{$posts[f].putdate}{if access("moderator")}&nbsp;&nbsp;&nbsp;&nbsp;{$posts[f].ip}{/if}</div>
{$posts[f].msg}
<div class="smalltext" style="text-align:right;">
  {if $access_add}<a href="{$smarty.server.PHP_SELF}-reply.{$posts[f].post_id}{$ext}">ответить</a>{/if}
  {if $posts[f].access_edit}&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-edit.{$posts[f].post_id}{$ext}">редактировать</a>{/if}
  {if $posts[f].access_delete}&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-delete.{$posts[f].post_id}{$ext}">удалить</a>{/if}
</div>
</td>
</tr>
{/section}
</table>

{if $total>1}
<div class="navigate">
{section name=pages start=0 loop=$total step=1}
 {if ($smarty.section.pages.index+1)==$current_page}{$smarty.section.pages.index+1}
 {else}<a href="{$smarty.server.PHP_SELF}-theme.{$theme_id}/{$smarty.section.pages.index+1}/{if $smarty.get.search}{$smarty.get.search|escape:"url"}{/if}{$ext}">{$smarty.section.pages.index+1}</a>{/if}
 {if ($smarty.section.pages.index+1)!=$total}|{/if}
{/section}
</div>
{/if}
{include file=forum/footer.tpl}