<hr />
{if $add_access}<span class="content_name"><a href="{$smarty.server.PHP_SELF}-add/">Написать сообщение</a></span>{/if}
{section name=guest loop=$guest}
<hr />
<h2>{if $guest[guest].email}&nbsp;&nbsp;{mailto address=$guest[guest].email text="@" encode="javascript"}{/if} {$guest[guest].name} ({if access("moderator")}{$guest[guest].ip}{/if})</h2>
<div class="descr">{$guest[guest].date}</div>
<p>
					{$guest[guest].post}
</p>
                                        {if $guest[guest].answer}
<p style="margin-bottom:5px;font-style: italic;">
                                       Admin: {$guest[guest].answer}
</p>
                                        {/if}
{if $admin_access}<a href="{$smarty.server.PHP_SELF}-edit.{$guest[guest].id}/">Редактировать</a> <a href="{$smarty.server.PHP_SELF}-delete.{$guest[guest].id}/">Удалить</a>{/if}
{sectionelse}
<hr />
{t}Пока нет ни одного сообщения.{/t}
{/section}
<hr />
{if $add_access}<span class="content_name"><a href="{$smarty.server.PHP_SELF}-add/">Написать сообщение</a></span>{/if}
<hr />
{if $total>1}
{section name=pages start=0 loop=$total step=1}
 {if ($smarty.section.pages.index+1)==$current_page}[{$smarty.section.pages.index+1}]
 {else}<a href="{$smarty.server.PHP_SELF}.{$smarty.section.pages.index+1}/">[{$smarty.section.pages.index+1}]</a>{/if}
{/section}
{/if}
