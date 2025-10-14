<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
            padding: 50px 50px 0px 50px;
            font-size: 12px;
            line-height: 1.4;
            position: relative;
        }

        .invoice-container {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
            background: #fff;
            min-height: calc(297mm - 50px);
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }

        .company-name {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #000;
        }

        .company-tagline {
            font-size: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #2d2d2d;
            font-weight: 500;
        }

        /* Client Info Section */
        .client-info {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .client-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .client-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }

        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 3px;
            font-weight: 600;
            letter-spacing: 0.8px;
        }

        .info-value {
            font-size: 12px;
            color: #000;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .info-value p {
            margin-bottom: 2px;
        }

        /* Event Cards Container */
        .event-cards-container {
            margin-bottom: 10px;
            overflow: hidden;
        }

        .event-card {
            display: inline-block;
            width: calc(18.58% - 10px);
            min-width: 100px;
            border: 1px solid #ddd;
            /* border-left: 2px solid #181818; */
            border-radius: 6px;
            padding: 8px 10px;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
            background: #f6f6f673;
            position: relative;
            margin-bottom: 15px;
            margin-right: 15px;
            vertical-align: top;
        }

        .event-card:nth-child(5n) {
            margin-right: 0;
        }

        .event-card-header {
            margin-bottom: 6px;
            border-bottom: 1px solid #e0e0e0;
        }

        .event-name {
            font-size: 10px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .event-card-body {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .event-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
        }

        .event-label {
            font-size: 9px;
            text-transform: capitalize;
            color: #545454;
            font-weight: 700;
        }

        .event-value {
            font-size: 11px;
            color: #333;
            font-weight: 600;
        }

        /* Day/Night badge */
        .day-night-badge {
            font-size: 9px;
            font-weight: 700;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            color: #666;
        }

      

        /* Services Table */
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .services-table thead {
            background: #333;
        }

        .services-table th {
            padding: 10px 12px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #fff;
        }

        .services-table th:last-child {
            text-align: right;
        }

        .services-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
            font-size: 11px;
        }

        .services-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .services-table td:nth-child(3),
        .services-table td:nth-child(4) {
            text-align: center;
        }

        .services-table tbody tr:last-child td {
            border-bottom: 1px solid #333;
        }

        .service-name {
            font-weight: 600;
            color: #000;
        }

        /* Summary Section */
        .summary-section {
            float: right;
            width: 300px;
            margin-top: 10px;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 8px 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-size: 12px;
            color: #000;
            font-weight: 600;
        }

        .total-row {
            background: #333;
            color: #fff;
            margin-top: 5px;
        }

        .total-row .summary-label {
            color: #fff;
            font-size: 11px;
        }

        .total-row .summary-value {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
        }

        /* Clear float */
        .clearfix {
            clear: both;
        }

        /* Bottom Section - Fixed at bottom */
        .bottom-section {
            position: absolute;
            bottom: 110px;
            left: 55px;
            right: 50px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            background: #fff;
        }

        .bottom-content {
            display: table;
            width: 100%;
        }

        .terms-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }

        .signature-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
            padding-left: 20px;
        }

        .section-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #333;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .terms-content {
            font-size: 9px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 10px;
        }

        .contact-info {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            font-size: 9px;
            color: #333;
        }

        .contact-label {
            font-weight: 700;
            margin-right: 5px;
            color: #333;
            text-transform: uppercase;
            font-size: 8px;
        }

        /* Signature */
        .signature-line {
            border-top: 2px solid #333;
            width: 180px;
            margin: 30px 0 8px auto;
        }

        .signature-label {
            text-align: right;
            margin-right: 23px;
            font-weight: 600;
            font-size: 9px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media print {
            body {
                padding: 50px 50px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">

        <!-- Header -->
        <div class="header">
            <div class="company-name">{{ strtoupper($settings->title ?? 'WEDDING DRAMATIC') }}</div>
            <div class="company-tagline">PHOTOGRAPHY & ALL EVENT MANAGEMENT</div>
        </div>

        <!-- Client Information -->
        <div class="client-info">
            <div class="client-left">
                <div class="info-label">To</div>
                <div class="info-value">
                    <p>{{ $customer->name }}</p>
                    <p>{{ $customer->phone }}</p>
                </div>
                <div class="info-label">Location</div>
                <div class="info-value">{{ $customer->address ?? 'Customer Address' }}</div>
            </div>
            <div class="client-right">
                <div class="info-value">INV - {{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="info-label">Date</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($todayDate ?? now())->format('d/m/Y') }}</div>
                <div class="info-label">Event Date</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($order->event_time ?? now())->format('d-m-Y') }}
                </div>
            </div>
        </div>

        <!-- Event Cards Section -->
        @php
            $customFields = [];
            if (isset($order->custom_fields)) {
                if (is_string($order->custom_fields)) {
                    $customFields = json_decode($order->custom_fields, true) ?? [];
                } elseif (is_array($order->custom_fields)) {
                    $customFields = $order->custom_fields;
                }
            }
        @endphp

        @if (!empty($customFields))
            <div class="event-cards-container">
                @foreach ($customFields as $index => $field)
                    @php
                        $eventTime = $field['event_time'] ?? '';
                        $hour = $eventTime ? (int) date('H', strtotime($eventTime)) : 12;
                        $timeOfDay = $hour >= 18 || $hour < 6 ? 'Night' : 'Day';
                        $badgeClass = $hour >= 18 || $hour < 6 ? 'night' : 'day';
                    @endphp
                    <div class="event-card">
                        <div class="event-card-header">
                            <div class="event-name">{{ $field['event_name'] ?? 'Event' }} ( <span class="day-night-badge {{ $badgeClass }}">{{ $timeOfDay }}</span>)</div>
                        </div>
                        <div class="event-card-body">
                            <div class="event-detail-row">
                                <span class="event-label"> Date : </span>
                                <span class="event-value">{{ $field['event_date'] ?? '-' }}</span>
                            </div>
                            <div class="event-detail-row">
                                <span class="event-label"> Time : </span>
                                <span class="event-value">{{ $field['event_time'] ?? '-' }}</span>
                            </div>
                          
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Services Table -->
        <table class="services-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Services</th>
                    <th style="width: 12%;">Qty</th>
                    <th style="width: 18%;">Unit Price</th>
                    <th style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems ?? [] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="service-name">{{ $item->service->name ?? 'Service Name' }}</div>
                        </td>
                        <td>{{ $item->quantity ?? 1 }}</td>
                        <td>
                            @if ($settings && $settings->currency_position == 'left')
                                {{ $settings->currency ?? '৳' }}
                                {{ number_format($item->service->unit_price ?? 0, 2) }}
                            @else
                                {{ number_format($item->service->unit_price ?? 0, 2) }}
                                {{ $settings->currency ?? '' }}
                            @endif
                        </td>
                        <td>
                            @if ($settings?->currency_position == 'left')
                                {{ $settings->currency ?? '৳' }} {{ number_format($item->subtotal ?? 0, 2) }}
                            @else
                                {{ number_format($item->subtotal ?? 0, 2) }} {{ $settings->currency ?? '৳' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-row">
                <div class="summary-label">Sub Total</div>
                <div class="summary-value">
                    @if ($settings && $settings->currency_position == 'left')
                        {{ $settings->currency ?? '৳' }}{{ number_format($order->subtotal ?? 0, 0) }}
                    @else
                        {{ number_format($order->subtotal ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                    @endif
                </div>
            </div>
            @if (($order->discount_amount ?? 0) > 0)
                <div class="summary-row">
                    <div class="summary-label">Discount</div>
                    <div class="summary-value">
                        @if ($settings && $settings->currency_position == 'left')
                            -{{ $settings->currency ?? '৳' }}{{ number_format($order->discount_amount ?? 0, 0) }}
                        @else
                            -{{ number_format($order->discount_amount ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                        @endif
                    </div>
                </div>
            @endif
            @if (($invoice->amount ?? 0) > 0)
                <div class="summary-row">
                    <div class="summary-label">Total Amount</div>
                    <div class="summary-value">
                        @if ($settings && $settings->currency_position == 'left')
                            {{ $settings->currency ?? '৳' }}{{ number_format($invoice->amount ?? 0, 0) }}
                        @else
                            {{ number_format($invoice->amount ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                        @endif
                    </div>
                </div>
            @endif
            <div class="summary-row">
                <div class="summary-label">Paid Amount</div>
                <div class="summary-value">
                    @if ($settings && $settings->currency_position == 'left')
                        {{ $settings->currency ?? '৳' }} {{ number_format($invoice->paid_amount ?? 0, 0) }}
                    @else
                        {{ number_format($invoice->paid_amount ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                    @endif
                </div>
            </div>
            <div class="summary-row total-row">
                <div class="summary-label">Due Amount</div>
                <div class="summary-value">
                    @if ($settings && $settings->currency_position == 'left')
                        {{ $settings->currency ?? '৳' }}{{ number_format($invoice->due_amount ?? 0, 0) }}
                    @else
                        {{ number_format($invoice->due_amount ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Clear float -->
        <div class="clearfix"></div>

    </div>

    <!-- Bottom Section - Fixed at bottom of page -->
    <div class="bottom-section">
        <div class="bottom-content">
            <div class="terms-left">
                <div class="section-title">Terms & Conditions</div>
                <div class="terms-content">
                    {{ $settings->message ?? 'The due amount is expected to be paid on the last event day. No delivery will be made without payment. Delivery time for photos and videos is at least 30 Working days.' }}
                </div>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-label">Address:</span>
                        <span>{{ $settings->address ?? '711 West World Shopping City Zinda Bazar' }}</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-label">Phone:</span>
                        <span>{{ $settings->phone ?? '01715183373' }}</span>
                    </div>
                </div>
            </div>

            <div class="signature-right">
                <div class="signature-line"></div>
                <div class="signature-label">Authorized Signature</div>
            </div>
        </div>
    </div>

</body>

</html>
