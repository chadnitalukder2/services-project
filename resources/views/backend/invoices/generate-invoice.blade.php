<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
     <link rel="icon" sizes="32x32" href="{{ asset('storage/' . $settings->logo) }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            size: A4;
            margin: 0.5in;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: #000;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .invoice {
            max-width: 8.5in;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
        }
         
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .invoice_details{
                display: flex;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 5px;
            }
            .invoice_details_left{
                flex: 0 0 150px;
            }
            .invoice_details_right{
                flex: 1;
            }
        .invoice-number {
            font-size: 16px;
            font-weight: bold;
        }
        
        .invoice_info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            margin-top: 15px;
            gap: 40px;
        }
        
        .invoice_info div {
            flex: 1;
        }
        
        .invoice_info h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }
        
        .meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        
        .meta div {
            flex: 1;
            text-align: center;
        }
        
        .meta strong {
            display: block;
            font-size: 12px;
            margin-bottom: 3px;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items th {
            background: #f9f9f9;
            color: #111111;
            text-transform: uppercase;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        
        .items td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
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
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .summary-row:last-child {
            border-bottom: none;
            background: #000;
            color: white;
            font-weight: bold;
        }
        
        .terms {
            padding: 15px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            margin-bottom: 15px;
        }
        
        .terms h4 {
            margin: 0 0 8px 0;
            font-size: 13px;
            font-weight: bold;
        }
        
        .terms p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .print-btn:hover {
            background: #333;
        }
        
        /* Mobile responsive */
        @media (max-width: 359px) {
            body {
                padding: 10px;
                font-size: 12px;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
           
            
            .invoice_info {
                flex-direction: column;
                gap: 20px;
            }
            
            .meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .meta div {
                text-align: left;
                border-bottom: 1px solid #eee;
                padding-bottom: 5px;
            }
            
            .items th,
            .items td {
                padding: 6px 4px;
                font-size: 11px;
            }
            
            .summary {
                width: 100%;
            }
            
            .print-btn {
                position: relative;
                top: auto;
                right: auto;
                display: block;
                margin: 10px auto;
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice p-5 border">
        <div class="header">
            <div>
                <h1>Invoice</h1>
            </div>
            {{-- {{ $setting }} --}}
            <div class="invoice-number">
                <img src="https://png.pngtree.com/element_pic/00/16/07/06577d261edb9ec.jpg" alt="Logo" style="max-height: 50px;"><br>
            </div>
        </div>

        <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px;">
            <div class="invoice_details">
                <p class="invoice_details_left"><strong>Invoice :</strong></p>
                <p class="invoice_details_right"> #001</p>
            </div>
            <div class="invoice_details">
                 <p class="invoice_details_left"><strong>Invoice Date :</strong></p>
                <p class="invoice_details_right">  Sep 18, 2024</p>
            </div>
             <div class="invoice_details">
                 <p class="invoice_details_left"><strong>Expiry Date :</strong></p>
                <p class="invoice_details_right"> Oct 18, 2024</p>
            </div>
        </div>
        
        <div class="invoice_info">
            <div>
                <strong>Your Company Name</strong><br>
                123 Business Street<br>
                (555) 123-4567<br>
                hello@company.com
            </div>
            
            <div>
                <strong>Client Company Name</strong><br>
                456 Client Avenue<br>
                (555) 987-6543<br>
                client@email.com
            </div>
        </div>
        
      
        
        <table class="items">
            <tr>
                <th style="width: 50%">Service</th>
                <th style="width: 10%; text-align: center;">Qty</th>
                <th style="width: 20%; text-align: right;">Unit Price</th>
                <th style="width: 20%; text-align: right;">Amount</th>
            </tr>
            <tr>
                <td>
                    <strong>Website Design & Development</strong><br>
                </td>
                <td class="center">1</td>
                <td class="right">$2,500.00</td>
                <td class="right">$2,500.00</td>
            </tr>
            <tr>
                <td>
                    <strong>SEO Optimization</strong><br>
                </td>
                <td class="center">1</td>
                <td class="right">$2,500.00</td>
                <td class="right">$500.00</td>
            </tr>
          
        </table>
        
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>$3,600.00</span>
            </div>
            <div class="summary-row">
                <span>Discount:</span>
                <span>-$100.00</span>
            </div>
            <div class="summary-row">
                <span>TOTAL:</span>
                <span>$3,806.00</span>
            </div>
        </div>
        
        
        <div class="footer">
            <p>Invoice generated on September 18, 2024 | support@company.com | (555) 123-4567</p>
        </div>
    </div>
    
    <button class="print-btn no-print" onclick="window.print()">Print PDF</button>
</body>
</html>