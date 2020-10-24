@extends('layouts.app')

@section('userman', 'active')
@section('content')
@include('layouts.loading')
<div class="container">
	<h4>User Management</h4>
	<p class="float-right" id="userCount"></p>
	<table class="table table-bordered">
		<thead class="thead-dark">
			<tr>
				<th width="50">No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Diaries</th>
				<th width="250">Action</th>
			</tr>
		</thead>
		<tbody id="tableBody">
		</tbody>
	</table>
</div>

<div class="modal fade" id="modalDeleteUser">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalDeleteTitle">Delete User?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="alert alert-danger">This action cannot be undone</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-sm btn-danger" id="deleteNow">Delete</button>
			</div>
		</div>
	</div>
</div>
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
			$('.loading').removeClass('false');
			$('#tableBody').children().remove();
			$.ajax({
				url: '{{ route('userman.index') }}',
				success: (res) => {
					let data = res.data;
					$('#userCount').html(`User count : ${data.length}`);
					$.each(data, function(index, val) {
						$('#tableBody').append(`<tr>
							<td>${index + 1}</td>
							<td>${val.name} <span class="badge badge-success">${val.created_at}, ${val.created_when}</span></td>
							<td>${val.email}</td>
							<td>${val.diaries_count}</td>
							<td>
							<button class="btn btn-danger btn-sm" id="deleteUser" value="${val.id}">Delete</button> 
							<button class="btn btn-success btn-sm" id="toAdmin" value="${val.id}">Change to admin</button>
							{{-- <button class="btn btn-success btn-sm" id="editUser" value="${val.id}">Edit</button>  --}}
							</td>
							</tr>`);
					});
					$('.loading').addClass('false');
				},
				error: (err) => {
					console.log(err);
				}
			});
		}

		loadData();

		$('body').on('click', '#deleteUser', function(event) {
			event.preventDefault();
			let user_id = this.value;
			$.ajax({
				url: '{{ route('userman.index') }}/'+user_id,
				success: (res) => {
					$('#deleteNow').val(res.id);
					$('#modalDeleteTitle').html(`Delete user ${res.name}?`);
					$('#modalDeleteUser').modal('show');
				},
				error: (res) => {
					console.log(res);
				}
			});
		});

		$('body').on('click', '#deleteNow', function(event) {
			event.preventDefault();
			let id = this.value;
			$.ajax({
				url: '{{ route('userman.index') }}/'+id,
				type: 'PUT',
				success: (res) => {
					$('#modalDeleteUser').modal('hide');
					loadData();
				}, 
				error: (err) => {
					console.log(err);
				}
			});
		});

		$('body').on('click', '#toAdmin', function(event) {
			event.preventDefault();
			let id = this.value;
			$.ajax({
				url: '{{ route('userman.toadmin') }}',
				type: 'POST',
				data: {id: id},
				success: (res) => {
					loadData();
				}, 
				error: (err) => {
					console.log(err);
				}
			});
			
		});
		
	});
</script>
@endsection
