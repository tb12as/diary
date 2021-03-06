@extends('layouts.app')

@section('adminman', 'active')
@section('content')
@include('layouts.loading')
<div class="container">
	<button class="btn btn-primary btn-sm float-right" id="addAdmin">Add New Admin</button>
	<h4>All Admin</h4>
	<p class="float-right" id="adminCount"></p>
	<table class="table table-bordered">
		<thead class="thead-dark">
			<tr>
				<th width="50">No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Diaries</th>
				<th width="200">Action</th>
			</tr>
		</thead>
		<tbody id="tableBody">
		</tbody>
	</table>
</div>

<div class="modal fade" id="modalDeleteAdmin">
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
				<p class="alert alert-danger">This action c@include('layouts.loading')
					$('.loading').removeClass('false');
				$('.loading').addClass('false');annot be undone</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-sm btn-danger" id="deleteNow">Delete</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAddAdmin">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Admin</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<form action="{{ route('adminman.store') }}" method="post" id="addAdminForm">
				<div class="modal-body">
					<ul id="errorList"></ul>
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">

					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Email">

					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-sm btn-primary">Save Admin</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modalEditAdmin">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Admin</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<form action="{{ route('adminman.store') }}" method="post" id="editAdminForm">
				<div class="modal-body">
					<ul id="errorListEdit"></ul>
					<input type="hidden" name="admin_id" id="admin_id">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name">

					<label for="email">Email</label>
					<input type="text" class="form-control" id="emailEdit" name="email" placeholder="Email">

					<label for="password">Password</label>
					<input type="password" class="form-control" id="passwordEdit" name="password" placeholder="Password">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-sm btn-success">Save Change</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="snackbar">
	<div class="alert alert-success px-5" role="alert">
		<strong id="snackbarMessage"></strong>
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

		function loadData(withLoading) {
			if(withLoading) {
				$('.loading').removeClass('false');
			}
			$('#tableBody').children().remove();
			$.ajax({
				url: '{{ route('adminman.index') }}',
				success: (res) => {
					let data = res.data;
					$('#adminCount').html(`Admin count : ${data.length}`);
					$.each(data, function(index, val) {
						$('#tableBody').append(`<tr>
							<td>${index + 1}</td>
							<td>${val.name} <span class="badge badge-dark">${val.created_at}, ${val.created_when}</span></td>
							<td>${val.email}</td>
							<td>${val.diaries_count}</td>
							<td>
							${(val.login_now ? '<p class="badge badge-success">Now Login</p>' : `
								<button class="btn btn-danger btn-sm" id="deleteAdmin" value="${val.id}">Delete</button>
								<button class="btn btn-success btn-sm" id="editAdmin" value="${val.id}">Edit</button>
								<button class="btn btn-warning btn-sm" id="toUser" value="${val.id}">To User</button>
								`)}
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

		$('body').on('click', '#deleteAdmin', function(event) {
			event.preventDefault();
			let user_id = this.value;
			$.ajax({
				url: '{{ route('adminman.index') }}/'+user_id,
				success: (res) => {
					// console.log(res);
					$('#deleteNow').val(res.id);
					$('#modalDeleteTitle').html(`Delete admin ${res.name}?`);
					$('#modalDeleteAdmin').modal('show');
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
				url: '{{ route('adminman.index') }}/'+id,
				type: 'PUT',
				success: (res) => {
					$('#modalDeleteAdmin').modal('hide');
					loadData();
				}, 
				error: (err) => {
					console.log(err);
				}
			});
		});

		$('#addAdmin').click(function(event) {
			event.preventDefault();
			$('#modalAddAdmin').modal('show');
		});

		$('form').submit(function(event) {
			event.preventDefault();
			let admin_data = $(this).serialize();
			$.ajax({
				url: '{{ route('adminman.store') }}',
				type: 'post',
				data: admin_data,
				success: (res) => {
					// $('#modalAddAdmin').modal('hide');
					$('.modal').modal('hide');
					$('#addAdminForm').trigger('reset');
					$('#editAdminForm').trigger('reset');

					$('.elli').remove();
					$('.err-lst').remove();
					loadData(true);
				}, 
				error: (err) => {
					console.log(err);
					if(err.responseJSON.errors) {
						let errors = err.responseJSON.errors;
						// create
						$('.elli').remove();
						$.each(errors, function(index, val) {
							$('#errorList').append(`<li class="text-danger elli"><strong>${val}</strong></li>`);
						});
						// update
						$('.err-lst').remove();
						$.each(err.responseJSON.errors, function(index, val) {
							$('#errorListEdit').append(`<li class="text-danger err-lst"><strong>${val}</strong></li>`);
						});
					}
				}
			});
		});

		$('body').on('click', '#editAdmin', function(event) {
			event.preventDefault();
			$.ajax({
				url: '{{ route('adminman.index') }}/'+this.value,
				success: (res) => {
					$('#editAdminForm').trigger('reset');
					$('#admin_id').val(res.id);
					$('#nameEdit').val(res.name);
					$('#emailEdit').val(res.email);
					$('#modalEditAdmin').modal('show');

					$('.err-lst').remove();
				},
				error: (err) => {
					console.log(err);
				}
			});
			
		});
		
		$('body').on('click', '#toUser', function(event) {
			event.preventDefault();
			let adminToUser_id = this.value;
			$.ajax({
				url: '{{ route('adminman.touser') }}',
				type: 'POST',
				data: {id: adminToUser_id},
				success: (res) => {
					$('#snackbarMessage').html('Role updated!');
					$('.snackbar').addClass('true');
					setTimeout(() => {
						$('.snackbar').removeClass('true');
					},1500);
					loadData(false);
				},
				error: (err) => {
					console.log(err);
				}
			});
			
		});
	});
</script>
@endsection
