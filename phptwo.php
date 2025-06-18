<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Блог вкусного вайба</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="styletwo.css">
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
      <?php
      $servername = "localhost";
      $username = "root"; 
      $password = "51947130528"; 
      $dbname = "news_blog";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      if (isset($_GET['date'])) {
          $date = $_GET['date'];
          $sql = "SELECT * FROM news WHERE news_date = '$date'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<div class="news-full">';
              echo '<h1>' . $row['title'] . '</h1>';
              echo '<p>' . $row['content'] . '</p>';
              echo '<img src="/image/' . $row['image'] . '" alt="' . $row['title'] . '">';
              echo '<a href="phptwo.php" class="back-link">Вернуться к календарю</a>';
              echo '</div>';
          } else {
              echo '<p>Новость не найдена</p>';
              echo '<a href="phptwo.php" class="back-link">Вернуться к календарю</a>';
          }
      } else {
          echo '<div class="calendar">';
          echo '<h2>Календарь новостей</h2>';
          
          $year = date('Y');
          $month = date('m');
          
          $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
          
          $first_day_of_week = date('N', mktime(0, 0, 0, $month, 1, $year));
          
          $news_dates = array();
          $sql = "SELECT news_date FROM news";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $news_dates[] = $row['news_date'];
              }
          }
          
          echo '<table>';
          echo '<tr><th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th></tr>';
          
          $day = 1;
          echo '<tr>';

          for ($i = 1; $i < $first_day_of_week; $i++) {
              echo '<td></td>';
          }
          
          for ($i = $first_day_of_week; $i <= 7; $i++) {
              $current_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
              $is_news_day = in_array($current_date, $news_dates);
              
              if ($is_news_day) {
                  echo '<td class="has-news"><a href="phptwo.php?date=' . $current_date . '">' . $day . '</a></td>';
              } else {
                  echo '<td>' . $day . '</td>';
              }
              
              $day++;
          }
          
          echo '</tr>';
          
          while ($day <= $days_in_month) {
              echo '<tr>';
              
              for ($i = 1; $i <= 7 && $day <= $days_in_month; $i++) {
                  $current_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                  $is_news_day = in_array($current_date, $news_dates);
                  
                  if ($is_news_day) {
                      echo '<td class="has-news"><a href="phptwo.php?date=' . $current_date . '">' . $day . '</a></td>';
                  } else {
                      echo '<td>' . $day . '</td>';
                  }
                  
                  $day++;
              }
              
              echo '</tr>';
          }
          
          echo '</table>';
          echo '</div>';
      }
      
      $conn->close();
      ?>

      <div class="serialization-task">
        <h2>Задание № 6 по сериализации данных</h2>
        
        <?php
        function generateRandomData() {
            $data = array(
                'numbers' => array(rand(1, 100), rand(1, 100), rand(1, 100)),
                'strings' => array("Строка 1", "Тестовая строка", "Еще одна строка"),
                'arrays' => array(
                    array(1, 2, 3),
                    array("a", "b", "c"),
                    array("ключ" => "значение", "другой_ключ" => 42)
                ),
                'boolean' => true,
                'null_value' => null,
                'float_number' => 3.14
            );
            return serialize($data);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serializedData = generateRandomData();
            
            echo '<div class="serialized-data">';
            echo '<h3>Сериализованные данные:</h3>';
            echo '<pre>' . htmlspecialchars($serializedData) . '</pre>';
            
            $unserializedData = unserialize($serializedData);
            
            echo '<h3>Десериализованные данные:</h3>';
            echo '<pre>' . print_r($unserializedData, true) . '</pre>';
            echo '</div>';
        }
        ?>
        
        <form method="post">
          <p>Нажмите кнопку, чтобы сгенерировать, сериализовать и десериализовать данные:</p>
          <button type="submit">Выполнить</button>
        </form>
      </div>


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