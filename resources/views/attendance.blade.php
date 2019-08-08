@guest
    <script type="text/javascript">window.location="/home"</script>
@else
@extends('layouts.app')
@section('content')
	<div class="container">
		<form method="post" action="/attendance/mark" enctype="multipart/form-data">
			<div class="row">
				<div class="col-12">
					<h3 class="text-uppercase">ATTENDance</h3>
				</div>
				<div class="col-lg-4 col-12">
					<label class="mt-4">Marked for</label>
					<select class="form-control" name="trainer">
						<option value="0">Choose</option>
						@forelse($trainers as $trainer)
							<option value="{{$trainer->id}}">{{$trainer->name}}</option>
						@empty{{''}}
						@endforelse
					</select>
				</div>
				<div class="col-lg-4 col-12">
					<label class="mt-4">Date</label>
					<input type="date" class="form-control" name="attended_date" id="attended_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
				</div>
				<div class="col-lg-4 col-12">
					<label class="mt-4">Marked as - </label>
					<br>
					<input type="checkbox" name="marking" value="0" id="marking" class="mr-2">Absent
				</div>
				<div class="col-12 mt-4">
					{{csrf_field()}}
					<button class="btn btn-primary" type="submit">Mark Attendance</button>
				</div>
			</div>
		</form>
		<hr>
	</div>
@endsection
@section('js')
	<script type="text/javascript">
		$('#marking').change(function(){
			if($('#marking').prop("checked") == true)
			{
				$('#marking').val("1");	
			}
			else{
				$('#marking').val("0");
			}
		});
	</script>
@endsection
@endguest