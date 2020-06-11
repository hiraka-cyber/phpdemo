<?php

require_once('actions.php');

try {
  $result = $pdo->query("select * from users order by id desc");
  $count = $result->rowCount();
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

$ptm = new PostTheMessage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$message = $_POST;
	$ptm->post($message);
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>Bulletin Board</title>
		<link rel="stylesheet" href="master.css">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="header">
			<h1>Bulletin Board</h1>
			<p>Now Post<span><?= $count; ?></span>件</p>
		</div><!-- header -->
		<div id="main">
			<div id ="modal" class ="hidden">
				<form action="" method="post">
					<label for="name">Name:</label>
					<input type="text" name="name" value="" id="name"><br>
					<label for="password">Delete Password</label>
					<input type="password" name="password" value=""><br>
					<textarea name="body" rows="8" cols="40" placeholder="Please Comment"></textarea><br>
					<button type="submit" name="submit" id="submit">Write</button>
				</form>
				<p id ="close_modal">Close</p>
			</div><!-- modal -->
			<div id="mask" class="hidden"></div>
			<div id ="open_modal">
				<h2>Post</h2>
			</div>
			<div id="posts">
				<?php if ($count == 0): ?>
				<p>Nothing Post...</p>
				<?php endif; ?>
				<dl>
          <?php $i = 0; ?>
					<?php foreach ($result as $row) : ?>
					<dt class = "postrow <?php if ($i > 4) { echo 'post_hidden'; } ?>"> <!-- 5件以上は非表示にする。 -->
						<span style="color: #e67e22; margin-right:10px;"><?= $count - $i; ?></span><span style="color: #e67e22;">名前：<?= h($row["name"]) ?></span>
						<span style ="font-size: 15px; color: #a0a0a0;"><?= h($row["created"])?> </span><br>
					</dt>
					<dd class = "postrow <?php if ($i > 4) { echo 'post_hidden'; } ?>"><!-- 5件以上は非表示にする。 -->
						<?=  nl2br(h($row["body"])) ?>
						<a href="delete.php?id=<?= h($row["id"]) ?>">Delete</a>
					</dd>
          <?php $i++ ?>
					<?php endforeach; ?>
				</dl>
				<div id="load_result"></div>
				<button id="load_more">All View</button>
			</div><!-- posts -->
		</div><!-- main -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="actions.js"></script>
	</body>
</html>
