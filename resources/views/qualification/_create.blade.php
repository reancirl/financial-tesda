<div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{ route('qualification.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Create Qualification</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="code" class="form-control mb-3" placeholder="Code" required>
                    <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
                    <input type="text" name="remaining_budget" class="form-control mb-3" placeholder="Budget" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
