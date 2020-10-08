@extends('layouts.app')

@section('content')

<div class="container">
	<button class="btn btn-primary btn-sm float-right" id="addDiary">New Diary</button> <br>
	<div class="row my-2" id="diaries">

	</div>
</div>

<div class="modal fade" id="modalNewDiary">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">New Diary</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<form action="{{ route('diary.store') }}" method="post" id="diaryForm">
				<div class="modal-body">
					<ul id="errorList"></ul>
					<input type="hidden" name="diary_id">

					<label for="title">Title</label>
					<input type="text" class="form-control" placeholder="Title" name="title">

					<label for="content">Content</label>
					<textarea class="form-control" placeholder="Content" rows="10" name="content"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary btn-sm">Save Diary</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script>
	$(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			}
		});

		function loadData() {
			$.ajax({
				url: '{{ route('diary.index') }}',
				type: 'GET',
				success: (data) => {
					$('#diaries').children().remove();
					$.each(data.data, function(index, val) {
						let string = `<div class="card">
						<div class="card-body">
						<h4 class="card-title">${val.title}</h4>
						<h6 class="card-subtitle mb-2 text-muted small">${(val.updated_at ? val.updated_at : val.created_at)}</h6>
						<p class="card-text" style="max-height: 50px; overflow: hidden; background: -webkit-linear-gradient(white, transparent); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">${val.content}</p>
						<hr>
						<button class="btn btn-danger btn-sm" data-id="${val.id}" id="delete">Delete</button>
						<button class="btn btn-success btn-sm" data-id="${val.id}" id="edit">Edit</button>
						</div>
						</div>`;

						$('#diaries').append(`<div class="col-md-4 my-2">
							${string}
							</div>`);
					});

				}, 
				error: (res) => {
					console.log(res.responseJSON);
				},
			});
		}

		loadData();

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
		
	});
</script>
@endsection
