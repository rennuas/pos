<script>
    var ctx = document.getElementById('dailyGrossIncomeChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($daily_gross_income as $data) : ?>
                    <?php echo '"' . date('d/m/Y', strtotime($data['date'])) . '", '; ?>
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Pendapatan Kotor Perhari',
                data: [
                    <?php foreach ($daily_gross_income as $data) : ?>
                        <?php echo '"' . $data['gross_income'] . '", '; ?>
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(50, 150, 255, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('monthlyGrossIncomeChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($monthly_gross_income as $data) : ?>
                    <?php echo '"' . $data['month'] . '", '; ?>
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Pendapatan Kotor Perbulan',
                data: [
                    <?php foreach ($monthly_gross_income as $data) : ?>
                        <?php echo '"' . $data['gross_income'] . '", '; ?>
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(50, 150, 255, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx = document.getElementById('yearlyGrossIncomeChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($yearly_gross_income as $data) : ?>
                    <?php echo '"' . $data['year'] . '", '; ?>
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Pendapatan Kotor Perbulan',
                data: [
                    <?php foreach ($yearly_gross_income as $data) : ?>
                        <?php echo '"' . $data['gross_income'] . '", '; ?>
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(50, 150, 255, 1)',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>