<?php
include_once '../connect.php';
include dirname(__FILE__).'\excel\PHPExcel.php';


if(!empty($_FILES))
{
//    print_r(dirname(__FILE__).'\excel\files_excel\\'.$_FILES['file']['name']);

    move_uploaded_file($_FILES['file']['tmp_name'],dirname(__FILE__).'\excel\files_excel\\'.$_FILES['file']['name']);



    $filename= dirname(__FILE__).'\excel\files_excel\\'.$_FILES['file']['name'];


    $file_type = PHPExcel_IOFactory::identify( $filename );
    // создаем объект для чтения
    $objReader = PHPExcel_IOFactory::createReader( $file_type );
    $objPHPExcel = $objReader->load( $filename ); // загружаем данные файла в объект
    $result = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив



    //print_r($wpdb->dbh);
    for ($i=6;$i<count($result[0])-2;$i++)
    {
//
        $sql="SELECT * FROM `lotr_lesson_name` WHERE `lesson_name`='{$result[0][$i]}'";
        $result_lesson=$wpdb->dbh->query($sql);

        if($result_lesson->num_rows===0)
        {
            $sql="INSERT INTO `lotr_lesson_name`(`lesson_name`) VALUES ('{$result[0][$i]}')";
            $wpdb->dbh->query($sql);
        }
    }


//    print_r($result);


    $error=[];
    for ($j=1;$j<count($result);$j++)
    {
        $sql="SELECT * FROM `lotr_enrollee` WHERE `fio`='{$result[$j][1]}'";
        $result_entrolle=$wpdb->dbh->query($sql);
        if($result_entrolle->num_rows===0)
        {
            $sql="SELECT * FROM `lotr_specialty` WHERE `number`='{$result[$j][4]}' AND `age` LIKE '%{$result[$j][5]}%'";
            $result_speciality=$wpdb->dbh->query($sql);
            if($result_speciality->num_rows>0)
            {

                $po=$result_speciality->fetch_assoc();

                $date_abitur=date('Y-m-d',strtotime($result[$j][2]));

                $sql="INSERT INTO `lotr_enrollee`(`id`, `fio`, `date`, `number`, `original`, `id_specialty`, `age_speciality`) 
                VALUES (NULL,'{$result[$j][1]}','$date_abitur','{$result[$j][0]}','{$result[$j][3]}','{$po['id']}','{$result[$j][5]}')";

                $wpdb->dbh->query($sql);

                $id=$wpdb->dbh->insert_id;


                for ($lesson=6;$lesson<count($result[$j])-1;$lesson++)
                {
                    $sql="SELECT * FROM `lotr_lesson_name` WHERE `lesson_name`='{$result[0][$lesson]}'";
                    $result_lesson_user=$wpdb->dbh->query($sql);
                    if($result_lesson_user->num_rows>0)
                    {
                        $po=$result_lesson_user->fetch_assoc();

                        $sql="INSERT INTO `lotr_grade`(`id`, `grade`, `id_lesson`, `id_enrollee`) 
                        VALUES (NULL,{$result[$j][$lesson]},{$po['id']},{$id})";

                        $wpdb->dbh->query($sql);

                    }
                }

            }
            else
            {
                $row_error=$j+1;
                array_push($error,['number'=>'Неверный номер специальности или класс в '.$row_error.' строке']);
            }


        }
        else
            {
            $row_error=$j+1;
            array_push($error,['fio'=>'Пользователь в '.$row_error.' строке  уже сществует']);
        }

    }
    print_r($result);
    if(!empty($error)){
        echo json_encode($error,256 | 64);
    }

//    unlink(dirname(__FILE__).'\excel\files_excel\\'.$_FILES['file']['name']);
}

?>
