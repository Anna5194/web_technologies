<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Блог вкусного вайба</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="header">
    <div class="container" id="header">
      <a href="index.html" class="logo">Блог вкусного вайба</a>
      <div class="search">
        <img src="/image/zoom_4556933.png" alt="" id="search-icon">
        <input type="text" id="search-input" placeholder="Пока не работает..." />
      </div>
      <div class="menu" id="menu">Меню</div>
      <ul id="menu-list">
        <li><a href="reviews.html">Отзывы о заведениях</a></li>
        <li><a href="advise.php">Посоветовать место</a></li>
        <li><a href="doublecheck.html">Требую переобзора!</a></li>
        <li><a href="php.php">тестовая для заданий по ВБ</a></li>
      </ul>
    </div>
  </header>

  <main class="main">
    <div class="container">
      <h1>Экспериментальная страница для решения задач на php</h1>
      
      <a href="phptwo.php">Задачи № 5 и 6</a><br/>
      <a href="phpthree.php">Задачи № 7 и 8</a><br/> <br/>
      
      <h3>Задача №2, Вариант 9</h3>
      <form method="post" action="">
        <div class="form-group">
          <label for="number">Введите число:</label>
          <input type="text" id="number" name="number" required>
        </div>
        <button type="submit" name="submit_number">Вычислить сумму цифр</button>
      </form>

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_number'])) {
          $input = $_POST['number'] ?? '';
          
          if (is_numeric($input)) {
              $numberStr = (string)$input;
              $sum = 0;
              $numberStr = str_replace(['-', '.'], '', $numberStr);
              for ($i = 0; $i < strlen($numberStr); $i++) {
                  $sum += (int)$numberStr[$i];
              }
              echo "<div class='result'>";
              echo "<p>Вы ввели число: " . htmlspecialchars($input) . "</p>";
              echo "<p>Сумма его цифр: $sum</p>";
              echo "</div>";
          } else {
              echo "<div class='error'>";
              echo "<p>Ошибка: Введенное значение '" . htmlspecialchars($input) . "' не является числом.</p>";
              echo "</div>";
          }
      }
      ?>



      <h3>Задача №3, Вариант 4</h3>
      <h3>Список файлов в каталоге</h3>

      <form method="post">
        <label for="directory">Введите путь к каталогу:</label>
        <input type="text" name="directory" id="directory" value="<?= htmlspecialchars($directory ?? '') ?>" required>
        <button type="submit" name="submit_directory">Показать файлы</button>
      </form>

      <?php
      function getDirectoryFiles($dir) {
          $result = [];
          $totalSize = 0;

          if (!is_dir($dir)) {
              return ['error' => "Указанная директория не существует или недоступна."];
          }

          $iterator = new RecursiveIteratorIterator(
              new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
          );

          foreach ($iterator as $file) {
              if ($file->isFile()) {
                  $filePath = $file->getPathname();
                  $fileSize = $file->getSize();
                  $result[] = [
                      'path' => $filePath,
                      'size' => $fileSize
                  ];
                  $totalSize += $fileSize;
              }
          }

          return [
              'files' => $result,
              'total_size' => $totalSize
          ];
      }

      $directory = '';
      $files = [];
      $totalSize = 0;
      $error = '';

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_directory'])) {
          $directory = trim($_POST['directory'] ?? '');
          if (!empty($directory)) {
              $data = getDirectoryFiles($directory);
              if (isset($data['error'])) {
                  $error = $data['error'];
              } else {
                  $files = $data['files'];
                  $totalSize = $data['total_size'];
              }
          } else {
              $error = "Пожалуйста, укажите путь к каталогу.";
          }
      }
      ?>

      <?php if ($error): ?>
          <div style="color: red;"><?= $error ?></div>
      <?php endif; ?>

      <?php if (!empty($files)): ?>
          <p><strong>Общий объём файлов:</strong> <?= number_format($totalSize, 0, '', ' ') ?> байт</p>
          <table border="1" cellpadding="8" cellspacing="0" style="margin-top: 10px;">
              <thead>
                  <tr>
                      <th>Путь к файлу</th>
                      <th>Размер (байт)</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($files as $file): ?>
                      <tr>
                          <td><?= htmlspecialchars($file['path']) ?></td>
                          <td><?= number_format($file['size'], 0, '', ' ') ?></td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
      <?php endif; ?>




      <h3>Задача №4, Вариант 8</h3>

      <form method="post">
        <label for="text_input">Введите текст:</label><br>
        <textarea name="text_input" id="text_input" rows="5" cols="50" placeholder="Введите произвольный текст здесь..."><?= htmlspecialchars($_POST['text_input'] ?? '') ?></textarea><br><br>
        <button type="submit" name="submit_text">Обработать текст</button>
      </form>

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_text'])) {
          $text = trim($_POST['text_input'] ?? '');

          if (!empty($text)) {
              $words = preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
              $result = '';

              foreach ($words as $word) {
                  if (preg_match('/^\d+$/', $word)) {
                      $result .= "<span style='color:green;'>$word</span>";
                  } elseif (preg_match('/^[a-zA-Z]+$/u', $word)) {
                      $result .= "<span style='color:blue;'>$word</span>";
                  } elseif (preg_match('/^[а-яА-ЯёЁ]+$/u', $word)) {
                      $result .= "<span style='color:red;'>$word</span>";
                  } else {
                      $result .= htmlspecialchars($word);
                  }
              }

              echo "<h4>Результат:</h4>";
              echo "<p>" . $result . "</p>";
          } else {
              echo "<p style='color:red;'>Ошибка: Пожалуйста, введите текст.</p>";
          }
      }
      ?>
    </div>
  </main>


  <footer class="footer">
    <div class="container">
      <div class="social">
        <img src="/image/in.png" alt="">
        <img src="/image/insta.png" alt="">
        <img src="/image/tg.png" alt="">
        <img src="/image/vk.png" alt="">
        <img src="/image/youtube.png" alt="">
      </div>
      <div>
        <p>Пока что я не знаю, что точно будет размещаться на этом сайте и буду ли я для 
          него создавать отдельные соц. сети. Потому я пока что показываю примерный футер 
          этого сайта. Иконки неактивные, но сайт будет дорабатываться.</p>
      </div>
      <div class="contacts"><p>Контакты:</p>
        <p>marchyk96step@mail.ru</p></div>
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>