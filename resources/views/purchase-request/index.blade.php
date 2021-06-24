@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Purchase Request Management</h3>
                        </div>
                        {{-- <form method="get" class="d-flex p-4">
							<select name="search_status" class="form-control">
								<option value="">-- Select Status --</option>
								<option value="Pending" {{ $request->search_status == 'Pending' ? 'selected' : '' }}>Pending</option>
							</select>
							<select name="search_qualification" class="form-control">
								<option value="">-- Select Qualification --</option>
								
							</select>
							<button type="submit" class="btn btn-outline-primary">
								Search
							</button>
							<a href="{{ route('purchase-request.index') }}" class="btn btn-outline-danger mr-auto">
								Clear
							</a>
						</form> --}}
                        <div class="card-body">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr class="">
                                        <th class="text-left">PR Number</th>
                                        <th>Requestor</th>
                                        <th>Qualification</th>
                                        <th>Overall</th>
                                        <th>Status</th>
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
                                            <td>
                                                @if ($pr->completed->count() == $pr->items->count())
                                                    <span class="badge badge-success p-2">Completed</span>
                                                @elseif($pr->status->count() == 0)
                                                    <span class="badge badge-secondary p-2">Pending</span>
                                                @else
                                                    <span class="badge badge-primary p-2">On Process</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-primary btn-view"
                                                    href="{{ route('purchase-request.edit', $pr->id) }}">
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
