@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="text-uppercase">Notifications</h3>
        </div>
    </div>
    @forelse($notifications as $notify)
        <div class="row mt-3">
            <div class="col-12 col-lg-8">
                <div class="row mb-3 p-2 bg-light info-div">
                    <div class="col-lg-1 col-12">
                        <div class="info-icon text-warning text-center">
                            <i class="fas fa-info"></i>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12">
                        <a href="/customer/view" class="text-secondary">
                        {{$notify->customer_name}} membership ends on {{ \Carbon\Carbon::parse($notify->due_date)->formatLocalized('%d %b %Y')}}.
                        </a>
                    </div>
                    <div class="col-lg-3 col-12">
                        <a href="" data-toggle="modal" data-target="#notify{{$notify->id}}" class="btn btn-outline-warning">Extend</a>
                    </div>
                </div>
            </div>
        </div>
    @empty{{'No Notifications for now'}}
    @endforelse
    <hr>
    <div class="row mt-4">
        <div class="col-12 mb-2">
            <h3 class="text-uppercase">STATISTICS</h3>
        </div>  
        <div class="col-12 col-lg-3 bg-primary text-center pb-2">
            <i class="fa fa-list-alt"></i>
            <br>
            Total members
            <br>
            <span class="badge badge-info pl-3 pr-3">{{count($members)}}</span>
        </div>
        <div class="col-12 col-lg-3 bg-success text-center pb-2 ml-lg-2">
            <i class="fa fa-list-alt"></i>
            <br>
            Joining(this month)
            <br>
            <span class="badge badge-light pl-3 pr-3">{{count($joining_members)}}</span>
        </div>
        <div class="col-12 col-lg-3 bg-warning text-center pb-2 ml-lg-2">
            <i class="fa fa-list-alt"></i>
            <br>
            GYM Due Amount
            <br>
            <span class="badge badge-light pl-3 pr-3">
                @php
                    $dueamt = 0;
                    $result = 0;
                @endphp
                @foreach($notifications as $notify)
                    @php
                    $dueamt = DB::table('packages')->where('id', $notify->package_id)->value('price');
                    $result = $dueamt + $result;
                    @endphp
                @endforeach
                ₹ {{$result}}
            </span>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-lg-3 bg-danger text-center pb-2">
            <i class="fa fa-list-alt"></i>
            <br>
            Memberships Expired
            <br>
            <span class="badge badge-light pl-3 pr-3">{{count($notifications)}}</span>
        </div>
        <div class="col-12 col-lg-3 bg-warning text-center pb-2 ml-lg-2">
            <i class="fa fa-list-alt"></i>
            <br>
            Memberships Expiring this month
            <br>
            <span class="badge badge-light pl-3 pr-3">{{count($expiring_members)}}</span>
        </div>
    </div>
</div>
@endsection

@section('modal')
    @forelse($notifications as $notify)
        <div class="modal fade" id="notify{{$notify->id}}" tabindex="-1" role="dialog" aria-labelledby="categoryTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="post" action="/notification/update/{{$notify->customer_id}}/{{$notify->customer_name}}/{{$notify->id}}" enctype="multipart/form-data">
                        <div class="modal-header">
                            <div class="header-content">
                                <h5 class="modal-title" id="exampleModalLongTitle">Extend Membership for {{$notify->customer_name}}</h5>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label class="mt-2">Start From</label>
                            <input type="date" class="date-change form-control pb-5" name="joiningdate" id="joiningdate{{$notify->id}}" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" data-id="{{$notify->id}}">
                            <label class="mt-4">Valid Till</label>
                            <input type="text" name="due_date" id="due_date{{$notify->id}}" class="form-control" readonly="" placeholder="mm/dd/yyyy">
                            <label class="mt-4">Select Package</label>
                            <select class="date-change form-control" name="package" id="package{{$notify->id}}" data-id="{{$notify->id}}">
                                <option value="0">Choose</option>
                                @forelse($packages as $package)
                                    <option value="{{$package->duration}}" data-id="{{$package->id}}">{{$package->package_name}}</option>
                                @empty{{''}}
                                @endforelse
                            </select>
                            <input type="hidden" name="package_id" id="package_id{{$notify->id}}" value="0">
                            <input type="hidden" name="price" id="amount{{$notify->id}}" value="0">
                        </div>
                        <div class="modal-footer">
                            <span class="text-success float-left font-weight-bold" id="price{{$notify->id}}"></span>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary">Extend</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty{{''}}
    @endforelse
@endsection
@section('js')
    <script type="text/javascript">
        $('.date-change').change(function(){
            var id=$(this).attr('data-id');
            var joiningdate = new Date($('#joiningdate'+id).val());
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
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200)
                   {
                        console.log('success');
                        console.log(this.responseText);
                        html = '';
                        $('#price'+id).empty();
                        var json = JSON.parse(this.responseText);
                        for(i=0; i<json.length; i++){
                            fetchprice = json[i];
                            $('#amount'+id).val(fetchprice.price);
                            $('#price'+id).text("(Amount to be paid - Rs. "+fetchprice.price+")");
                        }
                   }
            };
            xhttp.open("POST", '/api/fetchprice', true);
            xhttp.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf-token"]').attr('content'));
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send('id='+$("#package_id"+id).val());
        });
    </script>
@endsection