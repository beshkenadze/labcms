{include file=album/header.tpl}
<h1 style="margin-left:30px">Фотоальбомы</h1>
{foreach from=$albums key=name item=path}
<div style="margin:30px; display:block; float:left; background: url(images/album.gif) no-repeat center; width:70px; height:62px; line-height:62px; vertical-align:middle; text-align:center;"><a href="{$path}" title"{$album_descr}">{$name}</a><br /><a href="{$path}_edit">[E]</a> <a href="{$path}_delete">[D]</a></div>
{/foreach}
{section name=foo start=0 loop=20 step=1}
<div style="margin:30px; float:left; background: url(images/album_blank.gif) no-repeat center; width:70px; height:62px;"></div>  
{/section}
{include file=album/footer.tpl}