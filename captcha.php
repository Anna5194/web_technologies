<?php
// Начинаем сессию для хранения данных между запросами
session_start();

// Проверяем, загружена ли GD библиотека (для работы с изображениями)
if (!extension_loaded('gd')) {
    die('GD библиотека не загружена. Обратитесь к администратору сервера.');
}

// Устанавливаем размеры изображения капчи
$width = 200;
$height = 50;
$image = imagecreatetruecolor($width, $height);// Создаем новое изображение с заданными размерами

// Создаем цвета для изображения (RGB):
$bgColor = imagecolorallocate($image, 245, 245, 245); 
$textColor = imagecolorallocate($image, 50, 50, 50); 
$lineColor = imagecolorallocate($image, 200, 200, 200);

// Заливаем изображение фоновым цветом
imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Символы, которые будут использоваться в капче (исключены похожие символы)
$length = 6; // Длина капчи
$captcha = ''; // Переменная для хранения капчи
// Генерируем случайную строку капчи
for ($i = 0; $i < $length; $i++) {
    $captcha .= $chars[rand(0, strlen($chars) - 1)];
}

// Сохраняем капчу в сессию для последующей проверки
$_SESSION['captcha'] = $captcha;

$font = 'arial.ttf'; // Шрифт для текста капчи
// Если шрифт не найден, используем стандартный шрифт GD
if (!file_exists($font)) {
    imagestring($image, 5, 50, 15, $captcha, $textColor);
} else {// Иначе используем TrueType шрифт с небольшим наклоном
    imagettftext($image, 20, rand(-5, 5), 40, 35, $textColor, $font, $captcha);
}

// Добавляем случайные линии для усложнения распознавания
for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand() % $height, $width, rand() % $height, $lineColor);
}

// Устанавливаем заголовки для браузера
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

imagepng($image);// Выводим изображение в PNG формате
imagedestroy($image);// Освобождаем память, занятую изображением
exit; 
?>