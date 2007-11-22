{include file=album/header.tpl}
<style>
{literal}
 .next_prev{
 padding:0px;
 }
 .next_prev a
 {
 display:block; opacity: 0.50; filter: progid:DXImageTransform.Microsoft.Alpha(opacity = 50);
 } 
  .next_prev a:hover
 {
 opacity: 1; filter: progid:DXImageTransform.Microsoft.Alpha(opacity = 100);
 } 
{/literal}
</style>	
<a id="photo"></a>
<table>
 <tr>
  <td>{if $prev_id} 
 <div class="next_prev" style="background: url(images/arr_l.gif) no-repeat center center">
 <a href="{$smarty.server.PHP_SELF}-image.{$prev_id}{$ext}#photo"  title="{$prev_title}"><img src="{$prev_tn}" alt="{$prev_title}"></a>
 </div>
  {/if}
  </td>
  <td>
<div style="text-align:center;margin:20px"><h1><a href="{$album_link}" title="{$album_title}">{$album_title}</a></h1></div>
<div><img src="{$img_path}" alt="{$img_title}"></div>
{if $img_descr}<div style="text-align:center;margin:20px">{$img_descr}</div>{/if}
{if $access_edit}<a href="{$smarty.server.PHP_SELF}-edit.{$img_id}{$ext}">Редактировать</a>{/if}{if $access_delete}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-delete.{$img_id}{$ext}">Удалить</a>{/if}
 </td>
  <td>{if $next_id} 
 <div class="next_prev" style="background: url(images/arr_r.gif) no-repeat center center">
 <a href="{$smarty.server.PHP_SELF}-image.{$next_id}{$ext}#photo"  title="{$next_title}"><img src="{$next_tn}" alt="{$next_title}"></a>
 </div>
{/if}
  </td>
 </tr>
</table>

<div style="margin-top:50px;"></div>
{include file=album/footer.tpl}