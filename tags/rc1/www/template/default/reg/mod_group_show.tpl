{if $smarty.get.var2 OR $smarty.get.var2 == "0"}
		<form action="{$smarty.server.PHP_SELF}-edit.group/{$smarty.get.var2}" method="post">
{else}
		<form action="{$smarty.server.PHP_SELF}-insert.group" method="post">
{/if}
<div style="margin:10px;">
       Имя: <input class="focusPokus" {if $smarty.get.var2 == 0} disable {/if} type="text" name="group[group_name]" value="{$group.group_name}" size="60" maxlength="40"/> <br/><br/>
       <input type="submit" value="Сохранить" />
</div>
<div>
<ul id="mods">Права доступа [<span onclick="eMod()" style="cursor:pointer;text-decoration:underline" id="collapse">раскрыть\закрыть все</span>]
	{foreach from=$modules item=item key=key}
					{if $item.install == 1 AND $item.name}
	   	          	<li><b style="cursor:pointer;" onclick="JavaScript: toggleMod('mod_{$key}')">{$item.name}</b>  [<span onclick="checkMod('mod_{$key}')" style="cursor:pointer;text-decoration:underline" >отметить все</span>]
	   	          		<ul style="display:block" id="mod_{$key}">
	   	          			{foreach from=$allpermis item=permis}
	   	          				{if $item.info.access.$permis}
	   	          						<li>{$item.info.access.$permis} :   <input type="checkbox" name="module[{$item.name}][permis][{$permis}]" {if $item.permis.$permis}checked{/if}/></li>
	   	          				{/if}
	   	          			{/foreach}
	   	          		</ul>
	   	          	<input value="{$item.module_id}" type="hidden" name="module[{$item.name}][module_id]" />
	   	          	<input value="{$smarty.get.var2}" type="hidden" name="module[{$item.name}][group_id]" />
	   	          	</li>
	   	          	{/if}
	 {/foreach}
</ul>
<input type="submit" value="Сохранить" />
</div>
</form>
{literal}
	<script language="JavaScript" type="text/javascript">
  	function toggleMod(id) {
  		var mod = $(id);
  		var display = mod.getStyle("display");
  		if(display == "none") {
  			mod.setStyle("display","block");
  		}else{
  			mod.setStyle("display","none");
  		}
  	}
  	function eMod(){
  		var els = $$("#mods ul");
  		els.each( function(el){
  			toggleMod(el.id);
  		});
  	}
  	function checkMod(id){
  		var els = $(id).getElements('input');
  		els.each( function(el){
  			if(el.type == "checkbox"){
  				if(el.checked) {
  					el.checked = false;
  				}else{
  					el.checked = true;
  				}
  			}
  		});
  	}
	</script>

{/literal}