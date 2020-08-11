document.addEventListener('DOMContentLoaded', function() {
    const settingsButton = document.querySelector('#settings');
    let modalSettingsStatus;

    settingsButton.addEventListener('click', function() {
        let modalSettingsMethods = {
            _modalSettingsOpen: function() {
                const mainBlock = document.querySelector('.main-block');
                
                modalSettings = document.createElement('div');
                modalSettings.classList.add('modal-window');
                modalSettings.insertAdjacentHTML('afterbegin', `
                    <div class="modal-body">
                    <section class="modal-head">
                        <h2>Настройки</h2>
                        <span class="close">&times;</span>
                    </section>
                    <hr>
                    <section class="modal-content">
                        <form action="#" method="post" id="userUpdate">
                            <div class="info-row">
                                <div class="info-label"><label for="userEmail">Электронная почта:</label></div>
                                <input type="text" placeholder="Введите новую почту" id="userEmail" name="userEmail">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="userPassword">Пароль:</label></div>
                                <input type="text" placeholder="Введите новый пароль" id="userPassword" name="userPassword">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="userPhoto">Загрузить файл:</label></div>
                                <div class="info-label file"><label for="userPhoto">Выбрать файл</label></div>
                                <input type="file" id="userPhoto">
                            </div>
                            <div class="button-block">
                                <input type="submit" id="sendUpdates" name="sendUpdates" value="Отправить">
                                <button id="closeUpdates">Закрыть</button>
                            </div>
                        </form>
                    </section>
                    </div>
                `);

                document.body.appendChild(modalSettings);

                setTimeout(() => {
                    mainBlock.style.filter = "blur(1px)";
                    modalSettings.classList.add('open');
                }, 0);

                return [modalSettings, modalSettingsStatus = true];
            },
    
            _modalSettingsClose: function() {
                const mainBlock = document.querySelector('.main-block');
                const modalSettingsSpan = document.querySelector('.close');
                const modalSettingsOverlay = document.querySelector('.modal-window');
                const modalSettingsButton = document.querySelector('#closeUpdates')
                
                modalSettingsOverlay.onclick = function(event) {
                    if (event.target === modalSettingsOverlay) {
                        modalSettingsOverlay.classList.remove('open');
                        modalSettingsOverlay.classList.add('hiding');
                        setTimeout(() => {
                            mainBlock.style.filter = "";
                            modalSettingsOverlay.classList.remove('hiding');
                            modalSettingsOverlay.parentNode.removeChild(modalSettingsOverlay);
                        }, 200);
                    };
                };
    
                modalSettingsSpan.onclick = function() {
                    modalSettingsOverlay.classList.remove('open');
                    modalSettingsOverlay.classList.add('hiding');
                    setTimeout(() => {
                        mainBlock.style.filter = "";
                        modalSettingsOverlay.classList.remove('hiding');
                        modalSettingsOverlay.parentNode.removeChild(modalSettingsOverlay);
                    }, 200);
                };

                modalSettingsButton.onclick = function() {
                    modalSettingsOverlay.classList.remove('open');
                    modalSettingsOverlay.classList.add('hiding');
                    setTimeout(() => {
                        mainBlock.style.filter = "";
                        modalSettingsOverlay.classList.remove('hiding');
                        modalSettingsOverlay.parentNode.removeChild(modalSettingsOverlay);
                    }, 200);
                }
            },
        };
    
        modalSettingsMethods._modalSettingsOpen();
    
        if (modalSettingsStatus === true) {
            modalSettingsMethods._modalSettingsClose();
        };
    });
});