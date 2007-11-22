{include file=album/header.tpl}
<h1>{$album_title}</h1>
<div>
{if $current_page>1}<a href="{$smarty.server.PHP_SELF}.{$current_page-1}{$ext}"><img src="images/arr_a_l.gif" alt="Предыдущая страница"><a/>{/if}
{if $current_page<$total}<a href="{$smarty.server.PHP_SELF}.{$current_page+1}{$ext}"><img src="images/arr_a_r.gif" alt="Следующая страница"></a>{/if}
</div>

{if $access_add}<a href="{$smarty.server.PHP_SELF}-add{$ext}">Добавить</a>{/if}
<table cellspacing="0" cellpadding="0" style="width:95%">
 {foreach from=$images item=rows}
  <tr style="margin:10px;background: url(images/film.gif) repeat-x; height:200px; text-align:center">
  {section name=img loop=$rows}
  <td  valign="middle">
   {if $rows[img].link}
    <a href="{$smarty.server.PHP_SELF}-image.{$rows[img].img_id}{$ext}#photo"><img src="{$rows[img].tn_name}" alt="{$rows[img].title}" /></a>
   {/if}
  </td>
  {/section}
  <tr><td>&nbsp;<td></tr>
  </tr>
 {/foreach}
</table>

{if $total>1}
<div class="navigate">
{section name=pages start=0 loop=$total step=1}
 {if ($smarty.section.pages.index+1)==$current_page}{$smarty.section.pages.index+1}
 {else}<a href="{$smarty.server.PHP_SELF}.{$smarty.section.pages.index+1}{$ext}">{$smarty.section.pages.index+1}</a>{/if}
 {if ($smarty.section.pages.index+1)!=$total}|{/if}
{/section}
</div>
{/if}
{include file=album/footer.tpl}