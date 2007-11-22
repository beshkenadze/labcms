<div id="rus">
{if $errors}
Во время сохранения произошли следующие ошибки:	<br />
{foreach from=$errors item=error_msg}
	{$error_msg}<br/>
{/foreach}
{/if}
<label><span>
<span class="select"><b>Программа:</b> </span><span id="program">{$parents.0.name}</span><span class="select"><a href="JavaScript:togleDisplay('programs')">ткни</a></span>
<ul id="programs">
{foreach from=$parents item=item}
	<li><a onclick="selectElement(this,'program')" href="JavaScript:void(0);">{$item.name}</a></li>
{/foreach}
</ul>
</span>
</label>
<label><span>
<span class="select"><b>Программа:</b> </span><span id="version">{$parents.0.name}</span><span class="select"><a href="JavaScript:togleDisplay('versions')">ткни</a></span>
<ul id="versions">
{foreach from=$versions item=item}
	<li><a onclick="selectElement(this,'version')" href="JavaScript:void(0);">{$item.name}</a></li>
{/foreach}
</ul>
</span>
</label>
<!--
<label><select onchange="setVersion(this.value)" onload="setVersion(this.value)" name="parent">
{foreach from=$parents item=item}
	<option  value="{$item.id}">{$item.name}</option>
{/foreach}
</select>
</label>
<label>
<span id="versions">
{foreach from=$versions item=program key=program_id}
	<select style="display:none" id="program_{$program_id}" value="version">
	    <optiongroup>Версия:</optiongroup>
		{foreach from=$program item=ver}
			<option  value="{$ver.id}">{$ver.name}</option>
		{/foreach}
	</select>
{/foreach}
</span>
</label>
-->
<form action="{$smarty.server.PHP_SELF}-{$smarty.get.action}{if $smarty.get.var1}.{$smarty.get.var1}{/if}{$ext}" method="post">

</form>
<script language="JavaScript" type="text/javascript">
 {literal}
 function  setVersion(id){
	$("program_"+id).style.display="block";
	closeAll(id);
  }
 function closeAll(id){
	$('versions').getElements('select').each(function(el){
		if(el.id != "program_"+id)
		  el.style.display="none";
	})
 }
 function selectElement(el,id) {
 	$(id).setHTML(el.innerHTML);
    $(id+"s").setStyles("display:none;");
 }
  function togleDisplay(id) {
    if($(id).getStyle("display") == "none"){
    $(id).setStyles("display:block;");
    }else{
    $(id).setStyles("display:none;");
    }
 }
 {/literal}
</script>

</div>