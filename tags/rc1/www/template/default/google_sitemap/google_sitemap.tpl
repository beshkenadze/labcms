<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
{foreach from=$map item=item key=key}
   <url>
      <loc>http://{$smarty.server.HTTP_HOST}{$item.tree_path}</loc>
      <lastmod>{$smarty.now|date_format:"%Y-%m-%d"}</lastmod>
   </url>
{/foreach}
</urlset>