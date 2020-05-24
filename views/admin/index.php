<!DOCTYPE html>
<html>
<head>
	<title>Панель администратора</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
	<div id="back_btn_div">
		<a href="task" id="back_btn">Назад</a>
	</div>
	<table border="1">
		<tr>
			<th>имя</th>
			<th>email</th>
			<th>Задача</th>
			<th>Статус</th>
			<th>Редактировать</th>
			<th>Удалить</th>
		</tr>
		
		<?php for($i = 0; $i < count($tasks); $i++) : ?>
			<tr>
				<td><?= $tasks[$i]['name']?></td>
				<td><?= $tasks[$i]['email'] ?></td>
				<td><?= $tasks[$i]['task'] ?></td>
				<td><?= $tasks[$i]['status'] ?></td>
				<td><a href="edit/<?=$tasks[$i]['id']?>">Редактировать</a></td>
				<td><a href="delete/<?=$tasks[$i]['id']?>">Удалить</a></td>
			</tr>
		<?php endfor; ?>
		
	</table>
</body>
</html>

