<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 50mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4;
            color: #333;
            background: #fff;
            padding: 50px;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 0px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            vertical-align: top;
            width: 60%;
        }

        .header-right {
            display: table-cell;
            vertical-align: top;
            width: 40%;
            text-align: right;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .company-logo {
            max-width: 80px;
            max-height: 80px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        /* Invoice Details */
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .invoice-details {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .invoice-status {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }

        .detail-row {
            margin-bottom: 6px;
        }

        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }

        .status-badge {
            background: #f0f0f0;
            border: 1px solid #333;
            padding: 5px 15px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-paid {
            background: #333;
            color: #fff;
        }

        /* Billing Section */
        .billing-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .billing-from,
        .billing-to {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .billing-to {
            padding-right: 0;
            padding-left: 20px;
        }

        .billing-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .billing-content p {
            margin-bottom: 3px;
        }

        .company-name-billing {
            font-weight: bold;
            font-size: 13px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #333;
            color: #fff;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .items-table th:last-child {
            text-align: right;
        }

        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .items-table td:last-child {
            text-align: right;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 1px solid #333;
        }

        .service-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .service-description {
            font-size: 10px;
            color: #666;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Summary */
        .summary-section {
            float: right;
            width: 300px;
            margin-top: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }

        .summary-table td:first-child {
            font-weight: bold;
        }

        .summary-table td:last-child {
            text-align: right;
        }

        .total-row td {
            background: #f9f9f9;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            font-weight: bold;
            font-size: 14px;
            padding: 12px;
        }

        .due-row td {
            color: #d32f2f;
            font-weight: bold;
        }

        .discount-row td {
            color: #272827;
        }

        /* Footer */
        .footer {
            clear: both;
            margin-top: 30px;
            padding-top: 15px;
            /* border-top: 1px solid #eee; */
            text-align: center;
        }

        .footer-message {
            font-size: 13px;
            margin-bottom: 10px;
            font-style: italic;
        }

        .footer-note {
            font-size: 10px;
            color: #666;
        }

        /* Responsive adjustments for DomPDF */
        @media print {
            .container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <div class="invoice-title">INVOICE</div>
                </div>
                <div class="header-right">
                    @if (isset($settings) && $settings->logo)
                        <img src="{{ public_path('storage/' . $settings->logo) }}" alt="Logo" class="company-logo">
                    @else
                        <div class="company-name">{{ $settings->title ?? 'Company Name' }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Information -->
        <div class="invoice-info">
            <div class="invoice-details">
                <div class="detail-row">
                    <span class="detail-label">Invoice #:</span>
                    {{ str_pad($invoice->id ?? '001', 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    {{ \Carbon\Carbon::parse($todayDate ?? now())->format('d M, Y') }}
                </div>
                <div class="detail-row">
                    <span class="detail-label">Expiry Date:</span>
                    {{ \Carbon\Carbon::parse($invoice->expiry_date ?? now()->addDays(30))->format('d M, Y') }}
                </div>
            </div>
            <div class="invoice-status">
                <div class="status-badge {{ ($invoice->status ?? 'due') === 'paid' ? 'status-paid' : '' }}">
                    {{ ucfirst($invoice->status ?? 'Due') }}
                </div>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="billing-section">
            <div class="billing-from">
                <div class="billing-title">From</div>
                <div class="billing-content">
                    <p class="company-name-billing">{{ $settings->title ?? 'Company Name' }}</p>
                    <p>{{ $settings->address ?? 'Company Address' }}</p>
                    <p>{{ $settings->phone ?? '+1 234 567 890' }}</p>
                    <p>{{ $settings->email ?? 'info@company.com' }}</p>
                </div>
            </div>
            <div class="billing-to">
                <div class="billing-title">Bill To</div>
                <div class="billing-content">
                    <p class="company-name-billing">{{ $customer->name ?? 'Customer Name' }}</p>
                    <p>{{ $customer->address ?? 'Customer Address' }}</p>
                    <p>{{ $customer->phone ?? 'Customer Phone' }}</p>
                    <p>{{ $customer->email ?? 'Customer Email' }}</p>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Services</th>
                    <th style="width: 15%; text-align:center">Qty</th>
                    <th style="width: 17.5%; text-align:center">Unit Price</th>
                    <th style="width: 17.5%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems ?? [] as $item)
                    <tr>
                        <td>
                            <div class="service-name">{{ $item->service->name ?? 'Service Name' }}</div>

                        </td>
                        <td class="text-center">{{ $item->quantity ?? 1 }}</td>
                        <td style="text-align:center">
                            @if ($settings && $settings->currency_position == 'left')
                                {{ $settings->currency ?? '৳' }}
                                {{ number_format($item->service->unit_price ?? 0, 2) }}
                            @else
                                {{ number_format($item->service->unit_price ?? 0, 2) }}
                                {{ $settings->currency ?? '' }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($settings && $settings->currency_position == 'left')
                                {{ $settings->currency ?? '৳' }} {{ number_format($item->subtotal ?? 0, 2) }}
                            @else
                                {{ number_format($item->subtotal ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td>Subtotal</td>
                    <td>
                        @if ($settings && $settings->currency_position == 'left')
                            {{ $settings->currency ?? '৳' }} {{ number_format($order->subtotal ?? 0, 2) }}
                        @else
                            {{ number_format($order->subtotal ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                        @endif
                    </td>
                </tr>
                @if (($order->discount_amount ?? 0) > 0)
                    <tr class="discount-row">
                        <td>Discount</td>
                        <td>
                            @if ($settings && $settings->currency_position == 'left')
                                -{{ $settings->currency ?? '৳' }} {{ number_format($order->discount_amount ?? 0, 2) }}
                            @else
                                -{{ number_format($order->discount_amount ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                            @endif
                        </td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>Total Amount</td>
                    <td>
                        @if ($settings && $settings->currency_position == 'left')
                            {{ $settings->currency ?? '৳' }} {{ number_format($invoice->amount ?? 0, 2) }}
                        @else
                            {{ number_format($invoice->amount ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Paid Amount</td>
                    <td>
                        @if ($settings && $settings->currency_position == 'left')
                            {{ $settings->currency ?? '৳' }} {{ number_format($invoice->paid_amount ?? 0, 2) }}
                        @else
                            {{ number_format($invoice->paid_amount ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                        @endif
                    </td>
                </tr>
                @if (($invoice->due_amount ?? 0) > 0)
                    <tr>
                        <td>Amount Due</td>
                        <td style="font-weight: bold">
                            @if ($settings && $settings->currency_position == 'left')
                                {{ $settings->currency ?? '৳' }} {{ number_format($invoice->due_amount ?? 0, 2) }}
                            @else
                                {{ number_format($invoice->due_amount ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                            @endif
                        </td>
                    </tr>
                @endif
            </table>
        </div>




        <!-- Footer -->
        <div class="footer">
            {{-- <div class="footer-message">
                Thank you for your business!
            </div>
            <div class="footer-note">
                {{ $settings->message ?? '' }}
            </div> --}}
        </div>

        <table style="width:100%; margin-top:50px; page-break-inside:avoid;">
            <tr>
                <td style="text-align:left; width:50%;" class="footer-message">
                    Thank you for your business!
                    <div class="footer-note">
                        {{ $settings->message ?? '' }}
                    </div>
                </td>
                <td style="text-align:right; width:50%;">
                    <div style="border-top:1px solid #000; width:200px; margin:0 0px 5px 150px;"></div>
                    <p style="margin:0; margin-right:25px; font-weight:bold;">Authorized Signature</p>
                </td>
            </tr>
        </table>



    </div>
</body>

</html>
