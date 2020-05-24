<?php 
	class Router
	{
		private $routes;

		/**
		* Конструктор
		* Присваивает переменной $routes массив значений (маршруты)
		*/
		public function __construct() {
			$routesPath = ROOT . '/config/routes.php';
			$this->routes = include($routesPath);
		}

		/**
		* Получаем uri страницы (получаем строку запроса)
		* @return string
		*/
		private function getURI() {
			if (!empty($_SERVER['REQUEST_URI'])) {
				return trim($_SERVER['REQUEST_URI'], '/');
			}
		}

		/**
		* Принимает управление от фронт-контроллера
		* (Проверка uri запроса (маршруты), определение контроллера и екшена, создание объекта и ее вызов)
		*/
		public function run() {
			// Получить строку запроса
			$uri = $this->getURI();
			if (empty($uri)) {
				$uri = "/task";
			}
			//print($uri); die();
			// Проверить наличие такого запроса в routes.php
			foreach ($this->routes as $uriPattern => $path) {
				if (preg_match("~$uriPattern~", $uri)) {
					// Получаем внутренный путь 
					$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
					// Если есть совподение, определить какой controller и action обрабатывают запроса
					$segments = explode('/', $internalRoute);
					foreach ($segments as $item) {
						if (empty($item)) {
							array_shift($segments);
						}
					}
					$controllerName = array_shift($segments) . 'Controller';
					$controllerName = ucfirst($controllerName);
					$actionName = 'action' . ucfirst(array_shift($segments));
					$parameters = $segments;

					// Подключить файл класса-контроллера
					$controllerFile = 'controllers/' . $controllerName . '.php';
					if (file_exists($controllerFile)) {
						include_once($controllerFile);
					}
					// Создаем объект и вызываем метод (т.е. action)
					$controllerObject = new $controllerName();
				//	$result = $controllerObject->$actionName($parameters);
					$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
					
					if ($result != null) {
						break;
					}
				}

			}
		}
	}						