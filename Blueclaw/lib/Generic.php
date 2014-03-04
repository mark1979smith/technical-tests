<?php
abstract class Generic  
{
	/**
	 * isAjax
	 * Defines if the request is done via AJAX
	 *
	 * @return boolean
	 */
	function isAjax()
	{
		return (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
	}
}
