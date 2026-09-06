<?php
require_once "includes/db.php";

$categories_sql = "SELECT category_id, name
                   FROM categories
                   ORDER BY name ASC";

$categories_result = $conn->query($categories_sql);

$categories = [];

while ($category = $categories_result->fetch_assoc()) {
    $categories[] = $category;
}

$selected_category_id = 0;

if (isset($_GET["category_id"]) && ctype_digit($_GET["category_id"])) {
    $selected_category_id = (int) $_GET["category_id"];
}

$selected_product_1 = 0;
$selected_product_2 = 0;

if (isset($_GET["product_1"]) && ctype_digit($_GET["product_1"])) {
    $selected_product_1 = (int) $_GET["product_1"];
}

if (isset($_GET["product_2"]) && ctype_digit($_GET["product_2"])) {
    $selected_product_2 = (int) $_GET["product_2"];
}

$products = [];

if ($selected_category_id > 0) {
    $products_sql = "SELECT
                        product_id,
                        name,
                        brand,
                        current_price
                     FROM products
                     WHERE category_id = ?
                     ORDER BY name ASC";

    $products_stmt = $conn->prepare($products_sql);
    $products_stmt->bind_param("i", $selected_category_id);
    $products_stmt->execute();

    $products_result = $products_stmt->get_result();

    while ($product = $products_result->fetch_assoc()) {
        $products[] = $product;
    }
}

$product_1 = null;
$product_2 = null;
$error_message = "";

if ($selected_product_1 > 0 || $selected_product_2 > 0) {
    if ($selected_category_id === 0) {
        $error_message = "Choose a category first.";
    } elseif ($selected_product_1 === 0 || $selected_product_2 === 0) {
        $error_message = "Choose two products to compare.";
    } elseif ($selected_product_1 === $selected_product_2) {
        $error_message = "Choose two different products.";
    } else {
        $comparison_sql = "SELECT
                                products.*,
                                categories.name AS category_name,
                                AVG(price_history.price) AS average_price
                           FROM products
                           JOIN categories
                                ON products.category_id = categories.category_id
                           LEFT JOIN price_history
                                ON products.product_id = price_history.product_id
                           WHERE products.category_id = ?
                           AND products.product_id IN (?, ?)
                           GROUP BY products.product_id";

        $comparison_stmt = $conn->prepare($comparison_sql);
        $comparison_stmt->bind_param(
            "iii",
            $selected_category_id,
            $selected_product_1,
            $selected_product_2
        );
        $comparison_stmt->execute();

        $comparison_result = $comparison_stmt->get_result();

        $comparison_products = [];

        while ($product = $comparison_result->fetch_assoc()) {
            $comparison_products[$product["product_id"]] = $product;
        }

        if (
            !isset($comparison_products[$selected_product_1]) ||
            !isset($comparison_products[$selected_product_2])
        ) {
            $error_message = "Both products must belong to the selected category.";
        } else {
            $product_1 = $comparison_products[$selected_product_1];
            $product_2 = $comparison_products[$selected_product_2];
        }
    }
}

function show_price_difference($price_1, $price_2) {
    $difference = $price_1 - $price_2;

    if ($difference === 0.0) {
        return "Same current price";
    }

    if ($difference > 0) {
        return "$" . number_format($difference, 2) . " more expensive";
    }

    return "$" . number_format(abs($difference), 2) . " less expensive";
}

function value_status($current_price, $average_price) {
    if ($average_price === null) {
        return "No price history yet";
    }

    $current_price = (float) $current_price;
    $average_price = (float) $average_price;

    if ($current_price < $average_price) {
        return "Good Value";
    }

    if ($current_price > $average_price) {
        return "Above Average";
    }

    return "Near Average";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Products | TechInsight</title>

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

        .intro,
        .compare-form,
        .comparison-results,
        .message {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            padding: 25px;
            margin-bottom: 25px;
        }

        .intro h2,
        .compare-form h2,
        .comparison-results h2 {
            color: #0f172a;
            margin-top: 0;
        }

        .intro p {
            line-height: 1.6;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        select {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-family: inherit;
            font-size: 16px;
            padding: 11px;
            width: 100%;
        }

        button {
            background-color: #0f766e;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 22px;
            padding: 12px 18px;
        }

        button:hover {
            background-color: #115e59;
        }

        .error {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            color: #991b1b;
        }

        .comparison-table {
            border-collapse: collapse;
            width: 100%;
        }

        .comparison-table th,
        .comparison-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 14px;
            text-align: left;
            vertical-align: top;
        }

        .comparison-table th {
            background-color: #f8fafc;
            color: #334155;
        }

        .comparison-table th:first-child {
            width: 24%;
        }

        .price {
            color: #0f766e;
            font-size: 20px;
            font-weight: bold;
        }

        .status {
            border-radius: 16px;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            padding: 6px 10px;
        }

        .good-value {
            background-color: #dcfce7;
            color: #166534;
        }

        .above-average {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .near-average {
            background-color: #fef3c7;
            color: #92400e;
        }

        .no-history {
            background-color: #e2e8f0;
            color: #334155;
        }

        .details-link {
            background-color: #2563eb;
            border-radius: 6px;
            color: white;
            display: inline-block;
            padding: 9px 12px;
            text-decoration: none;
        }

        .details-link:hover {
            background-color: #1d4ed8;
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            margin-top: 40px;
            padding: 18px;
            text-align: center;
        }

        @media (max-width: 800px) {
            main {
                width: 92%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .comparison-table {
                font-size: 14px;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 10px;
            }
        }
.compare-steps {
    background-color: #ecfeff;
    border-left: 5px solid #0f766e;
    border-radius: 6px;
    color: #134e4a;
    line-height: 1.6;
    margin-top: 18px;
    padding: 14px 16px;
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
        <a href="products.php">Products</a>
        <a class="active-nav" href="compare.php">Compare</a>
        <a href="market_trends.php">Market Trends</a>
        <a href="update_price.php">Update Price</a>
	<a href="about.php">About</a>
    </nav>
</header>

<main>
    <section class="intro">
        <h2>Compare Products</h2>

        <p>
    Choose two products from the same category to compare their prices,
    specifications, and price-history value status.
</p>

<div class="compare-steps">
    <strong>How to compare:</strong>

    <ol>
        <li>Select a category.</li>
        <li>Click <strong>Load Products</strong>.</li>
        <li>Select two products from the displayed list.</li>
        <li>Click <strong>Compare Products</strong>.</li>
    </ol>
</div>
    </section>

    <section class="compare-form">
        <h2>Select Products</h2>

        <form method="GET" action="compare.php">
    <div class="form-grid">

        <div>
            <label for="category_id">Category</label>

            <select name="category_id" id="category_id" required>
                <option value="">Choose a category</option>

                <?php foreach ($categories as $category): ?>
                    <option
                        value="<?php echo $category["category_id"]; ?>"
                        <?php echo $selected_category_id === (int) $category["category_id"] ? "selected" : ""; ?>
                    >
                        <?php echo htmlspecialchars($category["name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button
                type="submit"
                name="load_products"
                value="1"
                formnovalidate
            >
                Load Products
            </button>
        </div>

        <div>
            <label for="product_1">First Product</label>

            <select name="product_1" id="product_1" required>
                <option value="">Choose the first product</option>

                <?php foreach ($products as $product): ?>
                    <option
                        value="<?php echo $product["product_id"]; ?>"
                        <?php echo $selected_product_1 === (int) $product["product_id"] ? "selected" : ""; ?>
                    >
                        <?php echo htmlspecialchars($product["name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="product_2">Second Product</label>

            <select name="product_2" id="product_2" required>
                <option value="">Choose the second product</option>

                <?php foreach ($products as $product): ?>
                    <option
                        value="<?php echo $product["product_id"]; ?>"
                        <?php echo $selected_product_2 === (int) $product["product_id"] ? "selected" : ""; ?>
                    >
                        <?php echo htmlspecialchars($product["name"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

    <button type="submit">Compare Products</button>
</form>
    </section>

    <?php if ($error_message !== ""): ?>
        <section class="message error">
            <?php echo htmlspecialchars($error_message); ?>
        </section>
    <?php endif; ?>

    <?php if ($product_1 !== null && $product_2 !== null): ?>
        <?php
            $product_1_current = (float) $product_1["current_price"];
            $product_2_current = (float) $product_2["current_price"];

            $product_1_average = $product_1["average_price"] !== null
                ? (float) $product_1["average_price"]
                : null;

            $product_2_average = $product_2["average_price"] !== null
                ? (float) $product_2["average_price"]
                : null;

            $product_1_status = value_status($product_1_current, $product_1_average);
            $product_2_status = value_status($product_2_current, $product_2_average);

            $status_class_1 = strtolower(str_replace(" ", "-", $product_1_status));
          $status_class_2 = strtolower(str_replace(" ", "-", $product_2_status));
        ?>

        <section class="comparison-results">
            <h2>
                <?php echo htmlspecialchars($product_1["name"]); ?>
                vs.
                <?php echo htmlspecialchars($product_2["name"]); ?>
            </h2>

            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th><?php echo htmlspecialchars($product_1["name"]); ?></th>
                        <th><?php echo htmlspecialchars($product_2["name"]); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>Brand</th>
                        <td><?php echo htmlspecialchars($product_1["brand"]); ?></td>
                        <td><?php echo htmlspecialchars($product_2["brand"]); ?></td>
                    </tr>

                    <tr>
                        <th>Model Number</th>
                        <td><?php echo htmlspecialchars($product_1["model_number"]); ?></td>
                        <td><?php echo htmlspecialchars($product_2["model_number"]); ?></td>
                    </tr>

                    <tr>
                        <th>Specifications</th>
                        <td><?php echo nl2br(htmlspecialchars($product_1["specifications"])); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($product_2["specifications"])); ?></td>
                    </tr>

                    <tr>
                        <th>Current Price</th>
                        <td>
                            <span class="price">
                                $<?php echo number_format($product_1_current, 2); ?>
                            </span>
                            <br>
                            <?php echo show_price_difference($product_1_current, $product_2_current); ?>
                        </td>

                        <td>
                            <span class="price">
                                $<?php echo number_format($product_2_current, 2); ?>
                            </span>
                            <br>
                            <?php echo show_price_difference($product_2_current, $product_1_current); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Average Tracked Price</th>
                        <td>
                            <?php echo $product_1_average !== null ? "$" . number_format($product_1_average, 2) : "No history yet"; ?>
                        </td>
                        <td>
                            <?php echo $product_2_average !== null ? "$" . number_format($product_2_average, 2) : "No history yet"; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Value Status</th>
                        <td>
                            <span class="status <?php echo $status_class_1; ?>">
                                <?php echo htmlspecialchars($product_1_status); ?>
                            </span>
                        </td>
                        <td>
                            <span class="status <?php echo $status_class_2; ?>">
                                <?php echo htmlspecialchars($product_2_status); ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>
                            <?php echo date("F j, Y", strtotime($product_1["last_updated"])); ?>
                        </td>
                        <td>
                            <?php echo date("F j, Y", strtotime($product_2["last_updated"])); ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Details</th>
                        <td>
                            <a
                                class="details-link"
                                href="product.php?id=<?php echo $product_1["product_id"]; ?>"
                            >
                                View Details
                            </a>
                        </td>
                        <td>
                            <a
                                class="details-link"
                                href="product.php?id=<?php echo $product_2["product_id"]; ?>"
                            >
                                View Details
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> TechInsight. Technology price information for comparison purposes.</p>
</footer>

</body>
</html>
</html>