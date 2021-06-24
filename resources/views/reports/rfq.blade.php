<table>
    <thead>
        <tr>
            <td colspan="5" style="text-align: center; font-size: 20;border: 1px solid black;">
                <b>
                    Request For Quotation
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-size: 10;border: 1px solid black;">
                <b>
                    Name of Entity: Tesda Regional Training Center Iligan
                </b>
            </td>
            <td colspan="2" style="text-align: center; font-size: 10;border: 1px solid black;">
                <b>
                    Date : {{ now()->format('M d, Y') }}
                </b>
            </td>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th style="font-size: 10; border: 1px solid black;">Item Description</th>
            <th style="font-size: 10; border: 1px solid black;">Quantity</th>
            <th style="font-size: 10; border: 1px solid black;">Unit</th>
            <th style="font-size: 10; border: 1px solid black;">Approved Budget</th>
            <th style="font-size: 10; border: 1px solid black;">Price Offer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pr->items as $i => $p)
            <tr>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->supply->name ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->quantity ?? '0' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->supply->unit ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">

                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
