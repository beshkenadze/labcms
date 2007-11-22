<div id="navitabs">
<h2 class="hide">Меню:</h2>
<ul>
{section name=main_menu loop=$menu}
 <li><a class="navitab" href="{$menu[main_menu].path|ext:$ext}">{$menu[main_menu].tree_name}</a></li>
{/section}
</ul>
</div>
