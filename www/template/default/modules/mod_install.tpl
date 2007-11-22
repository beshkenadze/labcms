{if !$install}
	<form action="{$smarty.server.PHP_SELF}-edit.{$smarty.get.var1}/{$smarty.get.var2}{$ext}" method="post">
{else}
	<form action="{$smarty.server.PHP_SELF}-install.{$path}{$ext}" method="post">
{/if}
<h2>Имя модуля:</h2>
  <p>Имя модуля<br /><input type="text"  name="mod_name" value="{if $info.default.name}{$info.default.name}{else}{$mod_name|default:"Имя модуля"|escape}{/if}" size="40" maxlength="40"/></p>
  <p>Компонент:<br /><input {if $component OR $info.default.component} checked {/if} type="checkbox" name="component" /></p>
  <p>Статический:<br /><input {if $static OR $info.default.static} checked {/if} type="checkbox" name="static" /></p>
  <p>Участвует в поиске по сайту:<br /><input {if $search OR $info.default.search} checked {/if} type="checkbox" name="search" /></p>
  <p><input type="submit"  class="button" value="Сохранить" /></p>
</form>