@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">PMR</h3>
                        </div>
                        <form method="get" class="d-flex p-4">
                            <select name="month" class="form-control">
                                <option value="">-- Select Month --</option>
                                @foreach ($month as $i => $data)
                                    <option value="{{ ++$i }}" {{ $request->month == $i ? 'selected' : '' }}>
                                        {{ $data }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary">
                                Search
                            </button>
                            <a href="{{ route('dashboard.pmr') }}" class="btn btn-outline-danger mr-auto">
                                Clear
                            </a>
                        </form>
                        <div class="card-body">
                            @php
                                $total = 0;
                            @endphp
                            @if ($request->month)
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>PR Number</th>
                                            <th>PR Date</th>
                                            <th>PO Date</th>
                                            <th>Status</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pr as $i => $p)
                                            <tr>
                                                <td>{{ $p->supply_name }}</td>
                                                <td>{{ $p->purchase_request->number ?? 'N/a' }}</td>
                                                <td>{{ date('M d,Y', strtotime($p->pr_created_at)) }}</td>
                                                </td>
                                                <td>{{ $p->po_created_at ? date('M d,Y', strtotime($p->po_created_at)) : 'N/a' }}
                                                </td>
                                                <td>{{ $p->pr_item_status }}</td>
                                                <td>{{ $p->quantity }}</td>
                                                <td>{{ $p->unit_cost ?? 'N/a' }}</td>
                                                @php
                                                    $expense = $p->quantity * $p->unit_cost;
                                                    $total += $expense;
                                                @endphp
                                                <td>{{ number_format($expense, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-right"><strong>Total:</strong></td>
                                            <td><strong>₱{{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a class="btn btn-success mr-3 report_btn float-right"
                                    href="{{ $request->fullUrl() }}&report=true" target="_blank"><i
                                        class="fa fa-paperclip"></i>
                                    Generate Report</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">

    </script>
@endsection
