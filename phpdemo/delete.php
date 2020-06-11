<?php

require_once('actions.php');

if (is_numeric($_GET["id"])) {
  $user_id = $_GET["id"];
} else {
  echo 'Missing Password...';
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(password_verify($_POST['password'], $row['password'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    echo 'Delete Success!';
    exit;
  }else{
    echo 'Missing paswword...';
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>delete</title>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
    <dl>
      <dt>
        <span style="color: #e67e22;">名前：<?= h($row["name"]) ?></span>
        <span style ="font-size: 15px; color: #a0a0a0;"><?= h($row["created"])?></span><br>
      </dt>
      <dd>
        <?=  nl2br(h($row["body"])) ?>
      </dd>
    </dl>
    <p>Delete Post?Please Password</p>
    <form action="" method="post">
      <label for="password">Please Password:</label>
      <input type="password" name="password">
      <input type="submit" value ="submit" style ="background-color:white">
    </form>
  </body>
</html>
