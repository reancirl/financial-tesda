@extends('dashboard.base')

@section('content')
    @include('purchase-request._award')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="modal-title">Approved by:
                                {{ $pr->user->name ?? '' }}{{ $pr->qualification ? ', Qualification items from ' . $pr->qualification->name . ' Department' : '' }}
                            </h4>
                            <a class="btn btn-outline-primary ml-auto" href="{{ route('purchase-request.award_index') }}">
                                <i class="cil-arrow-circle-left"></i>
                                Go back
                            </a>
                        </div>
                        <form action="{{ route('purchase-request.award_update', $pr->id) }}" method="POST"
                            id="form-submit">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <table class="table table-responsive-sm text-center table-sm">
                                    <thead>
                                        <tr class="">
                                            <th scope="col">Code</th>
                                            <th scope="col">Name</th>
                                            <th scope="col" width="15%">Unit Cost</th>
                                            <th scope="col">Quantity Request</th>
                                            <th scope="col" class="text-center">Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pr->items as $i => $item)
                                            @if ($item->status == 'Approve')
                                                <tr>
                                                    <input type="hidden" name="cart_item_id[{{ $i }}]"
                                                        value="{{ $item->cart_item->id }}">
                                                    <input type="hidden" name="pr_item_id[{{ $i }}]"
                                                        value="{{ $item->id }}">
                                                    <td>{{ $item->cart_item->supply->code ?? '' }}</td>
                                                    <td>{{ $item->cart_item->supply->name ?? '' }}</td>
                                                    <td>
                                                        <input type="number" class="form-control text-right unit_cost"
                                                            placeholder="0.00" value="{{ $item->cart_item->unit_cost }}"
                                                            name="unit_cost[{{ $i }}]">
                                                    </td>
                                                    <td>{{ $item->cart_item->quantity ?? '0' }}</td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="supplier[{{ $i }}]"
                                                            value="{{ $item->supplier ?? '' }}">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <div class="d-flex">
                                    <div class="ml-auto">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                            Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
