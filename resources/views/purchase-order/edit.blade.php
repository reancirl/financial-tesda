@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="modal-title">Supplier: {{ $po->supplier->name ?? '' }} | PO Number:
                                {{ $po->pr->number ?? '' }}
                            </h4>
                            <a class="btn btn-outline-primary ml-auto" href="{{ route('purchase-order.index') }}">
                                <i class="cil-arrow-circle-left"></i>
                                Go back
                            </a>
                        </div>
                        <form action="{{ route('purchase-order.update', $po->id) }}" method="POST" id="form-submit">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-5">
                                        <h6>Delivery Term</h6>
                                        <input type="number" class="form-control" name="delivery_term"
                                            placeholder="Delivery Term in DAYS" min="1" required
                                            value="{{ $po->delivery_term ?? '' }}">
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-5">
                                        <h6>Mode of Procurement</h6>
                                        <select name="mode_of_procurement" id="" class="form-control" required>
                                            <option value="">-- Select Mode of Procurement --</option>
                                            <option value="Small Value"
                                                {{ $po->mode_of_procurement == 'Small Value' ? 'selected' : '' }}> Small
                                                Value
                                            </option>
                                            <option value="Shopping"
                                                {{ $po->mode_of_procurement == 'Shopping' ? 'selected' : '' }}> Shopping
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-responsive-sm text-center table-sm">
                                    <thead>
                                        <tr class="">
                                            <th scope="col">Unit</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Unit Cost</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($po->items as $i => $item)
                                            <tr>
                                                <td>{{ $item->pr_item->cart_item->supply->unit ?? '' }}</td>
                                                <td>{{ $item->pr_item->cart_item->supply->name ?? '' }}</td>
                                                <td>{{ number_format($item->pr_item->cart_item->unit_cost, 2) ?? '' }}
                                                </td>
                                                <td>{{ $item->pr_item->cart_item->quantity ?? '0' }}</td>
                                                @php
                                                    $total_cost = $item->pr_item->cart_item->unit_cost * $item->pr_item->cart_item->quantity ?? 0;
                                                @endphp
                                                <td>
                                                    {{ number_format($total_cost, 2) }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="pr_item_id[{{ $i }}]"
                                                        class="form-control" value="{{ $item->pr_item->id ?? '' }}">
                                                    <input type="hidden" name="item_id[{{ $i }}]"
                                                        class="form-control" value="{{ $item->id ?? '' }}">
                                                    <input type="text" name="status[{{ $i }}]"
                                                        class="form-control text-right item_status"
                                                        value="{{ $item->status ?? '' }}" readonly>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="dropdown-toggle" type="button" id="dropdownMenu2"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="all:unset;">
                                                            Change Status
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            @if ($item->status == 'Pending')
                                                                @if (!auth()->user()->hasRole('supply_officer'))
                                                                    <button class="dropdown-item item_approve"
                                                                        type="button">Approve</button>
                                                                @else
                                                                    <button class="dropdown-item" type="button">No Available
                                                                        Action!</button>
                                                                @endif
                                                            @elseif ($item->status == 'Approve')
                                                                @if (!auth()->user()->hasRole('supply_officer'))
                                                                    <button class="dropdown-item item_receive"
                                                                        type="button">Receive</button>
                                                                @else
                                                                    <button class="dropdown-item" type="button">No Available
                                                                        Action!</button>
                                                                @endif
                                                            @else
                                                                <button class="dropdown-item" type="button">No Available
                                                                    Action!</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <div class="d-flex">
                                    <div class="ml-auto">
                                        @if ($po->is_submitted)
                                            <a class="btn btn-success mr-3" href="{{ $request->fullUrl() }}?report=true"
                                                target="_blank"><i class="fa fa-paperclip"></i>
                                                Generate Report</a>
                                            @role('finance_officer|admin')
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                Submit</button>
                                            @endrole
                                        @else
                                            @if ($po->completed_count != $po->items->count() &&
        !auth()->user()->hasRole('finance_officer'))
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                    Submit</button>
                                            @endif
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
        $('.item_receive').click(function(e) {
            var item = $(this).closest('tr').find('.item_status')
            item.val('Receive')
            item.addClass('border-success text-success')
        })

        $('.item_approve').click(function(e) {
            var item = $(this).closest('tr').find('.item_status')
            item.val('Approve')
            item.addClass('border-success text-success')
        })

        $('#form-submit').submit(function(e) {
            e.preventDefault(e)
            swal({
                title: "Are you sure you want to submit?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $(this).off('submit').submit()
                }
            })
        })

        $('.report_btn').click(function(e) {
            alert(
                'This button is not yet working, if working this action will generate "PURCHASE ORDER REPORT"'
            )
        })

        $('.inspection_report_btn').click(function(e) {
            alert(
                'This button is not yet working, if working this action will generate "INSPECTION & ACCEPTANCE REPORT"'
            )
        })
    </script>
@endsection
