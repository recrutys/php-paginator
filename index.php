<?php

require_once 'paginator.php';

$user = 'root';
$pass = 'root';
$opt = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

$db = new PDO('mysql:host=localhost;dbname=pagenav', $user, $pass, $opt);

$items = new paginator(
	$db,
	$_GET['page'],
	9,
	'SELECT * FROM `posts`',
	'/'
);
?>

<?= $items->getPageNavHtml() ?>

<?php foreach ($items->result() as $key => $item): ?>
	Post ID: <?= $item['item_id'] ?> <br>
<?php endforeach; ?>