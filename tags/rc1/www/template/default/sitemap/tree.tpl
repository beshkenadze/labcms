{if $tree}
<ul class='tree'>
{foreach from=$tree item="item"}
    <li {if !$item.path}class="no-style"{/if}>{if $item.path}<a href='{$item.path|ext:$ext}'>{$item.name}</a>{/if}
        {if $item.subtree}
            {include file="sitemap/tree.tpl" tree=$item.subtree}
        {/if}
    </li>
{/foreach}
</ul>
{/if}