<?php
header('Content-type: text/html; charset=utf-8');
require_once('const_data.php'); // даннные для подключения к БД
require_once('fun.php'); //содержит функции для работы с БД
if (isset($_POST['info']))
{
	$info=$_POST['info'];
	
	$db = new DB;
	$db->set_connect(HostName,UserName,Password,DBName);
	if($db->connect()===true)//коннектимся к БД
	{	
		switch ($info) //в зависимости от результата выбираем необходимую функцию
		{
			case 'same':
				$result='';

				$db->get_same_food($result);
				echo json_encode($result);			
			break;
			
			case 'different':
				$result='';

				$db->get_different_food($result);
				echo json_encode($result);			
			break;
		}	
	}
	else				
	{
		echo "Ошибка подключения к БД";
	}
}
?>