@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="modal-title">Requested by {{ $requisition->user->name ?? '' }}
                                {{ $requisition->user->qualification ? 'from ' . $requisition->user->qualification->name . ' Department' : '' }}
                            </h4>
                            <a class="btn btn-outline-primary ml-auto" href="{{ route('request.index') }}">
                                <i class="cil-arrow-circle-left"></i>
                                Go back
                            </a>
                        </div>
                        <form action="{{ route('request.update', $requisition->id) }}" method="POST" id="form-submit">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="qualification_id"
                                value="{{ $requisition->user->qualification_id }}">
                            <div class="card-body">
                                <table class="table table-responsive-sm text-center table-sm">
                                    <thead>
                                        <tr class="">
                                            <th scope="col">Code</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Qualification</th>
                                            <th scope="col">Quantity Request</th>
                                            <th scope="col">Sub-total</th>
                                            <th scope="col" class="text-right">Max Quantity</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requisition->cart->items as $i => $item)
                                            <tr>
                                                <td>{{ $item->supply->code ?? '' }}</td>
                                                <td>{{ $item->supply->name ?? '' }}</td>
                                                <td>{{ $item->supply->qualification->name ?? '' }}</td>
                                                <td>{{ $item->quantity ?? '' }} {{ $item->supply->type ?? '' }}</td>
                                                <td>{{ number_format($item->unit_cost, 2) ?? '' }}</td>
                                                <td class="text-right">{{ $item->supply->quantity ?? '0' }}
                                                    {{ $item->supply->type ?? '' }}</td>
                                                <td class="text-right">
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
                                                                @role('admin')
                                                                @if ($item->supply->in_stock && $item->status != 'In Stock')
                                                                    <button class="dropdown-item item_in_stock"
                                                                        type="button">In Stock</button>
                                                                @endif
                                                                @endrole
                                                                @if ($item->status == 'In Stock')
                                                                    <button class="dropdown-item item_completed"
                                                                        type="button">Completed</button>
                                                                @endif
                                                                <button class="dropdown-item item_decline"
                                                                    type="button">Decline</button>
                                                                @if ($item->status == 'Pending')
                                                                    <div class="dropdown-divider"></div>
                                                                    <button class="dropdown-item add_to_purchase_request"
                                                                        type="button">Add to purchase request</button>
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
                                <div class="d-flex">
                                    <div class="ml-auto">
                                        @if ($requisition->cart->completed->count() != $requisition->cart->items->count())
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                Submit</button>
                                        @else
                                            <button class="btn btn-success mr-3 report_btn" type="button"><i
                                                    class="fa fa-paperclip"></i>
                                                Generate Slip</button>
                                        @endif
                                    </div>
                                </div>
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
        $('.item_in_stock').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('In Stock');
            item.addClass('border-warning text-warning');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.val('');
            decline_remarks.hide();
            decline_remarks.attr('required', false);
        });

        $('.add_to_purchase_request').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('On Process');
            item.addClass('border-warning text-warning');
            var decline_remarks = $(this).closest('tr').find('.item_decline_remarks');
            decline_remarks.val('');
            decline_remarks.hide();
            decline_remarks.attr('required', false);
        });

        $('.item_completed').click(function(e) {
            var item = $(this).closest('tr').find('.item_status');
            item.val('Completed');
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

        $('.report_btn').click(function(e) {
            alert(
                'This button is not yet working, if working this action will generate "REQUISITION AND ISSUE SLIP"'
            )
        })
    </script>
@endsection
