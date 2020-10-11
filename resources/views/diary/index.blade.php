@extends('layouts.app')

@section('content')

@include('layouts.loading')

<div class="container diary-container">
	<button class="btn btn-primary btn-sm float-right" id="addDiary">New Diary</button> <br>
	<div class="row my-2" id="diaries">

	</div>
</div>


@include('diary.modal.add_diary')
@include('diary.modal.delete_diary')
@include('diary.modal.edit_diary')

@endsection

@section('script')
<script>
	$(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			}
		});

		@include('diary.script.get_data')
		@include('diary.script.add_data')
		@include('diary.script.delete_data')
		@include('diary.script.edit_data')
		@include('diary.script.detail_data')

	});
</script>
@endsection
