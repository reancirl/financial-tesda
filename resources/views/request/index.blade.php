@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Request Management</h3>
                                @if (!auth()->user()->hasAnyRole('finance_officer'))
                                    <a class="btn btn-outline-primary ml-auto"
                                        href="{{ route('dashboard.index') }}?shop=true">
                                        <i class="cil-arrow-circle-left"></i>
                                        Go back to supplies
                                    </a>
                                @endif
                        </div>
                        @hasanyrole('admin|finance_officer')
                        <form method="get" class="d-flex p-4">
                            <select name="search_qualification" class="form-control">
                                <option value="">-- Select Qualification --</option>
                                @foreach ($quals as $qual)
                                    <option value="{{ $qual->id }}"
                                        {{ $request->search_qualification == $qual->id ? 'selected' : '' }}>
                                        {{ $qual->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary">
                                Search
                            </button>
                            <a href="{{ route('request.index') }}" class="btn btn-outline-danger mr-auto">
                                Clear
                            </a>
                        </form>
                        @endrole
                        <div class="card-body">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr class="">
                                        <th>#</th>
                                        <th>Requestor</th>
                                        <th>Qualification</th>
                                        @hasanyrole('admin|finance_officer|supply_officer')
                                        <th>Total Amount</th>
                                        @endrole
                                        <th>Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($req as $i => $r)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $r->user->name ?? '' }}</td>
                                            <td>{{ $r->user->qualification->code ?? 'N/A' }}</td>
                                            @hasanyrole('admin|finance_officer|supply_officer')
                                            <td>
                                                {{ number_format($r->overall_total, 2) ?? '0' }}
                                            </td>
                                            @endrole
                                            <td>
                                                @if ($r->cart->completed->count() == $r->cart->items->count())
                                                    <span class="badge badge-success p-2">Completed</span>
                                                @elseif($r->cart->status->count() == 0)
                                                    <span class="badge badge-secondary p-2">Pending</span>
                                                @else
                                                    <span class="badge badge-primary p-2">On Process</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-view"
                                                    data-url="{{ route('request.show', $r->id) }}">
                                                    <i class="cil-zoom"></i> View
                                                </button>
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
    @include('request._modal')
@endsection
@section('script')
    <script type="text/javascript">
        $('.btn-view').click(function() {
            var div = $('.append-request');
            div.empty();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                success: function(data) {
                    div.append(data);
                    $('#view_request').modal('show');
                }
            });
        });

        $(document).on('click', '.decline_remarks_btn', function(e) {
            $('#decline_modal').modal('show');
            $('#remarks_field').val($(this).data('remarks'));
            $('.modal-title').html($(this).data('user'));
        })

    </script>
@endsection
