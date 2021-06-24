@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body pb-0">
                            <div class="text-value-md">Total Amount Spent in PO</div>
                            <div class="text-value-lg">₱ {{ number_format($po_amount, 2) }}</div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:30px;">
                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-info">
                        <div class="card-body pb-0">
                            <div class="text-value-md">Total Number of Supplies</div>
                            <div class="text-value-lg">{{ $supply }}</div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:30px;">
                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body pb-0">
                            <div class="text-value-md">Total Number of PO</div>
                            <div class="text-value-lg">{{ $po }}</div>
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:30px;">
                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body pb-0">
                            <div class="text-value-md">Total Number of PR</div>
                            <div class="text-value-lg">{{ $pr }}</div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:30px;">
                            <canvas class="chart" id="card-chart4" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Qualifications PR and Request Summary</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Qualifications</th>
                                        <th>Number of Closed PO</th>
                                        <th>Total amount on PR</th>
                                        <th class="text-right">Remaining Budget for the Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quals as $i => $q)
                                        <tr>
                                            <td>{{ $q->name ?? '' }}</td>
                                            <td>{{ $q->closed_po->count() ?? 0 }}</td>
                                            <td>
                                                @if ($q->purchase_requests->count() > 0)
                                                    @php $total = 0 @endphp
                                                    @foreach ($q->purchase_requests as $pr)
                                                        @foreach ($pr->items as $item)
                                                            @php $total += $item->cart_item->unit_cost @endphp
                                                        @endforeach
                                                    @endforeach
                                                    ₱ {{ number_format($total, 2) }}
                                                @else
                                                    ₱ 0.00
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                ₱ {{ number_format($q->remaining_budget, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>

@endsection

@section('javascript')

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
