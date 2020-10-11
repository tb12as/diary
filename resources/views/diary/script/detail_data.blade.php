$('body').on('click', '.diary-card', function(event) {
	event.preventDefault();
	$('.loading').removeClass('false');
	let diary_id = $(this).attr('data-id');
	$.ajax({
		url: '{{ route('diary.index') }}/'+diary_id,
		success: (data) => {
			$('.diary-container').addClass('d-none');
			$('body').append(`<div class="jumbotron jumbotron-fluid rounded diary-detail">
				<div class="container">
				<h1 class="display-4">${data.data.title}</h1>
				<p class="small text-muted">${data.data.updated_at ? data.data.updated_at : data.data.created_at}</p>
				<p class="lead">${data.data.content}</p>
				<hr>
				<button id="backBtnAfterDetail" class="btn btn-sm btn-success">Back</button>
				</div>
				</div>
				`);
			$('.loading').addClass('false');
		},
		error: (res) => {console.log(res)},
	});
});

$('body').on('click', '#backBtnAfterDetail', function(event) {
	event.preventDefault();
	$('.diary-detail').remove();
	$('.diary-container').removeClass('d-none');
	loadData();
});
