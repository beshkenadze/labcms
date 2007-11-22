	{if $access_add}<div><a href="{$smarty.server.PHP_SELF}-add{$ext}">Добавить</a></div>{/if}
{if $blog}
	<h2>{$blog.0.blog_title}</h2>
	<div class="text">{$blog.0.blog_text}</div>
{else}
А записи нет!
{/if}
</div>