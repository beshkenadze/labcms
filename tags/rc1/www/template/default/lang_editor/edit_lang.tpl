<form action="" method="post">
<p>{t}Название языка{/t}<br /><input type="text" name="lang_name" value="{$lang_data.lang_name|default:$smarty.post.lang_name|escape}"></p>
<p>{t}Обозначение языка (напр. ru){/t}<br /><input type="text" name="key" value="{$lang_data.key|default:$smarty.post.key|escape}"></p>
<p><input type="submit" value="сохранить"></p>
</form>