@extends('dashboard.base')

@section('content')
    @include('purchase-request._award')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="modal-title">Approved by:
                                {{ $pr->user->name ?? '' }}{{ $pr->qualification ? ', Qualification items from ' . $pr->qualification->name . ' Department' : '' }}
                            </h4>
                            <a class="btn btn-outline-primary ml-auto" href="{{ route('purchase-request.index') }}">
                                <i class="cil-arrow-circle-left"></i>
                                Go back
                            </a>
                        </div>
                        <form action="{{ route('purchase-request.update', $pr->id) }}" method="POST" id="form-submit">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <h5 class="mb-3">Remaining Budget :
                                    {{ $pr->qualification ? number_format($pr->qualification->remaining_budget, 2) : '50,000' }}
                                </h5>
                                <select name="fund_cluster" class="form-control mb-3" required>
                                    <option value="">-- Select Fund Cluster --</option>
                                    <option value="161" {{ $pr->fund_cluster == 161 ? 'selected' : '' }}>SSP</option>
                                    <option value="101" {{ $pr->fund_cluster == 101 ? 'selected' : '' }}>General Fund
                                    </option>
                                </select>
                                <table class="table table-responsive-sm text-center table-sm">
                                    <thead>
                                        <tr class="">
                                            <th scope="col">Code</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Unit Cost</th>
                                            <th scope="col">Quantity Request</th>
                                            <th scope="col">Total Cost</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pr->items as $i => $item)
                                            <tr>
                                                <td>{{ $item->cart_item->supply->code ?? '' }}</td>
                                                <td>{{ $item->cart_item->supply->name ?? '' }}</td>
                                                <td>{{ number_format($item->cart_item->unit_cost, 2) ?? '' }}</td>
                                                <td>{{ $item->cart_item->quantity ?? '0' }}</td>
                                                @php
                                                    $total_cost = $item->cart_item->unit_cost * $item->cart_item->quantity ?? 0;
                                                @endphp
                                                <td>
                                                    {{ number_format($total_cost, 2) }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="item_id[{{ $i }}]"
                                                        value="{{ $item->id }}">
                                                    <input type="text" name="status[{{ $i }}]"
                                                        class="form-control text-right item_status"
                                                        value="{{ $item->status ?? '' }}" readonly>
                                                    <textarea type="text" name="item_remarks[{{ $i }}]"
                                                        class="form-control item_decline_remarks mt-2" style="display:none"
                                                        placeholder="Remarks">{{ $item->remarks }}</textarea>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'Decline')
                                                        <u class="text-danger font-weight-bold view_remarks_btn"
                                                            data-remarks="{{ $item->remarks ?? '' }}"
                                                            data-user="{{ $item->user ? 'Updated by: ' . $item->user->name : 'Remarks:' }}"
                                                            style="cursor:pointer">View Remarks</u>
                                                    @elseif($item->status == 'Receive')
                                                        <span class="text-success font-weight-bold">Date Received:
                                                            {{ $item->updated_at->format('M d, Y') }}</span>
                                                    @else
                                                        <div class="dropdown">
                                                            <button class="dropdown-toggle" type="button" id="dropdownMenu2"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false" style="all:unset;">
                                                                Change Status
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                @if ($item->status == 'Awarded')
                                                                    @if (!auth()->user()->hasRole('finance_officer'))
                                                                        <button class="dropdown-item item_awarded"
                                                                            type="button"
                                                                            data-supply="{{ $item->cart_item->supply->name ?? '' }}"
                                                                            data-cart_item_id="{{ $item->cart_item->id }}"
                                                                            data-pr_item_id="{{ $item->id }}">Input
                                                                            Award</button>
                                                                    @endif
                                                                    {{-- @elseif($item->status == 'Bidding')
                                                                    @if (!auth()->user()->hasRole('supply_officer'))
                                                                        <button class="dropdown-item item_approve"
                                                                            type="button">Approve</button>
                                                                    @endif --}}
                                                                @elseif($item->status == 'Pending' &&
                                                                    !auth()->user()->hasRole('finance_officer'))
                                                                    <button class="dropdown-item item_approve"
                                                                        type="button">Approve</button>
                                                                @elseif($item->status == 'In Stock')
                                                                    @if (!auth()->user()->hasRole('finance_officer'))
                                                                        <button class="dropdown-item item_receive"
                                                                            type="button">Receive</button>
                                                                    @endif
                                                                @endif
                                                                @if (!auth()->user()->hasRole('finance_officer'))
                                                                    <button class="dropdown-item item_decline"
                                                                        type="button">Decline</button>
                                                                @else
                                                                    <button class="dropdown-item" type="button">No Available
                                                                        Action!</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                @role('admin|supply_officer|finance_officer')

                                <div class="d-flex">
                                    <div class="ml-auto">
                                        @if (!$pr->is_active)
                                            <a class="btn btn-success mr-3" href="{{ $request->fullUrl() }}?rfq=true"
                                                target="_blank"><i class="fa fa-paperclip"></i>
                                                Generate RFQ</a>
                                            <a class="btn btn-success mr-3" href="{{ $request->fullUrl() }}?report=true"
                                                target="_blank"><i class="fa fa-paperclip"></i>
                                                Generate Report</a>
                                        @endif
                                        @if ($pr->completed_count != $pr->items->count())
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                Submit</button>
                                        @endif
                                    </div>
                                </div>
                                @endrole
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('request._modal')
@endsection
@section('script')
    <script type="text/javascript">
        $('.item_receive').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('Receive');
            item.addClass('border-success text-success');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.val('');
            decline_remarks.hide();
            decline_remarks.attr('required', false);
        });

        $('.item_decline').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('Decline');
            item.addClass('border-warning text-warning');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.show();
            decline_remarks.attr('required', true);
        });

        $('.item_approve').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('Approve');
            item.addClass('border-warning text-warning');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.val('');
            decline_remarks.hide();
            decline_remarks.attr('required', false);
        });

        $('.item_bidding').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('Bidding');
            item.addClass('border-warning text-warning');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.val('');
            decline_remarks.hide();
            decline_remarks.attr('required', false);
        });

        $('.item_awarded').click(function(e) {
            $('#primaryModal').modal('show');

            var supply = $(this).data('supply');
            $('#award_supply').val(supply);

            var cart_item_id = $(this).data('cart_item_id');
            $('#cart_item_id').val(cart_item_id);

            var pr_item_id = $(this).data('pr_item_id');
            $('#pr_item_id').val(pr_item_id);
        });

        $('.view_remarks_btn').click(function(e) {
            $('#decline_modal').modal('show');
            $('#remarks_field').val($(this).data('remarks'));
            $('.modal-title').html($(this).data('user'));
        })

        $('#form-submit').submit(function(e) {
            e.preventDefault(e);
            swal({
                title: "Are you sure you want to submit?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $(this).off('submit').submit();
                }
            })
        });
    </script>
@endsection
