document.addEventListener('DOMContentLoaded', () => {
    // ДАННЫЕ С КОТОРЫМИ РАБОТАЕМ

    const modalAdd = {
            addAchievement: document.getElementById('add-achievement-modal'),
            addButton: document.getElementById('add-achievement-button'),
            closeSpan: document.getElementById('close-add-span-achievement'),
            closeButton: document.getElementById('close-add-button-achievement'),
            sendButton: document.getElementById('send-add-button-achievement'),
            addFile: document.getElementById('add-achievement-file'),
        },

        modalEdit = {
            editAchievement: document.getElementById('edit-achievement-modal'),
            closeSpan: document.getElementById('close-edit-span-achievement'),
            closeButton: document.getElementById('close-edit-button-achievement'),
            sendButton: document.getElementById('send-edit-button-achievement'),
            editFile: document.getElementById('edit-achievement-file'),
            files: document.querySelectorAll('.annotation-btn'),
            filesPlace: document.querySelectorAll('.place'),
        },

        modalSettings = {
            settingsModal: document.getElementById('settings-modal'),
            closeSpan: document.getElementById('setting-close-span'),
            closeButton: document.getElementById('close-updates'),
            sendButton: document.getElementById('send-updates'),
            settingFile: document.getElementById('user-photo'),
        },
        
        settingsButton = document.getElementById('settings'),
        mainBlock = document.querySelector('.main-block');

    // ФУНКЦИИ

    const openModal = (modalOverlay) => {
        document.body.style.overflow = 'hidden';
        modalOverlay.classList.add('open');
        modalOverlay.style.overflow = 'auto';
        mainBlock.style.filter = 'blur(1px)';
    };

    const closeModal = (modalOverlay, type, minDate, achievementSection, achievementStep, achievementPlace, inputName, inputDate, inputFile, inputLabel, imageArea, email, password) => {
        document.body.style.overflow = 'auto';
        modalOverlay.classList.remove('open');
        modalOverlay.style.overflow = 'hidden';

        if (type === 'achievement') {
            achievementSection.options.selectedIndex = 0;
            inputName.value = '';
            achievementStep.options.selectedIndex = 0;
            achievementPlace.options.selectedIndex = 0;
            inputDate.value = minDate;
            inputFile.value = '';
            inputLabel.textContent = 'Выберите файл';
            imageArea.innerHTML = '';
        } else if (type === 'settings') {
            minDate.value = '';
            achievementSection.value = '';
            achievementStep.innerHTML = ``;
            achievementPlace.textContent = 'Выберите файл';
        };

        mainBlock.style.filter = '';
    };

    const errorImage = (imgArea, label) => {
        const errorImage = document.createElement('div');
        errorImage.classList.add('error-image');
        errorImage.innerHTML = `<h2>Ошибка! Файл не является изображением! Выберите другой.</h2>`;
        label.textContent = 'Выбрать файл';
        imgArea.append(errorImage);
        return errorImage;
    }

    const dateForInput = () => {
        let today = new Date(),
            dd = today.getDate(),
            mm = today.getMonth()+1,
            yyyy = today.getFullYear();
        
        if (dd < 10) {
            dd = '0' + dd;
        };

        if (mm < 10) {
            mm = '0' + mm;
        };

        return today = yyyy+'-'+mm+'-'+dd;
    };

    const selectAddFile = function() {
        const imgArea = document.getElementById('add-output-image'),
            changeLabelText = document.getElementById('change-label-text'),
            file = this.files[0];

        imgArea.innerHTML = ``;

        if (file.type.match('image.*')) {
            const fReader = new FileReader();

            fReader.addEventListener('load', function() {
                const image = document.createElement('img');
                image.src = this.result;
                changeLabelText.textContent = file.name;
                imgArea.append(image);
                return image;
            });

            fReader.readAsDataURL(file);
        } else {
            errorImage(imgArea, changeLabelText);
        };
    };

    const selectEditFile = function() {
        const imgArea = document.getElementById('edit-output-image'),
            changeLabelText = document.getElementById('change-edit-label-text'),
            file = this.files[0];

        imgArea.innerHTML = ``;

        if (file.type.match('image.*')) {
            const fReader = new FileReader();

            fReader.addEventListener('load', function() {
                const image = document.createElement('img');
                image.src = this.result;
                changeLabelText.textContent = file.name;
                imgArea.append(image);
                return image;
            });

            fReader.readAsDataURL(file);
        } else {
            errorImage(imgArea, changeLabelText);
        };
    };

    const selectSettingFile = function() {
        const imgArea = document.getElementById('setting-output-image'),
            changeLabelText = document.getElementById('change-setting-label'),
            file = this.files[0];

        imgArea.innerHTML = ``;

        if (file.type.match('image.*')) {
            const fReader = new FileReader();

            fReader.addEventListener('load', function() {
                const image = document.createElement('img');
                image.src = this.result;
                changeLabelText.textContent = file.name;
                imgArea.append(image);
                return image;
            });

            fReader.readAsDataURL(file);
        } else {
            errorImage(imgArea, changeLabelText);
        };
    };

    // ОБРАБОТЧИКИ

    document.addEventListener('click', (event) => {
        const target = event.target;

        if (target === modalAdd.addButton) {
            const inputDate = document.getElementById('add-achievement-date');

            inputDate.setAttribute("max", dateForInput());

            openModal(modalAdd.addAchievement);

            modalAdd.addFile.addEventListener('change', selectAddFile, false);
            
        } else if (target === modalAdd.closeButton || 
            target === modalAdd.addAchievement || 
            target === modalAdd.closeSpan ||
            target === modalAdd.sendButton) {

            const minAddDate = document.getElementById('add-achievement-date').min,
                achievementSection = document.getElementById('add-achievement-section'),
                achievementStep = document.getElementById('add-achievement-step'),
                achievementPlace = document.getElementById('add-achievement-place'),
                addName = document.getElementById('add-achievement-name'),
                addDate = document.getElementById('add-achievement-date'),
                addFile = document.getElementById('add-achievement-file'),
                addLabel = document.getElementById('change-label-text'),
                addImageArea = document.getElementById('add-output-image'),
                achievement = 'achievement';
            
            event.preventDefault();

            closeModal(modalAdd.addAchievement, achievement, minAddDate, achievementSection, achievementStep, achievementPlace, addName, addDate, addFile, addLabel, addImageArea);
        };

        for (let i = 0; i < modalEdit.files.length; i++) {
            if (target === modalEdit.files[i] || target === modalEdit.filesPlace[i]) {

                openModal(modalEdit.editAchievement);

                modalEdit.editFile.addEventListener('change', selectEditFile, false);

            } else if (target === modalEdit.closeButton ||
                target === modalEdit.editAchievement ||
                target === modalEdit.closeSpan ||
                target === modalEdit.sendButton) {

                const minEditDate = document.getElementById('edit-achievement-date').min,
                    achievementSection = document.getElementById('edit-achievement-section'),
                    achievementStep = document.getElementById('edit-achievement-step'),
                    achievementPlace = document.getElementById('edit-achievement-place'),
                    addName = document.getElementById('edit-achievement-name'),
                    addDate = document.getElementById('edit-achievement-date'),
                    addFile = document.getElementById('edit-achievement-file'),
                    addLabel = document.getElementById('change-edit-label-text'),
                    editImageArea = document.getElementById('edit-output-image'),
                    achievement = 'achievement';

                event.preventDefault();

                closeModal(modalEdit.editAchievement, achievement, minEditDate, achievementSection, achievementStep, achievementPlace, addName, addDate, addFile, addLabel, editImageArea);

            };
        };

        if (target === settingsButton) {
            openModal(modalSettings.settingsModal);

            modalSettings.settingFile.addEventListener('change', selectSettingFile, false);
        } else if (target === modalSettings.settingsModal) {
            const inputEmail = document.getElementById('user-email'),
                inputPassword = document.getElementById('user-password'),
                settingsImageArea = document.getElementById('setting-output-image'),
                settingLabel = document.getElementById('change-setting-label'),
                settings = 'settings';

            event.preventDefault();

            closeModal(modalSettings.settingsModal, settings, inputEmail, inputPassword, settingsImageArea, settingLabel);
        };

        const userBlock = document.getElementById('user');
        
        const userActionBlock = document.getElementById('user-action-block'),
            userBlockName = document.getElementById('user-block-name'),
            userBlockPhoto = document.getElementById('user-block-photo');

        if (target === userBlock || target === userBlockName || target === userBlockPhoto || target === userActionBlock) {
            userActionBlock.classList.add('open');
        } else if (target !== userActionBlock) {
            userActionBlock.classList.remove('open');
        };
    });
});