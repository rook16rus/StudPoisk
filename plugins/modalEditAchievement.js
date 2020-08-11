document.addEventListener('DOMContentLoaded', function() {
    let doc = document.querySelectorAll('.doc');

    for (let i = 0; i < doc.length; i++) {

        doc[i].onclick = function() {
            
            let modalEditMedoths = {
                
                _createEditModal: function() {
                    const mainBlock = document.querySelector('.main-block');
                    let modalEdit = document.createElement('div');

                    modalEdit.classList.add('modal-window');
                    modalEdit.insertAdjacentHTML('afterbegin', `
                        <div class="modal-body">
                            <section class="modal-head">
                                <h2>Редактирование работы</h2>
                                <span class="close">&times;</span>
                            </section>
                            <hr>
                            <section class="modal-content">
                                <form action="#" method="post" id="addAchievement">
                                    <div class="info-row">
                                <div class="info-label"><label for="achievementSection">Вид участия:</label></div>
                                <select name="achievementSection" id="achievementSection">
                                    <option value="OlympAchievement">Олимпиада</option>
                                    <option value="OlympAchievement">Олимпиада</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="achievementName">Наименование:</label></div>
                                <input type="text" placeholder="Введите наименование награды" id="achievementName" name="achievementName">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="achievement-step">Степень:</label></div>
                                <select name="achievement-step" id="achievement-step">
                                    <option value="ThankYouNote">Благодарственное письмо</option>
                                    <option value="Certificate">Сертификат об участии</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="achievement-place">Место:</label></div>
                                <select name="achievement-place" id="achievement-place">
                                    <option value="1stPlace">1 место</option>
                                    <option value="2ndPlace">2 место</option>
                                </select>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="achievement-date">Дата:</label></div>
                                <input type="text" placeholder="Введите дату получения" id="achievement-date" name="achievement-date">
                            </div>
                            <div class="info-row">
                                <div class="info-label"><label for="achievementFile">Загрузить файл:</label></div>
                                <div class="info-label file"><label for="achievementFile">Выбрать файл</label></div>
                                <input type="file" id="achievementFile">
                            </div>
                            <div class="button-block">
                                <input type="submit" id="editAchievement" name="editAchievement" value="Отправить">
                                <button id="closeAchievement">Закрыть</button>
                            </div>
                                </form>
                            </section>
                            </div>
                    `);

                    document.body.appendChild(modalEdit);

                    setTimeout(() => {
                        mainBlock.style.filter = "blur(1px)";
                        modalEdit.classList.add('open');
                    }, 0);

                    modalEditStatus = true;
                    return modalEdit;
                },

                _destroyEditModal: function() {
                    const modalEditOverlay = document.querySelector('.modal-window');
                    const modalEditSpan = document.querySelector('.close');
                    const modalEditButton = document.querySelector('#closeAchievement');
                    const mainBlock = document.querySelector('.main-block');

                    modalEditOverlay.onclick = function(event) {
                        if (event.target === modalEditOverlay) {
                            modalEditOverlay.classList.remove('open');
                            modalEditOverlay.classList.add('hiding');
                            
                            setTimeout(() => {
                                mainBlock.style.filter = "none";
                                modalEditOverlay.classList.remove('hiding');
                                modalEditOverlay.parentNode.removeChild(modalEditOverlay);
                            }, 200);
                        };
                    };

                    modalEditSpan.onclick = function() {
                        modalEditOverlay.classList.remove('open');
                        modalEditOverlay.classList.add('hiding');

                        setTimeout(() => {
                            mainBlock.style.filter = "none";
                            modalEditOverlay.classList.remove('hiding');
                            modalEditOverlay.parentNode.removeChild(modalEditOverlay);
                        }, 200);
                    };

                    modalEditButton.onclick = function() {
                        modalEditOverlay.classList.remove('open');
                        modalEditOverlay.classList.add('hiding');

                        setTimeout(() => {
                            mainBlock.style.filter = "none";
                            modalEditOverlay.classList.remove('hiding');
                            modalEditOverlay.parentNode.removeChild(modalEditOverlay);
                        }, 200);
                    };
                },

            };

            modalEditMedoths._createEditModal();
            modalEditMedoths._destroyEditModal();

        };
    };
})