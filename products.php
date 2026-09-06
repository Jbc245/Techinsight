<?php
require_once "includes/db.php";

$categories = [
    "graphics-cards" => "Graphics Cards",
    "processors" => "Processors",
    "memory" => "Memory",
    "storage" => "Storage",
    "laptops" => "Laptops",
    "smartphones" => "Smartphones"
];

$selected_category = "graphics-cards";

if (isset($_GET["category"]) && array_key_exists($_GET["category"], $categories)) {
    $selected_category = $_GET["category"];
}

$category_name = $categories[$selected_category];

$search = "";
$result = null;
$average_prices = [];

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if ($search !== "") {
    $search_term = "%" . $search . "%";

    $sql = "SELECT products.*, categories.name AS category_name
            FROM products
            JOIN categories
                ON products.category_id = categories.category_id
            WHERE categories.name = ?
            AND (
                products.name LIKE ?
                OR products.brand LIKE ?
                OR products.model_number LIKE ?
                OR products.specifications LIKE ?
            )
            ORDER BY products.current_price ASC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssss",
        $category_name,
        $search_term,
        $search_term,
        $search_term,
        $search_term
    );

    $stmt->execute();
    $result = $stmt->get_result();

} else {
    $sql = "SELECT products.*, categories.name AS category_name
            FROM products
            JOIN categories
                ON products.category_id = categories.category_id
            WHERE categories.name = ?
            ORDER BY products.current_price ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();

    $result = $stmt->get_result();
}

$price_history_sql = "SELECT product_id, AVG(price) AS average_price
                      FROM price_history
                      GROUP BY product_id";

$price_history_result = $conn->query($price_history_sql);

if ($price_history_result) {
    while ($history = $price_history_result->fetch_assoc()) {
        $average_prices[$history["product_id"]] = (float) $history["average_price"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | TechInsight</title>

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
            padding: 18px 8%;
	    position: relative;
        }

        header h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        nav a {
            color: #e2e8f0;
            text-decoration: none;
            margin-right: 18px;
        }

        nav a:hover,
        nav a.active-nav {
            color: #5eead4;
        }

        main {
            width: 84%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .intro {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            margin-bottom: 25px;
        }

        .intro h2 {
            margin-top: 0;
            color: #0f172a;
        }

        .category-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .category-nav a {
            background-color: #e2e8f0;
            border-radius: 6px;
            color: #1e293b;
            padding: 10px 14px;
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .category-nav a:hover {
            background-color: #cbd5e1;
        }

        .category-nav a.active-category {
            background-color: #0f766e;
            color: white;
        }

        .search-form {
            margin-top: 22px;
        }

        .search-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .search-form input {
            padding: 10px;
            width: 280px;
            max-width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 16px;
        }

        .search-form button {
            padding: 10px 14px;
            margin-left: 6px;
            background-color: #0f766e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #115e59;
        }

        .clear-search {
            display: inline-block;
            margin-left: 10px;
            color: #2563eb;
            text-decoration: none;
        }

        .clear-search:hover {
            text-decoration: underline;
        }

        .search-message {
            margin-top: 14px;
            color: #374151;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }

        .product-card h3 {
            color: #0f172a;
            margin-top: 0;
        }

        .product-card p {
            line-height: 1.5;
        }

        .price {
            color: #0f766e;
            font-size: 23px;
            font-weight: bold;
        }

        .value-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
            border-radius: 20px;
            font-weight: bold;
            padding: 6px 10px;
            margin-top: 8px;
        }

        .details-link {
            display: inline-block;
            margin-top: 14px;
            background-color: #2563eb;
            color: white;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
        }

        .details-link:hover {
            background-color: #1d4ed8;
        }

        .empty-state {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            padding: 35px;
            text-align: center;
        }

        .empty-state h3 {
            color: #0f172a;
            margin-top: 0;
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            text-align: center;
            padding: 18px;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            main {
                width: 92%;
            }

            .search-form button {
                margin-left: 0;
                margin-top: 10px;
            }

            .clear-search {
                margin-left: 0;
                margin-top: 12px;
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

    <h1>TechInsight</h1>

    <nav>
        <a href="index.php">Home</a>
        <a class="active-nav" href="products.php">Products</a>
        <a href="compare.php">Compare</a>
        <a href="market_trends.php">Market Trends</a>
        <a href="update_price.php">Update Price</a>
	<a href="about.php">About</a>
    </nav>
</header>

<main>
    <section class="intro">
        <h2>Products</h2>

        <p>
            Browse technology products by category. Compare products and review
            recently checked prices before making a buying decision.
        </p>

        <div class="category-nav">
            <?php foreach ($categories as $slug => $name): ?>
                <a
                    href="products.php?category=<?php echo urlencode($slug); ?>"
                    class="<?php echo $slug === $selected_category ? 'active-category' : ''; ?>"
                >
                    <?php echo htmlspecialchars($name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="intro">
        <h2><?php echo htmlspecialchars($category_name); ?></h2>

        <p>
            Compare <?php echo strtolower(htmlspecialchars($category_name)); ?>
            and see recently checked prices. Prices can change, so always confirm
            the final price with the retailer.
        </p>

        <?php if ($selected_category === "memory"): ?>
            <p>
                Important: DDR4 and DDR5 memory are not interchangeable.
                Check your motherboard's supported memory type before purchasing.
            </p>
        <?php endif; ?>

        <?php if ($selected_category === "storage"): ?>
            <p>
                Important: Check that your device supports an M.2 2280 NVMe drive
                and the appropriate PCIe generation. A PCIe 5.0 SSD can work in a
                compatible PCIe 4.0 slot, but it will run at the lower connection speed.
            </p>
        <?php endif; ?>

        <?php if ($selected_category === "laptops"): ?>
            <p>
                Important: Laptop components are usually not as upgradeable as desktop
                parts. Before buying, compare the display, processor, graphics, memory,
                storage, ports, size, weight, battery needs, and operating system.
            </p>
        <?php endif; ?>

        <?php if ($selected_category === "smartphones"): ?>
            <p>
                Important: Before buying a smartphone, compare storage capacity, camera
                features, battery life, screen size, operating system, carrier
                compatibility, and whether the phone is unlocked. Also consider whether
                it works well with the devices and services you already use.
            </p>
        <?php endif; ?>

        <form class="search-form" method="GET" action="products.php">
            <input
                type="hidden"
                name="category"
                value="<?php echo htmlspecialchars($selected_category); ?>"
            >

            <label for="search">
                Search <?php echo htmlspecialchars($category_name); ?>:
            </label>

            <input
                type="text"
                name="search"
                id="search"
                value="<?php echo htmlspecialchars($search); ?>"
                placeholder="Search by brand, product name, model, or specifications"
            >

            <button type="submit">Search</button>

            <?php if ($search !== ""): ?>
                <a
                    class="clear-search"
                    href="products.php?category=<?php echo urlencode($selected_category); ?>"
                >
                    Clear search
                </a>
            <?php endif; ?>
        </form>

        <?php if ($search !== ""): ?>
            <p class="search-message">
                Search results for:
                <strong><?php echo htmlspecialchars($search); ?></strong>
            </p>
        <?php endif; ?>
    </section>

    <?php if ($result && $result->num_rows > 0): ?>
        <section class="product-grid">
            <?php while ($product = $result->fetch_assoc()): ?>
                <?php
                    $product_id = $product["product_id"];
                    $current_price = (float) $product["current_price"];
                    $average_price = $average_prices[$product_id] ?? $current_price;
                    $is_good_value = $current_price <= $average_price;
                ?>

                <article class="product-card">
                    <h3><?php echo htmlspecialchars($product["name"]); ?></h3>

                    <p>
                        <strong>Brand:</strong>
                        <?php echo htmlspecialchars($product["brand"]); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($product["description"]); ?>
                    </p>

                    <p class="price">
                        $<?php echo number_format($current_price, 2); ?>
                    </p>

                    <?php if ($is_good_value): ?>
                        <span class="value-badge">Good Value</span>
                    <?php endif; ?>

                    <br>

                    <a
                        class="details-link"
                        href="product.php?id=<?php echo $product_id; ?>"
                    >
                        View Details
                    </a>
                </article>
            <?php endwhile; ?>
        </section>
    <?php else: ?>
        <section class="empty-state">
            <h3>No <?php echo strtolower(htmlspecialchars($category_name)); ?> were found</h3>

            <p>
                Try searching for a brand, product name, model number, or a different keyword.
            </p>

            <?php if ($search !== ""): ?>
                <a
                    class="details-link"
                    href="products.php?category=<?php echo urlencode($selected_category); ?>"
                >
                    View All <?php echo htmlspecialchars($category_name); ?>
                </a>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<footer>
    <p>
        &copy; <?php echo date("Y"); ?> TechInsight.
        Technology price information for comparison purposes.
    </p>
</footer>

</body>
</html>