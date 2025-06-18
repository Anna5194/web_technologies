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
        <li><a href="advise.html">Посоветовать место</a></li>
        <li><a href="doublecheck.html">Требую переобзора!</a></li>
        <li><a href="php.php">тестовая для заданий по ВБ</a></li>
      </ul>
    </div>
  </header>

  <main class="main">
    <div class="container">
      <h1>Экспериментальная страница для решения задач на php</h1>
      <a href="php.php">Задачи № 1-4</a><br/>
      <a href="phptwo.php">Задачи № 5 и 6</a><br/><br/>
      
      <h3>Задача №8, Вариант 9</h3>
      <h2>Статистика посещений сайта</h2>
      
      <?php
      $db = new mysqli('localhost', 'vibe_user', '51947130528', 'visit_stats');
      
      if ($db->connect_error) {
          die("<div style='color:red;padding:20px;border:2px solid red;'>Ошибка подключения к базе данных: " . $db->connect_error . "</div>");
      }
      
      $ip = $_SERVER['REMOTE_ADDR'];
      $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Неизвестный';
      $insertVisit = "INSERT INTO visits (ip_address, user_agent) VALUES (?, ?)";
      $stmt = $db->prepare($insertVisit);
      $stmt->bind_param("ss", $ip, $userAgent);
      $stmt->execute();
      $stmt->close();
      
      function getDailyStats($db) {
          $query = "SELECT HOUR(visit_time) as hour, COUNT(*) as count 
                    FROM visits 
                    WHERE DATE(visit_time) = CURDATE() 
                    GROUP BY HOUR(visit_time)";
          return $db->query($query);
      }
      
      function getWeeklyStats($db) {
          $query = "SELECT DAYOFWEEK(visit_time) as day_num, DAYNAME(visit_time) as day_name, COUNT(*) as count 
                    FROM visits 
                    WHERE YEARWEEK(visit_time) = YEARWEEK(CURDATE()) 
                    GROUP BY DAYOFWEEK(visit_time), DAYNAME(visit_time)
                    ORDER BY day_num";
          return $db->query($query);
      }
      
      function getMonthlyStats($db) {
          $query = "SELECT DAYOFMONTH(visit_time) as day, COUNT(*) as count 
                    FROM visits 
                    WHERE MONTH(visit_time) = MONTH(CURDATE()) 
                    AND YEAR(visit_time) = YEAR(CURDATE()) 
                    GROUP BY DAYOFMONTH(visit_time)";
          return $db->query($query);
      }
      
      function getYearlyStats($db) {
          $query = "SELECT MONTH(visit_time) as month_num, MONTHNAME(visit_time) as month_name, COUNT(*) as count 
                    FROM visits 
                    WHERE YEAR(visit_time) = YEAR(CURDATE()) 
                    GROUP BY MONTH(visit_time), MONTHNAME(visit_time)
                    ORDER BY month_num";
          return $db->query($query);
      }
      
      $dailyStats = getDailyStats($db);
      $weeklyStats = getWeeklyStats($db);
      $monthlyStats = getMonthlyStats($db);
      $yearlyStats = getYearlyStats($db);
      $db->close();
      ?>
      
      <div class="stats-container">
        <div class="chart-container">
          <h3>Посещения за день</h3>
          <canvas id="daily-chart"></canvas>
        </div>
        
        <div class="chart-container">
          <h3>Посещения за неделю</h3>
          <canvas id="weekly-chart"></canvas>
        </div>
        
        <div class="chart-container">
          <h3>Посещения за месяц</h3>
          <canvas id="monthly-chart"></canvas>
        </div>
        
        <div class="chart-container">
          <h3>Посещения за год</h3>
          <canvas id="yearly-chart"></canvas>
        </div>
      </div>
      
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
      const dailyCtx = document.getElementById('daily-chart');
      const dailyData = {
          labels: Array.from({length: 24}, (_, i) => i + ':00'),
          datasets: [{
              label: 'Посещений в час',
              data: new Array(24).fill(0),
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1
          }]
      };
      
      <?php
      if ($dailyStats->num_rows > 0) {
          while($row = $dailyStats->fetch_assoc()) {
              echo "dailyData.datasets[0].data[{$row['hour']}] = {$row['count']};";
          }
      }
      ?>
      
      const weeklyCtx = document.getElementById('weekly-chart');
      const weekDays = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
      const weeklyData = {
          labels: weekDays,
          datasets: [{
              label: 'Посещений в день',
              data: new Array(7).fill(0),
              backgroundColor: 'rgba(153, 102, 255, 0.2)',
              borderColor: 'rgba(153, 102, 255, 1)',
              borderWidth: 1
          }]
      };
      
      <?php
      if ($weeklyStats->num_rows > 0) {
          while($row = $weeklyStats->fetch_assoc()) {
              echo "weeklyData.datasets[0].data[{$row['day_num']} - 1] = {$row['count']};";
          }
      }
      ?>
      
      const monthlyCtx = document.getElementById('monthly-chart');
      const monthlyData = {
          labels: Array.from({length: 31}, (_, i) => (i + 1).toString()),
          datasets: [{
              label: 'Посещений в день',
              data: new Array(31).fill(0),
              backgroundColor: 'rgba(255, 159, 64, 0.2)',
              borderColor: 'rgba(255, 159, 64, 1)',
              borderWidth: 1
          }]
      };
      
      <?php
      if ($monthlyStats->num_rows > 0) {
          while($row = $monthlyStats->fetch_assoc()) {
              echo "monthlyData.datasets[0].data[{$row['day']} - 1] = {$row['count']};";
          }
      }
      ?>
      
      const yearlyCtx = document.getElementById('yearly-chart');
      const yearlyData = {
          labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
          datasets: [{
              label: 'Посещений в месяц',
              data: new Array(12).fill(0),
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
          }]
      };
      
      <?php
      if ($yearlyStats->num_rows > 0) {
          while($row = $yearlyStats->fetch_assoc()) {
              echo "yearlyData.datasets[0].data[{$row['month_num']} - 1] = {$row['count']};";
          }
      }
      ?>
      
      document.addEventListener('DOMContentLoaded', function() {
          new Chart(dailyCtx, {
              type: 'bar',
              data: dailyData,
              options: { responsive: true, scales: { y: { beginAtZero: true } } }
          });
          
          new Chart(weeklyCtx, {
              type: 'bar',
              data: weeklyData,
              options: { responsive: true, scales: { y: { beginAtZero: true } } }
          });
          
          new Chart(monthlyCtx, {
              type: 'line',
              data: monthlyData,
              options: { responsive: true, scales: { y: { beginAtZero: true } } }
          });
          
          new Chart(yearlyCtx, {
              type: 'bar',
              data: yearlyData,
              options: { responsive: true, scales: { y: { beginAtZero: true } } }
          });
      });
      </script>
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