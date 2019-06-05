<?php
include_once '../connect.php';

//Получение данных всех абитуриентов и вывод их в json формате

//P.S в переменную $vivod, я добавляю данные при запросах, и отправляю данные на сайт в json формате


//беру данные их таблиц учеников а так же данные их оценок
$result = $wpdb->dbh->query("SELECT `lotr_enrollee`.`id` AS 'id_enrolle',`lotr_enrollee`.`number`
                                                    AS 'number_enrolle',`fio`,`date`,`original`,`id_specialty`,`age_speciality`,lotr_specialty.`number`
                                                    FROM `lotr_enrollee` 
                                                    INNER JOIN lotr_specialty ON (lotr_enrollee.id_specialty=lotr_specialty.id)");


if($result->num_rows > 0)
{
    $vivod=[];
    while ($po = $result->fetch_assoc())
    {


        $sql_lesson="SELECT * FROM `lotr_lesson_name`";
        $result_lesson = $wpdb->dbh->query($sql_lesson);


        $grades=[];
        while ($po_lesson=$result_lesson->fetch_assoc())
        {
            $sql = "SELECT * FROM `lotr_grade` WHERE `id_enrollee`={$po['id_enrolle']} AND `id_lesson`={$po_lesson['id']}";
            $result_grade = $wpdb->dbh->query($sql);



            if($result_grade->num_rows>0)
            {
                while ($po_grade=$result_grade->fetch_assoc())
                {
                    array_push($grades,$po_grade['grade']);
                }
            }
            else
            {
                array_push($grades,'-');
            }
        }




        $sql_avg="SELECT AVG (lotr_grade.grade) AS 'avg' FROM `lotr_grade`  
                    WHERE `id_enrollee`='{$po['id_enrolle']}' GROUP BY (lotr_grade.`id_enrollee`)";// Взятие средних данных оценок

        $result_avg=$wpdb->dbh->query($sql_avg);



        if($result_avg->num_rows>0)
        {
            $po_avg=$result_avg->fetch_assoc();

            $avg=substr($po_avg['avg'],0,4);


        }





        array_push($vivod,[[
            $po['fio'],
            $po['date'],
            $po['number'],
            $po['age_speciality'],
            $po['original'],

        ],$grades,$avg,$po['id_enrolle']]);

    }
}

echo json_encode($vivod,256 | 64);
?>
