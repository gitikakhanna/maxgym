@guest
    <script type="text/javascript">window.location="/home"</script>
@else

@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="mt-4 mb-2">Customers</h3>
				<input type="text" name="search" class="form-control w-25 float-right mt-3 mb-3" id="search" placeholder="Search...">
				<table class="table table-responsive table-dark mt-4">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Contact No</th>
							<th>Package</th>
							<th>Valid (from - to)</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($customers as $customer)
							<tr>
								<td>
									{{$customer->id}}
								</td>
								<td>
									{{$customer->name}}
								</td>
								<td>
									{{$customer->contact}}
								</td>
								<td>
                            		{{App\Packages::where('id', $customer->package)->value('package_name')}}
								</td>
								<td>
									{{ \Carbon\Carbon::parse($customer->joiningdate)->formatLocalized('%d %b %Y')}} - {{ \Carbon\Carbon::parse($customer->due_date)->formatLocalized('%d %b %Y')}}
								</td>
								<td>
									<a class="btn btn-primary" href="" data-toggle="modal" role="button" data-target="#exampleModal{{$customer->id}}">View</a>
									<a class="btn btn-warning ml-2" href="/invoice/log/view/{{$customer->id}}"><i class="fa fa-database mr-1"></i>Log</a>
								</td>
							</tr>
								@empty{{''}}
						@endforelse

					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('modal')
	@forelse($customers as $alldes)
		<div class="modal fade" id="exampleModal{{$alldes->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form action="/customer/update/{{$alldes->id}}" method="post" class="w-100" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Member Profile</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label class="mt-4">Name</label>
							<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name" value="{{$alldes->name}}">

							<label class="mt-4">Email</label>
							<input type="text" class="form-control" name="email" placeholder="you@example.com" aria-label="Designation" value="{{$alldes->email}}">
							
							<label class="mt-4">Contact Number</label>
							<input type="text" class="form-control" name="contact" placeholder="Eg: 9384465446" aria-label="Designation" value="{{$alldes->contact}}">
							
							<label class="mt-4">Address</label>
							<input type="text" class="form-control" name="address" placeholder="Add Adress here" aria-label="Designation" value="{{$alldes->address}}">
							
							<div class="row">
								<div class="col-lg-6 col-12">
									<label class="mt-4">Date Of Birth</label>
									<input type="date" class="form-control pb-5" name="dob" id="dob" value="{{$alldes->dob}}">
								</div>
								<div class="col-lg-6 col-12">
									<label class="mt-4">Gender</label>
									<select class="form-control" name="gender" id="gender">
									    <option value="0">Choose
									    </option>
									    <option value="Male" {{$alldes->gender == 'Male'?'selected':''}}>Male
									    </option>
									    <option value="Female" {{$alldes->gender == 'Female'?'selected':''}}>Female
									    </option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-12">
									<label class="mt-4">Valid From</label>
									<input type="date" class="form-control date-change" name="joining_date" id="joining_date{{$alldes->id}}" onselect="date_change({{$alldes->id}})" value="{{$alldes->joiningdate}}" readonly>
								</div>
								<div class="col-lg-6 col-12">
									<label class="mt-4">Valid Till</label>
									<input type="text" class="form-control" name="due_date" id="due_date{{$alldes->id}}" value="{{$alldes->due_date}}" readonly="">
								</div>
							</div>

						    <label class="mt-4">Package</label>
							<select class="form-control date-change" name="package" id="package{{$alldes->id}}" onchange="date_change({{$alldes->id}})">
							    <option value="0">Choose</option>
							    @forelse($packages as $package)
							    	<option value="{{$package->duration}}" data-id="{{$package->id}}" {{$package->id == $alldes->package?'selected':''}}>{{$package->package_name}}</option>
							    @empty{{''}}
							    @endforelse
								<input type="hidden" name="package_id" id="package_id{{$alldes->id}}" value="{{$alldes->package}}">
							</select>
						</div>
						<div class="modal-footer">
							{{csrf_field()}}
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{url('/customer/delete/'.$alldes->id)}}" class="btn btn-danger">Delete</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		@empty{{''}}
	@endforelse
@endsection
@section('js')
	<script type="text/javascript">
		function date_change(id)
		{
			console.log(id);
			var joiningdate = new Date($('#joining_date'+id).val());
			joiningdate.setMonth(joiningdate.getMonth()+parseInt($('#package'+id).val()));
			$('#package_id'+id).val($("#package"+id+" option:selected").attr("data-id"));
			
			var dd = joiningdate.getDate();
			var mm = joiningdate.getMonth()+1;
			var yyyy = joiningdate.getFullYear();

			if(dd<10){
				dd = '0'+dd;
			}
			if(mm<10){
				mm = '0'+mm;
			}
			duedate = mm+'/'+dd+'/'+yyyy;
			console.log("today"+duedate);

			$('#due_date'+id).attr('value', duedate);
		}
	</script>
@endsection
@endguest