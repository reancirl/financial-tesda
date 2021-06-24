@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Purchase Order Management</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="text-left">PO Number</th>
                                        <th>Supplier</th>
                                        <th>Qualification</th>
                                        <th>Number of Supply</th>
                                        <th>Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase_orders as $i => $po)
                                        <tr>
                                            <td class="text-left">
                                                {{ $po->pr->po_number ?? '' }}{{ $po->pr->po_number ? str_pad($po->id, 3, 0, STR_PAD_LEFT) : '' }}
                                            </td>
                                            <td>{{ $po->supplier ?? '' }}</td>
                                            <td>{{ $po->qualification->name ?? '' }}</td>
                                            <td>{{ $po->items->count() }}</td>
                                            <td>
                                                @if ($po->completed->count() == $po->items->count())
                                                    <span class="badge badge-success p-2">Completed</span>
                                                @elseif($po->status->count() == 0)
                                                    <span class="badge badge-secondary p-2">Pending</span>
                                                @else
                                                    <span class="badge badge-primary p-2">On Process</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-primary btn-view"
                                                    href="{{ route('purchase-order.edit', $po->id) }}">
                                                    <i class="cil-zoom"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="append-request"></div>
@endsection
@section('script')
    <script type="text/javascript">

    </script>
@endsection
