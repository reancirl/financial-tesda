<table>
    <thead>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 25;border: 1px solid black;">
                <b>
                    PURCHASE ORDER
                </b>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 15;border: 1px solid black;">
                <b>
                    Name of Entity: Tesda Regional Training Center Iligan
                </b>
            </td>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th style="font-size: 17; border: 1px solid black;">Item Name</th>
            <th style="font-size: 17; border: 1px solid black;">PR Number</th>
            <th style="font-size: 17; border: 1px solid black;">PR Date</th>
            <th style="font-size: 17; border: 1px solid black;">PO Number</th>
            <th style="font-size: 17; border: 1px solid black;">Status</th>
            <th style="font-size: 17; border: 1px solid black;">Quantity</th>
            <th style="font-size: 17; border: 1px solid black;">Price</th>
            <th style="font-size: 17; border: 1px solid black;">Expense</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; @endphp
        @foreach ($pr as $i => $p)
            <tr>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->supply_name }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->purchase_request->number ?? 'N/a' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ date('M d,Y', strtotime($p->pr_created_at)) }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->po_created_at ? date('M d,Y', strtotime($p->po_created_at)) : 'N/a' }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->pr_item_status }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->quantity }}
                </td>
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $p->unit_cost ?? 'N/a' }}
                </td>
                @php
                    $expense = $p->quantity * $p->unit_cost;
                    $total += $expense;
                @endphp
                <td style="text-align: left; font-size: 12; border: 1px solid black;">
                    {{ $expense ?? 'N/a' }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7" style="text-align: right; font-size: 12; border: 1px solid black;">Total:</td>
            <td colspan="" style="text-align: left; font-size: 12; border: 1px solid black;">
                {{ number_format($total, 2) }}</td>
        </tr>
    </tbody>
</table>
