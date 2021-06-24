<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{ route('supply.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Create Supply</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="code" class="form-control mb-3" placeholder="Code" required>
                    <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
                    <input type="text" name="unit" class="form-control mb-3" placeholder="Unit" required>
                    <input type="number" name="quantity" class="form-control mb-3" placeholder="Max Quantity" min="0">
                    <select class="form-control" name="qualification_id">
                        <option value="">Select Qualification</option>
                        @foreach ($quals as $qual)
                            <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
