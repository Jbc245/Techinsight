<?php
require_once "includes/db.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid product selected.");
}

$product_id = (int) $_GET["id"];

$product_sql = "SELECT products.*, categories.name AS category_name
                FROM products
                JOIN categories ON products.category_id = categories.category_id
                WHERE products.product_id = ?";

$stmt = $conn->prepare($product_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows === 0) {
    die("Product not found.");
}

$product = $product_result->fetch_assoc();
$average_sql = "SELECT AVG(price) AS average_price
                FROM price_history
                WHERE product_id = ?";

$average_stmt = $conn->prepare($average_sql);
$average_stmt->bind_param("i", $product_id);
$average_stmt->execute();
$average_result = $average_stmt->get_result();
$average_row = $average_result->fetch_assoc();

$average_price = $average_row["average_price"] !== null
    ? (float) $average_row["average_price"]
    : null;

$history_sql = "SELECT price, retailer, price_date
                FROM price_history
                WHERE product_id = ?
                ORDER BY price_date ASC";

$history_stmt = $conn->prepare($history_sql);
$history_stmt->bind_param("i", $product_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();

$dates = [];
$prices = [];

while ($row = $history_result->fetch_assoc()) {
    $dates[] = date("M j, Y", strtotime($row["price_date"]));
    $prices[] = (float) $row["price"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product["name"]); ?> | TechInsight</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            color: #222;
        }

        header {
            background-color: #111827;
            color: white;
            text-align: center;
            padding: 20px;
	    position: relative;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 900px;
            margin: auto;
            padding: 30px 20px;
        }

        .back-link {
            color: #2563eb;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .product-details,
        .chart-box {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .price {
            color: #0f766e;
            font-size: 30px;
            font-weight: bold;
        }

        .source-link {
            color: #2563eb;
            text-decoration: none;
        }

        .source-link:hover {
            text-decoration: underline;
        }

        .notice {
            background-color: #ecfeff;
            border-left: 4px solid #0f766e;
            padding: 12px;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            background-color: #111827;
            color: white;
        }
.value {
    font-weight: bold;
    padding: 10px;
    border-radius: 6px;
    font-size: 14px;
}

.good-value {
    background-color: #dcfce7;
    color: #166534;
}

.high-value {
    background-color: #fee2e2;
    color: #991b1b;
}

.average-value {
    background-color: #fef3c7;
    color: #92400e;
}
.logo-link {
    position: absolute;
    right: 8%;
    top: 50%;
    display: inline-flex;
    transform: translateY(-50%);
}

.site-logo {
    display: block;
    height: 52px;
    width: 52px;
    transition: transform 0.2s ease;
}

.logo-link:hover .site-logo {
    transform: scale(1.08);
}

@media (max-width: 600px) {
    .site-logo {
        height: 42px;
        width: 42px;
    }
}
    </style>
</head>

<body>
    <header>
<a class="logo-link" href="index.php" aria-label="TechInsight home">
        <img
            class="site-logo"
            src="images/techinsight-logo.svg"
            alt="TechInsight logo"
        >
    </a>

        <h1>TechInsight Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
	    <a href="compare.php">Compare</a>
	    <a href="market_trends.php">Market Trends</a>
	    <a href="update_price.php">Update Price</a>
	    <a href="about.php">About</a>
        </nav>
    </header>

    <main>
        <a class="back-link" href="products.php">
    ← Back to Products
</a>

        <section class="product-details">
            <h2><?php echo htmlspecialchars($product["name"]); ?></h2>

            <p><strong>Brand:</strong> <?php echo htmlspecialchars($product["brand"]); ?></p>

            <p><strong>Product type:</strong> <?php echo htmlspecialchars($product["category_name"]); ?></p>

            <p><strong>Specifications:</strong><br>
                <?php echo nl2br(htmlspecialchars($product["specifications"])); ?>
            </p>

            <p><strong>What it means:</strong><br>
                <?php echo nl2br(htmlspecialchars($product["description"])); ?>
            </p>

            <p class="price">
                $<?php echo number_format($product["current_price"], 2); ?>
            </p>
<?php if ($average_price !== null): ?>
    <?php if ($product["current_price"] < $average_price): ?>
        <p class="value good-value">
            Good Value: This price is below the average price in TechInsight.
        </p>
    <?php elseif ($product["current_price"] > $average_price): ?>
        <p class="value high-value">
            Above Average Price: This price is above the average price in TechInsight.
        </p>
    <?php else: ?>
        <p class="value average-value">
            Near Average Price: This price is close to the average price in TechInsight.
        </p>
    <?php endif; ?>
<?php endif; ?>

            <p><strong>Price source:</strong>
                <a class="source-link"
                   href="<?php echo htmlspecialchars($product["source_url"]); ?>"
                   target="_blank">
                    <?php echo htmlspecialchars($product["source_name"]); ?>
                </a>
            </p>

            <p><strong>Last updated:</strong>
                <?php echo date("F j, Y", strtotime($product["last_updated"])); ?>
            </p>

            <div class="notice">
                Prices are for informational purposes only and can change.
                Confirm the final price with the retailer before buying.
            </div>
        </section>

        <section class="chart-box">
            <h2>Price History</h2>

            <?php if (count($dates) > 0): ?>
                <canvas id="priceChart"></canvas>
            <?php else: ?>
                <p>No price-history records are available for this product yet.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>TechInsight Dashboard | Prices are for informational purposes only.</p>
    </footer>

    <?php if (count($dates) > 0): ?>
    <script>
        const priceLabels = <?php echo json_encode($dates); ?>;
        const priceData = <?php echo json_encode($prices); ?>;

        new Chart(document.getElementById("priceChart"), {
            type: "line",
            data: {
                labels: priceLabels,
                datasets: [{
                    label: "Price (USD)",
                    data: priceData,
                    borderColor: "#0f766e",
                    backgroundColor: "rgba(15, 118, 110, 0.15)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.25,
                    pointBackgroundColor: "#0f766e",
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return "$" + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>