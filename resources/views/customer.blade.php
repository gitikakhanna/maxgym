@guest
    <script type="text/javascript">window.location="/home"</script>
@else

@extends('layouts.app')
@section('content')
<div class="container">
		<div class="row">
			<div class="col-12">
				<h3 class="text-uppercase">Add Customer</h3>
				<form method="post" action="/customer/add" enctype="multipart/form-data">
					<label class="mt-4">Name</label>
					<input type="text" class="form-control" name="name" placeholder="Add Name" aria-label="Team Member name">

					<label class="mt-4">Email</label>
					<input type="text" class="form-control" name="email" placeholder="you@example.com" aria-label="Designation">
					
					<label class="mt-4">Contact Number</label>
					<input type="text" class="form-control" name="contact" placeholder="Eg: 9384465446" aria-label="Designation">
					
					<label class="mt-4">Address</label>
					<input type="text" class="form-control" name="address" placeholder="Add Adress here" aria-label="Designation">

					<label class="mt-4">Date Of Birth</label>
					<input type="date" class="form-control" name="dob" id="dob">
					
					<label class="mt-4">Gender</label>
					<select class="form-control" name="gender" id="gender">
					    <option value="0">Choose
					    </option>
					    <option value="Male">Male
					    </option>    
					    <option value="Female">Female
					    </option>
					</select>

					<label class="mt-4">Valid From</label>
					<input type="date" class="form-control date-change" name="joining_date" id="joining_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
					
					<label class="mt-4">Valid Till</label>
					<input type="text" class="form-control" name="due_date" id="due_date" placeholder="mm/dd/yyyy" readonly="">

					<label class="mt-4">Package</label>
					<select class="form-control date-change" name="package" id="package">
					    <option value="0" data-id="0">Choose
					    </option>
					    @forelse($packages as $package)
					    <option value="{{$package->duration}}" data-id="{{$package->id}}">{{$package->package_name}}
					    </option>
					    @empty{{''}}
					    @endforelse
					</select>
					<input type="hidden" name="package_id" id="package_id" value="0">
					<span class="text-success float-right" id="price"></span>
					<input type="hidden" name="price" id="amount" value="0">
					{{csrf_field()}}
					<button class="btn btn-primary mt-5 w-100" type="submit">Add </button>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script type="text/javascript">
		$('.date-change').change(function(){
			var joiningdate = new Date($('#joining_date').val());
			joiningdate.setMonth(joiningdate.getMonth()+parseInt($('#package').val()));
			$('#package_id').val($("#package option:selected").attr("data-id"));
			console.log("package: "+$("#package_id").val());
			console.log("date"+joiningdate);
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

			$('#due_date').attr('value', duedate);
			
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
	               if (this.readyState == 4 && this.status == 200)
	               {
	                    console.log('success');
	                    console.log(this.responseText);
	                    html = '';
	                    $('#price').empty();
	                    var json = JSON.parse(this.responseText);
	                    for(i=0; i<json.length; i++){
	                    	fetchprice = json[i];
	                    	$('#amount').val(fetchprice.price);
	                    	$('#price').text("Amount to be paid -"+fetchprice.price);
	                    }
	               }
	        };
	        xhttp.open("POST", '/api/fetchprice', true);
	        xhttp.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
	        xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	        xhttp.send('id='+$("#package_id").val());
		});
	</script>
@endsection

@endguest