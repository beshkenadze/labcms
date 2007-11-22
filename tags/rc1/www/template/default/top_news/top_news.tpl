<!-- новости -->
{section name=top_news loop=$top_news}

<h3>{$top_news[top_news].news_date|date_format} | {$top_news[top_news].news_title}</h3>
<p>{$top_news[top_news].news_text}{if $top_news[top_news].anonce} <a href="{$smarty.server.PHP_SELF}.{$top_news[top_news].news_id}/">...</a> {/if}	</p>
{if !$smarty.section.top_news.last}
<hr/>
{/if}
{/section}
