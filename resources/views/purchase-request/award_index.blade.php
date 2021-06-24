@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Award Management</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr class="">
                                        <th class="text-left">PR Number</th>
                                        <th>Requestor</th>
                                        <th>Qualification</th>
                                        <th>Overall</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prs as $i => $pr)
                                        <tr>
                                            <td class="text-left">{{ $pr->number ?? 'N/A' }}</td>
                                            <td>{{ $pr->items->first()->cart_item->cart->user->name ?? '' }}</td>
                                            <td>{{ $pr->qualification->name ?? '' }}</td>
                                            <td>{{ $pr->request ? number_format($pr->request->overall_total, 2) : '0.00' }}
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-primary btn-view"
                                                    href="{{ route('purchase-request.award_edit', $pr->id) }}">
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
