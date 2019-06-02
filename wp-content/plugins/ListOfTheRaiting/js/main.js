function add_lesson(link) {
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
					$('#lesson_name').css('border','1px solid #f5f5f5');
				} 
				else
				{
					$('#lesson_name').css('border','1px solid red');
				} 
			}, 
		}) 
	}

}function add_specialty(link) {

	if($('#specialty_name').val()!=='' && $('#specialty_number').val()!=='' && ($('#9_age')[0].checked || $('#11_age')[0].checked || $('#8_age')[0].checked) && $('#specialty_duration').val()!=='' && $('#specialty_count_place').val()!=='')
	{
		this.age = "";
		if($('#9_age')[0].checked)
		{
			this.age+= "На базе 9 классов";
		}
		if($('#11_age')[0].checked)
		{
			if(this.age == "")
			{
				this.age+= "На базе 11 классов";
			}
			else
			{
				this.age+= " ,На базе 11 классов";
			}
		}
		if($('#8_age')[0].checked)
		{
			if(this.age == "")
			{
				this.age+= "На базе 8 классов";
			}
			else
			{
				this.age+= " ,На базе 8 классов";
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
					$('#specialty_name').css('border','1px solid #f5f5f5');
					$('#specialty_number').val('');
					$('#specialty_number').css('border','1px solid #f5f5f5');
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
function switch_age() {
	//console.log($('#change_specialty').find('option:selected').attr('data-count'));
	this.data = $('#change_specialty').find('option:selected').attr('data-count').split(',');
	this.append = "";
	this.data.forEach(item=>{
		this.append+=`<option value="${item}" >${item}</option>`;
	});
	$('#change_specialty_age').html(this.append);

	//console.log(this.data);
}
function add_fucking_scoolboy() {
	alert(123);
}