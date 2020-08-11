document.addEventListener('DOMContentLoaded', () => {
    const scrollTop = document.getElementById('scroll-top');

    // Слушатель для топ-скролл-элемента

    scrollTop.addEventListener('click', () => {
        window.scrollTo({top: 0, behavior:"smooth"})
    });
    
    // Слушатель скролла (добавление класса при скролл > 200 пикселей)

    document.addEventListener('scroll', () => {
        const scrollTop = document.getElementById('scroll-top');

        if (pageYOffset > 200) {
            scrollTop.classList.add('visible');
        } else {
            scrollTop.classList.remove('visible');
        };
    });
});