<?
	/**
	 * copy file
	 * @author Logan Cai (cailongqun@yahoo.com.cn)
	 * @link www.phpletter.com
	 * @since 22/May/2007
	 *
	 */

	require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "config.php");
	$error = "";
	$info = '';
	if(!isset($_POST['selectedDoc']) || !is_array($_POST['selectedDoc']) || sizeof($_POST['selectedDoc']) < 1)
	{
		$error = ERR_NOT_DOC_SELECTED_FOR_COPY;
	}
	elseif(empty($_POST['currentFolderPath']) || !isUnderRoot($_POST['currentFolderPath']))
	{
		$error = ERR_FOLDER_PATH_NOT_ALLOWED;
	}else 
	{		
		require_once(CLASS_SESSION_ACTION);
		$sessionAction = new SessionAction();
		$sessionAction->setAction($_POST['action_value']);
		$sessionAction->setFolder($_POST['currentFolderPath']);
		$sessionAction->set($_POST['selectedDoc']);
		$info = ',num:' . sizeof($_POST['selectedDoc']);
	}
	echo "{error:'" . $error .  "'\n" . $info . "}";
?>