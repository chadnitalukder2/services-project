<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .company-info h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            line-height: 1.4;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .bill-to h3, .invoice-info h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .bill-to p, .invoice-info p {
            color: #666;
            line-height: 1.4;
            margin-bottom: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            color: #333;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .items-table tr:hover {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .total-box {
            min-width: 300px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .total-row.final {
            border-bottom: 2px solid #333;
            font-weight: 600;
            font-size: 18px;
            color: #333;
            margin-top: 10px;
            padding-top: 15px;
        }

        .notes {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .notes h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .notes p {
            color: #666;
            line-height: 1.5;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>Your Company Name</h1>
                <p>123 Business Street<br>
                City, State 12345<br>
                Phone: (555) 123-4567<br>
                Email: info@company.com</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> INV-001</p>
                <p><strong>Date:</strong> September 18, 2025</p>
                <p><strong>Due Date:</strong> October 18, 2025</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="bill-to">
                <h3>Bill To:</h3>
                <p><strong>Client Name</strong><br>
                456 Client Avenue<br>
                City, State 67890<br>
                Phone: (555) 987-6543<br>
                Email: client@email.com</p>
            </div>
            <div class="invoice-info">
                <h3>Payment Terms:</h3>
                <p>Net 30 days</p>
                <p><strong>Payment Method:</strong><br>
                Bank transfer or check</p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Web Design Services</td>
                    <td class="text-right">1</td>
                    <td class="text-right">$1,500.00</td>
                    <td class="text-right">$1,500.00</td>
                </tr>
                <tr>
                    <td>Logo Design</td>
                    <td class="text-right">1</td>
                    <td class="text-right">$500.00</td>
                    <td class="text-right">$500.00</td>
                </tr>
                <tr>
                    <td>Content Writing (10 pages)</td>
                    <td class="text-right">10</td>
                    <td class="text-right">$50.00</td>
                    <td class="text-right">$500.00</td>
                </tr>
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>$2,500.00</span>
                </div>
                <div class="total-row">
                    <span>Tax (8%):</span>
                    <span>$200.00</span>
                </div>
                <div class="total-row final">
                    <span>Total:</span>
                    <span>$2,700.00</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="notes">
            <h4>Notes:</h4>
            <p>Thank you for your business! Payment is due within 30 days of invoice date. 
            Please include the invoice number on your payment. If you have any questions 
            about this invoice, please contact us.</p>
        </div>
    </div>
</body>
</html>