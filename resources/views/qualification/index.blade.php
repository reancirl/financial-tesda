@extends('dashboard.base')

@section('content')
    @include('qualification._create')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Qualification Management</h3>
                                <button class="btn btn-primary ml-auto" type="button" data-toggle="modal"
                                    data-target="#primaryModal">
                                    <i class="cil-plus"></i>
                                    Create
                                </button>
                        </div>
                        <form method="get" class="d-flex p-4">
                            <input type="text" name="search_code" class="form-control" placeholder="Search Code"
                                value="{{ $request->search_code ?? '' }}">
                            <input type="text" name="search_name" class="form-control" placeholder="Search Name"
                                value="{{ $request->search_name ?? '' }}">
                            <button type="submit" class="btn btn-outline-primary">
                                Search
                            </button>
                            <a href="{{ route('qualification.index') }}" class="btn btn-outline-danger mr-auto">
                                Clear
                            </a>
                        </form>
                        <div class="card-body">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Remaining Budget</th>
                                        <th width="11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quals as $qual)
                                        <tr>
                                            <td>{{ $qual->code ?? '' }}</td>
                                            <td>{{ $qual->name ?? '' }}</td>
                                            <td>{{ number_format($qual->remaining_budget, 2) }}</td>
                                            <td>
                                                <form action="{{ route('qualification.destroy', $qual->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger float-right btn-delete">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-edit"
                                                    data-url="{{ route('qualification.edit', $qual->id) }}">
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
    <div class="append-qualification"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.btn-edit').click(function() {
            var div = $('.append-qualification');
            div.empty();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                success: function(data) {
                    div.append(data);
                    $('#edit_qualification').modal('show');
                }
            });
        });

        $('.btn-delete').click(function(e) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this qualification?",
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
