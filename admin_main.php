<?php
session_start();
require_once 'dbconnect.php';
require_once 'admin_header.php';

if(empty($_SESSION["session_username"])){
    // вывод "Session is set"; // в целях проверки
    header("Location: index.php");
    }
/* ================== Вывод студентов ================== */


if(isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$studentsOnPage = 2;
$from = ($page - 1) * $studentsOnPage;
$query = "SELECT * FROM users WHERE is_admin = 0 ORDER BY lastname LIMIT $studentsOnPage OFFSET $from";
$students = mysqli_query($mysqli, $query);
$query = "SELECT COUNT(*) as count FROM users WHERE is_admin = 0";
$res = mysqli_query($mysqli, $query);
$count = mysqli_fetch_assoc($res)['count'];
$pagesCount = ceil($count / $studentsOnPage);
if ( $page > $pagesCount ) $page = $pagesCount;

/* ================== ФИЛЬТР ПОИСКА СТУДЕНТА ================== */

$student_filter = mysqli_fetch_all($_POST, MYSQLI_ASSOC);

/* ================== Удаление студента ================== */

foreach ($students as $student) {
    $name = "delete" . $student[user_id];
    $student_id = $student[user_id];
    if (isset($_POST[$name])) {
        $del_query = "DELETE FROM users WHERE user_id = $student_id";
        $res = mysqli_query($mysqli, $del_query);
        $students = mysqli_query($mysqli, $query);
    }
}



    


?>


    <main>
        <div class="main-block">
            <section class="table">
                <table>
                        <tr>
                            <th>id</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Специальность/Профессия</th>
                            <th>Дата рождения</th>
                            <th>Курс</th>
                            <th>Группа</th>
                            <th></th>
                        </tr>
                <?php foreach ($students as $row): ?>
                    <?php if(!isset($_POST['filter-sub'])): ?>
                        <?php
                        $row[date_of_birth] = date_create($row[date_of_birth]);
                        $row[date_of_birth] = date_format($row[date_of_birth], 'd-m-Y');
                        $name = "delete";
                        ?>
                        <tr>
                            <td><?=$row[user_id]?></td>
                            <td><?=$row[lastname]?></td>
                            <td><?=$row[name]?></td>
                            <td><?=$row[patronymic]?></td>
                            <td><?=$row[profession]?></td>
                            <td><?=$row[date_of_birth]?></td>
                            <td><?=$row[course]?></td>
                            <td><?=$row[students_group]?></td>
                            <td><form method="post"><input type='submit' class="del-btn" name='<?php $name .= $row[user_id]; echo $name; ?>' value='x'></form></td>
                        </tr>
                    <?php elseif (isset($_POST['filter-sub'])): ?>
                       <?php if ((($_POST['lastname'] == $row['lastname']  || $_POST['name'] == $row['name']  || $_POST['patronymic'] == $row['patronymic'] || $_POST['profession'] == $row['profession'] || $_POST['students-group'] == $row['students_group'] || $_POST['min-age'] <= $row['age'] && $_POST['max-age'] >= $row['age']) && $_POST['course'] == $row['course'])): ?> 
                            <tr>
                                <td><?=$row[user_id]?></td>
                                <td><?=$row[lastname]?></td>
                                <td><?=$row[name]?></td>
                                <td><?=$row[patronymic]?></td>
                                <td><?=$row[profession]?></td>
                                <td><?=$row[date_of_birth]?></td>
                                <td><?=$row[course]?></td>
                                <td><?=$row[students_group]?></td>
                                <td><form method="post"><input type='submit' class="del-btn" name='<?php $name .= $row[user_id]; echo $name; ?>' value='x'></form></td>
                            </tr>
                        <? endif; ?>
                    <? endif ?>
                <?php endforeach ?>
                </table>
                <div class="pages">
                    <?php
                    if ( $pagesCount > 1 )
                    {
                        // Проверяем нужна ли стрелка "В начало"
                        if ( $page > 3 )
                            $startpage = '<a href="'.$_SERVER['PHP_SELF'].'?page=1"><<</a> ';
                        else
                            $startpage = '';
                        // Проверяем, нужна ли стрелка "В конец"
                        if ( $page < ($pagesCount - 2) )
                            $endpage = ' <a href="'.$_SERVER['PHP_SELF'].'?page='.$pagesCount.'">>></a>';
                        else
                            $endpage = '';

                        // Находим две ближайшие страницы с обоих краев, если они есть
                        if ( $page - 2 > 0 )
                            $page2left = ' <a href="'.$_SERVER['PHP_SELF'].'?page='.($page - 2).'">'.($page - 2).'</a>';
                        else
                            $page2left = '';
                        if ( $page - 1 > 0 )
                            $page1left = ' <a href="'.$_SERVER['PHP_SELF'].'?page='.($page - 1).'">'.($page - 1).'</a>';
                        else
                            $page1left = '';
                        if ( $page + 2 <= $pagesCount )
                            $page2right = ' <a href="'.$_SERVER['PHP_SELF'].'?page='.($page + 2).'">'.($page + 2).'</a>';
                        else
                            $page2right = '';
                        if ( $page + 1 <= $pagesCount )
                            $page1right = ' <a href="'.$_SERVER['PHP_SELF'].'?page='.($page + 1).'">'.($page + 1).'</a>';
                        else
                            $page1right = '';
                        $page = " <a class='active-page'>$page</a>";
                        // Выводим меню
                        echo $startpage.$page2left.$page1left.'<strong>'.$page.'</strong>'.$page1right.$page2right.$endpage;
                    }

                    ?>
                </div>
            </section>
            <section class="student-filter">
                <form action="#" method="post">
                    <div class="filter_row">
                        <div class="block-row">
                            <label for="first-name">Фамилия</label>
                        </div>
                        <input type="text" id="first-name" name="lastname" placeholder="Введите запрос">
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            <label for="name">Имя</label>
                        </div>
                        <input type="text" id="name" name="name" placeholder="Введите запрос">
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            <label for="last-name">Отчество</label>
                        </div>
                        <input type="text" id="last-name" name="patronymic" placeholder="Введите запрос">
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            Возраст
                        </div>
                        <input type="text" id="min-age" name="min-age" placeholder="Введите запрос `от`">
                        <input type="text" id="max-age" name="max-age" placeholder="Введите запрос `до`">
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            <label for="profession">Специальность/Профессия</label>
                        </div>
                        <input type="text" id="profession" name="profession" placeholder="Введите запрос">
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            <label for="course">Курс</label>
                        </div>
                        <select name="course" id="course" name="course">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="filter_row">
                        <div class="block-row">
                            <label for="students-group">Группа</label>
                        </div>
                        <input type="text" id="students-group" name="students-group" placeholder="Введите запрос">
                    </div>

                    <div class="button-block">
                        <input type="submit" name="filter-sub">
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
</body>
</html>