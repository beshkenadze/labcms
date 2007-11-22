<p>
Имя: {$user.realname|default:$user.login} {if $user.realname}a.k.a. {$user.login}{/if}
</p>
<p>
Website: <a href="{$user.website}">{$user.website}</a>
</p>
{if $user.icq}
<p>
ICQ: {$user.icq}
</p>
{/if}