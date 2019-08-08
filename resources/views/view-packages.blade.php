@guest
    <script type="text/javascript">window.location="/home"</script>
@else

@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="mt-4 mb-2">Packages</h3>
				<table class="table mt-4 table-dark">
					<thead class="">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Price</th>
							<th>Duration</th>
							
							
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($packages as $package)
							<tr>
								<td>
									{{$package->id}}
								</td>
								
								<td>
									{{$package->package_name}}
								</td>
								<td>
									Rs. {{$package->price}}
								</td>
								<td>

                            {{$package->duration}}
								</td>
								<td>
									<a class="btn btn-primary" href="" data-toggle="modal" role="button" data-target="#exampleModal{{$package->id}}">View</a>
								</td>
								
							</tr>
								@empty{{''}}
						@endforelse
<!--						</tr>-->
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection


@section('modal')
	@forelse($packages as $alldes)
		<div class="modal fade" id="exampleModal{{$alldes->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form action="/packages/update/{{$alldes->id}}" method="post" class="w-100" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label class="mt-4">Package Name</label>
							<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name" value="{{$alldes->package_name}}">

							<label class="mt-4">Price(Rs)</label>
							<input type="text" class="form-control" name="price" placeholder="you@example.com" aria-label="Designation" value="{{$alldes->price}}">
							
							<label class="mt-4">Duration</label>
							<select class="form-control" name="duration" id="duration">
							    <option value="0">Choose
							    </option>
							    @for($i=1;$i<=12;$i++)
							   <option value="{{$i}}" {{($alldes->duration == $i)?'selected':''}}>{{$i}}</option>
							    @endfor    
							</select>
						</div>
						<div class="modal-footer">
							{{csrf_field()}}
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{url('/packages/delete/'.$alldes->id)}}" class="btn btn-danger">Delete</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		@empty{{''}}
	@endforelse
@endsection
@endguest