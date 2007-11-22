{if $tree}
    {foreach key=key from=$tree item="item" name="treeMenu"}
    <li id="treeMenu{$key}">{if $item.path}<a href='{$item.path}' >{$item.name}</a>{else}{$item.name}{/if}
        {if $item.subtree}
        <ul id="menuUl{$key}"{if $item.active}style="display: block"{else}style="display: block"{/if}>
        	{include file="menu_tree/tree.tpl" tree=$item.subtree}
        </ul>
        {/if}
    </li>
    {/foreach}
{/if}
