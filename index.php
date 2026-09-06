<?php
require_once "includes/db.php";

$product_count_sql = "SELECT COUNT(*) AS total_products
                      FROM products";

$product_count_result = $conn->query($product_count_sql);
$product_count_row = $product_count_result->fetch_assoc();

$total_products = (int) $product_count_row["total_products"];

$lowest_price_sql = "SELECT
                        products.product_id,
                        products.name,
                        products.current_price,
                        categories.name AS category_name
                     FROM products
                     JOIN categories
                        ON products.category_id = categories.category_id
                     ORDER BY products.current_price ASC
                     LIMIT 1";

$lowest_price_result = $conn->query($lowest_price_sql);
$lowest_price_product = $lowest_price_result->fetch_assoc();



$recent_sql = "SELECT
                    products.product_id,
                    products.name,
                    products.brand,
                    products.current_price,
                    products.source_name,
                    products.last_updated,
                    categories.name AS category_name
               FROM products
               JOIN categories
                   ON products.category_id = categories.category_id
               ORDER BY products.last_updated DESC, products.product_id DESC
               LIMIT 1";

$recent_result = $conn->query($recent_sql);
$recent_update_product = $recent_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechInsight Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1f2937;
        }

        header {
            background-color: #0f172a;
            color: white;
            padding: 30px 8%;
            text-align: center;
	    position: relative;
        }

        header h1 {
            margin: 0;
            font-size: 32px;
        }

        nav {
            margin-top: 20px;
        }

        nav a {
            color: #e2e8f0;
            margin: 0 12px;
            text-decoration: none;
        }

        nav a:hover,
        nav a.active-nav {
            color: #5eead4;
        }

        main {
            width: 84%;
            max-width: 1100px;
            margin: 35px auto 60px;
        }

        .hero-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.10);
            padding: 30px;
        }

        .hero-card h2 {
            color: #0f172a;
            margin-top: 0;
        }

        .hero-card p {
            line-height: 1.7;
        }

        .button-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
        }

        .button-row a {
            background-color: #0f766e;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            padding: 12px 16px;
            text-decoration: none;
        }

        .button-row a:hover {
            background-color: #115e59;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 26px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        .stat-card h3 {
            color: #0f766e;
            margin-top: 0;
        }

        .stat-number {
            color: #0f172a;
            font-size: 30px;
            font-weight: bold;
            margin: 18px 0;
        }

        .recent-product {
            color: #0f172a;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.4;
        }

        .stat-card p {
            line-height: 1.5;
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            padding: 20px;
            text-align: center;
        }

        @media (max-width: 800px) {
            main {
                width: 92%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
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
        <a class="active-nav" href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="compare.php">Compare</a>
        <a href="market_trends.php">Market Trends</a>
        <a href="update_price.php">Update Price</a>
	<a href="about.php">About</a>
    </nav>
</header>

<main>
    <section class="hero-card">
        <h2>Make smarter technology buying decisions</h2>

<p>
    TechInsight is a product-comparison and price-tracking dashboard for
    technology shoppers. Explore graphics cards, processors, memory, storage,
    laptops, and smartphones; compare specifications and current prices; review
    price history; and read market updates that explain changes in technology
    pricing.
</p>

<p>
    Whether you are building a PC, choosing a laptop for school, or shopping for
    a new phone, TechInsight helps you compare options in one place before you buy.
</p>

        <div class="button-row">
            <a href="products.php">Browse Products</a>
            <a href="compare.php">Compare Products</a>
            <a href="market_trends.php">Read Market Trends</a>
        </div>
    </section>

    <section class="stats-grid">
        <article class="stat-card">
            <h3>Products tracked</h3>

            <p class="stat-number">
                <?php echo $total_products; ?>
            </p>

            <p>
                Products currently included in the TechInsight database.
            </p>
        </article>

        <article class="stat-card">
            <h3>Lowest product price</h3>

            <?php if ($lowest_price_product): ?>
                <p class="stat-number">
                    $<?php echo number_format((float) $lowest_price_product["current_price"], 2); ?>
                </p>

                <p class="recent-product">
                    <?php echo htmlspecialchars($lowest_price_product["name"]); ?>
                </p>

                <p>
                    Category:
                    <?php echo htmlspecialchars($lowest_price_product["category_name"]); ?>
                </p>
            <?php else: ?>
                <p>No products are available yet.</p>
            <?php endif; ?>
        </article>

        <article class="stat-card">
            <h3>Most recently updated</h3>

            <?php if ($recent_update_product): ?>
                <p class="recent-product">
                    <?php echo htmlspecialchars($recent_update_product["name"]); ?>
                </p>

                <p>
                    Price:
                    $<?php echo number_format((float) $recent_update_product["current_price"], 2); ?>
                </p>

                <p>
                    Retailer:
                    <?php echo htmlspecialchars($recent_update_product["source_name"]); ?>
                </p>

                <p>
                    Category:
                    <?php echo htmlspecialchars($recent_update_product["category_name"]); ?>
                </p>

                <p>
                    Updated:
                    <?php echo date("F j, Y", strtotime($recent_update_product["last_updated"])); ?>
                </p>
            <?php else: ?>
                <p>No product updates have been recorded yet.</p>
            <?php endif; ?>
        </article>
    </section>
</main>

<footer>
    <p>TechInsight Dashboard | Prices are for informational purposes only.</p>
</footer>

</body>
</html>