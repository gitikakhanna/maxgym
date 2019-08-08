@guest
    <script type="text/javascript">window.location="/home"</script>
@else

@extends('layouts.app')
@section('content')
<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="text-uppercase">Add Package</h3>
				<form method="post" action="/packages/add" enctype="multipart/form-data">
					<label class="mt-4">Name</label>
					<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name">

					<label class="mt-4">Price</label>
					<input type="text" class="form-control" name="price" placeholder="Enter Price" aria-label="Designation">
					
					<label class="mt-4">Duration</label>
					<select class="form-control" name="duration" id="duration">
					    <option value="0">Choose
					    </option>
					    @for($i=1;$i<=12;$i++)
					    <option value="{{$i}}">{{$i}}
					    </option>
					    @endfor
					</select>
					{{csrf_field()}}
					<button class="btn btn-outline-secondary mt-4 w-100" type="submit">Add </button>
					
				</form>
			</div>
		</div>
		<a href="/packages/view" class="btn btn-outline-secondary mt-4 w-100" >View Packages</a>
	</div>

@endsection
@endguest