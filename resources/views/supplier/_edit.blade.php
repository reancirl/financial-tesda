<div class="modal fade" id="edit_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <form action="{{ route('suppliers.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-3" placeholder="Name" required
                        value="{{ $supplier->name ?? '' }}">
                    <input type="text" name="address" class="form-control mb-3" placeholder="Address" required
                        value="{{ $supplier->address ?? '' }}">
                    <input type="text" name="business_permit_number" class="form-control mb-3"
                        placeholder="Business Permit Number" value="{{ $supplier->business_permit_number ?? '' }}">
                    <input type="text" name="tin" class="form-control mb-3" placeholder="Tax Identification Number"
                        value="{{ $supplier->tin ?? '' }}">
                    <input type="text" name="philgeps_reg_number" class="form-control mb-3"
                        placeholder="PhilGEPS Registration Number" value="{{ $supplier->philgeps_reg_number ?? '' }}">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
