<div class="modal fade" id="edit_qualification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{ route('qualification.update', $qualification->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Edit Qualification</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="code" class="form-control mb-3" value="{{ $qualification->code ?? '' }}"
                        required>
                    <input type="text" name="name" class="form-control mb-3" value="{{ $qualification->name ?? '' }}"
                        required>
                    <input type="text" name="remaining_budget" class="form-control mb-3"
                        value="{{ $qualification->remaining_budget ?? '' }}" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
