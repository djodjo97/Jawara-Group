<?php
include_once 'layout/header.php';
require 'functions/function_home.php';

// Ambil data dari database
$mitraData = getTotalMitra();
$usersData = getTotalUsers();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row g-4">

        <!-- Total Mitra Card -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="card border-left-info shadow-sm">
                <div class="card-body d-flex align-items-center p-2">
                    <div class="me-auto">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Mitra 2025</div>
                        <div class="h4 mb-0 font-weight-bold text-info">
                            <?php echo array_sum($mitraData); ?>
                        </div>
                    </div>
                    <i class="fas fa-user-circle fa-2x text-info"></i>
                </div>
            </div>
        </div>

        <!-- Total User Card -->
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="card border-left-info shadow-sm">
                <div class="card-body d-flex align-items-center p-2">
                    <div class="me-auto">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total User 2025</div>
                        <div class="h4 mb-0 font-weight-bold text-info">
                            <?php echo array_sum($usersData); ?>
                        </div>
                    </div>
                    <i class="fas fa-user-circle fa-2x text-info"></i>
                </div>
            </div>
        </div>

        <!-- Improved Line Chart Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow p-3">
                    <canvas id="dashboardChart" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mitraData = <?php echo json_encode(array_values($mitraData)); ?>;
            const usersData = <?php echo json_encode(array_values($usersData)); ?>;

            var ctx = document.getElementById('dashboardChart').getContext('2d');

            // Buat gradient warna biar lebih keren
            var gradientMitra = ctx.createLinearGradient(0, 0, 0, 400);
            gradientMitra.addColorStop(0, 'rgba(54, 162, 235, 0.5)');
            gradientMitra.addColorStop(1, 'rgba(54, 162, 235, 0.1)');

            var gradientUsers = ctx.createLinearGradient(0, 0, 0, 400);
            gradientUsers.addColorStop(0, 'rgba(255, 99, 132, 0.5)');
            gradientUsers.addColorStop(1, 'rgba(255, 99, 132, 0.1)');

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'Total Mitra',
                            data: mitraData,
                            borderColor: '#36A2EB',
                            backgroundColor: gradientMitra,
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: '#36A2EB',
                            pointBorderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            hoverBackgroundColor: '#36A2EB',
                        },
                        {
                            label: 'Total Users',
                            data: usersData,
                            borderColor: '#FF6384',
                            backgroundColor: gradientUsers,
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: '#FF6384',
                            pointBorderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            hoverBackgroundColor: '#FF6384',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: "#666",
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "rgba(200, 200, 200, 0.2)"
                            },
                            ticks: {
                                color: "#666",
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderWidth: 1,
                            borderColor: '#ddd',
                            cornerRadius: 8,
                            padding: 10
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
    </script>


    <?php
    include_once 'layout/footer.php';

    if (isset($_SESSION['message']) && $_SESSION['message'] == 'logfail') {
        echo "
    <script>
        $.toast({
            heading: 'Login Berhasil!',
            text: 'Welcome',
            position: 'top-right',
            hideAfter: 3500,
            textAlign: 'center',
            icon: 'success'
        });
    </script>
    ";
        unset($_SESSION['message']);
    }
    ?>