<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Transaction</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h1 { color: #333; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="number"], select {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background-color: #45a049; }
        .back-link { display: block; margin-top: 20px; text-align: center; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Transaction</h1>
        <form action="/transactions" method="POST">
            @csrf <div>
                <label for="description">What was this for?</label>
                <input type="text" id="description" name="description" required>
            </div>

            <div>
                <label for="amount">How much money?</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>

            <div>
                <label for="type">Money coming in or going out?</label>
                <select id="type" name="type" required>
                    <option value="income">Money In (Income)</option>
                    <option value="expense">Money Out (Expense)</option>
                </select>
            </div>

            <button type="submit">Record Transaction</button>
        </form>
        <a href="/transactions" class="back-link">View all transactions</a>
    </div>
</body>
</html>