<?php
namespace Core;

/**
 * View
 */


/**
 * Render a view file
 */
class View
{
	/**
	 * Render a view
	 */
	// public static function render($view, $arguments = [])
	// {
	// 	extract($arguments,EXTR_SKIP);
	// 	$file ="../App/Views/$view";

	// 	if(is_readable($file)){
	// 		require $file;
	// 	}else{
	// 		//echo "$file not found";
	// 		throw new \Exception("$file not found");
			
	// 	}
	// }


	/**
	 * Render a view using Twig
	 */

	public static function renderTemplate($template, $arguments = [] )
	{
		static $twig = null;

		if($twig === null)
		{
			$loader = new \Twig_Loader_Filesystem('../App/Views');
			$twig = new \Twig_Environment($loader);
		}
		echo $twig->render($template,$arguments);
	}
}