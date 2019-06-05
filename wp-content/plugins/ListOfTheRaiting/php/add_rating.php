<?php
include_once '../connect.php';

// При пост запросе с передачей параметра массива оценок , пробегая через весь этот массив я добавляю данные в бд


if(!empty($_POST))
{
    foreach ($_POST['rating'] as $key=>$value)
    {
        $wpdb->dbh->query("INSERT INTO `lotr_grade`(`id`, `grade`, `id_lesson`, `id_enrollee`) 
                            VALUES (NULL,'{$_POST['rating'][$key]['val']}','{$_POST['rating'][$key]['id']}','{$_POST['id']}')");
    }
    echo json_encode(true);
}






?>