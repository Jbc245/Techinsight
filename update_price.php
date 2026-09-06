<?php
require_once "includes/db.php";

$message = "";
$message_type = "";

$selected_product_id = "";
$entered_price = "";
$entered_retailer = "";
$entered_source_url = "";
$entered_date = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $selected_product_id = filter_input(
        INPUT_POST,
        "product_id",
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    $entered_price = trim($_POST["price"] ?? "");
    $entered_retailer = trim($_POST["retailer"] ?? "");
    $entered_source_url = trim($_POST["source_url"] ?? "");
    $entered_date = trim($_POST["price_date"] ?? "");

    $price = filter_var($entered_price, FILTER_VALIDATE_FLOAT);

    $date_object = DateTime::createFromFormat("Y-m-d", $entered_date);

    $valid_date = $date_object &&
                  $date_object->format("Y-m-d") === $entered_date;

    $valid_source_url = true;

    if ($entered_source_url !== "") {
        $url_parts = parse_url($entered_source_url);
        $scheme = strtolower($url_parts["scheme"] ?? "");

        if (
            !filter_var($entered_source_url, FILTER_VALIDATE_URL) ||
            !in_array($scheme, ["http", "https"], true)
        ) {
            $valid_source_url = false;
        }
    }

    if (
        $selected_product_id === false ||
        $price === false ||
        $price <= 0 ||
        $entered_retailer === "" ||
        !$valid_date
    ) {
        $message = "Please select a product and enter a valid price, retailer, and date.";
        $message_type = "error";

    } elseif (!$valid_source_url) {
        $message = "Please enter a valid source link beginning with https:// or http://.";
        $message_type = "error";

    } else {
        $product_check_sql = "SELECT product_id
                              FROM products
                              WHERE product_id = ?";

        $product_check_stmt = $conn->prepare($product_check_sql);

        $product_check_stmt->bind_param(
            "i",
            $selected_product_id
        );

        $product_check_stmt->execute();

        $product_check_result = $product_check_stmt->get_result();

        if ($product_check_result->num_rows === 0) {
            $message = "The selected product could not be found.";
            $message_type = "error";

        } else {
            try {
                $conn->begin_transaction();

                $history_sql = "INSERT INTO price_history
                                (
                                    product_id,
                                    price,
                                    retailer,
                                    source_url,
                                    price_date
                                )
                                VALUES (?, ?, ?, ?, ?)";

                $history_stmt = $conn->prepare($history_sql);

                $history_stmt->bind_param(
                    "idsss",
                    $selected_product_id,
                    $price,
                    $entered_retailer,
                    $entered_source_url,
                    $entered_date
                );

                $history_stmt->execute();

                $update_sql = "UPDATE products
                               SET current_price = ?,
                                   last_updated = ?
                               WHERE product_id = ?";

                $update_stmt = $conn->prepare($update_sql);

                $update_stmt->bind_param(
                    "dsi",
                    $price,
                    $entered_date,
                    $selected_product_id
                );

                $update_stmt->execute();

                $conn->commit();

                $message = "Price update saved successfully. The product card and details page now use the new current price.";
                $message_type = "success";

                $selected_product_id = "";
                $entered_price = "";
                $entered_retailer = "";
                $entered_source_url = "";
                $entered_date = date("Y-m-d");

            } catch (Exception $error) {
                $conn->rollback();

                $message = "The update could not be saved. Make sure price_history has a source_url column.";
                $message_type = "error";
            }
        }
    }
}

$products_sql = "SELECT
                    products.product_id,
                    products.name,
                    products.brand,
                    products.current_price,
                    categories.name AS category_name
                 FROM products
                 JOIN categories
                    ON products.category_id = categories.category_id
                 ORDER BY categories.name ASC, products.name ASC";

$products_result = $conn->query($products_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Price | TechInsight</title>

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
            max-width: 760px;
            margin: 30px auto;
        }

        .form-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            padding: 28px;
        }

        .form-card h2 {
            color: #0f172a;
            margin-top: 0;
        }

        .form-card p {
            line-height: 1.6;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        select,
        input {
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
            margin-top: 24px;
            padding: 12px 18px;
        }

        button:hover {
            background-color: #115e59;
        }

        .message {
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 14px;
        }

        .success {
            background-color: #dcfce7;
            border-left: 4px solid #16a34a;
            color: #166534;
        }

        .error {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            color: #991b1b;
        }

        .form-help {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
            margin: 6px 0 18px;
        }

        .note {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            color: #1e3a8a;
            margin-top: 24px;
            padding: 14px;
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            margin-top: 40px;
            padding: 18px;
            text-align: center;
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
        <a href="compare.php">Compare</a>
        <a href="market_trends.php">Market Trends</a>
        <a class="active-nav" href="update_price.php">Update Price</a>
	<a href="about.php">About</a>
    </nav>
</header>

<main>
    <section class="form-card">
        <h2>Update a Product Price</h2>

        <p>
            Add a newly checked price to a product's history. TechInsight will also
            use it as that product's current price.
        </p>

        <?php if ($message !== ""): ?>
            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="update_price.php">

            <label for="product_id">Product</label>

            <select name="product_id" id="product_id" required>
                <option value="">Choose a product</option>

                <?php while ($product_option = $products_result->fetch_assoc()): ?>
                    <option
                        value="<?php echo $product_option["product_id"]; ?>"
                        <?php echo (string) $selected_product_id === (string) $product_option["product_id"] ? "selected" : ""; ?>
                    >
                        <?php echo htmlspecialchars($product_option["category_name"]); ?>
                        —
                        <?php echo htmlspecialchars($product_option["name"]); ?>
                        — Current: $<?php echo number_format((float) $product_option["current_price"], 2); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="price">New Price (USD)</label>

            <input
                type="number"
                name="price"
                id="price"
                min="0.01"
                step="0.01"
                value="<?php echo htmlspecialchars($entered_price); ?>"
                placeholder="Example: 349.99"
                required
            >

            <label for="retailer">Retailer or Source</label>

            <input
                type="text"
                name="retailer"
                id="retailer"
                maxlength="100"
                value="<?php echo htmlspecialchars($entered_retailer); ?>"
                placeholder="Example: Walmart"
                required
            >

            <label for="source_url">Source URL (optional)</label>

            <input
                type="url"
                name="source_url"
                id="source_url"
                maxlength="500"
                value="<?php echo htmlspecialchars($entered_source_url); ?>"
                placeholder="https://www.example.com/product-page"
            >

            <p class="form-help">
                Paste the product page link where you found the price. Use a trusted
                retailer or manufacturer website. Leave this field blank if you do
                not have a product page link.
            </p>

            <label for="price_date">Date Checked</label>

            <input
                type="date"
                name="price_date"
                id="price_date"
                value="<?php echo htmlspecialchars($entered_date); ?>"
                required
            >

            <button type="submit">Save Price Update</button>
        </form>

        <div class="note">
            Prices are for comparison and tracking only. Confirm the retailer's final
            price before purchasing.
        </div>
    </section>
</main>

<footer>
    <p>
        &copy; <?php echo date("Y"); ?> TechInsight.
        Technology price information for comparison purposes.
    </p>
</footer>

</body>
</html>