<form style="margin-top: 50px;" action="{$smarty.server.PHP_SELF|ext:$ext}" method="post">
{section name=config loop=$config_form}
<p><input type="text" name="{$config_form[config].name}" value="{$config_form[config].value|escape}"> {$config_form[config].describe}</p>
{/section}
<p><input type="submit" class="button" value="Сохранить" /></p>
</form>