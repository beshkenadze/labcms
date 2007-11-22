{include file=headers/header.tpl}
<div id="content">
							<h3>Страница не найдена!</h3>
							Страница http://{$smarty.server.SERVER_NAME}{$smarty.server.REQUEST_URI|urldecode|escape} на этом сайте отсутствует.<br />
							Возможно, она была удалена или перемещена при редизайне.<br />
							Попробуйте воспользоваться <a href='/sitemap'>картой сайта</a>.
</div>
{include file=headers/footer.tpl}
