<div class="modal fade" id="add_bidders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success" role="document">
        <div class="modal-content">
            <form action="{{ route('bidding.store') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="modal-header">
                    <h4 class="modal-title">Add Suppliers</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <select name="supplier_one_id" id="" class="form-control mb-3" required>
                        <option value="">-- Supplier One --</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name ?? '' }}</option>
                        @endforeach
                    </select>
                    <select name="supplier_two_id" id="" class="form-control mb-3" required>
                        <option value="">-- Supplier Two --</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name ?? '' }}</option>
                        @endforeach
                    </select>
                    <select name="supplier_three_id" id="" class="form-control mb-3" required>
                        <option value="">-- Supplier Three --</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
