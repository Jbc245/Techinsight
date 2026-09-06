<?php
require_once "includes/db.php";

$sql = "SELECT * FROM market_notes
        ORDER BY published_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Trends | TechInsight</title>

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
            padding: 20px;
            text-align: center;
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

        .intro {
    background-color: #ecfeff;
    border-left: 5px solid #0f766e;
    border-radius: 6px;
    color: #134e4a;
    line-height: 1.6;
    margin-bottom: 25px;
    padding: 18px 20px;
}

.intro h2 {
    color: #0f766e;
    margin-top: 0;
}

.intro p {
    margin-bottom: 0;
}

        .trend-date {
            color: #666;
            font-size: 14px;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 30px;
            background-color: #111827;
            color: white;
        }
.trend-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
    margin-top: 25px;
    align-items: start;
}

.trend-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    padding: 22px;
}

.trend-card h3 {
    color: #0f766e;
    margin-top: 0;
}

.trend-card p {
    line-height: 1.6;
}

.trend-card a {
    color: #2563eb;
}

.trend-card a:hover {
    text-decoration: underline;
}

@media (max-width: 750px) {
    .trend-grid {
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
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="compare.php">Compare</a>
            <a href="market_trends.php">Market Trends</a>
	    <a href="update_price.php">Update Price</a>
	    <a href="about.php">About</a>
        </nav>
    </header>

    <main>
        <section class="intro">
            <h2>Market Trends</h2>
            <p>
                This page explains some of the market changes that can affect
                technology prices. These notes are meant to give users context
                before they make a purchase.
            </p>
        </section>

        <?php if ($result && $result->num_rows > 0): ?>

    <section class="trend-grid">
        <?php while ($note = $result->fetch_assoc()): ?>
            <article class="trend-card">
                <h2><?php echo htmlspecialchars($note["title"]); ?></h2>

                <p class="trend-date">
                    Posted:
                    <?php echo date("F j, Y", strtotime($note["published_date"])); ?>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars($note["content"])); ?>
                </p>

                <?php if (!empty($note["source_name"]) && !empty($note["source_url"])): ?>
                    <p>
                        <strong>Source:</strong>
                        <a
                            href="<?php echo htmlspecialchars($note["source_url"]); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <?php echo htmlspecialchars($note["source_name"]); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </section>

<?php else: ?>

    <section class="trend-card">
        <p>No market-trend notes have been added yet.</p>
    </section>

<?php endif; ?>
    </main>

    <footer>
        <p>TechInsight Dashboard | Information is for educational purposes only.</p>
    </footer>
</body>
</html>