document.getElementById('search-icon').addEventListener('click', function () {
    const input = document.getElementById('search-input');
    
    // Переключаем видимость поля ввода
    if (input.style.display === 'none' || input.style.display === '') {
      input.style.display = 'block';
      input.focus(); // Фокус сразу в поле ввода
    } else {
      input.style.display = 'none';
    }
});

document.getElementById('menu').addEventListener('click', function () {
    const list = document.getElementById('menu-list');
    const header = document.getElementById('header');

    // Переключаем видимость поля ввода
    if (list.style.display === 'none' || list.style.display === '') {
        list.style.display = 'block';
        header.style.gridTemplateRows = '1fr 3fr';
    } else {
        list.style.display = 'none';
        header.style.gridTemplateRows = '1fr';
    }
});