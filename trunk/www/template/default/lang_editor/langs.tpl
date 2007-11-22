{if access('add')}<a href="{url action="add_lang"}">Добавить новый</a>{/if}
{foreach from=$langs item=lang}
	<p><a href="{url var1=$lang.lang_id}">{$lang.lang_name}</a>
	{if access('edit')}<a href="{url action="edit_lang" var1=$lang.lang_id}">E</a>{/if}
	{if access('delete')}<a href="{url action="del_lang" var1=$lang.lang_id}">D</a>{/if}</p>
{/foreach}