<?php

namespace App\Controllers;
use \Core\View;

class Home extends \Core\Controller
{
	public function indexAction()
	{
		//echo "Home Controllers";
		View::renderTemplate('Home/index.html',['name' => 'Alan','colours' => ['red','green','blue']]);

	}

}