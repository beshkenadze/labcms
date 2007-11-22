<script>
{literal}
 function data_win(id)
 {
  window.open('{/literal}{$smarty.server.PHP_SELF}{literal}.'+id+'{/literal}{$ext}{literal}', 'edit', config='width=468,height=600');
 }
 {/literal}
</script>


<table border="0" style="margin: 30px auto 700px;">
{if $duples}<tr><td colspan="5"><b>Внимание:</b> в главном дереве имеются дубликаты, ни один из которых не является ссылкой.<br />
{foreach key=path item=var from=$duples}
 Путь: <a href="{$path}">{$path}</a><br /> Дубликаты:<br />
 {foreach item=val from=$var}
  <a href="{$smarty.server.PHP_SELF|ext:$ext}#id{$val.0}">{$val.1}</a><br />
 {/foreach} 
{/foreach}
<hr />
</td></tr>{/if}
<tr><td><input type="submit" value="Сохранить"></td></tr>
<tr><td colspan="5"><a href="javascript:data_win(0)">Создать новый</a></td></tr>
<form class="simple" action="{$smarty.server.PHP_SELF|ext:$ext}" method="post">
{section name=tree_items loop=$tree_items}
<tr>
 <td style="border-bottom:1px dotted;">
  <span style="margin-left:{$tree_items[tree_items].margin}px">
   <input class="simple" name="pos[{$tree_items[tree_items].id}]" type="text" value="{$tree_items[tree_items].pos}" size="1"> 
   <a id="id{$tree_items[tree_items].id}"></a><a href="javascript:data_win({$tree_items[tree_items].id})"  title="id={$tree_items[tree_items].id}">{$tree_items[tree_items].name}</a>
   {if $tree_items[tree_items].link} <a href="{$smarty.server.PHP_SELF|ext:$ext}#id{$tree_items[tree_items].link}">[Link]</a>{/if}
  </span>
 </td>
 <td>
 <input title="Отображение элемента при формировании меню" type="checkbox" class="simple" name="menu[{$tree_items[tree_items].id}]"{if $tree_items[tree_items].menu}checked{/if}>
 <input title="Отображение элемента в карте сайта" type="checkbox" class="simple" name="sitemap[{$tree_items[tree_items].id}]"{if $tree_items[tree_items].sitemap}checked{/if}>
 <input title="Доступность элемента при ссылке на него" type="checkbox" class="simple" name="show[{$tree_items[tree_items].id}]"{if $tree_items[tree_items].show}checked{/if}>
 <input title="Удаление элемента" type="checkbox" class="simple" name="del[{$tree_items[tree_items].id}]"></td>
</tr>
{/section}
<tr><td><input type="submit" value="Сохранить"></td></tr>
</form>
</table>
