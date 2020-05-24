<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Приложение-задачник</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="js/validate.js"></script> 
		<script src="../js/validate.js"></script>
	</head>
	<body>
		<div id="header">
			<div id="reg_auth_block">
				<?php
                    if(!isset($_SESSION['name']) && !isset($_SESSION['password'])){
                    ?>
                    <div id="auth_block">
                        <a href="task"><img src="images/house.png">Главная страница</a>
                        <a href="reg"><img src="images/reg.png">Регистрация</a>
                        <a href="auth"><img src="images/auth.png">Авторизация</a>
                    </div>
                    <?php
                        } else {
                    ?> 
                        <div id="logout_block">
                        	<a href="task"><img src="images/house.png">Главная страница</a>
                            <a href="logout"><img src="images/logout.png">Выход</a>
                        </div>
                    <?php
                        }
                    ?>
			</div>
		</div>