<p>{$current_lang}</p>
<form action="" method="post">
{foreach from=$text_data item=text}
<p>{$text.text_key}({$text.text_descr})<br />
<input type="text" name="translate_text[{$text.text_id}]" value="{$text.text}">
{if access('msg_delete')}<input type="checkbox" name="delete_string[{$text.text_id}]">{/if}</p>
{/foreach}
<p><input type="submit" value="сохранить"></p>
</form>
