<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = "select max(seq)+1 from tasks where type != 'deleted'";
$seq = $dbh->query($sql)->fetchColumn();

$sql = "insert into tasks
		(seq, title,created, modified)
		values
		(:seq, :title, now(), now())";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(
	":seq" => $seq,
	":title" => $_POST['title']
));

echo $dbh->lastInsertId();
