<?php include('includes/header.php'); ?>
<?php //FOR DAILYCHART DATABASE CONNECTION

// Initialize data for Sun (1) to Sat (7)
$weeklyData = array_fill(0, 7, 0);

// SQL: Group by day of week (1 = Sunday, ..., 7 = Saturday)
$sql = "
    SELECT 
        DAYOFWEEK(booking_date) AS day, 
        COUNT(*) AS total
    FROM 
        reservations_tb b
    JOIN 
        reservation_status_tb r ON b.reservation_status_id = r.reservation_status_id
    WHERE 
        r.reservation_status_id = 1
    GROUP BY 
        DAYOFWEEK(booking_date)
";

$result = $connection->query($sql);

while ($row = $result->fetch_assoc()) {
    $dayIndex = (int)$row['day'] - 1; // Convert to 0-based index
    $weeklyData[$dayIndex] = (int)$row['total'];
}

?>
<?php
//MONTHLY CHART BOOKED

$monthly_num = array_fill(0, 12, 0); // Init array for Jan to Dec

$sql = "SELECT
            MONTH(booking_date) AS month_num,
            COUNT(*) AS total
        FROM reservations_tb b
        JOIN 
        reservation_status_tb r ON b.reservation_status_id = r.reservation_status_id
        WHERE 
        r.reservation_status_id = 1
        GROUP BY month_num
        ORDER BY month_num";

$result = $connection->query($sql);

while ($row = $result->fetch_assoc()) {
    $index = (int)$row['month_num'] -1; // Convert 1–12 to 0–11 index
    $monthly_num[$index] = (int)$row['total'];
}
?>
<?php
// Queries
// Count of Available Rooms
$sql_available = "SELECT COUNT(*) as total FROM rooms_tb r
                  JOIN room_status_tb rs ON r.room_status_id = rs.room_status_id
                  WHERE rs.status_name = 'Available'";
$result_available = $connection->query($sql_available);
$available_count = ($result_available && $result_available->num_rows > 0) ? $result_available->fetch_assoc()['total'] : 0;

// Count of Pending Reservations
$sql_pending = "SELECT COUNT(*) as total FROM reservations_tb r
                JOIN reservation_status_tb rs ON r.reservation_status_id = rs.reservation_status_id
                WHERE rs.status_name = 'Pending'";
$result_pending = $connection->query($sql_pending);
$pending_count = ($result_pending && $result_pending->num_rows > 0) ? $result_pending->fetch_assoc()['total'] : 0;

// Count of Confirmed Reservations
$sql_confirmed = "SELECT COUNT(*) as total FROM reservations_tb r
                  JOIN reservation_status_tb rs ON r.reservation_status_id = rs.reservation_status_id
                  WHERE rs.status_name in ('Confirmed')";
$result_confirmed = $connection->query($sql_confirmed);
$confirmed_count = ($result_confirmed && $result_confirmed->num_rows > 0) ? $result_confirmed->fetch_assoc()['total'] : 0;

// Count of Cancelled Reservations
$sql_cancelled = "SELECT COUNT(*) as total FROM reservations_tb r
                  JOIN reservation_status_tb rs ON r.reservation_status_id = rs.reservation_status_id
                  WHERE rs.reservation_status_id = 4";
$result_cancelled = $connection->query($sql_cancelled);
$cancelled_count = ($result_cancelled && $result_cancelled->num_rows > 0) ? $result_cancelled->fetch_assoc()['total'] : 0;

// Count of Occupied Rooms
$sql_occupied = "SELECT COUNT(*) as total FROM rooms_tb r
                  JOIN room_status_tb rs ON r.room_status_id = rs.room_status_id
                  WHERE rs.room_status_id = 4";
$result_occupied = $connection->query($sql_occupied);
$occupied_count = ($result_occupied && $result_occupied->num_rows > 0) ? $result_occupied->fetch_assoc()['total'] : 0;

// Count of Pending Refunds
$sql_pendingrefunds = "SELECT COUNT(*) as total FROM refund_tb r
                  JOIN refund_status_tb rs ON r.refund_status_id = rs.refund_status_id
                  WHERE rs.refund_status_id = 1";
$result_pendingrefunds = $connection->query($sql_pendingrefunds);
$pendingrefunds_count = ($result_pendingrefunds && $result_pendingrefunds->num_rows > 0) ? $result_pendingrefunds->fetch_assoc()['total'] : 0;

// Count of Unread Inqueries
$sql_unread_inquiries = "SELECT COUNT(*) as total FROM inquiries_tb WHERE status_id = 1";
$result_unread_inquiries = $connection->query($sql_unread_inquiries);
$unread_inquiries_count = ($result_unread_inquiries && $result_unread_inquiries->num_rows > 0)
    ? $result_unread_inquiries->fetch_assoc()['total']
    : 0;

// Count of Total Guest Check-in
// Get today's date
$today = date('Y-m-d');

// Query to sum total guests who checked in today
$sql_guests_today = "SELECT SUM(r.total_guests) AS total
FROM reservations_tb r
JOIN reservation_status_tb rs ON r.reservation_status_id = rs.reservation_status_id
WHERE CURDATE() BETWEEN r.check_in_date AND r.check_out_date
  AND rs.reservation_status_id IN (1, 3)";
$result = $connection->query($sql_guests_today);
$row = $result->fetch_assoc();
$total_guests_today = $row['total'] ?? 0;


?>

<?php // REVENUE CARD
// Today's Date
$today = date('Y-m-d');
$monthStart = date('Y-m-01');  // First day of the current month
$monthEnd = date('Y-m-31');    // Last day of the current month (May 31st)
$weekStart = max(date('Y-m-d', strtotime("last sunday")), $monthStart);  // Start of the current week


// Total Revenue Today
$revenueToday = 0;
$sql = "
    SELECT SUM(p.amount_paid) AS total 
    FROM payments_tb p
    JOIN payment_status_tb ps ON p.payment_status_id = ps.payment_status_id
    WHERE DATE(p.date_paid) = '$today' AND ps.payment_status_id = 1";
$result = $connection->query($sql);
if ($row = $result->fetch_assoc()) {
    $revenueToday = $row['total'] ?? 0;
}

// Total Revenue This Week
$revenueWeek = 0;
$sql = "
    SELECT SUM(p.amount_paid) AS total 
    FROM payments_tb p
    JOIN payment_status_tb ps ON p.payment_status_id = ps.payment_status_id
    WHERE p.date_paid >= '$weekStart' AND p.date_paid <= '$today' AND ps.payment_status_id = 1";
$result = $connection->query($sql);
if ($row = $result->fetch_assoc()) {
    $revenueWeek = $row['total'] ?? 0;
}

// Total Revenue This Month
$revenueMonth = 0;
$sql = "
    SELECT SUM(p.amount_paid) AS total 
    FROM payments_tb p
    JOIN payment_status_tb ps ON p.payment_status_id = ps.payment_status_id
    WHERE p.date_paid >= '$monthStart' AND p.date_paid <= '$monthEnd' AND ps.payment_status_id = 1";
$result = $connection->query($sql);
if ($row = $result->fetch_assoc()) {
    $revenueMonth = $row['total'] ?? 0;
}
?>


<style>
        .dashboard {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .cards {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            width: 250px;
        }
        .cards h4 {
            margin: 0;
            font-size: 18px;
            color: #666;
        }
        .cards p {
            margin-top: 10px;
            font-size: 26px;
            font-weight: bold;
            color: #2E8B57;
        }
    </style>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Available Room</p>
                  <h4 class="mb-0"><?= $available_count ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Pending Reservation</p>
                  <h4 class="mb-0"><?= $pending_count ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">person</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Confirmed Reservation</p>
                  <h4 class="mb-0"><?= $confirmed_count ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">leaderboard</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Cancelled Reservation</p>
                  <h4 class="mb-0"><?= $cancelled_count ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Occupied Rooms</p>
                  <h4 class="mb-0"><?= $occupied_count ?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Total Guest Check in</p>
                  <h4 class="mb-0"><?=$total_guests_today?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Pending Refunds</p>
                  <h4 class="mb-0"><?=$pendingrefunds_count?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Unread Inqueries</p>
                  <h4 class="mb-0"><?=$unread_inquiries_count?></h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
  <div class="col-lg-6 col-md-6 mt-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0 ">Daily Booked</h6>
              <p class="text-sm ">Last Resort Performance</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
    <!-- <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h6 class="mb-0 ">Daily Booked</h6>
                <p class="text-sm ">Last Resort Performance</p>
                <div class="pe-2">
                  <div class="chart">
                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div> -->
    <div class="col-lg-6 col-md-6 mt-4 mb-4">
          <div class="card ">
            <div class="card-body">
              <h6 class="mb-0 ">Monthly Booked</h6>
              <p class="text-sm ">Last Resort Performance</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
    <!-- <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card">
        <div class="card-body">
          <h6 class="mb-0 ">Monthly Booked</h6>
          <p class="text-sm ">Last Resort Performance</p>
          <div class="pe-2">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="pe-2">
                <div class="chart">
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>     -->
</div>
<h2 style="text-align: center;">📊 Resort Booking Revenue Summary</h2>
<div class="dashboard">
    <div class="cards">
        <h4>Revenue Today</h4>
        <p>₱<?php echo number_format($revenueToday, 2); ?></p>
    </div>
    <div class="cards">
        <h4>Revenue This Week</h4>
        <p>₱<?php echo number_format($revenueWeek, 2); ?></p>
    </div>
    <div class="cards">
        <h4>Revenue This Month</h4>
        <p>₱<?php echo number_format($revenueMonth, 2); ?></p>
    </div>
</div>


<?php include('includes/footer.php'); ?>
<script>
  var ctx = document.getElementById("chart-bars").getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        label: "Booked",
        tension: 0.4, 
        borderWidth: 0,
        borderRadius: 4,
        borderSkipped: false,
        backgroundColor: "#43A047",
        data: <?php echo json_encode($weeklyData); ?>,
        barThickness: 'flex'
      }, ],
    },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: '#e5e5e5'
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 500,
          beginAtZero: true,
          padding: 10,
          font: {
            size: 14,
            lineHeight: 2
          },
          color: "#737373"
        },
      },
      x: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: false,
          drawTicks: false,
          borderDash: [5, 5]
        },
        ticks: {
          display: true,
          color: '#737373',
          padding: 10,
          font: {
            size: 14,
            lineHeight: 2
          },
        }
      },
    },
  },
});

var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Booked",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: <?php echo json_encode($monthly_num); ?>,
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                return fullMonths[context[0].dataIndex];
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Tasks",
          tension: 0,
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: "#43A047",
          pointBorderColor: "transparent",
          borderColor: "#43A047",
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [4, 4],
              color: '#e5e5e5'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#737373',
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [4, 4]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
            }
          },
        },
      },
    });
</script>