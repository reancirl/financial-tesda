@extends('dashboard.base')

@section('content')
	<div class="container-fluid">
		<div class="fadeIn">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header d-flex">
							<h4 class="mr-auto">PPMP Add Bulk</h3>
							<div class="ml-auto">
								<a class="btn btn-primary " href="{{ route('supply.index') }}">
									<i class=""></i>
									Back
                                </a> 
							</div>							 
						</div>											
						<div class="card-body">
                            <form action="{{ route('storeBulk') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4 mb-4">
                                        <select class="form-control" name="qualification_id">
                                            <option value="">Select Qualification</option>
                                            @foreach($quals as $qual)
                                                <option value="{{ $qual->id }}">{{ $qual->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-sm table-borderless">
                                    <thead>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Max Quantity</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="code[0]" class="form-control" placeholder="Code" required>
                                            </td>
                                            <td>
                                                <input type="text" name="name[0]" class="form-control" placeholder="Name" required>
                                            </td>
                                            <td>
                                                <input type="text" name="unit[0]" class="form-control" placeholder="Unit" required>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[0]" class="form-control" placeholder="Quantity" min="1" required>
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-primary add-row"><i class="cil-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>                                
                                </table>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-success ml-auto">Submit</button>
                                </div>
                            </form>                            
						</div>                        
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
    <script >
        var count = 1;
        $('.add-row').click(function(e) {
            var row = "<tr><td><input type='text' name='code[" + count + "]' class='form-control' placeholder='Code' required></td><td><input type='text' name='name[" + count + "]' class='form-control' placeholder='Name' required></td><td><input type='text' name='unit[" + count + "]' class='form-control' placeholder='Unit' required></td> <td><input type='text' name='quantity[" + count + "]' class='form-control' placeholder='Quantity' required></td> </td> <td> <button class='btn btn-danger remove-row' type='button'><i class='cil-minus'></i></button> </tr>";
            $("table tbody").append(row);
            count++;
        });

        $(document).on('click','.remove-row',function(e) {
            $(this).closest('tr').remove();
        });
    </script>
@endsection