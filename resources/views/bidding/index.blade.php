@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Bidding Management</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>PR Number</th>
                                        <th>Requestor</th>
                                        <th>Bidders</th>
                                        <th>Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biddings as $i => $bid)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $bid->purchase_request->number ?? '' }}</td>
                                            <td>{{ $bid->user->name ?? '' }}</td>
                                            <td class="text-center">
                                                @if ($bid->supplier_one_id || $bid->supplier_two_id || $bid->supplier_three_id)
                                                    <h6><u>{{ $bid->supplier_one->name ?? '' }}</u></h6>
                                                    <h6><u>{{ $bid->supplier_two->name ?? '' }}</u></h6>
                                                    <h6><u>{{ $bid->supplier_three->name ?? '' }}</u></h6>
                                                @else
                                                    N/a
                                                @endif
                                            </td>
                                            <td>{{ $bid->is_done ? 'Close' : 'Open' }}</td>
                                            <td>
                                                @if ($bid->supplier_one_id && $bid->supplier_two_id && $bid->supplier_three_id)
                                                    <a class="btn btn-primary btn-sm btn-view"
                                                        href="{{ route('bidding.edit', $bid->id) }}">
                                                        <i class="cil-zoom"></i> View Items
                                                    </a>
                                                @else
                                                    @if (!auth()->user()->hasRole('finance_officer'))
                                                        <button type="button" class="btn btn-success btn-sm btn-create"
                                                            data-url="{{ route('addBidders', $bid->id) }}">
                                                            <i class="cil-plus"></i>
                                                            Add Bidders
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item" type="button">No Available
                                                            Action!</button>
                                                    @endif
                                                @endif
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
    <div class="append-bidders"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.btn-create').click(function() {
            var div = $('.append-bidders');
            div.empty();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                success: function(data) {
                    div.append(data);
                    $('#add_bidders').modal('show');
                }
            });
        });

    </script>
@endsection
