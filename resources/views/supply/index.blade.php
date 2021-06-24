@extends('dashboard.base')

@section('content')
    @include('supply._create')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Supply Management</h3>
                                <div class="ml-auto">
                                    <button class="btn btn-primary " type="button" data-toggle="modal"
                                        data-target="#primaryModal">
                                        <i class="cil-plus"></i>
                                        Create
                                    </button>

                                    <a href="{{ route('supply.create') }}" class="btn btn-outline-primary ml-auto">
                                        <i class="cil-plus"></i>
                                        Create Bulk
                                    </a>
                                </div>
                        </div>
                        <form method="get" class="d-flex p-4">
                            <input type="text" name="search_code" class="form-control" placeholder="Search Code"
                                value="{{ $request->search_code ?? '' }}">
                            <input type="text" name="search_name" class="form-control" placeholder="Search Name"
                                value="{{ $request->search_name ?? '' }}">
                            <select name="search_qualification" class="form-control">
                                <option value="">-- Select Qualification --</option>
                                @foreach ($quals as $qual)
                                    <option value="{{ $qual->id }}"
                                        {{ $qual->id == $request->search_qualification ? 'selected' : '' }}>
                                        {{ $qual->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary">
                                Search
                            </button>
                            <a href="{{ route('supply.index') }}" class="btn btn-outline-danger mr-auto">
                                Clear
                            </a>
                        </form>
                        <div class="card-body">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Max Quantity</th>
                                        <th>Qualification</th>
                                        <th width="11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplies as $supply)
                                        <tr>
                                            <td>{{ $supply->code ?? '' }}</td>
                                            <td>{{ $supply->name ?? '' }}</td>
                                            <td>{{ $supply->unit }}</td>
                                            <td>{{ $supply->quantity ?? '0' }}</td>
                                            <td>{{ $supply->qualification->name ?? '' }}</td>
                                            <td>
                                                <form action="{{ route('supply.destroy', $supply->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger float-right btn-delete">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-edit"
                                                    data-url="{{ route('supply.edit', $supply->id) }}">
                                                    <i class="cil-pencil"></i>
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
    <div class="append-supply"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.btn-edit').click(function() {
            var div = $('.append-supply');
            div.empty();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                success: function(data) {
                    div.append(data);
                    $('#edit_supply').modal('show');
                }
            });
        });

        $('.btn-delete').click(function(e) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this supply?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $(this).closest('form').submit();
                }
            })
        });

    </script>
@endsection
