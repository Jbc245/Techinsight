<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | TechInsight</title>

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
            max-width: 1000px;
            margin: 30px auto;
        }

        .page-intro {
            background-color: #0f766e;
            border-radius: 10px;
            color: white;
            padding: 32px;
            margin-bottom: 24px;
        }

        .page-intro h2 {
            margin-top: 0;
            font-size: 30px;
        }

        .page-intro p {
            line-height: 1.7;
            margin-bottom: 0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .about-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        .about-card h2 {
            color: #0f766e;
            margin-top: 0;
        }

        .about-card p,
        .about-card li {
            line-height: 1.65;
        }

        .about-card ul {
            padding-left: 22px;
            margin-bottom: 0;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .disclaimer {
            background-color: #ecfeff;
            border-left: 5px solid #2563eb;
            border-radius: 8px;
            color: #134e4a;
        }

        footer {
            background-color: #0f172a;
            color: #cbd5e1;
            margin-top: 40px;
            padding: 18px;
            text-align: center;
        }

        @media (max-width: 750px) {
            main {
                width: 92%;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
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
        <a href="products.php">Products</a>
        <a href="compare.php">Compare</a>
        <a href="market_trends.php">Market Trends</a>
        <a href="update_price.php">Update Price</a>
        <a class="active-nav" href="about.php">About</a>
    </nav>
</header>

<main>
    <section class="page-intro">
        <h2>About TechInsight</h2>

        <p>
            TechInsight is a technology product-comparison and price-tracking
            website designed to help users research technology purchases with
            clearer product details, price history, market information, and
            source-based updates.
        </p>
    </section>

    <section class="about-grid">
        <article class="about-card">
            <h2>Project Purpose</h2>

            <p>
                Technology pricing can change quickly because of product launches,
                component supply, retailer sales, memory costs, demand, and broader
                market conditions. TechInsight brings useful research information
                together so users can compare options before purchasing.
            </p>

            <p>
                The project focuses on technology categories that shoppers commonly
                compare, including graphics cards, processors, memory, storage,
                laptops, and smartphones.
            </p>
        </article>

        <article class="about-card">
            <h2>What TechInsight Provides</h2>

            <ul>
                <li>Product browsing across multiple technology categories</li>
                <li>Search tools for product names, brands, models, and specifications</li>
                <li>Side-by-side comparisons for products in the same category</li>
                <li>Current prices and historical price entries</li>
                <li>Market-trend notes with published dates and source links</li>
                <li>Optional retailer or manufacturer links for price updates</li>
            </ul>
        </article>

        <article class="about-card">
            <h2>Who It Helps</h2>

            <p>
                TechInsight is intended for everyday technology shoppers, students,
                PC builders, gamers, and users comparing laptops or smartphones.
                It is especially useful for people who want to compare products
                without searching through multiple separate websites first.
            </p>

            <p>
                For example, a user can compare two graphics cards, review their
                specifications and current prices, and use price history to decide
                whether a listed price appears favorable.
            </p>
        </article>

        <article class="about-card">
            <h2>Using Price Information</h2>

            <p>
                Prices shown in TechInsight are intended for research and comparison.
                A product price can change because of retailer promotions, taxes,
                shipping, availability, product configuration, and regional pricing.
            </p>

            <p>
                Users should always confirm the final price, product configuration,
                warranty details, and seller information directly with the retailer
                before making a purchase.
            </p>
        </article>

        <article class="about-card full-width">
            <h2>About the Developer</h2>

            <p>
                TechInsight was created by <strong>Joshua Brown-Campbell</strong> as an
                information technology project focused on database-driven web
                development, product research, and technology price tracking.
            </p>

            <p>
    Joshua is pursuing a master's degree in Information Technology with a focus on
    web development and database management. This project demonstrates practical
    skills in PHP, MySQL, SQL database design, user-input validation, responsive
    web design, product research, and presenting technology information in a clear,
    organized format.
</p>

            <p>
                The project combines product records, price-history data, market
                sources, and user-friendly pages to demonstrate how a relational
                database can support a useful technology research website.
            </p>
        </article>

        <article class="about-card full-width disclaimer">
            <h2>Educational Project Disclaimer</h2>

            <p>
                TechInsight is an educational project and is not an online store,
                product seller, financial advisor, or guarantee of product pricing.
                Information is provided for research and comparison purposes only.
                Always confirm product details and final prices with the original
                retailer or manufacturer.
            </p>
        </article>
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