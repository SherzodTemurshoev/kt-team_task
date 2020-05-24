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
    // проверяем, если пользователь не авторизован, то выводим форму авторизации
    if(!isset($_SESSION["name"]) && !isset($_SESSION["password"])){
?>
 
 
    <div id="form_auth">
        <form action="auth_in" method="POST" class="form">
            <h1 title="Форма авторизации">Форма авторизации</h1>
            <div class="group">
                <label for="name">Имя пользователя</label>
                <input type="text" name="name" id="name" required="required">
            </div>
            <div class="group">
                <label for="pass">Пароль пользователя</label>
                <input type="password" name="pass" id="pass" required="required">
                <span id="pass_message_error" class="error"></span>
            </div>
            <div class="group">
                <input type="submit" name="btn_auth" value="Войти" id="btn">
            </div>
        </form>
    </div>
 
<?php
    }
    require_once ROOT . "/views/layouts/header.php";
?>