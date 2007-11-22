<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/>
<meta name="author" content="author"/>
<base href="{$base}">
<link rel="icon" href="{$base}favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="{$base}favicon.ico" type="image/x-icon">
{foreach from=$css item=css}
<link rel="stylesheet" type="text/css" href="{$css.path}" media="{$css.media}" />
{/foreach}

{foreach from=$feed_rss item=feed_rss}
<link href="{$feed_rss.path}" rel="alternate" type="application/rss+xml" title="{$feed_rss.name}" />
{/foreach}

{foreach from=$js item=js}
<script type="text/javascript" src="{$js}"></script>
{/foreach}
<title>{$title}</title>
</head>

<body>

<div class="outer-container">

<div class="inner-container">

	<div class="header">

		<div class="title">

			<span class="sitename"><a href="/"><img style="border:0" src="images/logo.png" alt="LABCMS"/></a></span>
			<div class="slogan">Fast, Flexible, Free CMS</div>

		</div>

	</div>