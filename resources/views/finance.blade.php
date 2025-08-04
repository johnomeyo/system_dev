<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finance Dashboard - Real-Time Financial Overview</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
            min-height: 100vh;
            color: #333;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.5em;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .live-indicator {
            width: 12px;
            height: 12px;
            background: #27ae60;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        .date-time {
            font-size: 1.1em;
            color: #7f8c8d;
            font-weight: 500;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #e74c3c, #27ae60, #f39c12);
            background-size: 300% 100%;
            animation: gradientMove 3s ease-in-out infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .metric-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .metric-title {
            font-size: 1.1em;
            color: #2c3e50;
            font-weight: 600;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }

        .metric-value {
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .metric-change {
            font-size: 0.9em;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .positive { color: #27ae60; }
        .negative { color: #e74c3c; }
        .neutral { color: #95a5a6; }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .chart-title {
            font-size: 1.3em;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .tables-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .table-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .table-title {
            font-size: 1.2em;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .overdue {
            color: #e74c3c;
            font-weight: 600;
        }

        .due-soon {
            color: #f39c12;
            font-weight: 600;
        }

        .ratios-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .ratio-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .ratio-card:hover {
            transform: scale(1.05);
        }

        .ratio-title {
            font-size: 1.1em;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .ratio-value {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .ratio-status {
            font-size: 0.9em;
            font-weight: 500;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .excellent { background: #d5edda; color: #155724; }
        .good { background: #d1ecf1; color: #0c5460; }
        .warning { background: #fff3cd; color: #856404; }

        @media (max-width: 768px) {
            .charts-section,
            .tables-section {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1>
                <span class="live-indicator"></span>
                Financial Dashboard
            </h1>
            <div class="date-time" id="currentDateTime"></div>
        </div>

        <!-- Key Metrics -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Total Revenue</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #3498db, #2980b9); color: white;">💰</div>
                </div>
                <div class="metric-value" style="color: #3498db;">$2,847,500</div>
                <div class="metric-change positive">▲ 12.5% vs last month</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Net Profit</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #27ae60, #229954); color: white;">📈</div>
                </div>
                <div class="metric-value" style="color: #27ae60;">$487,320</div>
                <div class="metric-change positive">▲ 8.3% vs last month</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Cash Balance</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white;">💵</div>
                </div>
                <div class="metric-value" style="color: #e74c3c;">$1,245,800</div>
                <div class="metric-change negative">▼ 3.2% vs last month</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Monthly Expenses</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22); color: white;">💸</div>
                </div>
                <div class="metric-value" style="color: #f39c12;">$892,150</div>
                <div class="metric-change positive">▼ 5.7% vs last month</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Outstanding Invoices</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #9b59b6, #8e44ad); color: white;">📄</div>
                </div>
                <div class="metric-value" style="color: #9b59b6;">$324,750</div>
                <div class="metric-change neutral">◆ 47 invoices pending</div>
            </div>

            <div class="metric-card">
                <div class="metric-header">
                    <div class="metric-title">Gross Profit Margin</div>
                    <div class="metric-icon" style="background: linear-gradient(135deg, #1abc9c, #16a085); color: white;">📊</div>
                </div>
                <div class="metric-value" style="color: #1abc9c;">68.7%</div>
                <div class="metric-change positive">▲ 2.1% vs last month</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-title">Revenue vs Expenses Trend</div>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
            
            <div class="chart-card">
                <div class="chart-title">Expense Categories</div>
                <canvas id="expenseChart" width="300" height="300"></canvas>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="tables-section">
            <div class="table-card">
                <div class="table-title">🧾 Accounts Receivable - Aging</div>
                <table>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Days Outstanding</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TechCorp Ltd</td>
                            <td>$45,800</td>
                            <td>15 days</td>
                            <td class="positive">Current</td>
                        </tr>
                        <tr>
                            <td>Global Industries</td>
                            <td>$78,500</td>
                            <td>45 days</td>
                            <td class="due-soon">Due Soon</td>
                        </tr>
                        <tr>
                            <td>StartUp Inc</td>
                            <td>$23,200</td>
                            <td>95 days</td>
                            <td class="overdue">Overdue</td>
                        </tr>
                        <tr>
                            <td>MegaCorp</td>
                            <td>$156,000</td>
                            <td>8 days</td>
                            <td class="positive">Current</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-card">
                <div class="table-title">💳 Accounts Payable</div>
                <table>
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Office Supplies Co</td>
                            <td>$12,400</td>
                            <td>Aug 15, 2025</td>
                            <td class="positive">On Track</td>
                        </tr>
                        <tr>
                            <td>IT Services Ltd</td>
                            <td>$67,800</td>
                            <td>Aug 5, 2025</td>
                            <td class="due-soon">Due Soon</td>
                        </tr>
                        <tr>
                            <td>Utilities Provider</td>
                            <td>$8,900</td>
                            <td>Jul 28, 2025</td>
                            <td class="overdue">Overdue</td>
                        </tr>
                        <tr>
                            <td>Legal Services</td>
                            <td>$34,500</td>
                            <td>Aug 20, 2025</td>
                            <td class="positive">On Track</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Financial Ratios -->
        <div class="ratios-section">
            <div class="ratio-card">
                <div class="ratio-title">Current Ratio</div>
                <div class="ratio-value" style="color: #27ae60;">2.34</div>
                <div class="ratio-status excellent">Excellent</div>
            </div>

            <div class="ratio-card">
                <div class="ratio-title">Debt-to-Equity</div>
                <div class="ratio-value" style="color: #3498db;">0.45</div>
                <div class="ratio-status good">Good</div>
            </div>

            <div class="ratio-card">
                <div class="ratio-title">ROI</div>
                <div class="ratio-value" style="color: #e74c3c;">18.7%</div>
                <div class="ratio-status excellent">Excellent</div>
            </div>

            <div class="ratio-card">
                <div class="ratio-title">Quick Ratio</div>
                <div class="ratio-value" style="color: #f39c12;">1.89</div>
                <div class="ratio-status warning">Watch</div>
            </div>
        </div>
    </div>

    <script>
        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Revenue vs Expenses Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Revenue',
                    data: [2100000, 2350000, 2200000, 2650000, 2800000, 2547000, 2847500],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Expenses',
                    data: [1800000, 1950000, 1850000, 2100000, 2200000, 2050000, 1892150],
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Expense Categories Chart
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: ['Salaries', 'Rent', 'Utilities', 'Marketing', 'Operations', 'Other'],
                datasets: [{
                    data: [450000, 120000, 35000, 95000, 142150, 50000],
                    backgroundColor: [
                        '#3498db',
                        '#e74c3c',
                        '#27ae60',
                        '#f39c12',
                        '#9b59b6',
                        '#95a5a6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Simulate real-time updates
        setInterval(() => {
            // Add subtle animation to metric values
            const metricValues = document.querySelectorAll('.metric-value');
            metricValues.forEach(value => {
                value.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    value.style.transform = 'scale(1)';
                }, 200);
            });
        }, 5000);
    </script>
</body>
</html>