document.addEventListener('DOMContentLoaded', function() {
    const userBlock = document.querySelector('.user');

    userBlock.onmouseover = function() {
        userBlock.style.backgroundColor = "#464646";
    };

    userBlock.onmouseout = function() {
        userBlock.style.backgroundColor = "";
    };

    userBlock.addEventListener('click', function() {

        let actionModalMethods = {
            _actionModalOpen: function() {
                const actionModal = document.querySelector('.user-action-block');
                const mainBlockHeader = document.querySelector('.main-block-header');

                setTimeout(() => {
                    actionModal.classList.add("open");
                }, 0);

                mainBlockHeader.append(actionModal);
                return actionModal;
            },

            _actionModalClose: function() {
                document.addEventListener('click', function (event) {
                    const actionModal = document.querySelector('.user-action-block');
                    actionModal.classList.remove('open');
                });
            },
        };

        actionModalMethods._actionModalOpen();
        actionModalMethods._actionModalClose();

    });
});