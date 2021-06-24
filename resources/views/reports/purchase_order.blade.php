<table>
    <thead>
        <tr>
            <td colspan="6" style="text-align: center; font-size: 25;border: 1px solid black;">
                <b>
                    PURCHASE ORDER
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-size: 15;border: 1px solid black;">
                <b>
                    Name of Entity: Tesda Regional Training Center Iligan
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; font-size: 15;border: 1px solid black;">
                <b>
                    Supplier: {{ $data->supplier ?? '' }}
                </b>
            </td>
            <td colspan="2" style="text-align: center; font-size: 15;border: 1px solid black;">
                <b>
                    Fund Cluster: {{ $data->pr->fund_cluster == 161 ? 'SSP' : 'General Fund' }}
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;border: 1px solid black;">
                <b>
                    Office/Section/Qualification: {{ $data->qualification_name ?? '' }}
                </b>
            </td>
            <td colspan="2" style="text-align: right;border: 1px solid black;">
                <b>
                    PR No. : {{ $data->pr->number ?? '' }}
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
            <th style="font-size: 17; border: 1px solid black;">Stock/Proper No.</th>
            <th style="font-size: 17; border: 1px solid black;">Unit</th>
            <th style="font-size: 17; border: 1px solid black;">Item Description</th>
            <th style="font-size: 17; border: 1px solid black;">Quantity</th>
            <th style="font-size: 17; border: 1px solid black;">Unit Cost</th>
            <th style="font-size: 17; border: 1px solid black;">Total Cost</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; @endphp
        @foreach ($data->items as $i => $p)
            <tr>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ ++$i ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->pr_item->cart_item->supply->unit ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->pr_item->cart_item->supply->name ?? '' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->pr_item->cart_item->quantity ?? '0' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ number_format($p->pr_item->cart_item->unit_cost, 2) ?? '0.00' }}
                </td>
                @php
                    $line_total = 0;
                    $line_total = $p->pr_item->cart_item->quantity * $p->pr_item->cart_item->unit_cost;
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
    </tbody>
</table>
