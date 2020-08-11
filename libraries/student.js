// ПОЛУЧЕНИЕ ЭЛЕМЕНТОВ СО СТРАНИЦЫ

const cardsColumn = document.getElementById('cards-column'),
    columnForCards = document.getElementById('column-for-cards'),
    paginationBlock = document.getElementById('pagination-show-cards'),
    errorCard = document.getElementById('error-card'),
    pagesBlock = document.getElementById('pages'),
    tabs = document.getElementById('tabs'),
    // ИНПУТЫ И ИХ СПИСКИ
    // Инпут и лист стран
    inputLocationCountries = document.getElementById('location-country'),
    dropDownCountries = document.getElementById('drop-down-country'),
    // Инпут и лист областей
    inputLocationAreas = document.getElementById('location-areas'),
    dropDownAreas = document.getElementById('drop-down-areas'),
    // Инпут и лист компаний
    inputCompanyName = document.getElementById('company-name'),
    dropDownCompanyName = document.getElementById('drop-down-company-name'),
    // Поле поиска
    inputSearch = document.getElementById('search'),
    dropDownSearch = document.getElementById('drop-down-search'),
    searchButton = document.getElementById('submit-search');

// НЕОБХОДИМЫЕ ДАННЫЕ ДЛЯ ПОЛУЧЕНИЯ ИНФОРМАЦИИ С ДРУГОГО САЙТА

const PROXY = 'https://cors-anywhere.herokuapp.com/',
    HH_API_LINK = 'https://api.hh.ru'
    HH_API_VACANCIES_LINK = 'https://api.hh.ru/vacancies',
    HH_API_AREAS_LINK = 'https://api.hh.ru/areas',
    HH_ARI_COUNTRIES_LINK = 'https://api.hh.ru/areas/countries',
    HH_API_EMPLOYERS_LINK = 'https://api.hh.ru/suggests/companies',
    HH_API_KEYWORDS_LINK = 'https://api.hh.ru/suggests/vacancy_search_keyword';

// ИСПОЛЬЗУЕМЫЕ ДАННЫЕ

let vacancies = [],
    pages = 0,
    per_page = 10,
    set_page = 0;
    COUNTRIES = [],
    AREAS = [],
    REGIONS = [],
    EMPLOYERS = [],
    KEY_WORDS = [],
    DEEP_PAGINATION_LINK = '',
    SEARCH_LINK = '';

// Ссылка для пагинации

let PAGINATION_LINK = `&per_page=${per_page}&page=0`;

// ФУНКЦИИ
// Фукнция получения данных

const getData = (url, callback, reject = console.log) => {
    const request = new XMLHttpRequest;

    request.open('GET', url);

    request.addEventListener('readystatechange', () => {
        if (request.readyState !== 4) return;

        if (request.status === 200) {
            callback(request.response);
        } else {
            createErrorCard(request.status);
            reject(request.response);
        };
    });

    request.send();
};

// Создание страниц пагинации

const createButtons = (pages) => {
    for (let i = 0; i < pages; i++) {
        let button = document.createElement('button');
        button.value = i;
        button.id = 'set-page-button';
        button.insertAdjacentText('afterbegin',`${i+1}`);
        pagesBlock.append(button);
    };
};

// Установка пагинации (какое количество карточек отображать)

const setPagination = (event, pages) => {
    const target = event.target;
    PAGINATION_LINK = `?per_page=${target.value}&page=0`;

    createButtons(pages);

    return PAGINATION_LINK;
};

// Получение заработной платы (с обработкой всех доступных форм)

const getSalary = (inputSalary) => {
    let outputSalary = ``;

    if (inputSalary !== null) {
        const inputSalaryFrom = inputSalary['from'],
            inputSalaryTo = inputSalary['to'],
            salaryCurrency = inputSalary['currency'];

        if (inputSalaryFrom !== null && inputSalaryTo !== null) {
            outputSalary = `От ${inputSalaryFrom} до ${inputSalaryTo} ${salaryCurrency}`;
        } else if (inputSalaryFrom !== null) {
            outputSalary = `От ${inputSalaryFrom} ${salaryCurrency}`;
        } else if (inputSalaryTo !== null) {
            outputSalary = `До ${inputSalaryTo} ${salaryCurrency}`;
        };

    } else {
        outputSalary = `Не указано`;
    };

    return outputSalary;
};

// Получение описания вакансии (с обработкой всех форм)

const getAnnotation = (snippet) => {
    let deep = ``;

    if (snippet !== null) {
        const requirement = snippet["requirement"],
            responsibility = snippet["responsibility"];

        if (requirement !== null) {
            deep = `<p class="item-annotation" id="item-requirement">${requirement}</p>`;
        } else {
            deep = `<p class="item-annotation" id="item-requirement">Не указано</p>`;
        };

        if (responsibility !== null) {
            deep += `<p class="item-annotation" id="item-responsibility">${responsibility}</p>`;
        } else {
            deep += `<p class="item-annotation" id="item-responsibility">Не указано</p>`;
        };
        
    } else {
        deep = `<p class="item-annotation" id="item-annotation">Не указано</p>`;
    };

    return deep;
};

// Получение даты создания карточки

const getDate = (date) => {
    return new Date(date).toLocaleString('ru', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

// Дополнительная информация (Адрес, компания, дата создания)

const getAdditionalInfo = (address, employer, created_at) => {
    let deep = ``,
        addressFull = ``,
        addressCity = ``,
        addressStreet = ``,
        addressBuilding = ``,
        employerFull = ``,
        createdAt = ``;

    if (address !== null) {
        
        if (address["city"] !== null) {
            addressCity = `Город: ${address["city"]}`;
        } else {
            addressCity = `Город не указан`;
        };

        if (address["street"] !== null) {
            addressStreet = `улица: ${address["street"]}`;
        } else {
            addressStreet = `улица не указана`;
        };

        if (address["building"] !== null) {
            addressBuilding = `строение: ${address["building"]}`;
        } else {
            addressBuilding = `строение не указано`;
        };

        addressFull = `${addressCity}, ${addressStreet}, ${addressBuilding}`

    } else {
        addressFull = `Адресс: не указан`;
    };

    if (employer !== null) {
        employerFull = `Компания: <a href="${employer['alternate_url']}">${employer['name']}</a>`;
    } else {
        employerFull = `Компнаия: не указана`;
    };

    if (created_at !== null) {
        createdAt = `Дата создания: ${getDate(created_at)}`;
    } else {
        createdAt = `Дата создания: не указана`;
    }

    deep = `<p class="item-additional-info" id="item-adress">${addressFull}</p>
            <p class="item-additional-info" id="item-employer">${employerFull}</p>
            <p class="item-additional-info" id="item-created-at">${createdAt}</p>`;

    return deep;
};

// Функция создания карточки-ошибки

const createErrorCard = (errorStatus) => {
    const card = document.createElement('div');
    card.classList.add('item-card');
    card.classList.add('error');
    card.id="error-card";

    card.insertAdjacentHTML('afterbegin', `
        <section class="item-head">
            Упс, возникла ошибка: ${errorStatus} :(
        </section>
        <hr>
        <section class="item-footer">
            <div class="button-block">
                <button id="error-card-close">Закрыть</button>
            </div>
        </section>
    `);

    columnForCards.append(card);

    return card;
};

// Функция создания карточки-вакансии

const createCards = (vacancies) => {
    const card = document.createElement('div');
    card.classList.add('item-card');

    let deep;

    if (vacancies) {
        deep = `
            <section class="item-head">
                <span id="hint-name">
                    ${vacancies.name}
                </span>
                <div class="item-name half-width">
                    ${vacancies.name}
                </div>
                <div class="item-wage half-width _wg-b">
                    ${getSalary(vacancies.salary)}
                </div>
            </section>
            <hr>
            <section class="item-annotation">
                ${getAnnotation(vacancies.snippet)}
            </section>
            <section class="item-additional-info">
                ${getAdditionalInfo(vacancies.address, vacancies.employer, vacancies.created_at)}
            </section>
            <hr>
            <section class="item-footer">
                <div class="button-block">
                    <button><a href="${vacancies.alternate_url}">Подробнее</a></button>
                </div>
            </section>
        `;
    } else {
        card.classList.add('error');
        card.id = "error-card";
        deep = `
            <section class="item-head">
                Упс, неизвестная ошибка! :(
            </section>
            <hr>
            <section class="item-footer">
                <div class="button-block">
                    <button id="error-card-close">Закрыть</button>
                </div>
            </section>
        `;
    };

    card.insertAdjacentHTML('afterbegin', deep);

    return card;
};

// Функция закрытия карточки-ошибки

const destroyErrorCard = (event) => {
    target = event.target;

    const errorCard = document.getElementById('error-card'),
        destroyElement = document.getElementById('error-card-close');

    if (target === destroyElement) {
        errorCard.remove(errorCard);
    };
};

// Рендеринг карточек-вакансий

const renderCard = (vacancies) => {
    for (let i = 0; i < per_page; i++) {
        const workCard = createCards(vacancies[i]);
        columnForCards.append(workCard);
    }
};

// Создаёт лишки для листа стран

const showCountries = (input, list) => {
    list.innerHTML = ``;

    if (input.value !== '') {
        const filterCountries = COUNTRIES.filter((item) => {
            if (item.name) {
                const fixItem = item.name.toLowerCase();
                return fixItem.startsWith(input.value.toLowerCase());
            };
        });

        filterCountries.forEach((item) => {
            const li = document.createElement('li');
            li.textContent = item.name;
            list.append(li);
        });
    };
};

// Создаёт лишки для листа областей

const showAreas = (input, list) => {
    list.innerHTML = '';

    if (input.value !== '') {
        for (let i = 0; i < AREAS.length; i++) {
            const filterAreas = AREAS[i]['areas'].filter((item) => {
                if (item.name) {
                    const fixItem = item.name.toLowerCase();
                    return fixItem.startsWith(input.value.toLowerCase());
                };
            });
            
            filterAreas.forEach((item) => {
                const li = document.createElement('li');
                li.textContent = item.name;
                list.append(li);
            });
        };
    };
};

// Создаёт лишки для городов

const showCities = (input, list) => {
    list.innerHTML = '';

    if (input.value !== '') {
        for (let i = 0; i < AREAS.length; i++) {
            REGIONS = AREAS[i]['areas'];
            for (let n = 0; n < REGIONS.length; n++) {
                const filterCities = REGIONS[n]['areas'].filter((item) => {
                    if (item.name) {
                        const fixItem = item.name.toLowerCase();
                        return fixItem.startsWith(input.value.toLowerCase());
                    };
                });

                filterCities.forEach((item) => {
                    const li = document.createElement('li');
                    li.textContent = item.name;
                    list.append(li);
                });
            };
        };
    };
};

// Создаёт лишки для листа поиска

const showSearchKeyWords = (input, list) => {
    list.innerHTML = ``;

    if (input.value !== '' && input.value.length > 1) {
        getData(HH_API_KEYWORDS_LINK + `?text=${input.value}`, (data) => {
            KEY_WORDS = JSON.parse(data).items;
        });

        for (let i = 0; i < KEY_WORDS.length; i++) {
            const keyWordText = KEY_WORDS[i].text;
            const li = document.createElement('li');
            li.textContent = keyWordText;
            list.append(li);
        };
    };   
};

// Создаёт лишки для листа с именами компаний

const showCompanyNames = (input, list) => {
    list.innerHTML = ``;

    if (input.value !== '' && input.value.length > 1) {
        getData(HH_API_EMPLOYERS_LINK + `?text=${input.value}`, (data) => {
            EMPLOYERS = JSON.parse(data).items;
        });

        for (let i = 0; i < EMPLOYERS.length; i++) {
            const keyWordCompanyName = EMPLOYERS[i].text;
            const li = document.createElement('li');
            li.textContent = keyWordCompanyName;
            list.append(li);
        };
    };
};

const getSearchValue = (value) => {
    const re = / /gi;
    let str = value;
    const newstr = str.replace(re, '+');
    console.log(newstr)
    return newstr;
};

// Заполнение значение инпута по клику на лишку

const selectItems = (event, input, list) => {
    const target = event.target;

    if (target.tagName.toLowerCase() === 'li') {
        input.value = target.textContent;
        list.textContent = '';
    };

    input.classList.remove('not-null');
};

// ОБРАБОТЧИКИ СОБЫТИЙ

paginationBlock.addEventListener('click', (event) => {
    const target = event.target;

    document.title = 'Поиск работы';

    if (target.tagName.toLowerCase() === 'button') {
        pagesBlock.innerHTML = ``;
        columnForCards.innerHTML = ``;

        setPagination(event, pages, per_page);
    
        getData(HH_API_VACANCIES_LINK + PAGINATION_LINK, (data) => {
            vacancies = JSON.parse(data).items;
            per_page = JSON.parse(data).per_page;
            pages = JSON.parse(data).pages;
            
            renderCard(vacancies, vacancies.salary);
            setPagination(event, pages);
        });
    };
});

pagesBlock.addEventListener('click', (event) => {
    columnForCards.innerHTML = ``;

    const target = event.target,
        setPageButton = document.querySelectorAll('#set-page-button');

    for (let i = 0; i < setPageButton.length; i++) {
        if (target === setPageButton[i]) {
            set_page = setPageButton[i].value;

            PAGINATION_LINK = `?per_page=${per_page}&page=${set_page}`

            console.log(PAGINATION_LINK);

            if (SEARCH_LINK === '') {
                getData(HH_API_VACANCIES_LINK + PAGINATION_LINK, (data) => {
                    vacancies = JSON.parse(data).items;
                    per_page = JSON.parse(data).per_page;
                    pages = JSON.parse(data).pages;
                    
                    renderCard(vacancies, vacancies.salary);
                });
            } else if (SEARCH_LINK !== '') {
                getData(HH_API_LINK + SEARCH_LINK + PAGINATION_LINK, (data) => {
                    vacancies = JSON.parse(data).items;
                    per_page = JSON.parse(data).per_page;
                    pages = JSON.parse(data).pages;
                    
                    renderCard(vacancies, vacancies.salary);
                    // setPagination(event, pages);
                    console.log(HH_API_LINK + SEARCH_LINK + PAGINATION_LINK)
                });
            };

            document.title = `Поиск работы - Страница ${i+1}`;
        };
    };
});

tabs.addEventListener('click', (event) => {
    const target = event.target,
        tabCountries = document.getElementById('tab-countries'),
        tabAreas = document.getElementById('tab-areas'),
        tabCities = document.getElementById('tab-cities'),
        
        tabContentCountries = document.getElementById('tab-content-countries'),
        tabContentAreas = document.getElementById('tab-content-areas'),
        tabContentCities = document.getElementById('tab-content-cities'),

        dropDownCountries = document.getElementById('drop-down-country'),
        dropDownAreas = document.getElementById('drop-down-areas'),
        dropDownCities = document.getElementById('drop-down-cities');

    let inputLocationCountries = document.getElementById('location-country'),
        inputLocationAreas = document.getElementById('location-areas'),
        inputLocationCities = document.getElementById('location-cities');

    if (target === tabCountries) {
        inputLocationAreas.value = '';
        inputLocationCities.value = '';

        dropDownAreas.textContent = '';
        dropDownCities.textContent = '';

        tabCountries.classList.add('active');
        tabAreas.classList.remove('active');
        tabCities.classList.remove('active');

        tabContentCountries.classList.add('active');
        tabContentAreas.classList.remove('active');
        tabContentCities.classList.remove('active');

        inputLocationCountries.addEventListener('input', (event) => {
            const target = event.target;
    
            showCountries(inputLocationCountries, dropDownCountries);

            if (dropDownCountries.textContent !== '') {
                target.classList.add('not-null');
            } else if (dropDownCountries.textContent === '') {
                target.classList.remove('not-null');
            };
        });
    
        dropDownCountries.addEventListener('click', (event) => {
            selectItems(event, inputLocationCountries, dropDownCountries);
        });
    };

    if (target === tabAreas) {
        inputLocationCountries.value = '';
        inputLocationCities.value = '';

        dropDownCountries.textContent = '';
        dropDownCities.textContent = '';

        tabAreas.classList.add('active');
        tabCountries.classList.remove('active');
        tabCities.classList.remove('active');

        tabContentAreas.classList.add('active');
        tabContentCountries.classList.remove('active');
        tabContentCities.classList.remove('active');

        inputLocationAreas.addEventListener('input', (event) => {
            const target = event.target;

            showAreas(inputLocationAreas, dropDownAreas);

            if (dropDownAreas.textContent !== '') {
                target.classList.add('not-null');
            } else if (dropDownAreas.textContent === '') {
                target.classList.remove('not-null');
            };
        });

        dropDownAreas.addEventListener('click', (event) => {
            selectItems(event, inputLocationAreas, dropDownAreas);
        });
    };

    if (target === tabCities) {
        inputLocationCountries.value = '';
        inputLocationAreas.value = '';

        dropDownCountries.textContent = '';
        dropDownAreas.textContent = '';

        tabCities.classList.add('active');
        tabCountries.classList.remove('active');
        tabAreas.classList.remove('active');

        tabContentCities.classList.add('active');
        tabContentCountries.classList.remove('active');
        tabContentAreas.classList.remove('active');

        inputLocationCities.addEventListener('input', (event) => {
            const target = event.target;

            showCities(inputLocationCities, dropDownCities);

            if (dropDownCities.textContent !== '') {
                target.classList.add('not-null');
            } else if (dropDownCities.textContent === '') {
                target.classList.remove('not-null');
            };
        });

        dropDownCities.addEventListener('click', (event) => {
            selectItems(event, inputLocationCities, dropDownCities)
        });
    }
});

inputSearch.addEventListener('input', () => {
    const button = document.getElementById('submit-search');

    showSearchKeyWords(inputSearch, dropDownSearch);

    if (dropDownSearch.textContent !== '') {
        inputSearch.classList.add('not-null');
        dropDownSearch.classList.add('not-null');
        button.classList.add('not-null');
    } else if (dropDownSearch.textContent === '') {
        inputSearch.classList.remove('not-null');
        dropDownSearch.classList.remove('not-null');
        button.classList.remove('not-null');
    };
});

searchButton.addEventListener('click', () => {
    columnForCards.innerHTML = ``;

    inputSearch.classList.remove('not-null');
    searchButton.classList.remove('not-null');
    dropDownSearch.classList.remove('not-null');

    SEARCH_LINK = `/vacancies?text=${getSearchValue(inputSearch.value)}`;

    getData(HH_API_LINK + SEARCH_LINK + PAGINATION_LINK, (data) => {
        vacancies = JSON.parse(data).items;
        per_page = JSON.parse(data).per_page;
        pages = JSON.parse(data).pages;
        
        renderCard(vacancies, vacancies.salary);
        createButtons(pages);
    });

    inputSearch.value = '';
});

dropDownSearch.addEventListener('click', (event) => {
    selectItems(event, inputSearch, dropDownSearch);
});

inputCompanyName.addEventListener('input', () => {
    showCompanyNames(inputCompanyName, dropDownCompanyName);

    if (dropDownCompanyName.textContent !== '') {
        inputCompanyName.classList.add('not-null');
    } else if (dropDownCompanyName.textContent === '') {
        inputCompanyName.classList.remove('not-null');
    };
});

dropDownCompanyName.addEventListener('click', (event) => {
    selectItems(event, inputCompanyName, dropDownCompanyName);
});

// Слушатель по клику с функцией дестроя карточки-ошибки

cardsColumn.addEventListener('click', (event) => {
    destroyErrorCard(event);
});

// ПОЛУЧЕНИЕ ДАННЫХ

// Получаем области
getData(HH_API_AREAS_LINK, (data) => {
    AREAS = JSON.parse(data);
});

// Получаем страны
getData(HH_ARI_COUNTRIES_LINK, (data) => {
    COUNTRIES = JSON.parse(data);
});

