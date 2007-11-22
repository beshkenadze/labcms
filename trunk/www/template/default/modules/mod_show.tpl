{if $smarty.get.var1 and $smarty.get.var2 != "new"}
		<form action="{$smarty.server.PHP_SELF}-edit.{$smarty.get.var1}{$ext}" method="post">
{elseif $smarty.get.var2 == "new"}
		<form action="{$smarty.server.PHP_SELF}-insert{$ext}" method="post">
{/if}
<script>
{literal}
function check(el){
	var op = $('mod').getElements('option');;
	op.each( function(o){
			if(el.lang == 1 & o.lang==1) {
				o.selected=false;
				el.selected=true;
			}
		});
}
{/literal}
</script>

<div class='mod_list'>
	<h2>
       <input type="text" name="group_name" value="{$group_name}" size="40" maxlength="40"/>
	</h2>
	<select multiple=multiple size=5 name="mod[]" id="mod">
	   	   {foreach from=$modules item=item key=key}
	   	      {if $item.name}
	   	          {if $item.select}
	   	   	          <option lang={$item.component} onclick="check(this)" selected value="{$item.module_id}"/>{$item.name}</option>
	   	          {else}
	   	              <option lang={$item.component} onclick="check(this)" value="{$item.module_id}"/>{$item.name}</option>
	   	           {/if}
	   	      {/if}
	   	   {/foreach}
	</select>
</div>
  <input type="submit" class="but" value="Сохранить" />
</form>