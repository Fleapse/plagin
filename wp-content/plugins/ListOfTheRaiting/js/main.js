function add_lesson(link)//Добавление урока, при нажатие на кнопку, принемает ссылку кторую я передаю в index.php
{
	if($('#lesson_name').val()!=='')
	{
		$.ajax({ 
			type:"post", 
			url:link+'php/add_lesson.php', 
			data:{"lesson_name":$('#lesson_name').val()}, 
			success:result=> 
			{
				this.result = JSON.parse(result);
				if(this.result)
				{
					$('#lesson_name').val('');
					$('#lesson_name').css('border','1px solid #ddd');
				} 
				else
				{
					$('#lesson_name').css('border','1px solid red');
				} 
			}, 
		}) 
	}

}function add_specialty(link)//Добавление специальности, при нажатие на кнопку, принемает ссылку кторую я передаю в index.php
{

	if($('#specialty_name').val()!=='' && $('#specialty_number').val()!=='' && ($('#9_age')[0].checked || $('#11_age')[0].checked || $('#8_age')[0].checked) && $('#specialty_duration').val()!=='' && $('#specialty_count_place').val()!=='')
	{
	    //Проверка на выбранный n классов
		this.age = "";
		if($('#9_age')[0].checked)
		{
			this.age+= "9";
		}
		if($('#11_age')[0].checked)
		{
			if(this.age == "")
			{
				this.age+= "11";
			}
			else
			{
				this.age+= " ,11";
			}
		}
		if($('#8_age')[0].checked)
		{
			if(this.age == "")
			{
				this.age+= "8";
			}
			else
			{
				this.age+= " ,8";
			}
		}
		


		$.ajax({ 
			type:"post", 
			url:link+'php/add_specialty.php', 
			data:
				{
					"specialty_name":$('#specialty_name').val(),
					"specialty_number":$('#specialty_number').val(),
					"specialty_age":this.age,
					"specialty_duration":$('#specialty_duration').val(),
					"specialty_count_place":$('#specialty_count_place').val()
				}, 
			success:result=> 
			{
				this.result = JSON.parse(result);
				if(this.result)
				{
					$('#specialty_name').val('');
					$('#specialty_name').css('border','1px solid #ddd');
					$('#specialty_number').val('');
					$('#specialty_number').css('border','1px solid #ddd');
					$('#specialty_duration').val('');
					$('#specialty_count_place').val('');
				} 
				else
				{
					$('#specialty_name').css('border','1px solid red');
					$('#specialty_number').css('border','1px solid red');
				} 
			}, 
		}) 
	}

}
function switch_age()
{
	this.data = $('#change_specialty').find('option:selected').attr('data-count');
	this.append = "";

	if(typeof this.data!=="undefined")
	{
		this.data=this.data.split(',');
		this.data.forEach(item=>
		{
			this.append+=`<option value="${item}" >На базе ${item} классов</option>`;
		});

		$('#change_specialty_age').html(this.append);
	}

}

//Функция добавить абитуриента при нажатие на кнопку, в ней идет проверка на не пустоту и уникальнсть абитуриента
async function add_abitur(link)
{
	if(
		$('#fio_abitur').val()!=''
		&&
		$('#date_abitur').val()!=''
		&&
		$('#change_specialty').val()!=''
		&&
		$('#change_specialty_age').val()!=''
		&&
		$('#abitur_att').val()!=''
	)
	{
		await $.ajax({
			type:"POST",
			url:link+'php/add_abitur.php',
			data:
			{
				"fio":$('#fio_abitur').val(),
				"date":$('#date_abitur').val(),
				"original":$('#abitur_att').val(),
				"id_specialty":$('#change_specialty').val(),
				"age_specialty":$('#change_specialty_age').val(),
			},
			success:result=>
			{
				this.data_user=JSON.parse(result);
				if(this.data_user!==false)
				{
					$('#fio_abitur').css('border','1px solid #ddd');

					this.data_rait=[];


					for (let i=0;i<$('#all_rating input').length;i++)
					{
						let item=$('#all_rating input')[i];
						this.data_rait.push({"val":item.value,"id":item.getAttribute('data-id')});
					}



					// Добавление оценок абитуриента
					$.ajax({
						type:"POST",
						url:link+'php/add_rating.php',
						data:{"id":result,"rating":this.data_rait},
						success:result=>
						{
							$('#fio_abitur').val('');

							$('#date_abitur').val('');

							$('#change_specialty').val('');

							$('#change_specialty_age').val('');

							$('#abitur_att').val('');


							for (let i=0;i<$('#all_rating input').length;i++)
							{
								$('#all_rating input')[i].value="";
							}
						},
					});

				}
				else
				{
					$('#fio_abitur').css('border','1px solid red');
				}
			},
		});
	}
}


// Передача файла в пхп часть , при изменении данных в инпуте фалй
async function file_excel(link)
{

	this.formData=new FormData();

	this.formData.append('file',$('#excel_file')[0].files[0]);

	await $.ajax({
		type:"POST",
		url:link+'php/add_excel.php',
		processData: false,
		contentType: false,
		data:this.formData,
		success:result=>{
			// console.log(result);
		}
	});
}








let vue = new Vue({
	el:'#app',
	data:{
		data_abitur:'',
		data_lesson:'',
		flag_sort:false,
	},
	methods:
	{
		async get_abitur()//Взятие всех данных абитуриентов
		{
			await $.ajax({
				type:"GET",
				url:link_data+'php/get_abitur.php',
				success:result=>
				{
					this.mas=JSON.parse(result);

				}
			});

			return this.mas;
		},
		async get_lesson()//Взятие всех данных урока
		{
			await $.ajax({
				type:"GET",
				url:link_data+'php/get_header_table.php',
				success:result=>
				{
					this.mas=JSON.parse(result);


				}
			});

			return this.mas;
		},
		My_sort(param)//Сортировка при нажатие на средний балл
		{
			this.flag_sort=!this.flag_sort;

			if(this.flag_sort)
			{
				this.data_abitur.sort((a,b)=>
				{
					return b[2]-a[2];
				});
			}
			else{
				this.data_abitur.sort((a,b)=>
				{
					return a[2]-b[2];
				});
			}

			// console.log(this.data_abitur);
		},

		async reLoadData()//Кнопка однавления данных
		{
			this.data_abitur=await this.get_abitur();
			this.data_lesson=await this.get_lesson();
		}
	},
	async created()
	{
		this.data_abitur=await this.get_abitur();
		this.data_lesson=await this.get_lesson();

	},
});






// $('#id').bind(')