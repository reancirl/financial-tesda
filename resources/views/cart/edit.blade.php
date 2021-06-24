@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h4 class="mr-auto">Cart</h3>
                                <a class="btn btn-outline-primary ml-auto"
                                    href="{{ route('dashboard.index') }}?shop=true">
                                    <i class="cil-arrow-circle-left"></i>
                                    Go back to supplies
                                </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" id="form-checkout">
                                @csrf
                                @method('PATCH')
                                <table class="table table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th width="10%" colspan="1">Code</th>
                                            <th width="20%" class="text-center" colspan="1">Name</th>
                                            <th width="20%" class="text-center" colspan="1">Unit</th>
                                            <th width="10%" class="text-center" colspan="1">Max Quantity</th>
                                            <th class="text-right" colspan="1">Action</th>
                                            <th width="15%" class="text-center" colspan="1">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->items as $i => $item)
                                            <tr>
                                                <input type="hidden" name="item[{{ $i }}]"
                                                    value="{{ $item->id }}">
                                                <td>{{ $item->supply->code ?? '' }}</td>
                                                <td class="text-center">{{ $item->supply->name ?? '' }}</td>
                                                <td class="text-center">{{ $item->supply->unit ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ $item->supply->quantity ?? '' }}
                                                    <input type="hidden" class="item_quantity"
                                                        value="{{ $item->supply->quantity ?? '' }}">
                                                </td>
                                                <td class="text-right">
                                                    <button class="btn btn-primary btn-add" type="button"
                                                        data-url="{{ route('cart.update', $item->id) }}">
                                                        <i class="cil-plus"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-minus" type="button"
                                                        data-url="{{ route('cart.update', $item->id) }}"
                                                        data-destroy="{{ route('cart.destroy', $item->id) }}">
                                                        <i class="cil-minus"></i>
                                                    </button>
                                                </td>
                                                <td class="text-right">
                                                    <input type="number" name="quantity[{{ $i }}]"
                                                        value="{{ $item->quantity ?? '0' }}"
                                                        max="{{ $item->supply->quantity ?? 0 }}"
                                                        class="form-control text-right quantity">
                                                </td>
                                                <input type="hidden" name="sub_total[{{ $i }}]" readonly
                                                    value="{{ $item->unit_cost ?? '' }}"
                                                    class="form-control text-right sub_total">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                <h3>Total Quantity:</h3>
                                            </td>
                                            <td>
                                                <input type="number" name="total_quantity" id="total_quantity" readonly
                                                    class="form-control text-right">
                                            </td>
                                            <input type="hidden" id="overall_total" name="overall_total" readonly
                                                class="form-control text-right">
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary btn-lg ml-auto"
                                        id="btn-checkout">Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="append-supply"></div>
@endsection
@section('script')
    <script type="text/javascript">
        $('document').ready(function() {
            updateSubTotal()
            updateTotal()
        })

        $('.quantity').change(function(e) {
            var quantity = $(this).val();

            if (quantity < 1) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to remove this from your cart?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result) {
                        $(this).closest('tr').remove();
                        updateTotal();

                    }
                    $(this).val(1);
                })
            } else {
                var price = $(this).closest('tr').find('.price').val();
                var sub_total = parseFloat(quantity) * parseFloat(price);
                $(this).closest('tr').find('.sub_total').val(sub_total);
                updateTotal();
            }
        })

        $('.btn-add').click(function(e) {
            var quantity = $(this).closest('tr').find('.quantity').val();
            quantity = parseFloat(quantity) + 1;
            $(this).closest('tr').find('.quantity').val(quantity);

            quantity = $(this).closest('tr').find('.quantity').val();
            var price = $(this).closest('tr').find('.price').val();
            var sub_total = quantity * parseFloat(price);

            $(this).closest('tr').find('.sub_total').val(sub_total);

            var url = $(this).data('url');
            $.ajax({
                type: 'PATCH',
                url: url,
                data: {
                    add: true,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    updateTotal();
                }
            });
        })

        $('.btn-minus').click(function(e) {
            var quantity = $(this).closest('tr').find('.quantity').val();

            quantity = parseFloat(quantity) - 1;

            if (quantity < 1) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to remove this from your cart?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result) {
                        $(this).closest('tr').remove();
                        updateTotal();

                        var url = $(this).data('destroy');
                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                $('#cart-number').empty();
                                $('#cart-number').html(data);
                            }
                        })

                    }
                })
            } else {
                $(this).closest('tr').find('.quantity').val(quantity);

                quantity = $(this).closest('tr').find('.quantity').val();
                var price = $(this).closest('tr').find('.price').val();
                var sub_total = quantity * parseFloat(price);

                $(this).closest('tr').find('.sub_total').val(sub_total);

                var url = $(this).data('url');
                $.ajax({
                    type: 'PATCH',
                    url: url,
                    data: {
                        minus: true,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        updateTotal();
                    }
                });
            }

        })

        $('#btn-checkout').click(function() {
            var count = 0;
            var correct = 0;
            $('.item_quantity').each(function() {
                count++;
                var quantity = $(this).val();
                var val = $(this).closest('tr').find('.quantity').val();
                if (parseInt(val) > parseInt(quantity)) {
                    $(this).closest('tr').css('background-color', '#ffcccb');
                } else {
                    $(this).closest('tr').css('background-color', '#ffffff');
                    correct++;
                }
            })
            if (count == correct) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to Checkout?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result) {
                        $('#form-checkout').submit();
                    }
                })
            }
        })

        function updateTotal() {
            var total = 0;
            var quantity = 0;
            $('.sub_total').each(function() {
                var el = $(this);
                var stotal = parseFloat(el.val());
                if (!isNaN(stotal)) {
                    total += parseFloat(stotal);
                }
            })

            $('.quantity').each(function() {
                var el = $(this);
                var squantity = parseFloat(el.val());
                if (!isNaN(squantity)) {
                    quantity += parseFloat(squantity);
                }
            })

            $('#overall_total').val(total.toFixed(2));
            $('#total_quantity').val(quantity);
        }

        function updateSubTotal() {
            $('.sub_total').each(function() {
                var el = $(this);
                var quantity = el.closest('tr').find('.quantity').val();
                var price = el.closest('tr').find('.price').val();
                quantity = parseFloat(quantity);
                price = parseFloat(price);
                if (!isNaN(quantity) && !isNaN(price)) {
                    quantity = $(this).closest('tr').find('.quantity').val();
                    var price = $(this).closest('tr').find('.price').val();
                    var sub_total = quantity * price;

                    $(this).val(sub_total);
                }
            })
        }

    </script>
@endsection
