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
        <h1>Посоветовать заведение</h1>
        <div class="formAdvise">
        <form action="send_email.php" method="post" enctype="multipart/form-data" class="form-advise">
            <div class="form-name">
                <label for="name">Ваше имя: </label>
                <input type="text" name="name" id="name" required />
            </div>
            <div class="form-email">
                <label for="email">Ваш email: </label>
                <input type="email" name="email" id="email" required />
            </div>
            <div class="form-nameshop">
                <label for="nameshop">Название заведения: </label>
                <input type="text" name="nameshop" id="nameshop" required />
            </div>
            <div class="form-adres">
                <label for="adres">Адрес заведения: </label>
                <input type="text" name="adres" id="adres" required />
            </div>
            <div class="form-attachments">
              <label for="attachments">Прикрепите фотографии (максимум 5 файлов):</label>
              <input type="file" name="attachments[]" id="attachments" multiple accept="image/*,.pdf,.doc,.docx">
            </div>
            <div class="form-comment">
              <label for="comment"></label>
              <textarea name="comment" id="comment">Расскажите, почему вы советуете данное заведение...</textarea>
            </div>
            <div class="captcha">
              <div class="captcha-image">
                <img src="captcha.php" alt="CAPTCHA">
              </div>
              <div class="captcha-input">
                <label for="captcha">Введите код с картинки:</label>
                <input type="text" name="captcha" id="captcha" required>
              </div>
            </div>
            
            <div class="form-submit">
                <input type="submit" value="Отправить!" />
            </div>
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