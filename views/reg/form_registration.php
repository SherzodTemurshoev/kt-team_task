<?php
	require_once ROOT . "/views/layouts/header.php";
?>

<div class="block_for_messages">
    <?php
        // если в сессии существуют сообщения об ошибках, то выводим их
        if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
            echo $_SESSION["error_messages"];
            
            //Уничтожаем чтобы не появилось заново при обновлении страницы
            unset($_SESSION["error_messages"]);
        }

        // если в сессии существуют радостные сообщения, то выводим их
        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
            echo $_SESSION["success_messages"];

            //Уничтожаем чтобы не появилось заново при обновлении страницы
            unset($_SESSION["success_messages"]);
        }
    ?>
</div>

<?php
    // проверяем, если пользователь не авторизован, то выводим форму регистрации
    if(!isset($_SESSION["name"]) && !isset($_SESSION["password"])) {
?>
		<form action="reg_in" method="POST" class="form">
			<h1 title="Форма регистрации">Форма регистрации</h1>
            <div class="group">
                <label for="first_name">Имя пользователя</label>
                <input type="text" name="name" id="first_name" required="required">
            </div>
            <div class="group">
                <label for="email">Адрес электронной почты</label>
                <input type="email" name="email" id="email" required="required">
                <span id="email_message_error" class="error"></span>
            </div>
            <div class="group">
                <label for="pass">Пароль пользователя</label>
                <input type="password" name="pass" id="pass" required="required">
                <span id="pass_message_error" class="error"></span>
            </div>
            <div class="group">
                <input type="submit" name="done" value="Зарегистрироватся" id="btn">
            </div>
		</form>
<?php
    }
    require_once ROOT . "/views/layouts/footer.php";
?>

