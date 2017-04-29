<?php
namespace MyCvApp\Models;

use Silex\Application;
use Doctrine\DBAL\Connection;

class pictureModels{

	private $db;

	function __construct( Connection $db )
	{
		$this->db = $db;
	}

	public function findRandPictures()
	{
		$sql = 'SELECT * FROM pictureWorks ORDER BY RAND() LIMIT 4';
		$result = $this->db->fetchAll($sql);
		return $result;
	}

	// public function insertPictures($name, $cat, $url){
	// 	$this->db->insert('pictureWorks', array('name'=>$name, 'cat'=>$cat, 'url'=>$url));
	// 	return 'picture save';
	// }

}