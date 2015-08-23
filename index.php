<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$tasks = array();

$sql = "select * from tasks where type != 'deleted' order by seq";

foreach ($dbh->query($sql) as $row) {
	array_push($tasks, $row);
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>Todoアプリ</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1>Todoアプリ</h1>
		<p>Todo件数：<?php echo count($tasks); ?>件</p>
		<ul id="tasks">
			<?php foreach ($tasks as $task) : ?>
				<li id="task_<?php echo h($task['id']); ?>" data-id="<?php echo h($task['id']); ?>">
					<input type="checkbox" class="checkTask" <?php if ($task['type']=="done") echo "checked"; ?>>
					<span class="<?php echo h($task['type']); ?>"><?php echo h($task['title']); ?></span>
					<span class="deleteTask">[削除]</span>
					<span class="drag">[ここを引っ張って！]</span>
				</li>
			<?php endforeach ; ?>
		</ul>
		<script>
			$(function() {

				// ここでドラッグできるようにしている
				$('#tasks').sortable({
					axis: 'y',
					opacity: 0.2,
					handle: '.drag',
					update: function() {
						$.post('_ajax_sort_task.php', {
							task: $(this).sortable('serialize')
						});
					}
				});

				// ここでチェックリストのjQueryを使っている
				$(document).on('click', '.checkTask', function() {
					var id = $(this).parent().data('id');
					var title = $(this).next();
					$.post('_ajax_check_task.php', {
						id: id
					}, function(rs) {
						if (title.hasClass('done')) {
							title.removeClass('done');
						} else {
							title.addClass('done');
						}
					});
				});

				// ここで削除機能の実装をしている
				$(document).on('click', '.deleteTask', function() {
					if (confirm('本当に削除しますか？')) {
						var id = $(this).parent().data('id');
						$.post('_ajax_delete_task.php', {
							id: id
						}, function(rs) {
							$('#task_'+id).fadeOut(800);
						});
					}
				});
			});
		</script>
	</body>
</html>














