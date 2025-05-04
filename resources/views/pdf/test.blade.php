<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h1 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $content }}</p>
    <p>Generated at: {{ now() }}</p>
</body>
</html>
