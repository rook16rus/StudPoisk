document.addEventListener('DOMContentLoaded', function() {
    const newAchievement = document.getElementById('addAchievement');

    newAchievement.addEventListener('click', function() {

        let modalMethods = {

            _createModal: function() {
                let modal = document.createElement('div');
                const mainBlock = document.querySelector('.main-block');
                
                modal.classList.add('modal-window');
                modal.insertAdjacentHTML('afterbegin', `
                    <div class="modal-body">
                        <section class="modal-head">
                            <h2>Добавить работу</h2>
                            <span class="close">&times;</span>
                        </section>
                    <hr>
                    <section class="modal-content">
                        <form action="#" method="post" id="addAchievement" enctype="multipart/form-data">
                            <div class="info-row">
                                <div class="info-label"><label for="add-achievement-section">Вид участия:</label></div>
                                <select name="achievementSection" id="add-achievement-section">
                                    <option value="Олимпиада">Олимпиада</option>
                                    <option value="Конференция">Конференция</option>
                                    <option value="Конкурс">Конкурс</option>
                                    <option value="Проектная деятельность">Проектная деятельность</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="add-achievement-name">Наименование:</label></div>
                                <input type="text" placeholder="Введите наименование награды" id="add-achievement-name" name="achievementName">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="add-achievement-step">Степень:</label></div>
                                <select name="achievement-step" id="add-achievement-step">
                                    <option value="Благодарственное письмо">Благодарственное письмо</option>
                                    <option value="Сертификат об участии">Сертификат об участии</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="add-achievement-place">Место:</label></div>
                                <select name="achievement-place" id="add-achievement-place">
                                    <option value="1 место">1 место</option>
                                    <option value="2 место">2 место</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="add-achievement-date">Дата:</label></div>
                                <input type="text" placeholder="Введите дату получения" id="add-achievement-date" name="achievement-date">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="add_achievement_file">Загрузить файл:</label></div>
                                <div class="info-label file"><label for="add_achievement_file"  id="change-label-text">Выбрать файл</label></div>
                                <input type="file" id="add_achievement_file" name="add-achievement-file">
                            </div>
                            <div class="info-row" id="add-output-image"></div>
                            <div class="button-block">
                                <input type="submit" id="closeAchievement" name="sendAchievement" value="Отправить">
                                <button id="closeAchievement">Закрыть</button>
                            </div>
                        </form>
                    </section>
                    </div>
                `);


                document.body.appendChild(modal);

                setTimeout(() => {
                    modal.classList.add('open');
                    mainBlock.style.filter = "blur(1px)";
                }, 0);

                modalStatus = true;
                return modal;
            },

            _destroyModal: function() {
                modalOverlay = document.querySelector('.modal-window');
                modalSpanClose = document.querySelector('.close');
                modalButton = document.querySelector('#closeAchievement');
                mainBlock = document.querySelector('.main-block');
                
                modalOverlay.onclick = function(event) {
                    if (event.target === modalOverlay) {
                        modalOverlay.classList.remove('open');
                        modalOverlay.classList.add('hiding')

                        setTimeout(() => {
                            modalOverlay.classList.remove('hiding');
                            modalOverlay.parentNode.removeChild(modalOverlay);
                            mainBlock.style.filter = "none";
                        }, 200);
                    };
                };

                modalSpanClose.onclick = function() {
                    modalOverlay.classList.remove('open');
                    modalOverlay.classList.add('hiding')

                    setTimeout(() => {
                        modalOverlay.classList.remove('hiding');
                        modalOverlay.parentNode.removeChild(modalOverlay);
                        mainBlock.style.filter = "none";
                    }, 200);
                };

                modalButton.onclick = function() {
                    modalOverlay.classList.remove('open');
                    modalOverlay.classList.add('hiding')

                    setTimeout(() => {
                        modalOverlay.classList.remove('hiding');
                        modalOverlay.parentNode.removeChild(modalOverlay);
                        mainBlock.style.filter = "none";
                    }, 200);
                };

                function destroy() {
                    modalOverlay.classList.remove('open');
                    modalOverlay.classList.add('hiding')

                    setTimeout(() => {
                        modalOverlay.classList.remove('hiding');
                        modalOverlay.parentNode.removeChild(modalOverlay);
                        mainBlock.style.filter = "none";
                    }, 200);
                }
            }
        };

        modalMethods._createModal();
        modalMethods._destroyModal();

    });
});