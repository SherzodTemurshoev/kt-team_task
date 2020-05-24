<?php
	require_once ROOT . '/models/Tasks.php';
	session_start();
	Db::getConnection();

	class AdminController
	{
		/**
		* Показывает список задач и испольнителей (с сортировкой, с пагинацией, ...)
		*/
		public function actionIndex() {
			$tasks = Tasks::getAllTasks();
			// Декодируеть данных json и преобразовывает в массив
			$tasks = json_decode($tasks, true);
			require_once ROOT.'/views/admin/index.php';
			
			return true;
		}

		/**
		* Проверка логина и пароля администратора
		*/
		public function actionCheck() {
			if (isset($_POST['btn_admin'])) {
				// ячейка для добавления ошибок
				$_SESSION["error_messages"] = '';
				// очистим введенные данные
				$name = Db::clearing($_POST['name']);
				$pass = Db::clearing($_POST['pass_admin']);
				if (!empty($name) && !empty($pass)) {
					// логин и пароль админа :) 
					if ($name === "admin" && $pass === "123") {
						header("Location: admin", true, 301);

						exit();
					} else {
						$_SESSION["error_messages"] .= "<p class='message_error'>Неправильный логин и/или пароль администратора</p>";
						header("Location: task", true, 301);

						exit();
					}
				} else {
					// если отсутствует логин и пароль администратора, добавляем в сессию сообщение об ошибке
					$_SESSION["error_messages"] .= "<p class='message_error'>Отсутствует логин и/или пароль администратора</p>";
					header("Location: task", true, 301);

					exit();
				}
			}

			return true;
		}

		/**
		* Изменение отдельную задачу с идентификатором
		* @param integer $id
		*/
		public function actionEdit($id) {
			// запрос на выборку по идентификатору
			$query_data = Db::dbQuery("SELECT * FROM `tasks` WHERE `id` = '$id'");
			$data_for_update = $query_data->fetch_array(MYSQLI_ASSOC);
			require_once ROOT . "/views/admin/edit.php";

			return true;
		}

		/**
		* Обновление отдельную задачу с идентификатором
		* @param integer $id
		*/
		public function actionUpdate($id) {
			$patch_data = Db::getFormData($_SERVER['REQUEST_METHOD']);
			$patch_data = json_decode($patch_data, true);
			// очистка данных
			$name = Db::clearing($patch_data['name']);
			$email = Db::clearing($patch_data['email']);
			$task = Db::clearing($patch_data['task']);
			$status = Db::clearing($patch_data['status']);
			// запрос на обновление данных
			$query = "UPDATE `tasks` SET `name`='$name',`email`='$email',`task`='$task',`status`='$status' WHERE `id` = '$id'";
			$result = Db::dbQuery($query);
			header("Location: /admin");

			return true;
		}

		/**
		* Удаление отдельную задачу с идентификатором
		* @param integer $id
		*/
		public function actionDelete($id) {
			// запрос на удаление
			$query = "DELETE FROM `tasks` WHERE `id` = '$id'";
			$result = Db::dbQuery($query);
			header("Location: /admin");

			return true;
		}

	}

