<table>
    <thead>
        <tr>
            <td colspan="6" style="text-align: center; font-size: 20;border: 1px solid black;">
                <b>
                    PURCHASE REQUEST
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; font-size: 10;border: 1px solid black;">
                <b>
                    Name of Entity: Tesda Regional Training Center Iligan
                </b>
            </td>
            <td colspan="3" style="text-align: center; font-size: 10;border: 1px solid black;">
                <b>
                    Fund Cluster: {{ $pr->fund_cluster == 161 ? 'SSP' : 'General Fund' }}
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;border: 1px solid black;">
                <b>
                    Office/Section/Qualification: {{ $pr->qualification->name ?? '' }}
                </b>
            </td>
            <td colspan="2" style="text-align: right;border: 1px solid black;">
                <b>
                    PR No. : {{ $pr->number ?? '' }}
                </b>
            </td>
            <td colspan="2" style="text-align: right;border: 1px solid black;">
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
            <th style="font-size: 10; border: 1px solid black;">Stock/Proper No.</th>
            <th style="font-size: 10; border: 1px solid black;">Unit</th>
            <th style="font-size: 10; border: 1px solid black;">Item Description</th>
            <th style="font-size: 10; border: 1px solid black;">Quantity</th>
            <th style="font-size: 10; border: 1px solid black;">Unit Cost</th>
            <th style="font-size: 10; border: 1px solid black;">Total Cost</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; @endphp
        @foreach ($pr->items as $i => $p)
            <tr>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ ++$i ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->supply->unit ?? '' }}
                    @php $requestor = $p->cart_item->cart->request->user->name; @endphp
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->supply->name ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->cart_item->quantity ?? '0' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ number_format($p->cart_item->unit_cost, 2) ?? '0.00' }}
                </td>
                @php
                    $line_total = 0;
                    $line_total = $p->cart_item->quantity * $p->cart_item->unit_cost;
                @endphp
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ number_format($line_total, 2) ?? '0.00' }}
                </td>
                @php
                    $total += $line_total;
                @endphp
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right; font-size: 12; border: 1px solid black;">Total:</td>
            <td colspan="" style="text-align: left; font-size: 12; border: 1px solid black;">
                {{ number_format($total, 2) }}</td>
        </tr>
        @if (null)
            <tr>
                <td colspan="" style="text-align: left; font-size: 12; border: 1px solid black;">Purpose: </td>
                <td colspan="8" style="text-align: center; font-size: 12; border: 1px solid black;"><u>Purpose Here</u>
                </td>
            </tr>
        @endif
    </tbody>
</table>
<table>
    @if (null)
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:left;font-size: 12">
                    <b>Requested By: {{ $requestor ?? '' }} </b>
                </td>
                <td></td>
                <td colspan="4" style="text-align: right; font-size: 12">
                    <b>Approved By: {{ $data->user->name ?? '' }}</b>
                </td>
            </tr>
        </tfoot>
    @endif
</table>
