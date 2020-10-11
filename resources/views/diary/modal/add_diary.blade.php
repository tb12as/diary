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
</div>

<div class="snackbar-added">
	<div class="alert alert-primary px-5" role="alert">
		<strong>Diary saved</strong>
	</div>
</div>
