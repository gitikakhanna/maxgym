@guest
    <script type="text/javascript">window.location="/home"</script>
@else

@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
			<h3 class="font-weight-bold text-uppercase text-secondary">{{$customer->name}}</h3>
			<br>
			<small>{{$customer->address}}</small>
			<p>{{$customer->contact}}<br>
			<a href="">{{$customer->email}}</a>
			</p>
			<span class="float-right font-weight-bold">Membership started on - {{ \Carbon\Carbon::parse($customer->created_at)->formatLocalized('%d %b %Y')}}</span>
		</div>
		<div class="col-12">
			<hr>
			<table class="table">
				<thead>
					<th>Package</th>
					<th>Valid from</th>
					<th>Valid till</th>
					<th>Amount Paid</th>
				</thead>
				<tbody>
					@php
						$total = 0;
					@endphp
					@forelse($invoice as $inv)
					<tr>
						<td>{{$inv->duration}} months package</td>
						<td>{{$inv->package_from}}</td>
						<td>{{$inv->package_till}}</td>
						<td class="text-success font-weight-bold">Rs. {{$inv->amount_paid}}</td>
						@php
						$total = $total+$inv->amount_paid;
						@endphp
					</tr>
					@empty{{''}}
					@endforelse
					<tr class="bg-primary">
						<td class="font-weight-bold text-right" colspan="4">Total Invoice Generated - Rs. {{$total}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@endguest