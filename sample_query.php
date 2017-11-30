<?php

$id = 1;

$conn = new \PDO("sqlite:test.db");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE TABLE IF NOT EXISTS tbUsers ";
$sql .= " (id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT, name TEXT, email TEXT, pwd TEXT, type TEXT, status TINYINT(1) );";
$conn->query($sql);

$login = "danilo";
$name = "danilo batista de queiroz";
$email = "danilo.queiroz@gmail.com";
$pwd = "123";
$type = "admin";
$status = "1";
$sql = "INSERT INTO `tbUsers` (login, name, email, pwd, type, status) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $login);
$stmt->bindParam(2, $name);
$stmt->bindParam(3, $email);
$stmt->bindParam(4, $pwd);
$stmt->bindParam(5, $type);
$stmt->bindParam(6, $status);
$stmt->execute();

$sql = "SELECT * FROM `tbUsers` WHERE id=" . $id;
$consulta = $conn->query($sql);
while ($row = $consulta->fetch(\PDO::FETCH_ASSOC)) {
    echo $row['name'] . "\n";
}

$sql = "SELECT * FROM `tbUsers` WHERE id=:id";
$stmt = $conn->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
$stmt->execute(array(':id' => 1));
$res = $stmt->fetchAll();
echo $res[0]["name"] . "\n";
foreach($res as $r) {
	echo $r["name"] . "\n";
}