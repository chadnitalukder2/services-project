<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #000;
        }

        .invoice {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            width: 100%;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
        }

        .logo {
            text-align: right;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 5px 0;
        }

        .invoice-info {
            width: 100%;
            margin-bottom: 10px;
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 5px 0px;
        }

        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-content {
            margin: 0;
            padding-bottom: 7px;
        }

        .items th,
        .items td {
            padding: 12px;
            font-size: 12px;
        }

        .items th {
            background: #f2f2f2;
        }
        .items td {
            border-bottom: 1px solid #ddd;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary {
            width: 250px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary td {
            padding: 12px 0px;
            border-bottom: 1px solid #ddd;
        }

        .summary tr:last-child td {
            font-weight: bold;
            border-bottom: none;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="invoice">

        <!-- Header -->
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-title">Invoice</td>
                    <td class="logo">
                        @if (isset($settings) && $settings->logo == null)
                            <h2>{{ $settings->title }}</h2>
                        @elseif (isset($settings) && $settings->logo != null)
                             <img src="{{ public_path('storage/' . $settings->logo) }}" alt="Logo" style="height:60px; width:60px;">
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Invoice details -->
        <div class="invoice-details">
            <table class="details-table">
                <tr>
                    <td><span style="font-weight: bold;">Invoice :</span></td>
                    <td>#001</td>
                </tr>
                <tr>
                    <td><span style="font-weight: bold;">Invoice Date:</span></td>
                    <td>{{ \Carbon\Carbon::parse($todayDate)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td><span style="font-weight: bold;">Expiry Date:</span></td>
                    <td>{{ \Carbon\Carbon::parse($expiryDate)->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Info -->
        <div class="invoice-info">
            <table class="info-table">
                <tr>
                    <td>
                        <div class="info-title">{{ $settings->title ?? 'Company Name' }}</div>
                        <p class="info-content">{{ $settings->address ?? 'Address' }}</p>
                        <p class="info-content">{{ $settings->phone ?? '017*******' }}</p>
                        <p class="info-content">{{ $settings->email ?? 'example@gmail.com' }}</p>
                    </td>
                    <td>
                        <div class="info-title">Bill To</div>
                        <p class="info-content">{{ $customer->name ?? 'Client Name' }}</p>
                        <p class="info-content">{{ $customer->address ?? 'Client Address' }}</p>
                        <p class="info-content">{{ $customer->phone ?? 'Client Phone' }}</p>
                        <p class="info-content">{{ $customer->email ?? 'Client Email' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items -->
        <table class="items">
            <tr> 
                <th style="width: 50%; text-align: left;">Service</th>
                <th style="width: 10%" class="center">Qty</th>
                <th style="width: 20%" class="right">Unit Price</th>
                <th style="width: 20%" class="right">Amount</th>
            </tr>
            <tr>
                <td>Website Design & Development</td>
                <td class="center">1</td>
                <td class="right">$2,500.00</td>
                <td class="right">$2,500.00</td>
            </tr>
            <tr>
                <td>SEO Optimization</td>
                <td class="center">1</td>
                <td class="right">$500.00</td>
                <td class="right">$500.00</td>
            </tr>
        </table>

        <!-- Summary -->
        <table class="summary">
            <tr>
                <td>Subtotal</td>
                <td class="right">$3,000.00</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td class="right">-$100.00</td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="right">$2,900.00</td>
            </tr>
            <tr>
                <td>Due Amount</td>
                <td class="right">$2,900.00</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            Thank you for your business!
        </div>
    </div>
</body>
</html>
