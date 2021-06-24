<div class="modal fade" id="edit_supply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-primary" role="document">
    <div class="modal-content">
      <form action="{{ route('supply.update',$supply->id) }}" method="post">
        @csrf              
        @method('PATCH')
        <div class="modal-header">
          <h4 class="modal-title">Edit Supply</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <input type="text" name="code" class="form-control mb-3" value="{{ $supply->code ?? '' }}" required>
          <input type="text" name="name" class="form-control mb-3" value="{{ $supply->name ?? '' }}" required>
          <input type="text" name="unit" class="form-control mb-3" value="{{ $supply->unit ?? '' }}" required > 
          <input type="number" name="quantity" class="form-control mb-3" value="{{ $supply->quantity ?? '0' }}" step="1" min="0">    
          @role('admin')
            <input type="number" name="price" class="form-control mb-3" value="{{ $supply->price }}" placeholder="Price" min="0" step="0.01">      
          @endrole
          <select class="form-control" name="qualification_id">
            <option value="">Select Qualification</option>
            @foreach($quals as $qual)
              <option value="{{ $qual->id }}" {{ $qual->id == $supply->qualification_id ? 'selected' : '' }}>{{ $qual->name }}</option>
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