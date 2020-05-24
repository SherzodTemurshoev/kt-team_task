<?php
	session_start();
	require_once ROOT . '/models/Tasks.php';

	class MainController
	{
		/**
		* Показывает список задач и испольнителей (с сортировки, без пагинации, ...)
		*/
		public function actionIndex() {
			$tasks = Tasks::getTasksList();
			// Декодируеть данных json и преобразовывает в массив
			$tasks = json_decode($tasks, true);
			require_once ROOT.'/views/main/index.php';

			return true;
		}

		/**
		* Валидация данных   
		* Добавления новой задачи в бд  
		*/
		public function actionCheck() {
			// ячейки для добавления ошибок и успешных сообщений
			$_SESSION['error_messages'] = '';
			$_SESSION['success_messages'] = '';

			// проверяем имя пользователя на существования
			if (isset($_POST['name'])) {
				// очистим введенные данные
				$name = Db::clearing($_POST['name']);
				if (empty($name)) {
					// если имя пользоваетля пустой, добавляем в сессию сообщение об ошибке
					$_SESSION['error_messages'] .= '<p class="message_error">Укажите Ваше имя</p>';
					header("Location: task", true, 301);

		            exit();
				}
			} else {
				// если отсутствует имя пользователя, добавляем в сессию сообщение об ошибке
				$_SESSION['error_messages'] .= '<p class="message_error">Отсутствует поле с именем</p>';
				header("Location: task", true, 301);

		        exit();
			}

			// проверяем почтовой адрес на существования
			if (isset($_POST['email'])) {
				$email = Db::clearing($_POST['email']);
				if (empty($email)) {
					$_SESSION['error_messages'] .= '<p class="message_error">Укажите Ваш email</p>';
					header("Location: task", true, 301);

		        	exit();
				} else {
					// Проверяем формат полученного почтового адреса с помощью регулярного выражения
					$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
					if (!preg_match($reg_email, $email)) {
						// если не соответствует добавляем в сессию ошибку
						$_SESSION['error_messages'] .= '<p class="message_error">Вы ввели неправельный email</p>';
						header("Location: task", true, 301);

		        		exit();
					}
				}
			} else {
				$_SESSION['error_messages'] .= '<p class="message_error">Отсутствует поле для ввода Email</p>';
				header("Location: task", true, 301);

		        exit();
			}

			// проверяем текст задачи на существования
			if (isset($_POST['task'])) {
				$task = Db::clearing($_POST['task']);
				if (empty($task)) {
					$_SESSION['error_messages'] .= '<p class="message_error">Укажите Ваш пароль</p>';
					header("Location: task", true, 301);

			        exit();
				} else if (strlen($task) < 10) {
					$_SESSION['error_messages'] .= '<p class="message_error">Минимальная длина текст задачи 10 символов</p>';
					header("Location: task", true, 301);

		        	exit();
				}
			} else {
				$_SESSION['error_messages'] .= '<p class="message_error">Отсутствует поле для ввода пароля</p>';
				header("Location: task", true, 301);

		        exit();
			}

			// добавляем данные в базу данных
			Db::getConnection();
			$query = "INSERT INTO tasks(`name`, `email`, `task`, `status`) VALUES ('$name', '$email', '$task', '')";
			$show = Db::dbQuery($query);
			if (!$show) {
				// добавляем в сессию сообщение об ошибке
				$_SESSION["error_messages"] .= "<p class='message_error'>Ошибка запроса на добавления пользователя в БД</p>";
				header("Location: reg", true, 301);

		        exit();
			} else {
				// добавляем сообщение об успешном добавление задачи
				$_SESSION['success_messages'] .= '<p class="success_message">Задача успешно добавлено!</p>';
				header("Location: task", true, 301);

				exit();
			}

			return true;
		}
	}
	
