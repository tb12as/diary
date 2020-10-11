$('#addDiary').click(function(event) {
	event.preventDefault();
	$('#modalNewDiary').modal('show');
});

$('#diaryForm').submit(function(event) {
	event.preventDefault();
	let formData = $(this).serialize();
	$.ajax({
		url: '{{ route('diary.store') }}',
		type: 'POST',
		data: formData,
		success: (data) => {
			$('#modalNewDiary').modal('hide');
			$('#diaryForm').trigger('reset');
			$('.snackbar-added').addClass('true');
			setTimeout(() => {
				$('.snackbar-added').removeClass('true');
			}, 1500);
			loadData();
		},
		error: (res) => {
			$('.error-list').remove();
			$.each(res.responseJSON.errors, function(i, v) {
				$('#errorList').append('<li class="text-danger error-list list-unstyled"><strong>'+v+'</strong></li>');
			});
		}
	});		
});
