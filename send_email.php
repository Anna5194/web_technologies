<?php
session_start();

// Проверяем капчу:
// 1. Пусто ли поле captcha в POST-запросе
// 2. Существует ли captcha в сессии
// 3. Совпадает ли введенная капча с сохраненной в сессии
if (empty($_POST['captcha']) || empty($_SESSION['captcha']) || 
    $_POST['captcha'] !== $_SESSION['captcha']) {
    die('Неверный код капчи!');// Если проверка не пройдена - останавливаем выполнение с сообщением
}

// Обрабатываем и очищаем введенные данные:
$name = htmlspecialchars($_POST['name']); // Экранируем HTML-теги в имени
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Очищаем email
$nameshop = htmlspecialchars($_POST['nameshop']); // Экранируем HTML-теги в названии магазина
$adres = htmlspecialchars($_POST['adres']); // Экранируем HTML-теги в адресе
$comment = htmlspecialchars($_POST['comment']); // Экранируем HTML-теги в комментарии

// Подключаем классы PHPMailer для работы с почтой
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключаем необходимые файлы библиотеки PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer\src/PHPMailer.php';
require 'phpmailer\src/SMTP.php';

// Создаем новый объект PHPMailer с включенными исключениями
$mail = new PHPMailer(true);

try {
    // Настраиваем SMTP:
    $mail->isSMTP(); // Указываем, что используем SMTP
    $mail->Host = 'smtp.mail.ru'; // SMTP-сервер (mail.ru)
    $mail->SMTPAuth = true; // Включаем аутентификацию
    $mail->Username = 'marchyk96step@mail.ru'; // Логин от почты
    $mail->Password = '7d0pwUXF2ecVXsXYA0bC'; // Пароль (в реальном коде так хранить нельзя!)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Шифрование SSL
    $mail->Port = 465; // Порт для SSL              

    // Настраиваем кодировку:
    $mail->CharSet = 'UTF-8'; // Устанавливаем кодировку UTF-8
    $mail->Encoding = 'base64'; // Кодирование контента

    // Устанавливаем отправителя и получателя:
    $mail->setFrom('marchyk96step@mail.ru', 'Блог вкусного вайба');
    $mail->addAddress('marchyk96step@mail.ru'); // Добавляем получателя

    // Обрабатываем вложения, если они есть:
    if (!empty($_FILES['attachments'])) {
        // Перебираем все загруженные файлы
        for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
            // Если файл загружен без ошибок
            if ($_FILES['attachments']['error'][$i] == UPLOAD_ERR_OK) {
                // Добавляем вложение к письму
                $mail->addAttachment(
                    $_FILES['attachments']['tmp_name'][$i], // Временный путь к файлу
                    $_FILES['attachments']['name'][$i] // Оригинальное имя файла
                );
            }
        }
    }

    // Формируем письмо:
    $mail->isHTML(true); // Указываем, что письмо в HTML-формате
    $mail->Subject = "Новое предложение заведения от $name"; // Тема письма
    $mail->Body = "
        <h1>Новое предложение заведения</h1>
        <p><strong>Имя:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Название заведения:</strong> $nameshop</p>
        <p><strong>Адрес:</strong> $adres</p>
        <p><strong>Комментарий:</strong> $comment</p>
    ";

    $mail->send(); // Отправляем письмо
    echo 'Письмо успешно отправлено!'; // Сообщение об успешной отправке
} catch (Exception $e) {
    echo "Ошибка отправки: {$mail->ErrorInfo}"; // Выводим ошибку, если что-то пошло не так
}