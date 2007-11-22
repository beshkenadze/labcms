	{if $access_add}<div><a href="{$smarty.server.PHP_SELF}-add/">Добавить</a></div>{/if}
{if $news}
	<!-- новости -->
	<div id="news">
	{section name=news loop=$news}
	<h1><a href="{$smarty.server.PHP_SELF}.{$news[news].news_id}/">{$news[news].news_title}</a></h1>
	<div class="descr">{$news[news].news_date|date_format}</div>
	<p>
	{$news[news].news_text}{if $news[news].anonce}... [ <a class="next" href="{$smarty.server.PHP_SELF}.{$news[news].news_id}/">дальше</a> ]{/if}
	</p>
	<p>
	{if $access_edit}<a href="{$smarty.server.PHP_SELF}-edit.{$news[news].news_id}/">редактировать</a>{/if}{if $access_delete}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$smarty.server.PHP_SELF}-delete.{$news[news].news_id}/">удалить</a>{/if}
	</p>
	{/section}

	{if $total>1}
	<div class="navigate">
	{section name=pages start=0 loop=$total step=1}
	 {if ($smarty.section.pages.index+1)==$current_page}{$smarty.section.pages.index+1}
	 {else}<a href="{$smarty.server.PHP_SELF}-page.{$smarty.section.pages.index+1}/">{$smarty.section.pages.index+1}</a>{/if}
	 {if ($smarty.section.pages.index+1)!=$total}|{/if}
	{/section}
	</div>
	{/if}
	</div>
{else}
А новостей пока нет!
{/if}
