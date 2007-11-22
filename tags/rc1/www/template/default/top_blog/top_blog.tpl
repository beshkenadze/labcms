<!-- блог -->
{section name=top_blog loop=$top_blog}

<h3>{$top_blog[top_blog].blog_date|date_format} | <a href="{$smarty.server.PHP_SELF}.entry/{$blog[blog].blog_id}/">{$top_blog[top_blog].blog_title}</a></h3>
<p>{$top_blog[top_blog].blog_text}{if $top_blog[top_blog].anonce} <a href="{$smarty.server.PHP_SELF}.entry/{$blog[blog].blog_id}/">[Дальше]</a> {/if} ({$top_blog[top_blog].blog_author})	</p>
{if !$smarty.section.top_blog.last}
<hr/>
{/if}
{/section}
