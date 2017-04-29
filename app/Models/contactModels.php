<?php
namespace MyCvApp\Models;

use Silex\Application;
use Doctrine\DBAL\Connection;

class contactModels{

	private $db;

	function __construct( Connection $db )
	{
		$this->db = $db;
	}
	protected function getDb()
	{
		return $this->db;
	}

	public function saveContact($name, $email, $message)
	{
		$this->getDb()->insert('contact', array('name'=>$name, 'email'=>$email,'message'=>$message));
		return 'Message bien envoyé';
	}

}