@extends('dashboard.base')

@section('content')
    @include('supplier._create')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Supplier Management</h4>
                            <div class="ml-auto">
                                <button class="btn btn-primary " type="button" data-toggle="modal"
                                    data-target="#primaryModal">
                                    <i class="cil-plus"></i>
                                    Create
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th width="15%">Business Permit No.</th>
                                        <th width="15%">TIN</th>
                                        <th width="15%">PhilGEPS Reg No.</th>
                                        <th width="11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier as $i => $s)
                                        <tr>
                                            <td>{{ $s->name ?? '' }}</td>
                                            <td>{{ $s->address ?? 'N/a' }}</td>
                                            <td>{{ $s->business_permit_number ?? 'N/a' }}</td>
                                            <td>{{ $s->tin ?? 'N/a' }}</td>
                                            <td>{{ $s->philgeps_reg_number ?? 'N/a' }}</td>
                                            <td>
                                                <form action="{{ route('suppliers.destroy', $s->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger float-right btn-delete">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-edit"
                                                    data-url="{{ route('suppliers.edit', $s->id) }}">
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
                    $('#edit_supplier').modal('show');
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
