<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: #fafbfc;
            color: #1a1a1a;
            line-height: 1.5;
        }

        .container {
            max-width: 15000px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 48px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-outline {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-outline:hover {
            background: #f9fafb;
        }

        /* Metrics Grid */
        .metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .metric {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            transition: box-shadow 0.2s ease;
        }

        .metric:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .metric-title {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
        }

        .metric-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .metric-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .metric-subtitle {
            font-size: 13px;
            color: #9ca3af;
        }

        .positive { color: #10b981; }
        .negative { color: #ef4444; }
        .neutral { color: #6b7280; }

        /* Charts Section */
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 48px;
        }

        .chart-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            /* Added min-height to ensure charts have a minimum size */
            min-height: 300px;
            display: flex;
            flex-direction: column;
        }

        .chart-card canvas {
            max-height: 250px; /* Ensures canvas doesn't grow too large */
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 24px;
        }

        /* Transactions Table */
        .transactions {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .transactions-header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .transactions-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 16px 24px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid #f3f4f6;
        }

        tr:hover {
            background: #f9fafb;
        }

        .no-data {
            padding: 64px 24px;
            text-align: center;
            color: #9ca3af;
        }

        .no-data h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #6b7280;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 24px 16px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .header h1 {
                font-size: 28px;
            }

            .charts {
                grid-template-columns: 1fr;
            }

            .metrics {
                grid-template-columns: 1fr;
            }

            th, td {
                padding: 12px 16px;
            }
        }

        /* Icons */
        .icon-income { background: #dcfce7; color: #16a34a; }
        .icon-expense { background: #fee2e2; color: #dc2626; }
        .icon-balance { background: #dbeafe; color: #2563eb; }
        .icon-trend { background: #f0f9ff; color: #0ea5e9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Finance Dashboard</h1>
            <div class="header-actions">
                <a href="{{ route('employees.index') }}" class="btn btn-outline">Proceed to Payout</a>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add Transaction</a>
            </div>
        </div>

        <div class="metrics">
            <div class="metric">
                <div class="metric-header">
                    <div class="metric-title">Total Income</div>
                    <div class="metric-icon icon-income">💰</div>
                </div>
                <div class="metric-value positive">${{ number_format($totalIncome, 2) }}</div>
                <div class="metric-subtitle">All time earnings</div>
            </div>

            <div class="metric">
                <div class="metric-header">
                    <div class="metric-title">Total Expenses</div>
                    <div class="metric-icon icon-expense">💸</div>
                </div>
                <div class="metric-value negative">${{ number_format($totalExpenses, 2) }}</div>
                <div class="metric-subtitle">All time spending</div>
            </div>

            <div class="metric">
                <div class="metric-header">
                    <div class="metric-title">Net Balance</div>
                    <div class="metric-icon icon-balance">📊</div>
                </div>
                <div class="metric-value @if($netBalance >= 0) positive @else negative @endif">${{ number_format($netBalance, 2) }}</div>
                <div class="metric-subtitle">Current balance</div>
            </div>

            <div class="metric">
                <div class="metric-header">
                    <div class="metric-title">This Month</div>
                    <div class="metric-icon icon-trend">📈</div>
                </div>
                <div class="metric-value @if($currentMonthNetBalance >= 0) positive @else negative @endif">${{ number_format($currentMonthNetBalance, 2) }}</div>
                <div class="metric-subtitle">Monthly net income</div>
            </div>
        </div>

        <div class="charts">
            <div class="chart-card">
                <div class="chart-title">Income vs Expenses Trend</div>
                <canvas id="incomeChart"></canvas>
            </div>
            
            <div class="chart-card">
                <div class="chart-title">Monthly Summary</div>
                <canvas id="summaryChart"></canvas>
            </div>
        </div>

        <div class="transactions">
            <div class="transactions-header">
                <div class="transactions-title">Recent Transactions</div>
            </div>
            
            <div class="table-container">
                @if ($transactions->isEmpty())
                    <div class="no-data">
                        <h3>No Transactions Yet!</h3>
                        <p>Click "Add Transaction" to get started.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="{{ $transaction->type == 'income' ? 'positive' : 'negative' }}">
                                        @if ($transaction->type == 'expense')-@endif${{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Income vs Expenses Chart
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Income',
                    data: @json($monthlyIncomeData),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Expenses',
                    data: @json($monthlyExpenseData),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                // This is the key change: setting maintainAspectRatio to true
                maintainAspectRatio: true, 
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Summary Doughnut Chart
        const summaryCtx = document.getElementById('summaryChart').getContext('2d');
        new Chart(summaryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses', 'Net Balance'],
                datasets: [{
                    data: [@json($totalIncome), @json($totalExpenses), @json($netBalance)],
                    backgroundColor: ['#10b981', '#ef4444', '#2563eb'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                // This is the key change: setting maintainAspectRatio to true
                maintainAspectRatio: true, 
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>