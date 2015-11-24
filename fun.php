<?php
header('Content-type: text/html; charset=utf-8');
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 'Off');

class DB
{
////////////////////connect/////////////////
	private $db;
	private $host;
	private $user;
	private $pass;
	private $base;
	
	public function __destruct()
	{
		@$this->db->close();
	}
	
	public function connect()
	{
		$this->db=new mysqli($this->host,$this->user,$this->pass,$this->base);
		if (!mysqli_connect_errno())
			{	
				$this->db->select_db("asterisk");
				$this->db->query('SET NAMES utf8'); // Для кодировки UTF-8
				return true;
			}
		else 
			return false;
	}
	
	public function set_connect($host,$user,$pass,$base)
	{
		$this->host=$host;
		$this->user=$user;
		$this->pass=$pass;
		$this->base=$base;
	}

////////////////////work for food///////////////
	public function get_same_food(&$result) //получить продукты присутствующие в обоих списках
	{
		$result=array();

		$str_query='SELECT DISTINCT `t2`.`name` FROM  `t2` INNER JOIN `t1` ON `t1`.`name`=`t2`.`name`';

		$respond=$this->db->query($str_query);
		
		while($value = $respond -> fetch_row())
		{
			$result[]=$value;
		}	
	}

	public function get_different_food(&$result)//получить продукты уникальные для каждого списка
	{
		$result=array();

		$str_1='SELECT t1.name FROM `t1` left join `t2` on t1.name=t2.name where t1.name is null or t2.name is null';
		$str_2='SELECT t2.name FROM `t1` right join `t2` on t1.name=t2.name where t1.name is null or t2.name is null';
		$str_query=$str_1 ." UNION " .$str_2; //формирование одного длинного запроса
		
		$respond=$this->db->query($str_query);
		
		while($value = $respond -> fetch_row())
		{
			$result[]=$value;
		}	
	}
}
?>
