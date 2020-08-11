<?php
    require_once "header.php";

    /* ================== Вывод студентов ================== */

    


?>
    <div class="top-scroll" id="scroll-top">Наверх</div>
    <main>
        <div class="main-block">
            <section class="cards-column" id="cards-column">
                <div class="search-field" id="search-field">
                    <input type="search" id="search" placeholder="Введите запрос для поиска вакансии" autocomplete="off">
                    <ul id="drop-down-search"></ul>
                    <button id="submit-search"></button>
                </div>
                <div class="pagination" id="pagination-show-cards">
                    Выберите, сколько карточек отображать:
                    <button id="pagination-button" value="10" type="submit">10</button>
                    <button id="pagination-button" value="25" type="submit">25</button>
                    <button id="pagination-button" value="50" type="submit">50</button>
                </div>
                <div class="cards" id="column-for-cards">
                </div>
                <div class="pagination" id="pagination-pages">
                    <button>&lt;</button>
                    <div class="pages" id="pages">
                    </div>
                    <button>&gt;</button>
                </div>
            </section>
            <section class="filters">
                <form action="#" method="post" id="send_filter" autocomplete="off">
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="speciality">Специальность</label>
                        </div>
                        <input type="text" id="speciality" name="speciality" placeholder="Введите запрос">
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="profession">Профессия</label>
                        </div>
                        <input type="text" id="profession" name="profession" placeholder="Введите запрос">
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="wage-range">Зарплата</label>
                        </div>
                        <div class="block-row" id="wage-range_row">
                            <input type="text" name="min-wage" id="minWage" placeholder="Мин. зарплата">
                            <span>_</span>
                            <input type="text" name="min-wage" id="maxWage" placeholder="Макс. зарплата">
                        </div>
                    </div>
                    <div class="filter_row tabs" id="tabs">
                        <div class="tabs-head">
                            <div class="tab" id="tab-countries">Страна</div>
                            <div class="tab" id="tab-areas">Область</div>
                            <div class="tab" id="tab-cities">Город</div>
                        </div>
                        <div class="tabs-content">
                            <div class="tab-content" id="tab-content-countries">
                                <input type="text" id="location-country" name="location-country" placeholder="Введите страну">
                                <ul id="drop-down-country"></ul>
                            </div>
                            <div class="tab-content" id="tab-content-areas">
                                <input type="text" id="location-areas" name="location-areas" placeholder="Введите область">
                                <ul id="drop-down-areas"></ul>
                            </div>
                            <div class="tab-content" id="tab-content-cities">
                                <input type="text" id="location-cities" name="location-cities" placeholder="Введите город">
                                <ul id="drop-down-cities"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="company-name">Название компании</label>
                        </div>
                        <input type="text" id="company-name" name="company-name" placeholder="Введите запрос">
                        <ul id="drop-down-company-name"></ul>
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            Занятость
                        </div>
                        <p><input type="checkbox" id="employment-1" name="employment"><label class="choice" for="employment-1">Полная занятость</label></p>
                        <p><input type="checkbox" id="employment-2" name="employment"><label class="choice" for="employment-2">Частичная занятость</label></p>
                        <p><input type="checkbox" id="employment-3" name="employment"><label class="choice" for="employment-3">Проектная/временная работа</label></p>
                        <p><input type="checkbox" id="employment-4" name="employment"><label class="choice" for="employment-4">Волонтёрство</label></p>
                        <p><input type="checkbox" id="employment-5" name="employment"><label class="choice" for="employment-5">Стажировка</label></p>
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            Опыт работы
                        </div>
                        <p><input type="radio" id="experience-1" name="experience" checked><label class="choice_2" for="experience-1">Не имеет значения</label></p>
                        <p><input type="radio" id="experience-2" name="experience"><label class="choice_2" for="experience-2">Нет опыта</label></p>
                        <p><input type="radio" id="experience-3" name="experience"><label class="choice_2" for="experience-3">От 1 до 3 лет</label></p>
                        <p><input type="radio" id="experience-4" name="experience"><label class="choice_2" for="experience-4">От 3 до 6 лет</label></p>
                        <p><input type="radio" id="experience-5" name="experience"><label class="choice_2" for="experience-5">Более 6 лет</label></p>
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            Сортировка
                        </div>
                        <p><input type="radio" id="sort-1" name="company-name"><label class="choice_2" for="sort-1">По дате изменения</label></p>
                        <p><input type="radio" id="sort-2" name="company-name"><label class="choice_2" for="sort-2">По убыванию зарплаты</label></p>
                        <p><input type="radio" id="sort-3" name="company-name"><label class="choice_2" for="sort-3">По возрастанию зарплаты</label></p>
                        <p><input type="radio" id="sort-4" name="company-name" checked><label class="choice_2" for="sort-4">По соответствию</label></p>
                    </div>
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="select-docs">Выбрать награды</label>
                        </div>
                        <input type="text" id="select-docs" name="select-docs" placeholder="Выбор">
                    </div>
                    <div class="button-block">
                        <button id="reset" type="reset">Сбросить</button>
                        <button id="submit" type="submit">Отправить</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
    <footer>
        <div class="main-block-footer">
            Copyright 2020
        </div>
    </footer>
    <script src="libraries/student.js"></script>
    <script src="plugins/scrollTop.js"></script>
</body>
</html>