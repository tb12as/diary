function loadData() {
	// $('.loading').removeClass('false');
	$.ajax({
		url: '{{ route('diary.index') }}',
		type: 'GET',
		success: (data) => {
			$('#diaries').children().remove();
			$.each(data.data, function(index, val) {
				let string = `<div class="card">
				<div class="card-body">
				<div class="diary-card" data-id="${val.id}">
				<h4 class="card-title">${val.title}</h4>
				<h6 class="card-subtitle mb-2 text-muted small">${(val.updated_at ? val.updated_at : val.created_at)}</h6>
				<p class="card-text" style="max-height: 50px; overflow: hidden; background: -webkit-linear-gradient(white, transparent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">${val.content}</p>
				</div>
				<hr>
				<button class="btn btn-danger btn-sm" data-id="${val.id}" id="delete">Delete</button>
				<button class="btn btn-success btn-sm" value="${val.id}" id="editBtn">Edit</button>
				</div>
				</div>`;

				$('#diaries').append(`<div class="col-md-4 my-2">
					${string}
					</div>`);
			});
			if(data.data.length < 1) {
				$('#diaries').append(`<div class="col-md-12 my-2">
					<h4 class="text-muted">You don't have any diary yet</h4>
					</div>`);
			}
			$('.loading').addClass('false');

		}, 
		error: (res) => {
			console.log(res.responseJSON);
		},
	});
}

loadData();
