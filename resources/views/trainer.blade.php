@guest
    <script type="text/javascript">window.location="/home"</script>
@else
@extends('layouts.app')
@section('content')
<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="text-uppercase">Add Trainer</h3>
				<form method="post" action="/trainer/add" enctype="multipart/form-data">
					<label class="mt-4">Name</label>
					<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name">

					<label class="mt-4">Email</label>
					<input type="text" class="form-control" name="email" placeholder="you@example.com" aria-label="Designation">
					
					<label class="mt-4">Contact Number</label>
					<input type="text" class="form-control" name="contact" placeholder="Eg: 9384465446" aria-label="Designation">
					
					<label class="mt-4">Address</label>
					<input type="text" class="form-control" name="address" placeholder="Add Adress here" aria-label="Designation">

					
					
					{{csrf_field()}}
					<button class="btn btn-primary mt-5 w-100" type="submit">Add </button>
				</form>
			</div>
		</div>
		
		<div class="row mt-5">
			<div class="col-12">
				<h3 class="text-uppercase">Listed Trainers</h3>
				
			</div>
			@forelse($trainer as $t)
				<div class="col-lg-3 col-12 mt-5 text-center" style="border:1px solid #e0e0e0; ">
				    <p>{{$t->name}}</p>
				    <small>{{$t->contact}}</small>
				    <p class="mt-3"><a class="btn btn-primary" href="" data-toggle="modal" role="button" data-target="#exampleModal{{$t->id}}">Edit</a><a class="btn btn-warning ml-1 ml-lg-2" href="/attendance/marking/log/{{$t->id}}">Attendance Log</a></p>
				    
				</div>
            @empty{{''}}
            @endforelse
		</div>
		
	</div>
@endsection


@section('modal')
	@forelse($trainer as $t)
		<div class="modal fade" id="exampleModal{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form action="/trainer/update/{{$t->id}}" method="post" class="w-100" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Trainer Profile</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label class="mt-4">Name</label>
							<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name" value="{{$t->name}}">

							<label class="mt-4">Email</label>
							<input type="text" class="form-control" name="email" placeholder="you@example.com" aria-label="Designation" value="{{$t->email}}">
							
							<label class="mt-4">Contact Number</label>
							<input type="text" class="form-control" name="contact" placeholder="Eg: 9384465446" aria-label="Designation" value="{{$t->contact}}">
							
							<label class="mt-4">Address</label>
							<input type="text" class="form-control" name="address" placeholder="Add Adress here" aria-label="Designation" value="{{$t->address}}">
							
							
						</div>
                        
                        <div class="modal-footer">
							{{csrf_field()}}
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{url('/trainer/delete/'.$t->id)}}" class="btn btn-danger">Delete</a>
						</div>
                        
					</div>
				</form>
			</div>
		</div>
		@empty{{''}}
	@endforelse
@endsection
@endguest