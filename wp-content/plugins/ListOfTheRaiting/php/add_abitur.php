<?php
include_once '../connect.php';

//Добавление абитуриента, при нажатие кнопки на форме

if(!empty($_POST))
{
    $result=$wpdb->dbh->query("SELECT * FROM `lotr_enrollee` WHERE `fio`='{$_POST['fio']}'");

    if($result->num_rows===0)
    {
        $result=$wpdb->dbh->query("INSERT INTO `lotr_enrollee`(`id`, `fio`, `date`, `number`, `original`, `id_specialty`,`age_speciality`)
                            VALUES (NULL,'{$_POST['fio']}','{$_POST['date']}',NULL,'{$_POST['original']}','{$_POST['id_specialty']}','{$_POST['age_specialty']}')");
        echo json_encode($wpdb->dbh->insert_id);
    }
    else
    {
        echo json_encode(false);
    }
}

?>