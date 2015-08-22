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
		<ul>
			<?php foreach ($tasks as $task) : ?>
				<li id="task_<?php echo h($task['id']); ?>" data-id="<?php echo h($task['id']); ?>">
					<?php echo h($task['title']); ?>
					<span class="deleteTask">[削除]</span>
				</li>
			<?php endforeach ; ?>
		</ul>
		<script>
			$(function() {
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














