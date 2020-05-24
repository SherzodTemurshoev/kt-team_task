<!DOCTYPE html>
<html>
<head>
	<title>Панель администратора</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="../js/validate.js"></script>
</head>
<body>
	<div id="content">
		<form method="PATCH" action="/update/<?= $data_for_update['id'] ?>">
			<div class="group">
				<input type="text" name="name" value="<?= $data_for_update['name'] ?>" placeholder="Имя пользователя">
			</div>
			<div class="group">
				<input type="email" name="email" value="<?= $data_for_update['email'] ?>" placeholder="email">
				<span id="email_message_error" class="error"></span>
			</div>
			<div class="group">
				<input type="text" name="task" value="<?= $data_for_update['task'] ?>" placeholder="Задача">
				<span id="task_message_error" class="error"></span>
			</div>
			<div class="group">
				<select name="status">
					<option value="0" selected="selected"></option>
					<option value="1">выполнено</option>
					<option value="2">не выполнено</option>
				</select>
			</div>
			<div class="group"><input type="submit" name="
				" value="Сохранить" id="btn"></div>
		</form>
	</div>
</body>
