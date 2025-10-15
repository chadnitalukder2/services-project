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
            font-family: 'DejaVu Sans', sans-serif;
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
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #000;
        }

        .company-tagline {
            font-size: 10px;
            font-family: 'DejaVu Sans', sans-serif;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #2d2d2d;
            font-weight: 500;
        }

        /* Client Info Section - Using table instead of display:table */
        .client-info {
            width: 100%;
            margin-bottom: 10px;
        }

        .client-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .client-left {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .client-right {
            width: 50%;
            vertical-align: top;
            text-align: right;
            padding-left: 20px;
        }

        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #484848;
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

        /* Event Cards Container - Full width table layout */
        .event-cards-container {
            margin-bottom: 15px;
            width: 100%;
        }

        .events-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }

        .events-table thead {
            background: #000;
        }

        .events-table th {
            padding: 8px 10px;
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
            border-right: 1px solid #fff;
        }

        .events-table th:last-child {
            border-right: none;
        }

        .events-table td {
            padding: 8px 10px;
            border-right: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #333;
        }

        .events-table td:last-child {
            border-right: none;
        }

        .events-table tbody tr:last-child td {
            border-bottom: none;
        }

        .event-name-cell {
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .event-date-cell {
            font-weight: 600;
            color: #333;
        }

        .event-time-cell {
            font-weight: 600;
            color: #333;
        }

        /* Day/Night badge */
        .day-night-badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 3px;
            margin-left: 5px;
        }

        .day-night-badge.day {
            background: #f0f0f0;
            color: #000;
            border: 1px solid #000;
        }

        /* .day-night-badge.night {
            background: #000;
            color: #fff;
            border: 1px solid #000;
        } */

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

        /* Summary Section - Using table instead of float */
        .summary-wrapper {
            width: 100%;
            margin-top: 10px;
        }

        .summary-wrapper-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-spacer {
            width: 60%;
        }

        .summary-section {
            width: 40%;
            vertical-align: top;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-row {
            width: 100%;
        }

        .summary-row td {
            padding: 8px 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-label {
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            color: #484848;
            letter-spacing: 0.5px;
            font-weight: 600;
            width: 60%;
        }

        .summary-value {
            text-align: right;
            font-size: 12px;
            color: #000;
            font-weight: 600;
            width: 40%;
        }

        .total-row td {
            background: #333;
            color: #fff;
            margin-top: 5px;
            padding: 10px 12px;
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
            height: 0;
            line-height: 0;
        }

        /* Bottom Section - Fixed at bottom */
        .bottom-section {
            position: absolute;
            bottom: 50px;
            left: 55px;
            right: 50px;
            padding-top: 30px;
            background: #fff;
            page-break-inside: avoid;
        }

        .bottom-content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .terms-left {
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }

        .signature-right {
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
            margin-top: 8px;
        }

        .contact-item {
            font-size: 9px;
            color: #333;
            margin-bottom: 5px;
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

        @php
            $customFields = [];
            if (isset($order->custom_fields)) {
                if (is_string($order->custom_fields)) {
                    $customFields = json_decode($order->custom_fields, true) ?? [];
                } elseif (is_array($order->custom_fields)) {
                    $customFields = $order->custom_fields;
                }
            }
            $firstEventDate =
                !empty($customFields) && isset($customFields[0]['event_date']) ? $customFields[0]['event_date'] : '';
        @endphp

        <!-- Client Information -->
        <div class="client-info">
            <table class="client-info-table">
                <tr>
                    <td class="client-left">
                        <div class="info-label">To</div>
                        <div class="info-value">
                            <p>{{ $customer->name }}</p>
                            <p>{{ $customer->phone }}</p>
                        </div>
                        @if (!empty($customer->address))
                            <div class="info-label">Location</div>
                            <div class="info-value">{{ $customer->address }}</div>
                        @endif
                    </td>
                    <td class="client-right">
                        <div class="info-value">INV - {{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($todayDate ?? now())->format('d/m/Y') }}</div>
                        @if ($firstEventDate)
                            <div class="info-label">Event Date</div>
                            <div class="info-value">{{ $firstEventDate }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Event Cards Section -->


        @if (!empty($customFields))
            <div class="event-cards-container">
                <table class="events-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">SL</th>
                            <th style="width: 35%;">Event Name</th>
                            <th style="width: 20%;">Event Date</th>
                            <th style="width: 20%;">Event Time</th>
                            <th style="width: 20%;">Day/Night</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customFields as $index => $field)
                            @php
                                $eventTime = $field['event_time'] ?? '';
                                $hour = $eventTime ? (int) date('H', strtotime($eventTime)) : 12;
                                $timeOfDay = $hour >= 18 || $hour < 6 ? 'Night' : 'Day';
                                $badgeClass = $hour >= 18 || $hour < 6 ? 'day' : 'day';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="event-name-cell">{{ $field['event_name'] ?? 'Event' }}</td>
                                <td class="event-date-cell">{{ $field['event_date'] ?? '-' }}</td>
                                <td class="event-time-cell">{{ $field['event_time'] ?? '-' }}</td>
                                <td>
                                    <span class="day-night-badge {{ $badgeClass }}">{{ $timeOfDay }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        <div class="summary-wrapper">
            <table class="summary-wrapper-table">
                <tr>
                    <td class="summary-spacer"></td>
                    <td class="summary-section">
                        <table class="summary-table">
                            <tr class="summary-row">
                                <td class="summary-label">Sub Total</td>
                                <td class="summary-value">
                                    @if ($settings && $settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}{{ number_format($order->subtotal ?? 0, 0) }}
                                    @else
                                        {{ number_format($order->subtotal ?? 0, 0) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                            </tr>
                            @if (($order->discount_amount ?? 0) > 0)
                                <tr class="summary-row">
                                    <td class="summary-label">Discount</td>
                                    <td class="summary-value">
                                        @if ($settings && $settings->currency_position == 'left')
                                            -{{ $settings->currency ?? '৳' }}{{ number_format($order->discount_amount ?? 0, 0) }}
                                        @else
                                            -{{ number_format($order->discount_amount ?? 0, 0) }}
                                            {{ $settings->currency ?? '৳' }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if (($invoice->amount ?? 0) > 0)
                                <tr class="summary-row">
                                    <td class="summary-label">Total Amount</td>
                                    <td class="summary-value">
                                        @if ($settings && $settings->currency_position == 'left')
                                            {{ $settings->currency ?? '৳' }}{{ number_format($invoice->amount ?? 0, 0) }}
                                        @else
                                            {{ number_format($invoice->amount ?? 0, 0) }}
                                            {{ $settings->currency ?? '৳' }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <tr class="summary-row">
                                <td class="summary-label">Paid Amount</td>
                                <td class="summary-value">
                                    @if ($settings && $settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}
                                        {{ number_format($invoice->paid_amount ?? 0, 0) }}
                                    @else
                                        {{ number_format($invoice->paid_amount ?? 0, 0) }}
                                        {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                            </tr>
                            <tr class="total-row">
                                <td class="summary-label">Due Amount</td>
                                <td class="summary-value">
                                    @if ($settings && $settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}{{ number_format($invoice->due_amount ?? 0, 0) }}
                                    @else
                                        {{ number_format($invoice->due_amount ?? 0, 0) }}
                                        {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Clear float -->
        <div class="clearfix"></div>

    </div>

    <!-- Bottom Section - Fixed at bottom of page -->
    <div class="bottom-section">
        <table class="bottom-content-table">
            <tr>
                <td class="terms-left">
                    <div class="section-title">Terms & Conditions</div>
                    <div class="terms-content">
                        {{ $settings->message ?? 'The due amount is expected to be paid on the last event day. No delivery will be made without payment. Delivery time for photos and videos is at least 30 Working days.' }}
                    </div>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="contact-label">Address:</span>
                            {{ $settings->address ?? '711 West World Shopping City Zinda Bazar' }}
                        </div>
                        <div class="contact-item">
                            <span class="contact-label">Phone:</span>
                            {{ $settings->phone ?? '01715183373' }}
                        </div>
                    </div>
                </td>

                <td class="signature-right">
                    <div class="signature-line"></div>
                    <div class="signature-label">Authorized Signature</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
