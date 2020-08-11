<?php
session_start();
require_once 'dbconnect.php';
require_once 'header.php';

    /* ================== Блок настроек ================== */
    

    if (isset($_POST['send-updates'])) {
            $login_change = htmlspecialchars($_POST['user-email']);
            $password_change = htmlspecialchars($_POST['user-password']);
            if (!empty($login_change)) {
                $update_login = mysqli_query($mysqli, "UPDATE users SET user_login = '$login_change' WHERE user_login = '$session_name'");
                session_unset();
                header("Location: index.php");
            }
        
            if (!empty(htmlspecialchars($_POST['user-photo']))) {
                $photo_change = htmlspecialchars($_POST['user-photo']);
                $update_photo = mysqli_query($mysqli, "UPDATE users SET student_photo = '$photo_change' WHERE user_login = '$session_name'");
                }

            if (!empty($password_change)) {
                $update_password = mysqli_query($mysqli, "UPDATE users SET user_password = '$password_change' WHERE user_login = '$session_name'");
            }

    }

    /* ================== Блок добавления достижения ================== */

    if (isset($_POST['send-add-button-achievement'])) {
        if (!empty($_POST['add-achievement-section']) && !empty($_POST['add-achievement-name']) && !empty($_POST['add-achievement-step']) && !empty($_POST['add-achievement-place']) && !empty($_POST['add-achievement-date']) && !empty($_FILES['add-achievement-file']['tmp_name'])) {
            
            $achievement_type = htmlspecialchars($_POST['add-achievement-section']);
            $achievement_name = htmlspecialchars($_POST['add-achievement-name']);
            $achievement_step = htmlspecialchars($_POST['add-achievement-step']);
            $achievement_place = htmlspecialchars($_POST['add-achievement-place']);
            $achievement_date = htmlspecialchars($_POST['add-achievement-date']);

            $img_type = substr($_FILES['add-achievement-file']['type'], 0, 5);
            $img_size = 2*1024*1024;

            $achievement_photo = addslashes(file_get_contents($_FILES['add-achievement-file']['tmp_name']));
                   
            

            $sql = "INSERT INTO achievements (user_id, type, achievement_name, level, place, achievement_date, achievement_photo) VALUES ('$session_id', '$achievement_type', '$achievement_name', '$achievement_step', '$achievement_place', '$achievement_date', '$achievement_photo')";
            $result = mysqli_query($mysqli, $sql);

        }
    }


    /* ================== Блок вывода достижений ================== */

    //Олимпиады
    $olympiad_query = "SELECT * FROM achievements WHERE user_id = $session_id AND type = 'Олимпиада' ORDER BY achievement_id DESC";
    $olympiads = mysqli_query($mysqli, $olympiad_query);

    //Конференции
    $conference_query = "SELECT * FROM achievements WHERE user_id = $session_id AND type = 'Конференция' ORDER BY achievement_id DESC";
    $conferences = mysqli_query($mysqli, $conference_query);

    //Конкурсы
    $contest_query = "SELECT * FROM achievements WHERE user_id = $session_id AND type = 'Конкурс' ORDER BY achievement_id DESC";
    $contests = mysqli_query($mysqli, $contest_query);

    //Проектные деятельности
    $project_query = "SELECT * FROM achievements WHERE user_id = $session_id AND type = 'Проектная деятельность' ORDER BY achievement_id DESC";
    $projects = mysqli_query($mysqli, $project_query);

    //Все вместе
    $achievements_query = "SELECT * FROM achievements";
    $achievements_all = mysqli_query($mysqli, $achievements_query);

    /* ================== Блок редактирования достижения ================== */

    foreach ($olympiads as $olympiad) {
        $name_edit = "edit" . "$olympiad[achievement_id]";
        $olympiad_id = $olympiad[achievement_id];
        if (isset($_POST[$name_edit])) {
            exit;
            if (isset($_POST['send-edit-button-achievement'])) {
                if (!empty($_POST['edit-achievement-section']) && !empty($_POST['edit-achievement-name']) && !empty($_POST['edit-achievement-step']) && !empty($_POST['edit-achievement-place']) && !empty($_POST['edit-achievement-date']) && !empty($_FILES['edit-achievement-file']['tmp_name'])) {
                    
                        $achievement_type = htmlspecialchars($_POST['edit-achievement-section']);
                        $achievement_name = htmlspecialchars($_POST['edit-achievement-name']);
                        $achievement_step = htmlspecialchars($_POST['edit-achievement-step']);
                        $achievement_place = htmlspecialchars($_POST['edit-achievement-place']);
                        $achievement_date = htmlspecialchars($_POST['edit-achievement-date']);

                        $img_type = substr($_FILES['edit-achievement-file']['type'], 0, 5);
                        $img_size = 2*1024*1024;

                        $achievement_photo = addslashes(file_get_contents($_FILES['edit-achievement-file']['tmp_name']));

                        $sql = "UPDATE achievements SET type = '$achievement_type', achievement_name = '$achievement_name', level = '$achievement_step', place = '$achievement_place', achievement_date = '$achievement_date', achievement_photo = '$achievement_photo' WHERE user_id = '$session_id' AND achievement_id = '$olympiad_id'";
                        $result = mysqli_query($mysqli, $sql);
                        $olympiads = mysqli_query($mysqli, $olympiad_query);
                }
            }
        }
    }

    /* ================== Удаление достижений ================== */

    // Олимпиады
    foreach ($olympiads as $olympiad) {
        $name_delete = "delete" . "$olympiad[achievement_id]";
        $olympiad_id = $olympiad[achievement_id];
        if (isset($_POST[$name_delete])) {
            $delete_query = "DELETE FROM achievements WHERE achievement_id = '$olympiad_id'";
            $result = mysqli_query($mysqli, $delete_query);
            $olympiads = mysqli_query($mysqli, $olympiad_query);
        }
    }

    // Конференции
    foreach ($conferences as $conference) {
        $name_delete = "delete" . "$conference[achievement_id]";
        $conference_id = $conference[achievement_id];
        if (isset($_POST[$name_delete])) {
            $delete_query = "DELETE FROM achievements WHERE achievement_id = '$conference_id'";
            $result = mysqli_query($mysqli, $delete_query);
            $conferences = mysqli_query($mysqli, $conference_query);
        }
    }

    // Конкурсы
    foreach ($contests as $contest) {
        $name_delete = "delete" . "$contest[achievement_id]";
        $contest_id = $contest[achievement_id];
        if (isset($_POST[$name_delete])) {
            $delete_query = "DELETE FROM achievements WHERE achievement_id = '$contest_id'";
            $result = mysqli_query($mysqli, $delete_query);
            $contests = mysqli_query($mysqli, $contest_query);
        }
    }

    // Проектные деятельности
    foreach ($projects as $project) {
        $name_delete = "delete" . "$project[achievement_id]";
        $project_id = $project[achievement_id];
        if (isset($_POST[$name_delete])) {
            $delete_query = "DELETE FROM achievements WHERE achievement_id = '$project_id'";
            $result = mysqli_query($mysqli, $delete_query);
            $projects = mysqli_query($mysqli, $project_query);
        }
    }

?>

    <div class="modal-window" id="add-achievement-modal">
    <div class="modal-body">
        <section class="modal-head">
            <h2>Добавить работу</h2>
            <span class="close" id="close-add-span-achievement">&times;</span>
        </section>
        <hr>
        <section class="modal-content">
            <form method="post" id="addAchievement" autocomplete="off" enctype="multipart/form-data">
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-section">Вид участия:</label></div>
                    <select name="add-achievement-section" id="add-achievement-section">
                        <option value="Олимпиада">Олимпиада</option>
                        <option value="Конференция">Конференция</option>
                        <option value="Конкурс">Конкурс</option>
                        <option value="Проектная деятельность">Проектная деятельность</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-name">Наименование:</label></div>
                    <input type="text" placeholder="Введите наименование награды" id="add-achievement-name" name="add-achievement-name">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-step">Степень:</label></div>
                    <select name="add-achievement-step" id="add-achievement-step">
                        <option value="Благодарственное письмо">Благодарственное письмо</option>
                        <option value="Сертификат об участии">Сертификат об участии</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-place">Место:</label></div>
                    <select name="add-achievement-place" id="add-achievement-place">
                        <option value="1 место">1 место</option>
                        <option value="2 место">2 место</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-date">Дата:</label></div>
                    <input type="date" placeholder="Введите дату получения" id="add-achievement-date" name="add-achievement-date" value="2016-01-01" min="2016-01-01" max="">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="add-achievement-file">Загрузить файл:</label></div>
                    <div class="info-label file"><label for="add-achievement-file" id="change-label-text">Выбрать файл</label></div>
                    <input type="file" id="add-achievement-file" name="add-achievement-file">
                </div>
                <div class="info-row" id="add-output-image"></div>
                <div class="button-block">
                    <input type="submit" name="send-add-button-achievement"  value="Отправить">
                    <button id="close-add-button-achievement">Закрыть</button>
                </div>
            </form>
        </section>
    </div>
</div>

<div class="modal-window" id="edit-achievement-modal">
    <div class="modal-body">
        <section class="modal-head">
            <h2>Редактирование работы</h2>
            <span class="close" id="close-edit-span-achievement">&times;</span>
        </section>
        <hr>
        <section class="modal-content">
            <form method="post" id="addAchievement" autocomplete="off" enctype="multipart/form-data">
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-section">Вид участия:</label></div>
                    <select name="add-achievement-section" id="edit-achievement-section">
                        <option value="OlympAchievement">Олимпиада</option>
                        <option value="OlympAchievement">Олима</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-name">Наименование:</label></div>
                    <input type="text" placeholder="Введите наименование награды" id="edit-achievement-name" name="edit-achievement-name">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-step">Степень:</label></div>
                    <select name="edit-achievement-step" id="edit-achievement-step">
                        <option value="ThankYouNote">Благодарственное письмо</option>
                        <option value="Certificate">Сертификат об участии</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-place">Место:</label></div>
                    <select name="edit-achievement-place" id="edit-achievement-place">
                        <option value="1stPlace">1 место</option>
                        <option value="2ndPlace">2 место</option>
                    </select>
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-date">Дата:</label></div>
                    <input type="date" placeholder="Введите дату получения" id="edit-achievement-date" name="edit-achievement-date" value="2016-01-01" min="2016-01-01" max="">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="edit-achievement-file">Загрузить файл:</label></div>
                    <div class="info-label file"><label for="edit-achievement-file" id="change-edit-label-text">Выбрать файл</label></div>
                    <input type="file" id="edit-achievement-file" name="achievement-file">
                </div>
                <div class="info-row" id="edit-output-image"></div>
                <div class="button-block">
                    <input type="submit" name="send-edit-button-achievement" id="send-edit-button-achievement">
                    <button id="close-edit-button-achievement">Закрыть</button>
                </div>
            </form>
        </section>
    </div>
</div>

<div class="modal-window" id="settings-modal">
    <div class="modal-body">
        <section class="modal-head">
            <h2>Настройки</h2>
            <span class="settings-close-span">&times;</span>
        </section>
        <hr>
        <section class="modal-content">
            <form action="#" method="post" id="user-update" autocomplete="off">
                <div class="info-row">
                    <div class="info-label"><label for="user-email">Электронная почта:</label></div>
                    <input type="text" placeholder="Введите новую почту" id="user-email" name="user-email">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="user-password">Пароль:</label></div>
                    <input type="text" placeholder="Введите новый пароль" id="user-password" name="user-password">
                </div>
                <div class="info-row">
                    <div class="info-label"><label for="user-photo">Загрузить файл:</label></div>
                    <div class="info-label file"><label for="user-photo" id="change-setting-label">Выбрать файл</label></div>
                    <input type="file" id="user-photo" name="user-photo">
                </div>
                <div class="info-row" id="setting-output-image"></div>
                <div class="button-block">
                    <button type="submit" id="send-updates">Отправить</button>
                    <button id="close-updates">Закрыть</button>
                </div>
            </form>
        </section>
    </div>
</div>
    <div class="top-scroll" id="scroll-top">Наверх</div>
    <main>
        <div class="main-block">
            <section class="lite-column">
                <div class="lite-column-block">
                    <div class="student-photo">
                        <img src="data:image/jpeg;base64, <?php  $photo = base64_encode($profile['student_photo']); echo $photo; ?>" alt="student-photo">
                    </div>
                    <div class="button-block">
                        <button id="add-achievement-button" name="add-achievement-button" type="submit">Добавить работу</button>
                    </div>
                </div>
            </section>
            <section class="info-column">
                <div class="student-info">
                    <?php foreach ($profiles as $profile): ?>
                    <div class="info-row">
                        <div class="label">
                            Фамилия:
                        </div>
                        <div class="first-name labeled" id="first-name-label">
                            <?php echo $profile['lastname']; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Имя:
                        </div>
                        <div class="name labeled" id="name-label">
                            <?php echo $profile['name']; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Отчество:
                        </div>
                        <div class="last-name labeled" id="last-name-label">
                            <?php echo $profile['patronymic']; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Дата рождения:
                        </div>
                        <div class="birth-date labeled" id="birth-date-label">
                            <?php 
                            $date_of_birth = date_create($profile['date_of_birth']);
                            echo date_format($date_of_birth, 'd-m-Y'); 
                            ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Специальность/Профессия:
                        </div>
                        <div class="speciality labeled" id="speciality-label">
                            <?php echo $profile['profession']; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Группа:
                        </div>
                        <div class="group-number labeled" id="group-number-label">
                            <?php echo $profile['students_group']; ?>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">
                            Курс:
                        </div>
                        <div class="course-number labeled" id="course-number-label">
                            <?php echo $profile['course']; ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php if (mysqli_num_rows($achievements_all) == 0) {
                    echo "
                    <div class='no-work'>
                        <img src='images/icons/Docs.png' alt='docs.png'>
                    </div>
                    ";
                }
                ?>
                <?php if (mysqli_num_rows($olympiads) > 0): ?>
                <div class="student-achievements">
                    <h2>Участие в олимпиадах</h2>
                    <div class="docs-block" id="olympic-achievements">
                        <?php foreach ($olympiads as $olympiad): ?>
                        <div class="doc">
                            <img src="data:image/jpeg;base64, <?php  $photo_olympiad = base64_encode($olympiad[achievement_photo]); echo $photo_olympiad; ?>" alt="achievement-photo" width="108px" height="120px">
                            <form class="annotation annotation-form" method="post" id="annotation">
                                <input class="annotation annotation-btn" type="button" title="<?php  echo $olympiad[achievement_name]; ?>" id="<?php $name = "edit" . "$olympiad[achievement_id]"; echo $name; ?>" name='<?php $name = "edit" . "$olympiad[achievement_id]"; echo $name; ?>' value="">
                                    <button type="submit" class="delete-work" name='<?php $name = "delete" . "$olympiad[achievement_id]"; echo $name; ?>'>&times;</button>
                                
                                    <div class="place"><?php echo "$olympiad[place]" ?></div>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (mysqli_num_rows($conferences) > 0): ?>
                <div class="student-achievements">
                    <h2>Участие в конференциях</h2>
                    <div class="docs-block" id="olympic-achievements">
                        <?php foreach ($conferences as $conference): ?>
                        <div class="doc">
                            <img src="data:image/jpeg;base64, <?php  $photo_conference = base64_encode($conference[achievement_photo]); echo $photo_conference; ?>" alt="achievement-photo" width="108px" height="120px">
                            <form class="annotation annotation-form" method="post" id="annotation">
                                <input class="annotation annotation-btn" type="submit" id="annotation-btn" name='<?php $name = "edit" . "$conference[achievement_id]"; echo $name; ?>' value="">
                                    <button type="submit" class="delete-work" name='<?php $name = "delete" . "$conference[achievement_id]"; echo $name; ?>'>&times;</button>
                                
                                    <div class="place"><?php echo "$conference[place]" ?></div>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                 <?php if (mysqli_num_rows($contests) > 0): ?>
                <div class="student-achievements">
                    <h2>Участие в конкурсах</h2>
                    <div class="docs-block" id="olympic-achievements">
                        <?php foreach ($contests as $contest): ?>
                        <div class="doc">
                            <img src="data:image/jpeg;base64, <?php  $photo_contest = base64_encode($contest[achievement_photo]); echo $photo_contest; ?>" alt="achievement-photo" width="108px" height="120px">
                            <form class="annotation annotation-form" method="post" id="annotation">
                                <input class="annotation annotation-btn" type="submit" id="annotation-btn" name='<?php $name = "edit" . "$contest[achievement_id]"; echo $name; ?>' value="">
                                    <button type="submit" class="delete-work" name='<?php $name = "delete" . "$contest[achievement_id]"; echo $name; ?>'>&times;</button>
                                
                                    <div class="place"><?php echo "$contest[place]" ?></div>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                 <?php if (mysqli_num_rows($projects) > 0): ?>
                <div class="student-achievements">
                    <h2>Участие в проектной деятельности</h2>
                    <div class="docs-block" id="olympic-achievements">
                        <?php foreach ($projects as $project): ?>
                        <div class="doc">
                            <img src="data:image/jpeg;base64, <?php  $photo_project = base64_encode($project[achievement_photo]); echo $photo_project; ?>" alt="achievement-photo" width="108px" height="120px">
                            <form class="annotation annotation-form" method="post" id="annotation">
                                <input class="annotation annotation-btn" type="submit" id="annotation-btn" name='<?php $name = "edit" . "$project[achievement_id]"; echo $name; ?>' value="">
                                    <button type="submit" class="delete-work" name='<?php $name = "delete" . "$project[achievement_id]"; echo $name; ?>'>&times;</button>
                                
                                    <div class="place"><?php echo "$project[place]" ?></div>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <footer>
        <div class="main-block-footer">
            Copyright 2020
        </div>
    </footer>
    <script src="plugins/scrollTop.js"></script>
    <script src="noSubmit.js"></script>
</body>
</html>