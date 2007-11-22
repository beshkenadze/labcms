<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>{$rss.title}</title>
    <link>{$rss.link}</link>
    <description>{$rss.description}</description>
    <language>{$rss.lang}</language>
    <pubDate>{$rss.pubDate}</pubDate>

    <lastBuildDate>{$rss.lastBuildDate}</lastBuildDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>LabCMS Feed</generator>
    <managingEditor>{$rss.editor}</managingEditor>
    <webMaster>{$rss.webmaster}</webMaster>

    {foreach from=$rssItem item=item}
    <item>
      <title>{$item.title}</title>
      <link>http://{$smarty.server.HTTP_HOST}{$smarty.server.PHP_SELF}.entry/{$item.id}</link>
      <description>{$item.text|escape}</description>
      <pubDate>{$item.date} GMT</pubDate>
      <guid>http://{$smarty.server.HTTP_HOST}{$smarty.server.PHP_SELF}.entry/{$item.id}</guid>
    </item>
    {/foreach}
  </channel>
</rss>