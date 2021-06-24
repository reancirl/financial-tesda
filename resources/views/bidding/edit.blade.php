@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="modal-title">Requested by:
                                {{ $bidding->user->name ?? '' }} |
                                PR No.: {{ $bidding->purchase_request->number ?? '' }}
                            </h4>
                            <a class="btn btn-outline-primary ml-auto" href="{{ route('bidding.index') }}">
                                <i class="cil-arrow-circle-left"></i>
                                Go back
                            </a>
                        </div>
                        <form action="{{ route('bidding.update', $bidding->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <h6 class="mb-2">Current Status:</h6>
                                <select name="is_done" id="" class="form-control mb-4">
                                    <option value="">-- Change Status --</option>
                                    <option value="0" {{ $bidding->is_done ? '' : 'selected' }}>On Progress</option>
                                    <option value="1" {{ $bidding->is_done ? 'selected' : '' }}>Done</option>
                                </select>
                                <table class="table table-responsive-sm text-center table-sm">
                                    <thead>
                                        <tr class="">
                                            <th width="3%">#</th>
                                            <th width="35%">Supply</th>
                                            <th width="4%">Unit</th>
                                            <th width="3%">Quantity</th>
                                            <th width="15%">{{ $bidding->supplier_one->name ?? '' }}</th>
                                            <th width="15%">{{ $bidding->supplier_two->name ?? '' }}</th>
                                            <th width="15%">{{ $bidding->supplier_three->name ?? '' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bidding->items as $i => $item)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $item->pr_item->cart_item->supply->name ?? '' }}</td>
                                                <td>{{ $item->pr_item->cart_item->supply->unit ?? '' }}</td>
                                                <td>{{ $item->pr_item->cart_item->quantity ?? 0 }}</td>
                                                <td>
                                                    <input type="hidden" name="item_id[{{ $i }}]"
                                                        value="{{ $item->id }}">
                                                    <input type="number" class="form-control text-right"
                                                        name="price_one[{{ $i }}]"
                                                        value="{{ $item->price_one ?? '' }}" @role('finance_officer')
                                                        readonly @endrole>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-right"
                                                        name="price_two[{{ $i }}]"
                                                        value="{{ $item->price_two ?? '' }}" @role('finance_officer')
                                                        readonly @endrole>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-right"
                                                        name="price_three[{{ $i }}]"
                                                        value="{{ $item->price_three ?? '' }}" @role('finance_officer')
                                                        readonly @endrole>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                @role('admin|supply_officer|finance_officer')
                                <div class="d-flex">
                                    <div class="ml-auto">
                                        @if ($bidding->is_done)
                                            <button class="btn btn-success mr-3 abstract_of_request_btn" type="button"><i
                                                    class="fa fa-paperclip"></i>
                                                Generate Abstract of Request</button>
                                            @if ($bidding->is_approved == 0)
                                                @role('admin|finance_officer')
                                                <input type="hidden" name="approve" value="true">
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                    Approve</button>
                                                @endrole
                                            @endif
                                        @else
                                            @role('admin|supply_officer')
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                                Save Changes</button>
                                            @endrole
                                        @endif
                                    </div>
                                </div>
                                @endrole
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.abstract_of_request_btn').click(function(e) {
            alert(
                'This button is not yet working, if working this action will generate "ABSTRACT OF REQUEST FOR PRICE QUOTATION"'
            )
        })

    </script>
@endsection
