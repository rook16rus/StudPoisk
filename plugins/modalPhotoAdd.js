// Массив расширений для которых есть картинка на сервере
var extensions = ["doc", "pdf", "txt", "js", "image", "jpg", "png"];

// input за которым следим
var fileField = document.getElementById('add_achievement_file');

// Сюда вставим превьюшку
var preview = document.getElementById('add-output-image');

// Следим за выбором файла
fileField.addEventListener('change', function(event) {
    
    // Если выбран файл начинаем работать (этот пример рассчитан на 1 файл)
    if(event.target.files.length > 0){
        // Создаем изображение
        var img = document.createElement('img');
    
        // Достаем расширение файла
        var ext = event.target.files[0].name.split('.').pop();
        
        // Проверяем есть ли такое
        if(extensions.indexOf(ext) !== -1){
            // Добавляем картинку с расширением
            var src = '/images/order/'+ ext +'.jpg';
        }
        else{
            // Иначе ставим дефолтную картинку
            var src = '/images/order/default.jpg';
        }
        
        // Устанавливаем src для изображения
        img.setAttribute('src', src);
               
        // Добавляем изображение на страницу
        preview.appendChild(img);
    }
}, false);