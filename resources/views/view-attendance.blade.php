@guest
    <script type="text/javascript">window.location="/home"</script>
@else
@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				View Attendance for the month selected
				<input type="hidden" name="trainerid" id="trainerid" value="{{$trainerid}}">
			</div>
			<div class="col-9 col-lg-4 mt-2">
				<input type="date" class="form-control" name="view_attendance" id="view_attendance" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
			</div>
			<div class="col-3 col-lg-3 ">
				<button class="btn btn-success" onclick="filter_attendance()">View</button>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<table class="table table-dark">
					<thead>
						<tr>
							<th>Name</th>
							<th>Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($attendance as $attended)
							<tr id="attend{{$attended->id}}" class="attendance">
								<td>{{$attended->name}}</td>
								<td>{{ \Carbon\Carbon::parse($attended->attended_date)->formatLocalized('%d %b %Y')}}</td>
								<td><span class="badge {{$attended->marking == 1?'badge-danger':'badge-success'}}">{{$attended->marking == 1?'Absent':'Present'}}</span></td>
							</tr>
						@empty{{''}}
						@endforelse	
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script type="text/javascript">
		function filter_attendance(){
			var f_date = new Date($('#view_attendance').val());
			var mm = f_date.getMonth()+1;
			var yyyy = f_date.getFullYear();
			if(mm<10){
				mm = '0'+mm;
			}

			var final_date = yyyy+"-"+mm;
			var trainerid = $('#trainerid').val();
			console.log(final_date+" "+trainerid);
			
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
               if (this.readyState == 4 && this.status == 200)
               {
                    console.log(this.responseText+"hy");
               		if(this.responseText == '')
               		{
               			$.each($(".attendance").removeClass('d-none'));
               		}
               		else{
               			var json = JSON.parse(this.responseText);
               			html = '';
               			$.each($(".attendance"), function(){
               				$(this).addClass('d-none');
               			});
               			for(i=0; i<json.length; i++)
               			{
               				$('#attend'+json[i]).removeClass('d-none');
               			}
               		}
               }
            };

            xhttp.open("POST", '/api/filter-attendance', true);
            xhttp.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send('f_date='+final_date+'&trainer_id='+trainerid);
		}
	</script>
@endsection
@endguest
