<div class="forum">
			<div class="forum_bar"><span style="float:left; margin-left:11px">
		<form action="{$smarty.server.PHP_SELF}-search{if $forum_id}.{$forum_id}{/if}{$ext}" method="get">
			Поиск сообщений </span><input type="text" style="float:left" name="search" value="{$smarty.get.search|escape}" />{if $forum_id}<a href="{$smarty.server.PHP_SELF}.{$forum_id}{$ext}">список тем</a>{/if}{if ($access_add && $forum_id)}<a href="{$smarty.server.PHP_SELF}-new.{$forum_id}{$ext}">добавить тему</a>{/if}
				<input type="submit" style="display:none" />
		</form>
		<form onsubmit="window.location.href='{$smarty.server.PHP_SELF}.'+(this.change_forum.value)+'{$ext}'; return false;" method="post">
			{html_options options=$select_forum selected=$current_forum name=change_forum}
			<input type="submit" value="ok">
		</form>
			</div>