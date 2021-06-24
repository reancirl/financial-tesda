<div class="modal fade" id="view_request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-primary modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Requested by {{ $requisition->user->name ?? '' }}
                    {{ $requisition->user->qualification ? 'from ' . $requisition->user->qualification->name . ' Department' : '' }}
                </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-md">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Quantity Request</th>
                            <th scope="col">Sub-total</th>
                            <th scope="col" class="text-right">Max Quantity</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requisition->cart->items as $i => $item)
                            <tr>
                                <td>{{ $item->supply->code ?? '' }}</td>
                                <td>{{ $item->supply->name ?? '' }}</td>
                                <td>{{ $item->supply->qualification->name ?? '' }}</td>
                                <td>{{ $item->quantity ?? '' }} {{ $item->supply->type ?? '' }}</td>
                                <td>{{ number_format($item->unit_cost, 2) ?? '' }}</td>
                                <td class="text-right">{{ $item->supply->quantity ?? '0' }}
                                    {{ $item->supply->type ?? '' }}</td>
                                <td class="text-right">
                                    @if ($item->status == 'Decline')
                                        <span class="badge badge-danger py-2 px-4 decline_remarks_btn"
                                            style="cursor:pointer" data-remarks="{{ $item->remarks }}"
                                            data-user="{{ $item->user ? 'Updated by: ' . $item->user->name : 'Remarks:' }}">Declined</span>
                                    @elseif($item->status == 'Completed')
                                        <span class="badge badge-success py-2 px-4">Completed</span>
                                    @elseif($item->status == 'Pending')
                                        <span class="badge badge-secondary py-2 px-4">Pending</span>
                                    @elseif($item->status == 'On Process')
                                        <span class="badge badge-warning py-2 px-4">On Process</span>
                                    @else
                                        <span class="badge badge-primary py-2 px-4">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                @if (auth()->user()->hasRole(['admin', 'supply_officer', 'finance_officer']))
                    <a class="btn btn-primary" href="{{ route('request.edit', $requisition->id) }}"><i
                            class="fa fa-edit"></i>Edit Request Items</a>
                @endif
            </div>
        </div>
    </div>
</div>
