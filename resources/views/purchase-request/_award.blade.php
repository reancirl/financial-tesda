<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{ route('purchase-request.award') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Input Award</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="pr_item_id" id="pr_item_id" value="">
                    <input type="hidden" name="cart_item_id" id="cart_item_id" value="">
                    <input type="text" id="award_supply" class="form-control mb-3" value="" readonly>
                    <select name="supplier_id" class="form-control mb-3" required>
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $i => $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control" placeholder="Unit Cost" name="unit_cost" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
