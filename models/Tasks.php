<?php
	class Tasks
	{
		/**
		* Возвращает отдельную задачу с указанным идентификатором
		* @param integer $id
		*/
		public static function getTasksItemById($id) {

		}

		/**
		* Возвращает полный список задач (без сортировки, ...)
		* @return json_encode
		*/
		public static function getAllTasks() {
			$data = [];
			// Подключение и запрос на выборку из базы данных
			$conn = Db::getConnection();
			$result_query = Db::dbQuery("SELECT * FROM tasks");

			$i = 0;
			while ($row = mysqli_fetch_array($result_query)) {
				$data[$i]['id'] 	 = $row[0];
				$data[$i]['name'] 	 = $row[1];
				$data[$i]['email']   = $row[2];
				$data[$i]['task'] 	 = $row[3];
				$data[$i]['status']  = $row[4];
				$i++;
			}

			return json_encode($data);
		}

		/**
		* Извлекает данных из бд
		* Сортирует данных
		* Реализовывает пагинацию
		* @return json_encode 
		*/
		public static function getTasksList() {
			$resultArray = array();
			$conn = Db::getConnection();
			// Получение номер текущей страницы
			if (isset($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
			/** Данные для погинации	**/
			// Число выводимых данных на странице 
			$limit = 3;
			// Кол-во данных в бд
			$result_query = Db::dbQuery("SELECT * FROM tasks");
			$rows = mysqli_num_rows($result_query);
			// Нахождение кол-во страниц
			$number_of_pages = ceil($rows / $limit);
			// Начальная страница, след. страница, пред. страница, первая и последняя страница
			$start_page = ($page - 1) * $limit;
			$next_page = ($page < $number_of_pages) ? ($page + 1) : $page;
			$prev_page = ($page > 1) ? ($page - 1) : $page;
			$first = 1;
			$last = $number_of_pages;
			// Сортировка данных по имени, email и задачам
			$sorting = $_GET['sort'] ?? '';			
			switch ($sorting) {
				case 'name':
					$sorting = 'name ASC';
					$sort_name = 'Сортировка по имени';
					break;
				case 'email':
					$sorting = 'email ASC';
					$sort_name = 'Сортировка по email';
					break;
				case 'task':
					$sorting = 'task ASC';
					$sort_name = 'Сортировка по задачам';
					break;
				default:
					$sorting = 'id ASC';
					$sort_name = 'Без сортировки';
					break;
			}
			$resultArray['sort_name'] = $sort_name;
			$resultArray['first'] = $first;
			$resultArray['page'] = $page;
			$resultArray['prev_page'] = $prev_page;
			$resultArray['next_page'] = $next_page;
			$resultArray['last'] = $last;
			$resultArray['number_of_pages'] = $number_of_pages;
			$resultArray['result_query'] = $result_query;

			$query = "SELECT * FROM tasks ORDER BY $sorting LIMIT $start_page, $limit";
			$result = Db::dbQuery($query);

			$i = 0;
			while ($row = mysqli_fetch_array($result)) {
				$resultArray[$i]['id'] 		= $row['id'];
				$resultArray[$i]['name'] 	= $row['name'];
				$resultArray[$i]['email'] 	= $row['email'];
				$resultArray[$i]['task'] 	= $row['task'];
				$resultArray[$i]['status'] 	= $row['status'];
				$i++;
			}
			
			return json_encode($resultArray);
		}

	}
