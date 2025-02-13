<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Due Date Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #555555;
            font-size: 16px;
            line-height: 1.5;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 8px;
            font-size: 16px;
            color: #555555;
            vertical-align: top;
        }

        .table-header {
            font-weight: bold;
            color: #333333;
        }

        .table-value {
            color: #007BFF;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777777;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Task Due Date Notification</h1>
        <p>Hello, {{ $user }}</p>
        <p>This is a reminder that the following task is due in 2 days:</p>

        <table>
            <tr>
                <td class="table-header">Title:</td>
                <td class="table-value">{{ $task->title }}</td>
            </tr>
            <tr>
                <td class="table-header">Due Date:</td>
                <td class="table-value">{{ $task->due_date->format('F j, Y') }}</td>
            </tr>
        </table>

        <p>Don't forget to complete it before the due date!</p>

        <div class="footer">
            <p>If you have any questions, feel free to <a href="mailto:support@example.com">contact us</a>.</p>
        </div>
    </div>
</body>

</html>
