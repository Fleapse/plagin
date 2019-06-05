<?php
/**
 * @package ListOfTheRaiting
 * @version 1.0
 */
/*
Plugin Name: ListOfTheRaiting
Description: Плагин оценок, доступен по шорткоду [listoftheraiting]
Author: Pozdnyakov Nikita
Version: 1.0
*/ 

register_activation_hook("ListOfTheRaiting/index.php", 'myplugin_activate' );// Хук активации плагина
register_deactivation_hook("ListOfTheRaiting/index.php", 'myplugin_deactivate' );//  Хук де активации плагина
add_action( 'admin_menu', 'register_my_custom_menu_page' );//  Хук добавления в панель админа
add_shortcode('listoftheraiting', 'user_view');//Хук активации по шорткоду




//Функция активации плагина
function myplugin_activate()
{
	global $wpdb;
	//---------------------------------------------------------------
	$sql = "CREATE TABLE `lotr_specialty` (
		  `id` int(11) NOT NULL,
		  `count_place` text DEFAULT NULL,
		  `name` text DEFAULT NULL,
		  `number` text DEFAULT NULL,
		  `age` text DEFAULT NULL,
		  `duration` text DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"; 
	$wpdb->dbh->query($sql);

		$sql = "ALTER TABLE `lotr_specialty`
		  ADD PRIMARY KEY (`id`);
		"; 
	$wpdb->dbh->query($sql);

		$sql = "ALTER TABLE `lotr_specialty`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
		"; 
	$wpdb->dbh->query($sql);
	//---------------------------------------------------------------



	$sql = "CREATE TABLE `lotr_enrollee` (
		  `id` int(11) NOT NULL,
		  `fio` text DEFAULT NULL,
		  `date` date DEFAULT NULL,
		  `number` int(11) DEFAULT NULL,
		  `original` text DEFAULT NULL,
		  `id_specialty` int(11) DEFAULT NULL,
		  `age_speciality` text DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"; 
	$wpdb->dbh->query($sql);

	$sql = "CREATE TABLE `lotr_grade` (
		  `id` int(11) NOT NULL,
		  `grade` int(1) DEFAULT NULL,
		  `id_lesson` int(11) DEFAULT NULL,
		  `id_enrollee` int(11) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"; 
	$wpdb->dbh->query($sql);

	$sql = "CREATE TABLE `lotr_lesson_name` (
		  `id` int(11) NOT NULL,
		  `lesson_name` text DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_enrollee`
		  ADD PRIMARY KEY (`id`);
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_grade`
		  ADD PRIMARY KEY (`id`);
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_lesson_name`
		  ADD PRIMARY KEY (`id`);
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_enrollee`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_grade`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
		"; 
	$wpdb->dbh->query($sql);

	$sql = "ALTER TABLE `lotr_lesson_name`
		  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
		"; 
	$wpdb->dbh->query($sql);
}

//Функция де активации плагина
function myplugin_deactivate()
{
	global $wpdb;

	$sql = "DROP TABLE `lotr_enrollee`";
	$wpdb->dbh->query($sql);

	$sql = "DROP TABLE `lotr_grade`";
	$wpdb->dbh->query($sql);

	$sql = "DROP TABLE `lotr_lesson_name`";
	$wpdb->dbh->query($sql);

	$sql = "DROP TABLE `lotr_specialty`";
	$wpdb->dbh->query($sql);
}


//Функция добавления по хуку в админ панель
function register_my_custom_menu_page()
{
	add_menu_page(
		'Аттестаты', 
		'Аттестаты', 
		'manage_options',
		'ListOfTheRaiting/index.php',
		'admin_view'
		);
}

//Функция вывода данных в админ панель
function admin_view()
{
	global $wpdb;
	?>
	<link rel="stylesheet" type="text/css" href="<?= plugins_url() ?>/ListOfTheRaiting/css/bootstrap-4_0_0.css">
	<link rel="stylesheet" type="text/css" href="<?= plugins_url() ?>/ListOfTheRaiting/css/style.css">

<div class="container mt-5 max-w-1300" >






	<div class="row">
        <div class="col-lg-9 mt-4">

            <!--========Кнопки переключения экранов========-->
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Добавить абитуриента</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Все абитуриенты</a>
                </li>
            </ul>
            <!--===================== END ==============-->




            <div class="tab-content row m-0" id="pills-tabContent">
                <div class="tab-pane fade show active w-100" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <!--========Добавление абитуриента========-->
                    <div class="row w-100 m-auto">
                        <div class="col-lg-6 text-center mt-4">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Контактная информация</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form ">
                                            <!--========Форма добавления абитуриента========-->
                                            <input type="text" class="form-control" placeholder="ФИО" id="fio_abitur">
                                            <input type="date" class="form-control mt-3" id="date_abitur">
                                            <select name="change_specialty" id="change_specialty" class="form-control mt-3" onchange="switch_age()">
                                                <option value="" selected="">Выберете специальность</option>
                                                <?php
                                                $result = $wpdb->dbh->query("SELECT * FROM `lotr_specialty`");
                                                if($result->num_rows > 0)
                                                {
                                                    while ($po = $result->fetch_assoc())
                                                    {
                                                        echo "<option data-count = '{$po['age']}' value = '{$po['id']}'>{$po['name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <select name="change_specialty_age" id="change_specialty_age" class="form-control mt-3">
                                            </select>
                                            <!--===================== END ==============-->
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6 mt-4 text-center">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Данные аттестата</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="form ">
                                            <!--========Форма добавления данных аттестата абитуриента========-->
                                            <input type="text" class="form-control" placeholder="Аттестат" id="abitur_att">

                                            <div id="all_rating">
                                                <?php
                                                $result = $wpdb->dbh->query("SELECT * FROM `lotr_lesson_name`");
                                                if($result->num_rows > 0)
                                                {
                                                    while ($po = $result->fetch_assoc()) {

                                                        echo '
						      					<div class="form-group row mt-3 text-left ml-0 mr-0">
											    	<label for="lesson_'.$po["id"].'" class="col-sm-10 col-form-label">'.$po["lesson_name"].'</label>
											    	<div class="col-sm-2">
											    		<input type="" class="form-control pl-2 pr-2" id="lesson_'.$po["id"].'" data-id='.$po["id"].'>
											    	</div>
												</div>
												<hr>
						      					';
                                                    }
                                                }
                                                ?>
                                                <!--===================== END ==============-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-success" onclick="add_abitur('<?= plugins_url() ?>/ListOfTheRaiting/')">Добавить абитуриента</button>
                        </div>
                    </div>
                    <!--===================== END ==============-->

                </div>
                <div class="tab-pane w-100 fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">


                    <!--========Вывод всех абитуриентов========-->
                    <div id="app">
                        <button class="reload btn btn-success btn-sm" @click="reLoadData">&circlearrowleft; Обновить</button>
                        <div class="scroll mt-2" >
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" >#</th>
                                    <th scope="col" >ФИО</th>
                                    <th scope="col" >Дата поступления</th>
                                    <th scope="col" >Код специальности</th>
                                    <th scope="col" >На базе N классов</th>
                                    <th scope="col">Аттестат</th>
                                    <th scope="col" v-for="data in data_lesson">
                                        {{ data }}
                                    </th>
                                    <th scope="col" @click="My_sort(2)" style="cursor: pointer" :class="{flag_sort:flag_sort,flag_non_sort:!flag_sort}">Средний бал</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(abitur,index) in data_abitur">
                                    <td>
                                        {{ index+1 }}
                                    </td>
                                    <td v-for="(data) in abitur[0]">
                                        {{ data }}
                                    </td>
                                    <td v-for="(data) in abitur[1]">
                                        {{ data }}
                                    </td>

                                    <td>
                                        {{ abitur[2] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================== END ==============-->

                    <!--========Пагинация вывода всех абитуриентов========-->
<!--                    <nav aria-label="Page navigation example">-->
<!--                        <ul class="pagination justify-content-center mt-5">-->
<!--                            <li class="page-item disabled">-->
<!--                                <a class="page-link" href="#" tabindex="-1">Previous</a>-->
<!--                            </li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                            <li class="page-item">-->
<!--                                <a class="page-link" href="#">Next</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </nav>-->
                    <!--===================== END ==============-->

                    <!--========Кнопки выгрузки файлов excel========-->
                    <div class="row ml-0 mr-0 mt-5">
                        <div class="col-6">
                            <!--========загрузка файлов excel========-->
                            <div class="add_excel">
                                <label class="btn btn-success " for="excel_file">Загрузить Excel файл</label>
                                <input type="file" hidden id="excel_file" onchange="file_excel('<?= plugins_url() ?>/ListOfTheRaiting/')">
                            </div>
                            <!--===================== END ==============-->
                        </div>

                        <div class="col-6">
                    <!--========выгрузка файлов excel========-->
<!--                            <div class="add_excel text-right">-->
<!--                                <label class="btn btn-success " for="excel_file">Выгрузить Excel файл</label>-->
<!--                                <input type="file" hidden id="excel_file" onchange="file_excel('<?//= plugins_url() ?>/ListOfTheRaiting/')">-->
<!--                           </div>-->
                            <!--===================== END ==============-->
                        </div>
                    </div>
                    <!--===================== END ==============-->

                </div>

            </div>



        </div>


        <div class="col-lg-3 mt-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Добавление предмета</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="form ">
                            <input type="text" class="form-control" id="lesson_name" placeholder="Название предмета">
                            <button class="btn btn-success mt-3" onclick="add_lesson('<?= plugins_url() ?>/ListOfTheRaiting/')">Добавить</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Добавление специальности</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="form text-center">
                            <!--======== Добавление специальности ========-->
                            <input type="text" class="form-control" id="specialty_name" placeholder="Специальность">

                            <input type="text" class="form-control mt-3" id="specialty_number" placeholder="Номер специальности">

                            <input type="text" class="form-control mt-3" id="specialty_duration" placeholder="Длительность обучения">

                            <input type="text" class="form-control mt-3" id="specialty_count_place" placeholder="Количество мест">

                            <div class="custom-control custom-checkbox my-1 mr-sm-2 mt-3">

                                <input type="checkbox" class="custom-control-input" id="9_age" checked="">

                                <label class="custom-control-label" for="9_age"> На базе 9 классов</label>

                            </div>

                            <div class="custom-control custom-checkbox my-1 mr-sm-2 ">

                                <input type="checkbox" class="custom-control-input" id="11_age">

                                <label class="custom-control-label" for="11_age">На базе 11 классов</label>

                            </div>

                            <div class="custom-control custom-checkbox my-1 mr-sm-2">

                                <input type="checkbox" class="custom-control-input" id="8_age">

                                <label class="custom-control-label" for="8_age">На базе 8 классов</label>

                            </div>

                            <button class="btn btn-success mt-3" onclick="add_specialty('<?= plugins_url() ?>/ListOfTheRaiting/')">Добавить</button>

                            <!--===================== END ==============-->
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
	</div>
</div>
<script src="<?= plugins_url() ?>/ListOfTheRaiting/js/jquery-3_2_1_min.js"></script>
<script src="<?= plugins_url() ?>/ListOfTheRaiting/js/bootstrap-4.0.0.js"></script>
    <script>
        let  link_data = '<?= plugins_url() ?>/ListOfTheRaiting/';
        let delay=1000;
    </script>
<script src="<?= plugins_url() ?>/ListOfTheRaiting/js/vue.js"></script>
<script src="<?= plugins_url() ?>/ListOfTheRaiting/js/main.js"></script>

	<?php
}


//Функция вывода данных по шорткоду
function user_view( $atts )
{
	
	
	// echo "<pre>";
	// print_r($wpdb->dbh);
	// print_r($mysqli);
	// echo "</pre>";
    ?>
    <link rel="stylesheet" type="text/css" href="<?= plugins_url() ?>/ListOfTheRaiting/css/bootstrap-4_0_0.css">
    <link rel="stylesheet" type="text/css" href="<?= plugins_url() ?>/ListOfTheRaiting/css/style.css">


    <div class="container max-w-1300">
        <!--========Вывод всех абитуриентов========-->
        <div class="scroll mt-5" id="app">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" >#</th>
                    <th scope="col" >ФИО</th>
                    <th scope="col" >Дата поступления</th>
                    <th scope="col" >Код специальности</th>
                    <th scope="col" >На базе N классов</th>
                    <th scope="col">Аттестат</th>

                    <th scope="col" @click="My_sort(2)" style="cursor: pointer" :class="{flag_sort:flag_sort,flag_non_sort:!flag_sort}">Средний бал</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(abitur,index) in data_abitur">
                    <td>
                        {{ index+1 }}
                    </td>
                    <td v-for="(data) in abitur[0]">
                        {{ data }}
                    </td>

                    <td>
                        {{ abitur[2] }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--===================== END ==============-->
    </div>


    <script src="<?= plugins_url() ?>/ListOfTheRaiting/js/jquery-3_2_1_min.js"></script>
    <script src="<?= plugins_url() ?>/ListOfTheRaiting/js/bootstrap-4.0.0.js"></script>
    <script>
        let  link_data = '<?= plugins_url() ?>/ListOfTheRaiting/';
    </script>
    <script src="<?= plugins_url() ?>/ListOfTheRaiting/js/vue.js"></script>
    <script src="<?= plugins_url() ?>/ListOfTheRaiting/js/main.js"></script>
<?php
}




?>
