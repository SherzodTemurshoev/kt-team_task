<?php
	require_once ROOT . "/views/layouts/header.php";
?>
<div class="block_for_messages">
		<?php
			if (isset($_SESSION['error_messages']) && $_SESSION['error_messages'] != '') {
				echo $_SESSION['error_messages'];
				unset($_SESSION['error_messages']);
			}

			if (isset($_SESSION['success_messages']) && $_SESSION['success_messages'] != '') {
				echo $_SESSION['success_messages'];
				unset($_SESSION['success_messages']);
			}
		?>
</div>
<div id="content">
	<div class="admin">
		<a href="#admin_form" class="admin_popup">Панель администратора</a>
		<div class="hidden_form">
			<form method="POST" action="adminCheck" id="admin_form" class="form">
				<div>
					<span class="close">&times;</span>
				</div>
				<input type="text" name="name" placeholder="Логин">
				<input type="password" name="pass_admin" placeholder="Пароль">
				<button id="btn_admin" name="btn_admin">Войти</button>
			</form>
		</div>
	</div>
	<form method="POST" action="check">
		<div class="group">
			<input type="text" name="name" placeholder="Имя пользователя" required="required">
		</div>
		<div class="group">
			<input type="email" name="email" placeholder="email" required="required">
			<span id="email_message_error" class="error"></span>
		</div>
		<div class="group">
			<input type="text" name="task" placeholder="Задача" required="required">
			<span id="task_message_error" class="error"></span>
		</div>
		<div class="group">
			<input type="submit" name="done" value="Добавить задачу" id="btn">
		</div>
	</form>
	<div id="sort_div">
		Сортировать: <a id="select_sort"><?php if(isset($tasks['sort_name'])) {echo($tasks['sort_name']);}?></a>
		<ul id="sorting_list">
			<li><a href="task?sort=name">Сортировка по имени</a></li>
			<li><a href="task?sort=email">Сортировка по email</a></li>
			<li><a href="task?sort=task">Сортировка по задачам</a></li>
		</ul>
	</div>
	<table class="table">
		<tr id="th_input">
			<th>Имя пользователя</th>
			<th>Email</th>
			<th>Задачи</th>
			<th>Статус</th>
		</tr>
		<?php
			for ($i = 0; $i < 3; $i++) {
		?>
				<tr>
					<td><?= $tasks[$i]['name'] ?? '' ?></td>
					<td><?= $tasks[$i]['email'] ?? '' ?></td>
					<td><?= $tasks[$i]['task'] ?? '' ?></td>
					<td><?= $tasks[$i]['status'] ?? '' ?></td>
				</tr>
		<?php 
			}	
		?>
	</table>
	<?php
		echo "<div class='pagination'><a href='task?page=" . $tasks['first'] . "'>First</a>";
		echo "<a href='task?page=" . $tasks['prev_page'] . "'>Prev</a>";
		echo "<a href='task?page=" . $tasks['page'] . "'>" . $tasks['page'] . "</a>";
		echo "<a href='task?page=" . $tasks['next_page'] . "'>Next</a>";	
		echo "<a href='task?page=" . $tasks['last'] . "'>Last</a></div>";
	?>
</div>
<?php
	require_once ROOT . "/views/layouts/footer.php";
?>
