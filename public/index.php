<?php require 'monitoring.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Status page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
</head>
<body>

    <section class="hero is-success is-bold">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    <a href="<?= $website_url; ?>">
                        <?= $website_name . ' - ' . $website_url; ?>
                    </a>
                </h1>
                <h2 class="subtitle">Website status</h2>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="section">
            <div class="columns">
                <div class="column is-6">
                    <h3 class="subtitle">Details:</h3>
                        <div class="content">
                            <p>Monitoring started: <?= $monitor_started; ?></p>
                            <p>Current status: <?= $monitor_status; ?></p>
                            <p><?= $monitor_info; ?></p>
                            <p>
                                Contact support:
                                <span class="icon is-large">
                                    <a href="#" class="has-text-success">
                                        <i class="fas fa-lg fa-envelope"></i>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </ul>
                </div>
                <div class="column is-6">
                    <h3 class="subtitle has-text-centered">Overall uptime: <?= $monitor_uptime; ?>%</h3>
                    <canvas id="uptime"></canvas>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                Status page by <a href="https://stevencotterill.co.uk">Steven Cotterill</a>.
                Feel free to use or modify :)
            </p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("uptime");
        var config = new Chart(ctx,{
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?= $data; ?>],
                    backgroundColor: [<?= $background_colour; ?>],
                    borderColor: [<?= $border_colour; ?>]
                }],
                labels: [<?= $labels; ?>],
            },
			options: {
				responsive: true,
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
        });
    </script>

</body>
</html>