<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Transactions Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transactions Report</h1>
        <p>Generated on: {{ $date }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                @if(!empty($transactions))
                    @foreach(array_keys($transactions[0]) as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    @foreach($transaction as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>MobilesNest &copy; {{ date('Y') }} - All rights reserved</p>
    </div>
</body>
</html>
