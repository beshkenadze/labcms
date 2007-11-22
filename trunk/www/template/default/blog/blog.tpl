	{if $access_add}<div><a href="{$smarty.server.PHP_SELF}-add{$ext}">Добавить</a></div>{/if}
{if $blog}
	<!-- записи -->
	<div id="blog">
	{section name=blog loop=$blog}

	<span class="date">{$blog[blog].blog_date|date_format}</span> <span class="dots">:</span> <span class="name"><a href="{$smarty.server.PHP_SELF}.entry/{$blog[blog].blog_id}{$ext}">{$blog[blog].blog_title}</a></span>
{$blog[blog].blog_text}{if $blog[blog].anonce} [<a href="{$smarty.server.PHP_SELF}.entry/{$blog[blog].blog_id}{$ext}">дальше</a>]{/if} ({$blog[blog].blog_author})<br />
<a href="{$smarty.server.PHP_SELF}.entry/{$blog[blog].blog_id}{$ext}"><!--comment{$blog[blog].blog_id}--></a>
	{if $access_edit}<A href="{$smarty.server.PHP_SELF}-edit.entry/{$blog[blog].blog_id}{$ext}">редактировать</a>{/if}{if $access_delete}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A href="{$smarty.server.PHP_SELF}-delete.entry/{$blog[blog].blog_id}{$ext}">удалить</a>{/if}

	{if $smarty.section.blog.last}

	{else}
						<hr/>
	{/if}
	{/section}

	{if $total>1}
	<div class="navigate">
	{section name=pages start=0 loop=$total step=1}
	 {if ($smarty.section.pages.index+1)==$current_page}{$smarty.section.pages.index+1}
	 {else}<a href="{$smarty.server.PHP_SELF}-page.{$smarty.section.pages.index+1}{$ext}">{$smarty.section.pages.index+1}</a>{/if}
	 {if ($smarty.section.pages.index+1)!=$total}|{/if}
	{/section}
	</div>
	{/if}
{else}
А записей пока нет!
{/if}
</div>