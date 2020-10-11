$('body').on('click', '#delete', function() {
	event.preventDefault();
	let diary_id = $(this).attr('data-id');
	$.ajax({
		url: '{{ route('diary.index') }}/'+diary_id,
		success: (data) => {
			$('#deleteNow').val(data.data.id);
			$('#confirmDelete').modal('show');
			$('#modalDeleteTitle').html('Delete diary '+data.data.title+'?');
			$('#deleteMessage').html('This action cannot be undone');
		},
		error: (res) => {
			console.log(res);	
		}
	});
});

$('#deleteNow').click(function(event) {
	event.preventDefault();
	let diary_id = $(this).val();
	$.ajax({
		url: '{{ route('diary.index') }}/'+diary_id,
		method: 'delete',
		success: (data) => {
			$('#confirmDelete').modal('hide');
			$('.snackbar').addClass('true');
			setTimeout(() => {
				$('.snackbar').removeClass('true');
			}, 1500);
			loadData();
		},
		error: (res) => {
			console.log(res);	
		}
	});
});
