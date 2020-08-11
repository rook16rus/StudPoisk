<?php

	$img_type = substr($_FILES['student_image']['type'], 0, 5);
    $img_size = 2*1024*1024;
    echo "PRIVET";
    exit;
            
    if(!empty($_FILES['student_image']['tmp_name'] && $img_type == 'image' && $img_size <= $FILES['student_image']['size'])) {
       	$photo = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));
        mysqli_query($mysqli, "INSERT INTO users (student_photo) VALUES ('$photo')");
        echo "PRIVET";
        exit;
    }

?>