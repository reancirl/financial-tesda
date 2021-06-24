@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="d-flex p-4 font-weight justify-content-around">
                <button type="button" class="btn btn-primary px-5 py-3 font-weight-bold pr_btn">Purchase Request</button>

                <button type="button" class="btn btn-primary px-5 py-3 font-weight-bold req_btn">Purchase Order</button>

                <button type="button" class="btn btn-primary px-5 py-3 font-weight-bold qual_btn">Qualifications</button>
            </div>
        </div>

        <div class="card pr_div" style="display:none">
            <h3 class="pt-4 pl-4">Purchase Request</h3>
            <form action="{{ route('reports.purchaseRequest') }}" method="GET">
                <div class="row p-3 container">
                    <div class="col-sm-3">
                        <select name="qualification" id="" class="form-control" required>
                            <option value="">-- Select Qualification --</option>
                            @foreach($quals as $i => $qual)
                                <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="month" id="" class="form-control" required>
                            <option value="">-- Select Month --</option>
                            <option value="latest">Latest PR</option>
                            @foreach($months as $i => $month)
                                <option value="{{ ++$i }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="item_status" id="" class="form-control" required>
                            <option value="">-- Select Item/s Status  --</option>
                            <option value="All">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Approve">Approve</option>
                            <option value="Receive">Receive</option>
                            <option value="Decline">Decline</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success"><i class="cil-cloud-download"></i> Generate Report</button>
                        <button type="button" class="btn btn-danger hide_pr">Hide Section</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card req_div" style="display:none">
            <h3 class="pt-4 pl-4">Purchase Order</h3>
            <form action="{{ route('reports.purchaseOrder') }}" method="GET">
                <div class="row p-3 container">
                    <div class="col-sm-3">
                        <select name="qualification" id="" class="form-control" required>
                            <option value="">-- Select Qualification --</option>
                            @foreach($quals as $i => $qual)
                                <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="month" id="" class="form-control" required>
                            <option value="">-- Select Month --</option>
                            <option value="latest">Latest PO</option>
                            @foreach($months as $i => $month)
                                <option value="{{ ++$i }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success"><i class="cil-cloud-download"></i> Generate Report</button>
                        <button type="button" class="btn btn-danger hide_req">Hide Section</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card qual_div" style="display:none">
            <h3 class="pt-4 pl-4">Qualifications</h3>      
            <h3 class="pb-4 pl-4">Pending (under dev) </h3>        
            <button type="button" class="btn btn-danger hide_qual">Hide Section</button>
        </div>
    </div>
@endsection
@section('script')
	<script type="text/javascript">
		$('.pr_btn').click(function(e){
            $('.pr_div').show();
        });

        $('.req_btn').click(function(e){
            $('.req_div').show();
        });

        $('.hide_pr').click(function(e){
            $('.pr_div').hide();
        });

        $('.hide_req').click(function(e){
            $('.req_div').hide();
        });

        $('.qual_btn').click(function(e){
            $('.qual_div').show();
        });

        $('.hide_qual').click(function(e){
            $('.qual_div').hide();
        });
	</script>
@endsection