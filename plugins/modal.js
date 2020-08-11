document.addEventListener('DOMContentLoaded', function() {
    let newAchievement = document.getElementById('addAchievement');

    newAchievement.addEventListener('click', function() {
        const modalMethods = {
            modalStatus: true,

            _createModal: function() {
                const modal = document.createElement('div');
        
                modal.classList.add('modal-window');
                modal.insertAdjacentHTML('afterbegin', `
                    <div class="modal-body">
                        <section class="modal-head">
                            <h2>Добавить работу</h2>
                            <span class="close">&times;</span>
                        </section>
                        <hr>
                        <section class="modal-content">
                            <form action="#" method="post">
                                <div class="info-row">
                                    <div class="info-label"><label for="achievement-section">Вид участия:</label></div>
                                    <select name="achievement-section" id="achievement-section">
                                        <option value="OlympAchievement">Олимпиада</option>
                                        <option value="OlympAchievement">Олимпиада</option>
                                    </select>
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><label for="achievement-name">Наименование:</label></div>
                                    <input type="text" placeholder="Введите наименование награды" id="achievement-name" name="achievement-name">
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><label for="achievement-place">Место:</label></div>
                                    <input type="text" placeholder="Введите полученное место" id="achievement-place" name="achievement-place">
                                </div>
                                <div class="info-row">
                                    <div class="info-label"><label for="achievement-date">Дата:</label></div>
                                    <input type="text" placeholder="Введите дату получения" id="achievement-date" name="achievement-date">
                                </div>
                                <div class="button-block">
                                    <button type="submit" id="send-achievement">Отправить</button>
                                </div>
                            </form>
                        </section>
                    </div>
                `)

                modalStatus = true;

                document.body.appendChild(modal);
                return [modal, modalStatus];
            },

            _showModal: function(modalMethods, _createModal, modal) {
                modal.classList.add('open');
            },

            _destroyModal: function(_createModal) {

            }
        };
        
        modalMethods._createModal();
        
        if (modalStatus == true) {
            modalMethods._showModal();
        }
    })
})