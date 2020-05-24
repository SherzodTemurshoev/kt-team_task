<?php
	class AuthController
	{
		/**
		* Показывает форму авторизации
		*/
		public function actionIndex() {
			require_once ROOT . '/views/auth/form_auth.php';
		
			return true;
		}

		/**
		* Валидация данных   
		* Авторизация пользователя
		*/
		public function actionCheck() {
			session_start();
			Db::getConnection();
			// ячейки для добавления ошибок и успешных сообщений
			$_SESSION["error_messages"] = '';
			$_SESSION["success_messages"] = '';

			// проверям была ли нажата кнопка отправки формы
			if (isset($_POST['btn_auth'])) {
				// проверяем почтовой адрес на существование
				if (isset($_POST['name'])) {
					// очистим введенные данные
					$name = Db::clearing($_POST['name']);
					// проверяем на пустоту
					if (empty($name)) {
						//добавляем в сессию сообщение об ошибке
						$_SESSION['error_messages'] .= "<p class='message_error'>Укажите Ваше имя</p>";
						header("Location: auth", true, 301);

		               	exit();
					}
				} else {
					// если отсутствует имя пользователя, добавляем в сессию сообщение об ошибке
					$_SESSION["error_messages"] .= "<p class='message_error'>Отсутствует поле с именем пользователя</p>";
		            header("Location: auth", true, 301);

		            exit();
				}

				// проверяем пароль пользователя на существование
				if (isset($_POST['pass'])) {
					// очистим введенные данные
					$pass = Db::clearing($_POST['pass']);
					if (!empty($pass)) {
						// шифруем пароль
						$pass = hash('ripemd160', $pass);
					} else {
						// если пароль пользователя пустой, сохраняем в сессию сообщение об ошибке.
						$_SESSION['error_messages'] .= "<p class='message_error'>Укажите Ваш пароль</p>";
						header("Location: auth", true, 301);

		               	exit();
					}
				} else {
					$_SESSION["error_messages"] .= "<p class='message_error'>Отсутствует поле для ввода пароля</p>";
		            header("Location: auth", true, 301);

		            exit();
				}

				// запрос в базу данных на выборке пользователя.
				$query_insert = Db::dbQuery("SELECT * FROM `users` WHERE name = '".$name."' AND password = '".$pass."'");
				if (!$query_insert) {
					// добавляем в сессию сообщение об ошибке
					$_SESSION["error_messages"] .= "<p class='message_error'>Ошибка запроса на добавления пользователя в БД</p>";
					header("Location: auth", true, 301);

		            exit();
				} else {
					if($query_insert->num_rows == 1){
		                // если введенные данные совпадают с данными из базы, то сохраняем логин и пароль в массив сессий
		                $_SESSION['name'] = $name;
		                $_SESSION['password'] = $pass;

		                header("Location: auth", true, 301);
		            } else {
		                // Сохраняем в сессию сообщение об ошибке. 
		                $_SESSION["error_messages"] .= "<p class='message_error'>Неправильный логин и/или пароль</p>";
		                header("Location: auth", true, 301);

		                exit();
		            }
					$_SESSION["success_messages"] = "<p class='success_message'>Авторизация прошла успешно!!!";
					header("Location: task", true, 301);
						
		            exit();
				}

			}else{
		        exit("<p><b>Ошибка!</b> Форма не отправлена</p>");
		    }

		    return true;
		}

		/**
		* Выход авторизованного пользователя
		*/
		public function actionLogout() {
			// запускаем сессию
		    session_start();

		    // удаляем сессии с пользовательскими данными (логин и пароль)
		    unset($_SESSION["name"]);
		    unset($_SESSION["password"]);

		    // возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход
		    header("Location: ".$_SERVER["HTTP_REFERER"], true, 301);
		}
		
	}
