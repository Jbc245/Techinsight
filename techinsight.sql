-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2026 at 01:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techinsight`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Graphics Cards'),
(2, 'Processors'),
(3, 'Memory'),
(4, 'Storage'),
(5, 'Laptops'),
(6, 'Smartphones');

-- --------------------------------------------------------

--
-- Table structure for table `market_notes`
--

CREATE TABLE `market_notes` (
  `note_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `source_name` varchar(255) DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `published_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `market_notes`
--

INSERT INTO `market_notes` (`note_id`, `title`, `content`, `source_name`, `source_url`, `published_date`) VALUES
(1, 'AI demand is increasing pressure on memory chips', 'Reuters reported that the rapid growth of AI infrastructure has absorbed a large amount of the world’s memory-chip supply. Manufacturers have been prioritizing higher-profit data-center components, which can affect the cost and availability of memory used in consumer PCs and smartphones. This is one reason users may see higher prices or fewer lower-cost options.', 'Reuters: Surging memory chip prices dim outlook for consumer electronics makers', 'https://www.reuters.com/world/asia-pacific/surging-memory-chip-prices-dim-outlook-consumer-electronics-makers-2026-01-22/', '2026-01-22'),
(2, 'AMD says AI infrastructure is driving data-center demand', 'AMD reported that its data-center revenue reached $6.7 billion in the second quarter of 2026, which was 107% higher than the previous year. AMD said the increase was driven by strong demand for EPYC processors and Instinct GPUs. This shows how quickly AI and data-center demand are growing and why those markets can affect the wider hardware industry.', 'AMD: Second Quarter 2026 Financial Results', 'https://ir.amd.com/news-events/press-releases/detail/1295/amd-reports-second-quarter-2026-financial-results', '2026-08-04'),
(3, 'NVIDIA data-center revenue shows strong AI hardware demand', 'NVIDIA reported record data-center revenue of $62.3 billion for its fourth quarter of fiscal 2026. The company said this was 75% higher than the same period the year before. This does not mean every consumer graphics card will become more expensive, but it shows that demand for high-performance AI hardware is very strong.', 'NVIDIA: Fourth Quarter and Fiscal 2026 Financial Results', 'http://nvidianews.nvidia.com/news/nvidia-announces-financial-results-for-fourth-quarter-and-fiscal-2026', '2026-02-25'),
(4, 'DRAM Spot Prices Increased', 'TrendForce reported that the average spot price of mainstream DDR4 chips increased 0.93% in the week ending August 10, 2026. The report also noted that 512Gb TLC NAND wafer prices increased 4.97%. Higher DRAM and NAND pricing may affect consumer RAM, SSDs, laptops, and smartphones.', 'TrendForce', 'https://www.trendforce.com/news/2026/08/12/insights-memory-spot-price-update-dram-spot-trading-stays-subdued-as-pricing-gap-persists-ddr4-up-0-93/', '2026-08-12'),
(5, 'AI Server Demand Creates NAND Flash Supply Pressure', 'TrendForce reported that steady AI-server demand, especially for enterprise SSDs, created a NAND flash supply shortage during the second quarter of 2026. When enterprise demand is high, consumer SSD pricing and availability can be affected.', 'TrendForce', 'https://www.trendforce.com/presscenter/news/20260818-13186.html', '2026-08-18'),
(6, 'Mobile Memory Costs Affect Smartphone Prices', 'Counterpoint Research forecast that mobile DRAM prices would rise about 10% quarter over quarter in Q3 2026. It also reported that higher memory prices increased the bill of materials for low-end smartphones. Phone makers may raise prices, reduce included storage, or limit features in lower-cost models.', 'Counterpoint Research', 'https://counterpointresearch.com/en/reports/memory-price-tracker-and-forecast-aug-2026', '2026-08-07'),
(7, 'Chipflation Pressures Flagship Smartphone Pricing', 'Counterpoint Research reported that DRAM average selling prices had risen 400% and NAND average selling prices had risen more than 300% over the prior 12 months. Its analysis estimated that rising component costs could add about $300 to a highest-configuration Pro Max smartphone and about $200 to $250 to some base and Pro configurations.', 'Counterpoint Research', 'https://counterpointresearch.com/en/insights/chipflation-apples-iphone-18-choice-protect-margins-or-go-for-the-kill', '2026-08-11'),
(8, 'Tariffs and AI Trends Affect Laptop Prices', 'TechInsights identified on-device AI, tariffs, and pricing impacts as major PC and laptop market trends for 2026. Its outlook said higher tariff-related prices in the United States could pressure retail pricing and affect consumer notebook demand.', 'TechInsights', 'https://www.techinsights.com/outlook-reports-2026/pc-laptop-tablet-outlook-report', '2026-09-03'),
(9, 'Enterprise SSD Demand Reaches Nearly Half of NAND Shipments', 'Counterpoint Research reported that AI-inference workloads pushed enterprise SSDs to 48% of worldwide NAND shipments in Q2 2026, nearly double the 26% share from the previous year. Strong data-center demand can influence consumer NVMe SSD supply, prices, and sales availability.', 'Counterpoint Research', 'https://counterpointresearch.com/en/insights/server-led-essds-hit-48-percent-of-nand-shipments', '2026-08-12'),
(10, 'Graphics Card Prices Rise as Memory Costs Increase', 'Tom\'s Hardware reported that prices for several NVIDIA RTX 50-series graphics cards increased sharply in the United States between June and August 2026. Its review of Newegg listings found the median price of the RTX 5070 rose 36%, the RTX 5060 rose 27%, and the RTX 5060 Ti 16GB rose 39%. The report connected these increases to memory shortages and higher component costs.', 'Tom\'s Hardware', 'https://www.tomshardware.com/pc-components/gpus/geforce-rtx-50-series-gpu-prices-spike-as-much-as-39-percent-as-blackwell-price-hikes-hit-the-us-rtx-5070-gets-a-36-percent-hike-rtx-5060-up-27-percent-at-the-median-of-newegg-listings', '2026-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `price_history`
--

CREATE TABLE `price_history` (
  `price_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `retailer` varchar(150) DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `price_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price_history`
--

INSERT INTO `price_history` (`price_id`, `product_id`, `price`, `retailer`, `source_url`, `price_date`) VALUES
(1, 1, 549.99, 'Micro Center', NULL, '2026-06-01'),
(2, 1, 529.99, 'Micro Center', NULL, '2026-07-01'),
(3, 1, 519.99, 'Micro Center', NULL, '2026-08-01'),
(4, 1, 499.99, 'Micro Center', NULL, '2026-09-05'),
(5, 2, 649.99, 'Amazon', NULL, '2026-06-01'),
(6, 2, 639.99, 'Amazon', NULL, '2026-07-01'),
(7, 2, 629.99, 'Amazon', NULL, '2026-08-01'),
(8, 2, 619.99, 'Amazon', NULL, '2026-09-05'),
(9, 3, 519.99, 'Best Buy', NULL, '2026-06-01'),
(10, 3, 499.99, 'Best Buy', NULL, '2026-07-01'),
(11, 3, 489.99, 'Best Buy', NULL, '2026-08-01'),
(12, 3, 479.99, 'Best Buy', NULL, '2026-09-05'),
(13, 4, 279.99, 'Best Buy', NULL, '2026-06-01'),
(14, 4, 269.99, 'Best Buy', NULL, '2026-07-01'),
(15, 4, 259.99, 'Best Buy', NULL, '2026-08-01'),
(16, 4, 249.99, 'Best Buy', NULL, '2026-09-05'),
(17, 3, 799.99, 'Best Buy', NULL, '2026-09-06'),
(18, 2, 856.99, 'Amazon', NULL, '2026-09-06'),
(19, 1, 639.99, 'Amazon', NULL, '2026-09-06'),
(20, 4, 249.99, 'Best Buy', NULL, '2026-09-06'),
(21, 1, 650.99, 'ebay', NULL, '2026-09-06'),
(22, 5, 199.00, 'AMD', NULL, '2026-09-06'),
(23, 6, 369.00, 'AMD', NULL, '2026-09-06'),
(24, 7, 279.00, 'Intel', NULL, '2026-09-06'),
(25, 8, 379.00, 'Intel', NULL, '2026-09-06'),
(29, 5, 204.00, 'Amazon', NULL, '2026-09-06'),
(30, 5, 172.00, 'Walmart', NULL, '2026-09-06'),
(31, 7, 267.64, 'Amazon', NULL, '2026-09-06'),
(32, 6, 367.39, 'Amazon', NULL, '2026-09-06'),
(33, 6, 319.99, 'Micro Center', NULL, '2026-09-06'),
(34, 8, 390.99, 'Newegg', NULL, '2026-09-06'),
(35, 8, 365.99, 'Amazon', NULL, '2026-09-06'),
(36, 9, 399.99, 'Newegg', NULL, '2026-09-06'),
(37, 10, 249.99, 'Best Buy', NULL, '2026-09-06'),
(38, 11, 499.99, 'Newegg', NULL, '2026-09-06'),
(39, 12, 454.99, 'Corsair', NULL, '2026-09-06'),
(43, 13, 750.00, 'Amazon', NULL, '2026-09-06'),
(44, 14, 389.99, 'Amazon', NULL, '2026-09-06'),
(45, 15, 302.99, 'Newegg', NULL, '2026-09-06'),
(46, 16, 299.99, 'Amazon', NULL, '2026-09-06'),
(50, 14, 389.99, 'Amazon', NULL, '2026-09-06'),
(51, 13, 770.00, 'Amazon', NULL, '2026-07-08'),
(52, 14, 409.99, 'Amazon', NULL, '2026-07-08'),
(53, 15, 322.99, 'Newegg', NULL, '2026-07-08'),
(54, 16, 319.99, 'Amazon', NULL, '2026-07-08'),
(58, 13, 740.00, 'Amazon', NULL, '2026-08-07'),
(59, 14, 379.99, 'Amazon', NULL, '2026-08-07'),
(60, 15, 292.99, 'Newegg', NULL, '2026-08-07'),
(61, 16, 289.99, 'Amazon', NULL, '2026-08-07'),
(65, 13, 755.00, 'Amazon', NULL, '2026-08-23'),
(66, 14, 394.99, 'Amazon', NULL, '2026-08-23'),
(67, 15, 307.99, 'Newegg', NULL, '2026-08-23'),
(68, 16, 304.99, 'Amazon', NULL, '2026-08-23'),
(72, 14, 639.99, 'Amazon', NULL, '2026-07-23'),
(73, 14, 369.99, 'Amazon', NULL, '2026-08-17'),
(74, 13, 899.99, 'Amazon', NULL, '2026-07-23'),
(75, 13, 829.99, 'Amazon', NULL, '2026-08-17'),
(76, 15, 282.99, 'Newegg', NULL, '2026-07-23'),
(77, 15, 322.99, 'Newegg', NULL, '2026-08-17'),
(78, 16, 349.99, 'Amazon', NULL, '2026-07-23'),
(79, 16, 329.99, 'Amazon', NULL, '2026-08-17'),
(80, 11, 399.99, 'Amazon', NULL, '2026-03-10'),
(81, 11, 419.99, 'Amazon', NULL, '2026-05-09'),
(82, 11, 449.99, 'Amazon', NULL, '2026-07-08'),
(83, 12, 394.99, 'Corsair', NULL, '2026-03-10'),
(84, 12, 454.99, 'Corsair', NULL, '2026-05-09'),
(85, 12, 514.99, 'Corsair', NULL, '2026-07-08'),
(86, 9, 479.99, 'Newegg', NULL, '2026-03-10'),
(87, 9, 449.99, 'Newegg', NULL, '2026-05-09'),
(88, 9, 429.99, 'Newegg', NULL, '2026-07-08'),
(89, 10, 199.99, 'Best Buy', NULL, '2026-03-10'),
(90, 10, 219.99, 'Best Buy', NULL, '2026-05-09'),
(91, 10, 229.99, 'Best Buy', NULL, '2026-07-08'),
(92, 5, 229.99, 'Walmart', NULL, '2026-03-10'),
(93, 5, 199.99, 'Walmart', NULL, '2026-05-09'),
(94, 5, 184.99, 'Walmart', NULL, '2026-07-08'),
(95, 6, 269.99, 'Amazon', NULL, '2026-03-10'),
(96, 6, 289.99, 'Amazon', NULL, '2026-05-09'),
(97, 6, 299.99, 'Amazon', NULL, '2026-07-08'),
(98, 7, 227.64, 'Amazon', NULL, '2026-03-10'),
(99, 7, 267.64, 'Amazon', NULL, '2026-05-09'),
(100, 7, 307.64, 'Amazon', NULL, '2026-07-08'),
(101, 8, 449.99, 'Amazon', NULL, '2026-03-10'),
(102, 8, 419.99, 'Amazon', NULL, '2026-05-09'),
(103, 8, 389.99, 'Amazon', NULL, '2026-07-08'),
(104, 14, 389.99, 'Amazon', NULL, '2026-09-06'),
(105, 17, 4499.99, 'Amazon', NULL, '2026-09-06'),
(106, 18, 799.99, 'HP', NULL, '2026-09-06'),
(107, 19, 799.99, 'Apple', NULL, '2026-09-06'),
(108, 20, 899.99, 'Walmart', NULL, '2026-09-06'),
(112, 17, 4999.99, 'Amazon', NULL, '2025-09-11'),
(113, 17, 4799.99, 'Amazon', NULL, '2026-01-09'),
(114, 17, 4699.99, 'Amazon', NULL, '2026-05-09'),
(115, 17, 4599.99, 'Amazon', NULL, '2026-07-08'),
(116, 18, 649.99, 'HP', NULL, '2025-09-11'),
(117, 18, 699.99, 'HP', NULL, '2026-01-09'),
(118, 18, 729.99, 'HP', NULL, '2026-05-09'),
(119, 18, 759.99, 'HP', NULL, '2026-07-08'),
(120, 19, 699.99, 'Apple', NULL, '2025-09-11'),
(121, 19, 749.99, 'Apple', NULL, '2026-01-09'),
(122, 19, 849.99, 'Apple', NULL, '2026-05-09'),
(123, 19, 899.99, 'Apple', NULL, '2026-07-08'),
(124, 20, 1099.99, 'Walmart', NULL, '2025-09-11'),
(125, 20, 999.99, 'Walmart', NULL, '2026-01-09'),
(126, 20, 949.99, 'Walmart', NULL, '2026-05-09'),
(127, 20, 929.99, 'Walmart', NULL, '2026-07-08'),
(128, 21, 1399.99, 'Apple', NULL, '2025-09-11'),
(129, 21, 1349.99, 'Apple', NULL, '2026-01-09'),
(130, 21, 1299.99, 'Apple', NULL, '2026-05-09'),
(131, 21, 1249.99, 'Apple', NULL, '2026-07-08'),
(132, 21, 1199.99, 'Apple', NULL, '2026-09-06'),
(133, 22, 1399.99, 'Samsung', NULL, '2025-09-11'),
(134, 22, 1349.99, 'Samsung', NULL, '2026-01-09'),
(135, 22, 1299.99, 'Samsung', NULL, '2026-05-09'),
(136, 22, 1274.99, 'Samsung', NULL, '2026-07-08'),
(137, 22, 1249.99, 'Samsung', NULL, '2026-09-06'),
(138, 23, 699.99, 'Apple', NULL, '2025-09-11'),
(139, 23, 749.99, 'Apple', NULL, '2026-01-09'),
(140, 23, 849.99, 'Apple', NULL, '2026-05-09'),
(141, 23, 899.99, 'Apple', NULL, '2026-07-08'),
(142, 23, 799.99, 'Apple', NULL, '2026-09-06'),
(143, 24, 599.99, 'Google Fi', NULL, '2025-09-11'),
(144, 24, 579.99, 'Google Fi', NULL, '2026-01-09'),
(145, 24, 549.99, 'Google Fi', NULL, '2026-05-09'),
(146, 24, 524.99, 'Google Fi', NULL, '2026-07-08'),
(147, 24, 499.99, 'Google Fi', NULL, '2026-09-06'),
(148, 22, 1249.99, 'Samsung', NULL, '2026-09-06'),
(149, 22, 1249.99, 'Samsung', NULL, '2026-09-06'),
(150, 22, 1249.99, 'Samsung', NULL, '2026-09-06'),
(151, 22, 1249.99, 'Samsung', NULL, '2026-09-06');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model_number` varchar(100) DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `current_price` decimal(10,2) DEFAULT NULL,
  `source_name` varchar(150) DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `last_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `brand`, `model_number`, `specifications`, `description`, `image_url`, `current_price`, `source_name`, `source_url`, `last_updated`) VALUES
(1, 1, 'Gigabyte Radeon RX 7800 XT Gaming OC 16GB', 'Gigabyte / AMD', 'GV-R78XTGAMING OC-16GD', '16GB GDDR6 memory, triple-fan cooling, PCIe 4.0', 'This graphics card helps your computer display games, videos, and other visuals. It is a good choice for someone who wants to play newer games at high settings on a 1440p monitor. The 16GB of memory can also help with larger games and creative work like video editing.', NULL, 650.99, 'eBay', 'https://www.ebay.com/shop/rx-7800-xt?_nkw=rx+7800+xt', '2026-09-06 02:02:14'),
(2, 1, 'GeForce RTX 4070 Super 12GB', 'NVIDIA', 'RTX 4070 Super', '12GB GDDR6X memory, PCIe 4.0, DLSS 3 support', 'This graphics card helps your computer run games and display high-quality graphics. It is a strong option for playing newer games at high settings on a 1440p monitor. It also has NVIDIA features that can improve performance in supported games and can be useful for streaming or creative work.', NULL, 856.99, 'Amazon', 'https://www.amazon.com/geforce-rtx-4070-super/s?k=geforce+rtx+4070+super', '2026-09-06 01:48:36'),
(3, 1, 'ASUS Dual GeForce RTX 5060 Ti OC Edition 16GB', 'ASUS / NVIDIA', 'DUAL-RTX5060TI-O16G', '16GB GDDR7 memory, PCIe 5.0, dual-fan cooling', 'This graphics card helps your computer run games and other programs with better visuals. It is a good option for someone who wants to play newer games at high settings, especially on a 1080p or 1440p monitor. The 16GB of memory can also be helpful for video editing, streaming, and other creative work.', NULL, 799.99, 'Best Buy', 'https://www.bestbuy.com/product/asus-dual-nvidia-geforce-rtx-5060-ti-oc-edition-16gb-gddr7-pci-express-5-0-graphics-card-black/JJGHGYVFHK/sku/6644034', '2026-09-06 01:43:36'),
(4, 1, 'Intel Arc B580 Limited Edition 12GB', 'Intel', 'Arc B580 Limited Edition', '12GB GDDR6 memory, PCIe 4.0, dual-fan cooling', 'This graphics card helps your computer display games, videos, and graphics. It is a lower-cost option for someone who wants better gaming performance than basic built-in graphics. It can work well for playing many games at 1080p, which is the most common monitor resolution.', NULL, 249.99, 'Best Buy', 'https://www.bestbuy.com/product/intel-arc-b580-limited-edition-graphics-card-multi/JXZRJ552Z4', '2026-09-06 01:52:06'),
(5, 2, 'AMD Ryzen 5 7600', 'AMD', 'Ryzen 5 7600', '6 cores, 12 threads, up to 5.1 GHz boost clock, AM5 socket', 'A strong mid-range processor for everyday work, school, and gaming. It is a practical choice for a new AM5 desktop build.', NULL, 172.00, 'Walmart', 'https://www.walmart.com/ip/AMD-Ryzen-5-7600X-6-Core-4-7-GHz-Socket-AM5-105W-Desktop-Processor-100-100000593WOF/1693068603?wmlspartner=wlpa&selectedSellerId=101012648&wmlspartner=wlpa&cn=FY25-ENTP-PMAX_cnv_dps_dsn_dis_ad_entp_e_n&gclsrc=aw.ds&adid=222222222971693068603_101012648_0000000000_21407473164&wl0=&wl1=g&wl2=c&wl3=&wl4=&wl5=9003805&wl6=&wl7=&wl8=&wl9=pla&wl10=219540148&wl11=online&wl12=1693068603_101012648&veh=sem&gad_source=1&gad_campaignid=21690411341&gclid=CjwKCAjwnvTUBhBoEiwAZNDxZ2nMD', '2026-09-06 00:00:00'),
(6, 2, 'AMD Ryzen 7 7800X3D', 'AMD', 'Ryzen 7 7800X3D', '8 cores, 16 threads, up to 5.0 GHz boost clock, 3D V-Cache, AM5 socket', 'A high-performance gaming processor. Its extra cache can improve game performance, especially when paired with a powerful graphics card.', NULL, 319.99, 'Micro Center', 'https://www.microcenter.com/product/674503/ryzen_7_7800x3d_raphael_am5_42ghz_8-core_boxed_processor_-_heatsink_not_included?osfs=true&osfs=true&bvstate=pg%3A19%2Fct%3Ar&storeid=095', '2026-09-06 00:00:00'),
(7, 2, 'Intel Core i5-14600K', 'Intel', 'Core i5-14600K', '14 cores, 20 threads, up to 5.3 GHz turbo frequency, LGA1700 socket', 'A fast all-purpose desktop processor that is well suited to gaming, multitasking, and content creation.', NULL, 267.64, 'Amazon', 'https://www.amazon.com/clp/B0CGJ9STNF', '2026-09-06 00:00:00'),
(8, 2, 'Intel Core i7-14700K', 'Intel', 'Core i7-14700K', '20 cores, 28 threads, up to 5.6 GHz turbo frequency, LGA1700 socket', 'A powerful processor for demanding gaming, streaming, video editing, and other heavy multitasking workloads.', NULL, 365.99, 'Amazon', 'https://www.amazon.com/dp/B0CGJ41C9W?lv=shuf&channelId=500&plpRedirect=mhFallback&th=1', '2026-09-06 00:00:00'),
(9, 3, 'Kingston FURY Beast 32GB (2 x 16GB) DDR4-3200 CL16', 'Kingston', 'KF432C16BB12AK2/32', '32GB kit (2 x 16GB), DDR4-3200 (PC4-25600), CL16, 1.35V, desktop memory', 'A 32GB DDR4 desktop memory kit with two 16GB modules. It is a practical choice for compatible DDR4 gaming, school, and everyday productivity desktop builds.', NULL, 399.99, 'Newegg', 'https://www.newegg.com/kingston-technology-corp-fury-beast-32gb-ddr4-3200-cas-latency-cl16-desktop-memory-midnight-black/p/N82E16820242800', '2026-09-06 00:00:00'),
(10, 3, 'Corsair VENGEANCE LPX 32GB (2 x 16GB) DDR4-3200 C16 Black', 'Corsair', 'CMK32GX4M2E3200C16', '32GB kit (2 x 16GB), DDR4-3200, C16, UDIMM desktop memory, black', 'A 32GB DDR4 desktop memory kit with two 16GB modules. It is a practical upgrade for compatible DDR4 gaming, school, and everyday productivity desktop builds.', NULL, 249.99, 'Best Buy', 'https://www.bestbuy.com/product/corsair-vengeance-lpx-32gb-2x16gb-ddr4-3200mhz-c16-udimm-desktop-memory-black/J39QHH5FH5/sku/6448611', '2026-09-06 00:00:00'),
(11, 3, 'Kingston FURY Beast DDR5 32GB 6000MT/s CL30', 'Kingston', 'KF560C30BBEK2-32', '32GB kit (2 x 16GB), DDR5-6000, CL30, Intel XMP and AMD EXPO', 'A straightforward 32GB DDR5 kit for a gaming or productivity desktop. It offers fast DDR5 speed without adding RGB lighting.', NULL, 499.99, 'Newegg', 'https://www.newegg.com/kingston-technology-corp-fury-beast-32gb-ddr5-6000-cas-latency-cl36-memory-black/p/0RN-001J-01574', '2026-09-06 00:00:00'),
(12, 3, 'Corsair VENGEANCE RGB 32GB (2 x 16GB) DDR5-6400 CL36 White', 'Corsair', 'CMH32GX5M2B6400C36W', '32GB kit (2 x 16GB), DDR5-6400 (PC5-51200), CL36-48-48-104, 1.35V, Intel XMP 3.0, RGB, white', 'A 32GB DDR5 desktop memory kit with two 16GB modules, 6400MT/s rated speed, CL36 timings, and RGB lighting. It is designed for compatible Intel DDR5 desktop systems.', NULL, 454.99, 'Corsair', 'https://www.corsair.com/us/en/p/memory/CMH32GX5M2B6400C36W/vengeance-rgb-32gb-2x16gb-ddr5-dram-6400mt-s-cl36-memory-kit-white-cmh32gx5m2b6400c36w', '2026-09-06 00:00:00'),
(13, 4, 'Corsair MP700 PRO XT 2TB PCIe 5.0 NVMe SSD', 'Corsair', 'MP700 PRO XT 2TB', '2TB, M.2 2280 NVMe SSD, PCIe 5.0, up to 14,900 MB/s read speed, DirectStorage ready', 'A high-end 2TB PCIe 5.0 solid-state drive for compatible desktop systems. It is designed for very fast game loading, large file transfers, and demanding storage workloads.', NULL, 750.00, 'Amazon', 'https://www.amazon.com/Corsair-MP700-PCIe-NVMe-DirectStorage-PC/dp/B0FV33S11L', '2026-09-06 00:00:00'),
(14, 4, 'Samsung 990 PRO 2TB PCIe 4.0 NVMe SSD', 'Samsung', 'MZ-V9P2T0B/AM', '2TB, M.2 2280 NVMe SSD, PCIe 4.0, up to 7,450 MB/s read and 6,900 MB/s write', 'A high-performance 2TB PCIe 4.0 SSD for gaming, content creation, and demanding desktop workloads. It balances high speed with substantial storage capacity.', NULL, 389.99, 'Amazon', 'https://www.amazon.com/SAMSUNG-Internal-Expansion-MZ-V9P2T0B-AM/dp/B0BHJJ9Y77', '2026-09-06 00:00:00'),
(15, 4, 'WD_BLACK SN7100 M.2 2280 2TB PCI-Express 4.0 x4 TLC 3D NAND Internal Solid State Drive (SSD)', 'WD_BLACK', 'WDS200T4X0E', '2TB, M.2 2280 NVMe SSD, PCIe 4.0 x4, TLC 3D NAND, up to 7,250 MB/s read and 6,900 MB/s write', 'A 2TB PCIe 4.0 NVMe SSD for gaming desktops, laptops, and compatible handheld systems. It provides much more space than a 500GB drive while retaining fast Gen4 storage performance.', NULL, 302.99, 'Newegg', 'https://www.newegg.com/western-digital-2tb-sn7100-nvme/p/N82E16820250275', '2026-09-06 00:00:00'),
(16, 4, 'BIWIN Black Opal NV7400 2TB PCIe 4.0 NVMe SSD', 'BIWIN', 'NV7400 2TB', '2TB, M.2 2280 NVMe SSD, PCIe 4.0 x4, up to 7,450 MB/s read speed', 'A 2TB PCIe 4.0 SSD for desktops, laptops, and compatible PlayStation 5 systems. It provides high-capacity storage with fast Gen4 performance.', NULL, 299.99, 'Amazon', 'https://www.amazon.com/dp/B0DM23JKXC', '2026-09-06 00:00:00'),
(17, 5, 'ASUS ROG Strix SCAR 18 (2025)', 'ASUS', 'G835LX-XS97', '18-inch ROG Nebula HDR 16:10 2.5K display, 240Hz refresh rate, 3ms response time, NVIDIA GeForce RTX 5090 laptop GPU, Intel Core Ultra 9 275HX, 32GB DDR5 RAM, 2TB PCIe Gen 4 SSD, Wi-Fi 7, Windows 11 Pro', 'A premium 18-inch gaming laptop for users who want top-tier gaming and demanding creative performance. It combines an RTX 5090 laptop GPU, a Core Ultra 9 processor, 32GB of memory, and 2TB of SSD storage.', NULL, 4499.99, 'Amazon', 'https://www.amazon.com/ASUS-Strix-Gaming-Laptop-Nebula/dp/B0DW1WX8H2', '2026-09-06 00:00:00'),
(18, 5, 'HP OmniBook X Flip 2-in-1 16t-as00', 'HP', '16t-as00', '16-inch 2-in-1 touchscreen laptop, Intel Core Ultra processor, 16GB RAM, 512GB SSD', 'A large-screen 2-in-1 laptop that can be used as a traditional notebook or folded into tablet-style modes. It is designed for schoolwork, everyday productivity, media, and general home use.', NULL, 799.99, 'HP', 'https://www.hp.com/us-en/shop/custom/hp-omnibook-x-flip-2-in-1-laptop-next-gen-ai-16t-as00-16-inch-intel-core-ultra-16gb-ram-512gb-ssd-B88CWAV_261583', '2026-09-06 00:00:00'),
(19, 5, 'Apple MacBook Neo 256GB', 'Apple', 'MHFF4LL/A', 'MacBook Neo, 256GB storage, Indigo finish', 'An entry-level Mac laptop for students and everyday users who prefer the Apple ecosystem. It includes 256GB of storage and works closely with iPhone, iCloud, and other Apple devices.', NULL, 799.99, 'Apple', 'https://www.apple.com/shop/buy-mac/macbook-neo/indigo-256gb', '2026-09-06 00:00:00'),
(20, 5, 'Dell 16 Plus DB16250', 'Dell', 'DB16250', '16-inch 2.5K Mini-LED touchscreen display, Intel Core Ultra 7 258V, 32GB RAM, 1TB SSD, Intel Arc graphics, Ice Blue', 'A large-screen Windows laptop for productivity, schoolwork, multitasking, and creative projects. It combines a 2.5K touchscreen, 32GB of memory, and 1TB of storage.', NULL, 899.99, 'Walmart', 'https://www.walmart.com/ip/Dell-16-Plus-DB16250-Laptop-16-0-inch-2-5K-Mini-LED-Touchscreen-Display-Intel-Core-Ultra-7-258V-32GB-RAM-1TB-SSD-Intel-Arc-Graphics-Ice-Blue/18193953599', '2026-09-06 00:00:00'),
(21, 6, 'Apple iPhone 17 Pro Max', 'Apple', 'iPhone 17 Pro Max', 'Premium iPhone, iOS, A19 Pro chip, 6.9-inch Super Retina XDR display, ProMotion, 48MP Pro Fusion camera system, USB-C, 5G, eSIM', 'A high-end Apple smartphone for users who want a large premium display, strong performance, advanced cameras, and integration with Apple devices and services.', NULL, 1199.99, 'Apple', 'https://www.apple.com/shop/buy-iphone/iphone-17-pro', '2026-09-06 00:00:00'),
(22, 6, 'Samsung Galaxy S26 Ultra 512GB', 'Samsung', 'SM-S948UZVEXAA', '512GB storage, unlocked, Android, premium display, advanced camera system, S Pen support, 5G connectivity', 'A premium unlocked Android smartphone with 512GB of storage, a large display, advanced cameras, and productivity features including S Pen support.', NULL, 1249.99, 'Samsung', 'https://www.samsung.com/us/smartphones/galaxy-s26-ultra/buy/galaxy-s26-ultra-512gb-unlocked-sku-sm-s948uzvexaa/', '2026-09-06 00:00:00'),
(23, 6, 'Apple iPhone 17', 'Apple', 'iPhone 17', 'iOS, A19 chip, 6.3-inch Super Retina XDR display, ProMotion, 48MP Dual Fusion camera system, USB-C, 5G, eSIM', 'A mainstream iPhone for everyday communication, photos, apps, schoolwork, entertainment, and users who prefer the Apple ecosystem.', NULL, 799.99, 'Apple', 'https://www.apple.com/shop/buy-iphone/iphone-17', '2026-09-06 00:00:00'),
(24, 6, 'Google Pixel 10a 128GB', 'Google', 'Pixel 10a', '128GB storage, Android, 6.3-inch Actua display, Tensor G4 chip, 8GB RAM, dual rear cameras, 5G, IP68 protection, 7 years of updates', 'A value-focused Android phone with Google AI features, a 6.3-inch display, durable IP68 protection, 30-plus-hour battery life, and seven years of security and operating-system updates.', NULL, 499.99, 'Google Fi', 'https://fi.google.com/about/phones/pixel-10a', '2026-09-06 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `market_notes`
--
ALTER TABLE `market_notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `price_history`
--
ALTER TABLE `price_history`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `market_notes`
--
ALTER TABLE `market_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `price_history`
--
ALTER TABLE `price_history`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `price_history`
--
ALTER TABLE `price_history`
  ADD CONSTRAINT `price_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
