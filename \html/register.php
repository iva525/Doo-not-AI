<?php
// Получаем данные из формы
$login = $_POST['login'];
$password = $_POST['password'];

// Хэшируем пароль (никогда не храни в открытом виде!)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Подключаемся к базе данных (MySQL)
$conn = new mysqli('localhost', 'root', '', 'my_site');
if ($conn->connect_error) die('Ошибка БД');

// Проверяем, не занят ли логин
$check = $conn->query("SELECT id FROM users WHERE login='$login'");
if ($check->num_rows > 0) {
  echo 'Такой логин уже существует';
} else {
  // Сохраняем нового пользователя
  $sql = "INSERT INTO users (login, password) VALUES ('$login', '$hashed_password')";
  if ($conn->query($sql) === TRUE) {
    echo 'Регистрация успешна!';
  } else {
    echo 'Ошибка: ' . $conn->error;
  }
}
$conn->close();
?>
