<?php
	class RegController
	{
		/**
		* Показывает форму регистрации
		*/
		public function actionIndex() {
			require_once ROOT . '/views/reg/form_registration.php';

			return true;
		}

		/**
		* Валидация данных
		* Добавления нового пользователя
		*/
		public function actionCheck() {
			session_start();
			Db::getConnection();
			// ячейки для добавления ошибок и успешных сообщений
			$_SESSION["error_messages"] = '';
			$_SESSION["success_messages"] = '';

			// проверям была ли нажата кнопка отправки формы
			if (isset($_POST['done'])) {
				// проверяем имя пользователя на существования
				if (isset($_POST['name'])) {
					// очистим введенные данные
					$name = Db::clearing($_POST['name']);
					if (empty($name)) {
						// если имя пользоваетля пустой, добавляем в сессию сообщение об ошибке
						$_SESSION['error_messages'] .= "<p class='message_error'>Укажите Ваше имя</p>";
						// возвращаем пользователя на страницу регистрации
						header("Location: reg", true, 301);

						// прекращаем выполнение текущего скрипта
		                exit();
					}
					// проверяем нет ли уже такого имя пользователя в базе данных
					$query = Db::dbQuery("SELECT `name` FROM `users` WHERE `name`='".$name."'");
					if ($query->num_rows == 1) {
						// если пользователь зарегистрирован, добавляем в сессию ошибку
						$_SESSION["error_messages"] .= "<p class='message_error'>Пользователь с таким именим уже зарегистрирован</p>";
						header("Location: reg", true, 301);

		                exit();
					}
					// закрываем запрос
					$query->close();	

				} else {
					// если отсутствует имя пользователя, добавляем в сессию сообщение об ошибке
					$_SESSION["error_messages"] .= "<p class='message_error'>Отсутствует поле с именем пользователя</p>";
					header("Location: reg", true, 301);

		            exit();
				}
				
				// проверяем почтовой адрес на существования
				if (isset($_POST['email'])) {
					$email = Db::clearing($_POST['email']);
					if (empty($email)) {
						$_SESSION['error_messages'] .= '<li>Укажите Ваш email</li>';
					} else {
						// Проверяем формат полученного почтового адреса с помощью регулярного выражения
						$reg_email = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i";
						if (!preg_match($reg_email, $email)) {
							// если не соответствует добавляем в сессию ошибку
							$_SESSION['error_messages'] .= '<li>Вы ввели неправельный email</li>';
							header("Location: reg", true, 301);

			                exit();
						}
					}
				} else {
					$_SESSION['error_messages'] .= '<li>Отсутствует поле для ввода Email</li>';
					header("Location: reg", true, 301);

		            exit();
				}

				// проверяем пароль пользователя на существования
				if (isset($_POST['pass'])) {
					$pass = Db::clearing($_POST['pass']);
					if (!empty($pass)) {
						// шифруем пароль
						$pass = hash('ripemd160', $pass);
					} else {
						$_SESSION['error_messages'] .= "<p class='message_error'>Укажите Ваш пароль</p>";
						header("Location: reg", true, 301);

			            exit();
					}
				} else {
					$_SESSION["error_messages"] .= "<p class='message_error'>Отсутствует поле для ввода пароля</p>";
		            header("Location: reg", true, 301);

		            exit();
				}

				// запрос на добавления пользователя в базу данных
				$query_insert = Db::dbQuery("INSERT INTO `users`(`name`, `email`, `password`) VALUES ('".$name."', '".$email."', '".$pass."')");
				if (!$query_insert) {
					// добавляем в сессию сообщение об ошибке
					$_SESSION["error_messages"] .= "<p class='message_error'>Ошибка запроса на добавления пользователя в БД</p>";
					header("Location: reg", true, 301);

		            exit();
				} else {
					$_SESSION["success_messages"] = "<p class='success_message'>Регистрация прошла успешно!!! <br/>Теперь Вы можете авторизоваться используя Ваш логин и пароль.</p>";
					header("Location: reg", true, 301);

		            exit();
				}
				// закрывем запрос и подключение к базу данных
				$query_insert->close();
				$conn->close();

			}else{
		        exit("<b>Ошибка!</b> Форма не отправлена");
		    }

		    return true;
		}
	}
