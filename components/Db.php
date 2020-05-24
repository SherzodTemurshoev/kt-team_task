<?php
	class Db
	{
	//	private $conn;
		public static $conn;

		/**
		* Подключение к базе данных
		*/
		public static function getConnection()
		{
			include "config/connect_db.php";
			self::$conn = mysqli_connect($host, $user_name, $user_pass, $db);
			if (self::$conn->connect_error) die(self::$conn->connect_error);
		}

		/**
		* Отправка запроса к базе данных
		* @param string $query (запрос)
		* @return object (MySQL Object)
		*/
		public static function dbQuery($query) {
			$result = self::$conn->query($query);
			if (!$result) die(self::$conn->error);
			return $result;
		}

		/**
		* Очистка данных (строку)
		* @param string $var
		* @return string $var
		*/
		public static function clearing($var) {
			$var = trim($var);
			$var = strip_tags($var);
			$var = stripcslashes($var);
			$var = htmlspecialchars($var, ENT_QUOTES);
			return $var;
			//return htmlspecialchars(stripcslashes(strip_tags(trim($var))), ENT_QUOTES);
		}

		/**
		* Функция для поддержки методов PATCH, PUT, DELETE
		* @param string $method
		* @return array $data
		*/
		public static function getFormData($method) {
		    $data = array();
		//    $temp = file_get_contents('php://input');
		    $exploded = explode('&', $_SERVER['REQUEST_URI']);
		    $pos = strpos($exploded[0], '?');
		 	$exploded[0] = substr($exploded[0], $pos+1);
		    foreach($exploded as $pair) {
		        $item = explode('=', $pair);
		        if (count($item) == 2) {
		            $data[urldecode($item[0])] = urldecode($item[1]);
		        }
		    }

		    return json_encode($data);
		}

	}