$('body').on('click', '#editBtn', function(event) {
	event.preventDefault();
	let diary_id = this.value;
	$.ajax({
		url: '{{ route('diary.store') }}/'+diary_id,
		success: (data) => {
			let val = data.data;
			$('#diary_id').val(val.id);
			$('#titleEdit').val(val.title);
			$('#contentEdit').html(val.content);
			$('#modalEditDiary').modal('show');
		},
		error: (res) => {
			console.log(res);
		}
	});	
});

$('#diaryEditForm').submit(function(event) {
	event.preventDefault();
	let data = $(this).serialize();
	$.ajax({
		url: '{{ route('diary.store') }}',
		type: 'POST',
		data: data,
		success: (data) => {
			$('#diaryEditForm').trigger('reset');
			$('#modalEditDiary').modal('hide');
			loadData();
		},
		error: (res) => {console.log(res)},
	});
});
