{include file=headers/header.tpl}
	<div class="path">
		{$_module_path}
	</div>
	<div class="main">

		<div class="content">
{$_module_blocks_static_1}
			<h1>{$content_name}</h1>
			{$_component}
			{if $_module_comments}
			<hr/>
			{$_module_comments}
			{/if}
		</div>

		<div class="navigation">
			{$_module_menu_level_1}
			{if $_module_login}
			<h2>Аторизация:</h2>
			<div id="login">{$_module_login}</div>
			{/if}
		</div>

		<div class="clearer">&nbsp;</div>

	</div>
{include file=headers/footer.tpl}