-- phpMyAdmin SQL Dump
<<<<<<< HEAD
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Generation Time: Dec 05, 2025 at 11:34 AM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
=======
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 12:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
<<<<<<< HEAD
-- Database: `if0_40532602_malls`
=======
-- Database: `nccc_malls`
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_type` enum('admin','customer') NOT NULL,
  `user_id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `action_description` text NOT NULL,
  `table_affected` varchar(50) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_type`, `user_id`, `action_type`, `action_description`, `table_affected`, `record_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
<<<<<<< HEAD
(1, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 11:45:24'),
(2, 'admin', 1, 'admin_login', 'Admin logged in: Admin User', 'admin_users', 1, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 12:05:11'),
(3, 'admin', 1, 'product_image_add', 'Image added to product (ID: 51)', 'product_images', 278, NULL, '{\"image_url\":\"https:\\/\\/ph.garmin.com\\/m\\/ph\\/g\\/products\\/fenix-7x-pro-sapphire-carbongray-cf-lg.jpg\",\"is_primary\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:13:18'),
(4, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 51)', 'product_images', 84, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1523394058394-40c08c8d5d4d?w=800&q=80\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:13:24'),
(5, 'admin', 1, 'product_image_add', 'Image added to product (ID: 54)', 'product_images', 279, NULL, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxMSEhUSERIVFRUXGRgWGBcWFRcWGBkYFxUWFhcXFRYYHSggGBolHhcYIjIhJSkrLi4vFx8zODMtNygtLisBCgoKDQ0NDg0NDy0ZFRkrNys3NzcrKysrLS0rNysrKy0tKysrKysrKysrKysrKysrKysrKystKysrKysrKysrK\\/\\/AABEIAOEA4QMBIgACEQEDEQH\\/xAAcAAEAAQUBAQAAAAAAAAAAAAAABAIDBQYHCAH\\/xABHEAABAwICBgYFCAYKAwAAAAABAAIDBBEhMQUGEkFRYQcTInGBkTJCcqHBFCNSYoKSsfAIM1OiwtEVJDRDc4Oys+HxY5PD\\/8QAFgEBAQEAAAAAAAAAAAAAAAAAAAEC\\/8QAFhEBAQEAAAAAAAAAAAAAAAAAAAER\\/9oADAMBAAIRAxEAPwDuKIiAiIgIiICIiAiLUekTXmLRkIwD53g9XHe2QPbk4MHvOA3kBm9P6fpqKPraqVsbd18XOPBjRi44jILk2snTTI4ltDEI2\\/tJRtPOG6MHZZuzLu5cx0npOorZTPUSOc4+s7HAkHZYzJjeWXJRnQtHPvN9wVGbrdbKyoPztbUO5CR0Yz\\/Zx2HuVsGV2PXSE\\/4jifHFYNwByz7+9TqCuLeyeQzAHjhnzQS3z1Lcp5x3TSD8HK\\/SazaQiPYrqkd8z3j7ryR7lU6rbbHHuxVh07T6qDcNB9L1fCQKlsdSzfcCKTwcwbPgW+K61qnrtSaQFoJLSAXdC\\/syNHG2Tm4+k0kYrziXs4KyHFj2yQvcyRh2mOabOa4ZEFB63RaZ0Za6f0jARLZtTFYSAYBwPoytG4GxBG4g7iFuagIiICIiAiIgIiICIiAiIgIiICIiAiIgx+n9Lx0dPLUzGzImlxyuT6rW39ZxsBzIXlHTemJq+pkqah1y45Y2aATsxtH0WjzzOJK6N+kFrR1ksejonYR2kltvkcPm2n2Wku+23guUlwa2wQX5amwUGSoJVuR91aKorMp4qVBPtYHMZKGGro3RL0c\\/0i509QXspo7tBabOkktk07mtwJPMDjYNYpJbixzCv2X3WDQ8tDVSU8vpRnMCwe04te3k4Y8jcZhfWm4ugoISyuFfCEFVJUyROD4pHxuHrMcWOzvmN2AwXojo51rGkKa7yOvjs2UDC59WQDcHWPcQ4bl51ss7qVrC6gq2TC+wexK3jGSL4cR6Q7uaD0wiohlDmhzSC1wBBGRBFwQq1AREQEREBERAREQEREBERAREQFH0hWNhikmkNmRsdI48GsaXH3BSFz3pz0z8n0W9gPaqHNhFvom75PDZaR9pB520lpF9VUS1MnpSvc8jO20b2B4AWHgokzkhFgqDiqigBXWsV2GG6uvjtmEFeidGPqZ4qeIduV7WN4C5xceQFyeQK9daB0RHR08VNCLMjaGjiTm5x+s43J5kriX6Pug+sq5qxwwgaGMw\\/vJQbkcwwEf5i76orl\\/Tnq111O2tjb85B2ZLZmFxz57DiDyDnrghrnMwbbDiLr2NUwNkY6N4DmvBa4HItcLEHwK8wa59FlfRyPMUT6mC92SRjbdYnASMb2g4bza3NBqx0o\\/eR5BfP6WPEeSgdQ4P2HAtdexDgQQeBByWaZQtGVx3FBGbpU8vIq83SR3tHgVWdHsO89\\/Pitu1R6Ja6rLHzNFNAbHafYyOacfm4x+LrDHfkqOq9CWlZKjR9pGnZikdFG4+swBrrDiGlxb4W3LoCgaD0RFSQR00DdmOMWAzJxuXOO9xJJJ4kqeoCIiAiIgIiICIiAiIgIiICIiAuC\\/pI6Q2p6SnB9CN8hG75xwa2\\/hE7zK70vLPTNWmbTFQLm0exGL3w2Y2k2v9ZzvNBp5yC+xMuV8dmplKwKouxRfm6pq8ApjGYbvNQKljnvEbBdznBrRxc4hoHmUHo3oS0V1GionEWdO587vtHZZ+41nmt9UbRlE2CGKFnoxsZGO5jQ0fgpKiiwesWt1HQj+szBrjiI23fIeew25A5mw5rSukbpGdE51JQuG227ZZs9k72R7i4b3bss8uPS3c4ucS5xN3OcSXOPFzjiTzQWdYZpK2pkqZ5Xuc9xLdwY3aJaxtzg0A5WRkdhYbldbHyVMkzG4Oe0HhtC\\/kqKC1b7qf0nT0UTaeSJs8TAAztFj2N3NvYhzRuFhbK+VtAFbETbrG+8DzOCyNPQvk\\/VAS2zET2SuHMtjJIHeEHbtD9K9BNZspkp3HD51t2\\/fZcAc3WW7U1SyRofG9r2nEOa4Oae4jAryrJFsktcCCMwRYjvByU\\/Qemaijft00rozm5oxY722HB2WeY3EKD1Ai0bUbpFirSIZgIajcL9iT\\/DJyP1TjwJxW8oCIiAiIgIiICIiAiIgIiIC8a6w13yisqJr3EksjweTnuI9xA8F7B0nUdXDLJlsMe\\/H6rSfgvFsZ3oLgzWRpmcFjGHFZOnuqi++4CmaixdbpWiba46+N1uTHbf8ACoMxNltPQlS7el4nfs2SO372Obc8M\\/eivTC0rpR1s+Q04jidaonu1ls2NFtuTwuAOZ5FbHrHpqKippaqY9iNt7DNxyaxv1nEgDvXmmt05NXzyVVQ67ibNaPRYwYtjYOAucd9ySoLTI\\/z\\/NR66rbEMcXbh8SdyvVlQI2F2\\/IDmsFA3adtux34\\/iqLpbJL6biG\\/RGA8v53V6Khjbuv3qsSL7tIPppmfRHkFbfo+M5C3dh+Cu7S+hyCfR6cqYgGSFtXCP7qpu4gb+qm\\/WRG2WyQORWzUegIdIROm0W53WMF5aOYjrmc435SM4Xsed8Fpe0r2j66WnmZUU7yyVhu1w97XD1mnIhBfkYWusdprmnm1zXNPm0gjvFl3Hov1yNbGYJ3XqIhe\\/7SO9g\\/2hcB3eDvsNe0pQxacovl9KwMq4xszRDNzmgbTDxNrFjt4IB+rzrQWln0lRFUsveN1yPpNyezxaSPIqD1Cit007ZGNkYbte0OaeIcLg+RVxAREQEREBERAREQEREGF12k2dHVjgL2pp8P8py8fRr2JrfAZKCrYCAXU8zbnIXicMbrx0w4IPsZxWUpSsSwqVFUAKjJz2st6\\/R9ZfSUp4U8h8pIB\\/F+d\\/NpKy4XXv0caFxfVVBb2AGxB1\\/WNnuaByAYbniLb0Fj9ILWDbnioA47EbRLIBvkfcMB9luP+YtC0azZZZWNa9Jtq66ee9+slcWn6gOzH+4G+SkA2w5\\/FBj9OTXeG7mj3nE+6ysRusFYrJLyOPMo1yCY16vRi6ixKewHANBJOAA3nv3DidyCoMG\\/dny7zuCDH0Q53stc4ebQR71nKDRDWgOks92Yw7DfZb\\/Ebk8VKmCYmtYINrlj2ji5jgPvEWVPcuh6tjsk81B1r0RAQXsAjfndos13tNGHiMe\\/JXDUToz1l+Q1rC42hm2YpeAuexIfZcc\\/ouesh0s6EFLXOcwWjnHWtAyDr2kA8e19taC8Zg9xC6drTVGu0FRVbsZIH9TITnbGMuPNxZE77Sit+6ItI9do2IE3MLnQnkGnaYPuOYt0XK+gOovDVR8JGP8Avs2f\\/muqKAiIgIiICIiAiIgIiINR6WZ5GaJq3RPLHBrcWmx2TKwPF+bS4eK8pO7h5L1n0oR7Wia0f+Fx+7Z3wXkxyD6xo4K+2Jv0QrDCr7SqKhG36I8lsOpmnJKapDmvLWiKcFowBPyeTYB+3srX7q5Rn5wDkcPBBZawbWG4f8LLTSWc7vP4rHuZi42AsN3eFIrTaR\\/tFBiZXdoqppVh5xKuNKDK6NgdI9sbBd73NY0fWcbC\\/K5W1aUpYqecwxEu6sBjnHe+13W4Y++6j9F8Tflbp3+jTQyznhdrdkX8HOPgsMapznF7jdziXOPEuNyfMpBt1HLcKqqYsFo6vsVvOrugH1wJaQxgwLyL42vstbcbRyOYtccQqixoM2iv3rV9ZtJ7bi0HALYNPvFJG+MO2i172NOV7OIvbwXPpZCTcoKXu3rfdUZus0NpSnz2DDUDxc29v\\/T71oK2rUevZHHXxyPawS0cwaXODdqVpaY2Nvm47T7DkpVbr0AOtJWDi2A+RmHxXZVxnoMe1tRUNJALo2WBNiSHOOA34XXZlAREQEREBERAREQEREGD15h29HVreNNP\\/tOXkEr2nX0wlikiOT2OYftNLfiuGxdAc9u1XRDuicfxcEHHWNsrrSto6Q9SXaKliidMZusYXh3VdW0EO2S0HadtEYE5W2m8VqzYyd1ud\\/gVRdurlA350Hjce4r4ylG9zj3YfBSaamYHAhz787Wy5IKmRWLsQeyVe0m5oebjMkqlrW7RANxY3ULS820\\/DEgY24nuQWqhjCMBY\\/nNRAUdfgqUG9dH39m0px+SO8rPusAs50ZSt+USQOPZqKeWHvNg7\\/SHrCOYWkhwsRgRwIwIViPgK63XaTdR6ConQjCXYEhBsfnGySPx5uGz3YLki3DQGlJKinj0c+xja8kE\\/RLtvZPc69jwNtyUZjQmqjdIlvWyPija3staWbePaODgccfctD05RCCpmgBJEUj4wTa5DXEAm2F7BdFir2UWkXuZaVrbZPFiXwtDgHAEYOJHgte1iphUTSzBuz1ji+1722jfO2KDTlep37Nz3fFSZ9HEKXq7q7LWzCmhLGyOBcDISG2aCTctBOXJKLeidJvhkjlYbOjeHN+y7Ad1sF6uBXFtW+huoZURPq5oTExwe5sRe5z9k7Qb2mgBpOfK\\/eO1LKiIiAiIgIiICIiAiIgLUekPXqLRkQwElRID1UV7ci+Q+qweZOA3kYDpG6UBSOdTUWy+cYPkOLIjvAHrycshvviFw2or5amV01RI6WR2bnm5sMgNwA4CwCCVpzTFTWyGWqldI7cCbMYOEbMmjuz33OKx2wApxhsFj6o7lRS591RD6be+3mrJmAVttRZwO4EHyKDJgN2iG8CFCox84ObB7gP5LITzASDZAGOPO\\/8A2oBGzK2\\/Fzf3jb3EIFc1Y9ZStCxZQTNF6QdDIyVnpMcHjnY4g8iLjxWyaxbD5evi9Cb5wcifSB53x8StOUylrnNbsZi9wP5IjJNC3XUelttSHuC0ujeH2t\\/0uk6vQ7EXgtFYCtf8+8\\/WKnQu2gsbX\\/rXd6k0b1BflpNrILIdEYDtKgtxAZLY8g3Zv43v4rAaW0wA0xxm7nDZLh6oOdjxIw5XJ4LaugukJrZZNzIC3xkkZb3McpR3FERRRERAREQEREBERAWn9KOszqGjJiNppT1cZGbbgl0ngMuZatwXEenuqJqoIzkyEvHfJIWn\\/aCDlNQbAnefxKtwYFUTSXcBuVbRgCqMwGktWH0gLLK0UlxZQtKx4IMGBdVbCqjCqeLIMgHgxNcfS9G\\/MKLpMYB45HxIsfIgeauaLms4sdiHZd4Vczb7TCLA3Lfj+APggokdtNB4rGSDFSaWW12Hd+bK1UZoLbQvuyqWlXmohC8tIcCQRvHxG9bbozXeVjdh8TJBxa7YPiDcE91lrAYrjYkGZqtYC9xcITjxePgFHfXyvwcQ0fRbh5nMqG1qvRhBIiC7t0H6KMdHJUOGM7+z7EV2j94ye5cT0VQvnljgiF3yODG95OZ5AXJ5Ar1TouhbBDHBH6MbGsHc0AXPNRUpERAREQEREBERAREQFxT9IKiIlpZwMHMkiJ5sc17R5Pf5FdrWldL2hDVaNkLRd8BFQ0DM7AIkA43jc\\/DjZB5lkNngcVJgxDhwP\\/PxUWvw2XDcfcpVO7ttO54t4hUX6GWxUquYHNWPeNhyyFPJdqDAObYkK4pmkKb1gobCgp2eClSOMjRYgOHh4qM8b1VCLnCwtjigqcwC7iBff\\/wqXQBsZc7Fz\\/RH4lXxHtOt6rcSo9e0vdfEWwA3WQQurK+gqrbIwcF9DgUF2N6kMKiBVwuPCwREwK60qfq7qzV1pApYHyDe+2zGOO1I7s4cL35Lt+oXRbFRFs9S4T1AxaLfNRniwHFzvrHwAQR+iHUd1M35bVNtM9to2EYxsOZcNz3cMwMMyQumoiiiIiAiIgIiICIiAiIgL44XwOS+og8f6ywsZLURxgtZHNIxoOJDGyOawc8AB4LH0jiWG2bSCPj4LqOvfRfXyVc5pKcSRSyGRr+tiaBtuL3NcHuDrhxIwBFrdw1fSHR7pDR8ZqKmJoju1pLZGvxcbC4GQJ7N+JCowsg6yNrxwxVmCayv0oEcmyfQky4X3ed1ErIix5CDKMeHDFY+rpS03GStxVCmMqAUGOc4K7SxADrXjsg2A+k7c0cO\\/v4WMiSnZ6bjZoztv4AcSfzaxIj1j3OIJbsgCzW7mg\\/xHefDkAjzTuO0Sbl2J+AA3AZDuVtkzhz7\\/BfS1XqWkJNygkx0+2L39ytyUNtzfAlTwQBZWXm6DYujjURulJJWGo6kRBjiBHtlweXiwJcA22znY55LtOr3RXo2lIcYjO8evOQ+x4iMAMHfa\\/Nab+jvSHarZvV+ajHMjrHu8g5vmu0qCljAAAAABkALAdwVSIgIiICIiAiIgIiICIiAiL4TbEoPqLFVWslFEbS1lMw\\/Xnjb+LlTR60UMrgyKtppHnJrJ43OPcA65QZdQtN6MZVQS08noyMLCRmLjBw5g2I5hTUQeTNM6KkhklpJhsyRuIb7Q7QtycLObycoDZtv5uWweLi\\/HeF3\\/pZ1H+Wx\\/Kadv9YjGLRgZWC52Qdz2nFp7xvBHnytcHgOedl7cn4DaHs8fcqINRGWY7uKvwt2RtSXA3N9Z3h+fBUmrws0D23YC\\/FoVDmbQJ2iXXsTythbgEF19TtEE2w9FoxDf5u5\\/kXm1KxnVOAuqmE5IMoJhwVXW7ljmyq8yVBKuqCS5zY42l73ENa1ouS5xsABvJKsF5K6\\/wBBGpxLzpKdnZALacOGZOD5RfcB2Qd93ckHRejXVk6OoI4H261xMstv2j7XF9+yA1t\\/qraURQEREBERAREQEREBERAREQF516Wta5amrlpw8inhcYxGDZrnNNnveB6R2rgXwAAtmb+il5w6YdUp6WqlqWsc6mmeZBIBcMe83cyS3o9q5BOBBG8FBorpLZWUOplvf4qky80hp3yuDImOkcfVY0uJ8Big6pqL0pS0cboZGuqYm26syyhr2Gwu0vIN4+AzGWWWUqOmOsmOxR0sZdwjElS4fdDfwU3oY6OHQh9XpCAbbwGxRStBcxubnvacnGwABxAB4rr8UbWizQGjgAAPIIOCSavaxaW\\/tDnQxHdM4RNtwMEYubfWb4rJzdAwEBLasyVOY22bMJ+qQLuB+tc+yu1og8iawav1NE\\/qqmJ0fDbF2O\\/w5BgfAm3ALC9XY3F2+8e5ez6uljlYY5WNkYcC17Q5p72nArSNL9EWjJ7lsb6dx3wPsPBjw5g8AEHmdr3YgFpvjmMDlkqyXG3Y78d3ALuFV0DxH9XXSDhtwsf\\/AKXNVum6A4\\/7yuc72IGs\\/wBT3KjipGeAHeVkdD6Dqat2zSwSTY2PVt7IP15D2W+JC7\\/oboe0ZAQXxvqHD9s+7fuMDWkd4K3ulpmRtDI2NYxuAaxoa0DgAMAoOPal9DFnNm0m5ptYinjN2900nrey3DmRguyRxhoDWgAAAAAWAAwAAGQVSICIiAiIgIiICIiAiIgIiICIiArFd+rf7LvwKIg83aQ\\/tfj8Su5ai\\/qF9RBsqIiAiIgIiICIiAiIgIiICIiAiIgIiICIiAiIgIiIP\\/\\/Z\",\"is_primary\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:14:02'),
(6, 'admin', 1, 'product_image_add', 'Image added to product (ID: 54)', 'product_images', 280, NULL, '{\"image_url\":\"https:\\/\\/gameone.ph\\/media\\/catalog\\/product\\/mpiowebpcache\\/d378a0f20f83637cdb1392af8dc032a2\\/1\\/_\\/1_5_33.webp\",\"is_primary\":0}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:14:21'),
(7, 'admin', 1, 'product_image_primary', 'Primary image changed for product (ID: 54)', 'product_images', 280, '{\"is_primary\":0}', '{\"is_primary\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:14:25'),
(8, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 54)', 'product_images', 87, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:14:30'),
(9, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 54)', 'product_images', 279, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxMSEhUSERIVFRUXGRgWGBcWFRcWGBkYFxUWFhcXFRYYHSggGBolHhcYIjIhJSkrLi4vFx8zODMtNygtLisBCgoKDQ0NDg0NDy0ZFRkrNys3NzcrKysrLS0rNysrKy0tKysrKysrKysrKysrKysrKysrKystKysrKysrKysrK\\/\\/AABEIAOEA4QMBIgACEQEDEQH\\/\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:14:33'),
(10, 'admin', 1, 'product_image_add', 'Image added to product (ID: 57)', 'product_images', 281, NULL, '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRLHHCR0crFX-tSodoDOip-2jKXrQNfJeYOFQ&s\",\"is_primary\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:15:09'),
(11, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 57)', 'product_images', 90, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562979526-5f0e9cf8a9e1?w=800&q=80\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:15:13'),
(12, 'admin', 1, 'product_image_add', 'Image added to product (ID: 43)', 'product_images', 282, NULL, '{\"image_url\":\"https:\\/\\/assets2.razerzone.com\\/images\\/pnx.assets\\/f4e4b271435e1b02702e6012ed1f72b7\\/razer-blackwidow-v4-macro-keys-desktop.webp\",\"is_primary\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:16:14'),
(13, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 43)', 'product_images', 75, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1541140532154-b024d705b90a?w=800&q=80\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:16:20'),
(14, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 49)', 'product_images', 82, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1546868871-7041f2a55e12?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.belkin.com\\/dw\\/image\\/v2\\/BGBH_PRD\\/on\\/demandware.static\\/-\\/Sites-master-product-catalog-blk\\/default\\/dw10d0db8c\\/images\\/hi-res\\/NaN\\/f247a9985c6660b_WIZ009-BLK_MagSafe_BoostChargePro_3in1WirelessChargeDock_Tilt_Device_WEB.jpg?sw=700&sh=700&sm=fit&sfrm=png\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:17:09'),
(15, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 49)', 'product_images', 82, '{\"image_url\":\"https:\\/\\/www.belkin.com\\/dw\\/image\\/v2\\/BGBH_PRD\\/on\\/demandware.static\\/-\\/Sites-master-product-catalog-blk\\/default\\/dw10d0db8c\\/images\\/hi-res\\/NaN\\/f247a9985c6660b_WIZ009-BLK_MagSafe_BoostChargePro_3in1WirelessChargeDock_Tilt_Device_WEB.jpg?sw=700&sh=700&sm=fit&sfrm\"}', '{\"image_url\":\"https:\\/\\/www.belkin.com\\/dw\\/image\\/v2\\/BGBH_PRD\\/on\\/demandware.static\\/-\\/Sites-master-product-catalog-blk\\/default\\/dwb3101a8b\\/images\\/hi-res\\/7\\/135cfdc88f5c66a4_WIZ009-BLK_Hero_WDevice_WEB.jpg?sfrm=png\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:17:22'),
(16, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 40)', 'product_images', 71, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1543512214-318c7553f230?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRqfqSIsCA88Gr4I9VF-eM1rtf-KMsJirxqUA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:18:38'),
(17, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 48)', 'product_images', 81, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1605792657660-596af9009e82?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/villman.com\\/product_photos\\/gifffffffffff_l8f9e.gif\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:19:32'),
(18, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 50)', 'product_images', 83, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1600003263720-95b45a4035d5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/dlcdnwebimgs.asus.com\\/gain\\/0A9C172B-6ACB-4C9F-BC29-D5219D513D4A\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:20:19'),
(19, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 52)', 'product_images', 85, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1513506003901-1e6a229e2d15?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQeCrdBCH8fN55I1mk8aMSst1as_Wth35sp5Q&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:20:59'),
(20, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 56)', 'product_images', 89, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1513885535751-8b9238bd345a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.officewarehouse.com.ph\\/__resources\\/_web_data_\\/products\\/products\\/image_gallery\\/8944_7008.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:21:55'),
(21, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 58)', 'product_images', 91, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/mms.businesswire.com\\/media\\/20201020005041\\/en\\/831125\\/5\\/1000-611.jpg?download=1\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:22:34'),
(22, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 59)', 'product_images', 92, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1605792657660-596af9009e82?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61FeCECR4wL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:23:17'),
(23, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 60)', 'product_images', 93, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1551698618-1dfe5d97d256?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQCIYuycLxl6EyNb71vJ_8mEnONejeeZVIWfA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:23:50'),
(24, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 62)', 'product_images', 95, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1473968512647-3e447244af8f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/static.gopro.com\\/assets\\/blta2b8522e5372af40\\/bltb59f1b72c0ffbd0f\\/6799e1bc3b4101d815031ec0\\/03-max_lenses_50-50_1920-375-v2.png\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:24:34'),
(25, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 64)', 'product_images', 97, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1590658165737-15a047b8b5e0?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.outsideonline.com\\/wp-content\\/uploads\\/2022\\/09\\/AIRPODS_PRO2_s.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:25:12'),
(26, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 66)', 'product_images', 99, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1594938328876-1e0d11c36b14?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/calvinklein.scene7.com\\/is\\/image\\/CalvinKlein\\/LX000588_015_main\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:26:02'),
(27, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 67)', 'product_images', 100, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556821840-3a63f95609a7?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/columbiasportswear.ph\\/cdn\\/shop\\/files\\/1000330554_01.jpg?v=1707883809\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:26:51'),
(28, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 72)', 'product_images', 105, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556821840-3a63f95609a7?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/sportingbrandsonline.com.au\\/cdn\\/shop\\/files\\/IMG_0955_1200x.jpgSepiaRed.jpg?v=1729407358\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:27:52'),
(29, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 74)', 'product_images', 107, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1542291026-7eec264c27ff?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/static.nike.com\\/a\\/images\\/t_web_pdp_936_v2\\/f_auto\\/gorfwjchoasrrzr1fggt\\/AIR+MAX+270.png\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:28:35'),
(30, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 75)', 'product_images', 108, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.converse.ph\\/media\\/catalog\\/product\\/cache\\/9f24855fac20eb8d4a46102f0f20e4a1\\/0\\/8\\/0802-CONM9160C00010H-1.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:46:57'),
(31, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 76)', 'product_images', 109, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1542272604-787c3835535d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTg3LbBoKs-fZnqMqk-zRc3tNoPx5v1SSfaZw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:47:32'),
(32, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 77)', 'product_images', 110, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1594938328876-1e0d11c36b14?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/slimages.macysassets.com\\/is\\/image\\/MCY\\/products\\/3\\/optimized\\/27187953_fpx.tif\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:48:06'),
(33, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 78)', 'product_images', 111, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1542291026-7eec264c27ff?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRh7sPObWKR59HIcxs5B_i8V2qlyN9x2oXEVw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:48:35'),
(34, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 79)', 'product_images', 112, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.shopboxbasics.com\\/cdn\\/shop\\/articles\\/shoe-review-blog-featured-image-Rbk-NX3.jpg?v=1678412846\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:49:45'),
(35, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 80)', 'product_images', 113, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1586363104862-3a5e2ab60d99?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSiduIwSWajWil2W5HT5Dy-ntJ0_ECQUgK8Ng&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:50:13'),
(36, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 82)', 'product_images', 115, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.skechers.com\\/dw\\/image\\/v2\\/BDCN_PRD\\/on\\/demandware.static\\/-\\/Library-Sites-SkechersSharedLibrary\\/default\\/dw8c529bad\\/images\\/Landing\\/Temp%20Files\\/SKX54719_Walking-Technologies-Images_Massage-Fit-124903-GYPL.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:51:16'),
(37, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 83)', 'product_images', 116, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1572635196237-14b3f281503f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQA1Z3586IOOWN6EDDxMxGPfSUyRDji8kq-nw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:52:57'),
(38, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 84)', 'product_images', 117, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556821840-3a63f95609a7?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61w3q+Q0hAL._AC_UF894,1000_QL80_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 00:56:01'),
(39, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 85)', 'product_images', 118, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSx8A1wMoCw3gTqkb3l1SdMwsoMt-K5sq2y9Q&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:00:32'),
(40, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 86)', 'product_images', 119, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1523275335684-37898b6baf30?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.fossil.com\\/on\\/demandware.static\\/-\\/Library-Sites-FossilSharedLibrary\\/default\\/dwb9c5cfb1\\/2022\\/FA22\\/set_0929_smartwatches_lm\\/Slices\\/Gen6\\/0929_Gen6_Learnmore_Hero8_Desktop_Mobile.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:00:57'),
(41, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 87)', 'product_images', 120, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1586363104862-3a5e2ab60d99?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/dynamic.zacdn.com\\/uy9zdq8IW8JdJUfdmdoDLn2a5wA=\\/filters:quality(70):format(webp)\\/https:\\/\\/static-ph.zacdn.com\\/p\\/coach-4248-2114913-1.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:01:34'),
(42, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 88)', 'product_images', 121, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556821840-3a63f95609a7?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcS0Q6SxXxgtmK1SqfIi5JXNa7RnUISEyxkBcA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:02:05'),
(43, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 89)', 'product_images', 122, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1542291026-7eec264c27ff?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn11.bigcommerce.com\\/s-21x65e8kfn\\/images\\/stencil\\/original\\/products\\/8624\\/37556\\/SAL3763_1000_1__86614.1688135315.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:03:09'),
(44, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 90)', 'product_images', 123, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRKEKvkLk73TVrG_eKZgVFnngsF7oizTRuwXA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:03:30'),
(45, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 91)', 'product_images', 124, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556821840-3a63f95609a7?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.cleverhiker.com\\/wp-content\\/uploads\\/2024\\/09\\/IMG_E5396-scaled.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:03:57'),
(46, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 92)', 'product_images', 125, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1542291026-7eec264c27ff?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.asics.com\\/is\\/image\\/asics\\/1011B690_001_SR_RT_GLB?$zoom$\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:04:20'),
(47, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 93)', 'product_images', 126, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1572635196237-14b3f281503f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTGvU-tmvLxK32OLb4zy2xftyNmQd0FxdDARw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:05:23'),
(48, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 94)', 'product_images', 127, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1549298916-b41d501d3772?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71vXk8hSAoL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:07:12'),
(49, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 95)', 'product_images', 128, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcS-ou8Mf360jioJnoXTm0AQN4cQ2dwuwZqKFA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:09:52'),
(50, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 96)', 'product_images', 129, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSV4VSJVxLMDvVaN-KicZvfDa30uP5IXuGdgg&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:10:22'),
(51, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 97)', 'product_images', 130, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.breville.com.ph\\/image\\/cache\\/catalog\\/catalog\\/barista-express\\/barista-express-550x550.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:15:02'),
(52, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 98)', 'product_images', 131, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.thewirecutter.com\\/wp-content\\/media\\/2023\\/07\\/vitamix5200-2048px-vitamix-3x2-v2.jpg?auto=webp&quality=75&crop=1:1,smart&width=1024\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:16:52'),
(53, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 99)', 'product_images', 132, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSjk0b_PVs2eZMPrr92FMB1HmLSkHmHmQvpVA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:17:17'),
(54, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 100)', 'product_images', 133, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1558317374-067fb5f30001?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/assets.sharkninja.com\\/image\\/upload\\/f_auto\\/q_auto\\/SharkNinja-NA\\/NV360_02.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:17:40'),
(55, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 101)', 'product_images', 134, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/img.lazcdn.com\\/g\\/p\\/d86136a8e44ce4f02a469685c6c12d36.png_960x960q80.png_.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:18:03'),
(56, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 102)', 'product_images', 135, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.lodgecastiron.com\\/cdn\\/shop\\/files\\/LCCWND_800x800_84ffdd8e-33db-4ae2-8bb4-15c2973138ed.jpg?v=1734123207\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:21:47'),
(57, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 103)', 'product_images', 136, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRP5-EhxeHBZIrHoLhp60ickJcvat6DToDaxw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:22:09'),
(58, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 104)', 'product_images', 137, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/81RLNY9ieZL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:22:32'),
(59, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 105)', 'product_images', 138, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71oexBYw08L._AC_UF1000,1000_QL80_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:22:59'),
(60, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 106)', 'product_images', 139, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/91TInqFH83L._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:23:31'),
(61, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 107)', 'product_images', 140, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/strapi-ecm-assets.s3.ap-southeast-1.amazonaws.com\\/5_KFC_3516_PER_1_8ea929dbd3.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:24:15'),
(62, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 107)', 'product_images', 140, '{\"image_url\":\"https:\\/\\/strapi-ecm-assets.s3.ap-southeast-1.amazonaws.com\\/5_KFC_3516_PER_1_8ea929dbd3.webp\"}', '{\"image_url\":\"https:\\/\\/strapi-ecm-assets.s3.ap-southeast-1.amazonaws.com\\/5_KFC_3516_PER_1_8ea929dbd3.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:24:15'),
(63, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 108)', 'product_images', 141, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTpcSWtTMVNoMAN-vzEsH-IsrP5GMRtlzModA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:25:03'),
(64, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 109)', 'product_images', 142, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcR7VlJrnpPfjdICinGAkUXxDWb5ISLdstpzpw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:25:32'),
(65, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 110)', 'product_images', 143, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/917dBseIiwL.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:25:54'),
(66, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 111)', 'product_images', 144, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/i5.walmartimages.com\\/seo\\/simplehuman-58-Liter-15-3-Gallon-Stainless-Steel-Rectangular-Kitchen-Step-Can-Dual-Compartment-Recycler-Brushed-Stainless-Steel_e4f4a844-10a3-4d3d-818f-aaab1851046c.3222efe0ef0564e0b9137a544eaaac1c.jpeg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:26:20'),
(67, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 112)', 'product_images', 145, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71p2h853rfL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:26:45'),
(68, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 113)', 'product_images', 146, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/farberwarecookware.com\\/cdn\\/shop\\/products\\/luoqk6f2zhnadmibfvna_1000x1000.jpg?v=1748880976\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:27:10'),
(69, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 114)', 'product_images', 147, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/710OfeaejzL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:27:35'),
(70, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 115)', 'product_images', 148, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71tRoYzBJdL.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:28:00'),
(71, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 116)', 'product_images', 149, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.sunbeam.ca\\/on\\/demandware.static\\/-\\/Sites-master-catalog\\/default\\/dw91051df5\\/images\\/highres\\/2379-33A-1.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:28:24'),
(72, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 117)', 'product_images', 150, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61UXQ82C8bL._AC_SL1024_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:28:54'),
(73, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 118)', 'product_images', 151, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1555939594-58d7cb561ad1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRTNmFeHxDpuDLyUUKsv1r9poqqAqxJp3MMeg&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:29:20'),
(74, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 119)', 'product_images', 152, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTZ4ROqusf5Gom6b4E4AMtqIuY6S21g8SbD5Q&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:29:43'),
(75, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 120)', 'product_images', 153, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSR86DEGd-V_gDUDo84x3ScIwsmcuwzEXTM1w&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:30:08'),
(76, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 121)', 'product_images', 154, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQT4R5NX4-cWEg3Q5S7ru88n-Ru3FYssnRCYw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:30:34'),
(77, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 122)', 'product_images', 155, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1517668808822-9ebb02f2a0e6?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/i5.walmartimages.com\\/seo\\/Magic-Bullet-NutriBullet-Nutrition-Extraction-12-Piece-Mixer-Blender-As-Seen-on-TV_7e178177-0f3f-4f1b-a78b-6c2cae048e11.e89c7d4f9ef203881164446b56003786.jpeg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:31:02'),
(78, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 123)', 'product_images', 156, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1578269174936-2709b6aeb913?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcT8Ha8pqwKsnRJVAS9SCWqLty7bQrKvRkb-ng&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:31:25'),
(79, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 124)', 'product_images', 157, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1556909114-f6e7ad7d3136?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/i5.walmartimages.com\\/seo\\/T-fal-Easy-Care-20-Piece-Non-Stick-Pots-and-Pans-Cookware-Set-Grey_5666016b-38d1-4e88-a91f-a634cc014214.555f2321d82ca0ac4ea7b3e938c9151a.jpeg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:32:01'),
(80, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 125)', 'product_images', 158, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1541140532154-b024d705b90a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRx1eA-Qzpr4TGwKPkMxbEK-TjxMnFxqjT_Zw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:32:26'),
(81, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 126)', 'product_images', 159, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1523275335684-37898b6baf30?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/res.garmin.com\\/en\\/products\\/010-02638-10\\/g\\/46824-FR955-S2-F3.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:32:50'),
(82, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 127)', 'product_images', 160, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/ecommerce.datablitz.com.ph\\/cdn\\/shop\\/products\\/hyperx_cloud_alpha_wireless_2_main_dongle_900x_71100e95-211e-4cc1-a00a-6523f4485c79.jpg?v=1676876185\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:33:23'),
(83, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 128)', 'product_images', 161, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.shopify.com\\/s\\/files\\/1\\/0460\\/2567\\/0805\\/files\\/CORSAIR-CS-CMG16GX4M2D3600C18-BOX-CORSAIR-VENGEANCE-RGB-RS-16GB2X8GB-DDR4-3600-C18-MEMORY-KIT-RAM-12-MONTHS-WARRANTY-MEMORY-CARD.jpg?v=1714782603\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:33:57'),
(84, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 130)', 'product_images', 163, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/gameone.ph\\/media\\/catalog\\/product\\/mpiowebpcache\\/d378a0f20f83637cdb1392af8dc032a2\\/s\\/t\\/steelseries-arctis-nova-pro-wireless-headset-_61520_-1_1.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:34:35'),
(85, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 132)', 'product_images', 165, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQYhXqWQmPPyPU_aKPxCL5BJ_uaVp6D3_J4Xg&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:34:58'),
(86, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 131)', 'product_images', 164, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1593359677879-a4bb92f829d1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/dlcdnwebimgs.asus.com\\/gain\\/CD75D7C5-6A84-4B78-BA57-2F1AD1738010\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:35:20');
INSERT INTO `activity_logs` (`log_id`, `user_type`, `user_id`, `action_type`, `action_description`, `table_affected`, `record_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(87, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 133)', 'product_images', 166, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1541140532154-b024d705b90a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSwx8MuiDnosnk2ZBJ76Q_BluKJjUVY0SBeZw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:35:42'),
(88, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 134)', 'product_images', 167, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1527864550417-7fd91fc51a46?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2021\\/11\\/MZ-V8P500BW_001_Front_Black.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:36:11'),
(89, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 129)', 'product_images', 162, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1527864550417-7fd91fc51a46?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/ecommerce.datablitz.com.ph\\/cdn\\/shop\\/files\\/vsddsvsvdzx_800x.jpg?v=1758173426\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:36:37'),
(90, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 135)', 'product_images', 168, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQ1-hiwfceaA-YupIOC2KiaKc0qTUB4_LGxXA&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:37:27'),
(91, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 136)', 'product_images', 169, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1593359677879-a4bb92f829d1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSYktK9F7X24DPwbWOPgWnP6OCfiZaTGeQaCQ&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:37:47'),
(92, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 137)', 'product_images', 170, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61gtdFnK+UL._AC_SL1500_.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:38:19'),
(93, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 138)', 'product_images', 171, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1541140532154-b024d705b90a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/d1rlzxa98cyc61.cloudfront.net\\/catalog\\/product\\/cache\\/1801c418208f9607a371e61f8d9184d9\\/1\\/8\\/182906_2022.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:38:40'),
(94, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 139)', 'product_images', 172, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1527864550417-7fd91fc51a46?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/jgsuperstore.com\\/cdn\\/shop\\/products\\/51o0BaAQeNL._AC_SL1023.jpg?v=1618985786&width=416\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:39:00'),
(95, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 140)', 'product_images', 173, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQcdJSswO_g3AQ5k7ZBcLVrLRRRW1j8g7Sl-Q&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:39:33'),
(96, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 141)', 'product_images', 174, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1593359677879-a4bb92f829d1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQK8w7C3icQOPEs9Bh0NCNszzocNSK3SKp6ow&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:40:04'),
(97, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 142)', 'product_images', 175, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.google.com\\/imgres?q=Corsair%20K100%20Keyboard&imgurl=https%3A%2F%2Ftpucdn.com%2Freview%2Fcorsair-k100-rgb-mechanical-keyboard%2Fimages%2Ftitle.jpg&imgrefurl=https%3A%2F%2Fwww.techpowerup.com%2Freview%2Fcorsair-k100-rgb-mechanical-keyboard%2F&docid=zWvJASxvkVe4UM&tbnid=6C3XLvchzr0HnM&vet=12ahUKEwjR0oTw4p2RAxV3bvUHHUFzJQMQM3oECCAQAA..i&w=670&h=350&hcb=2&ved=2ahUKEwjR0oTw4p2RAxV3bvUHHUFzJQMQM3oECCAQAA\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:40:36'),
(98, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 142)', 'product_images', 175, '{\"image_url\":\"https:\\/\\/www.google.com\\/imgres?q=Corsair%20K100%20Keyboard&imgurl=https%3A%2F%2Ftpucdn.com%2Freview%2Fcorsair-k100-rgb-mechanical-keyboard%2Fimages%2Ftitle.jpg&imgrefurl=https%3A%2F%2Fwww.techpowerup.com%2Freview%2Fcorsair-k100-rgb-mechanical-keyboard%2F&d\"}', '{\"image_url\":\"https:\\/\\/tpucdn.com\\/review\\/corsair-k100-rgb-mechanical-keyboard\\/images\\/title.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:41:03'),
(99, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 143)', 'product_images', 176, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1541140532154-b024d705b90a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSO7uCCvAGieCOlDr64_516sNyKN8cxsDuY5w&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:41:32'),
(100, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 144)', 'product_images', 177, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1527864550417-7fd91fc51a46?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2022\\/09\\/msi-rtx-4080-suprim-x.webp\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:42:02'),
(101, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 145)', 'product_images', 178, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTo7dbGB2bbmNYWenD_69PV1AfbbtYVmaaO3g&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 01:42:48'),
(102, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 150)', 'product_images', 183, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1585298723680-4a13f8c46a62?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.google.com\\/imgres?q=be%20quiet!%20Dark%20Rock%204&imgurl=https%3A%2F%2Fbermorzone.com.ph%2Fwp-content%2Fuploads%2F2021%2F11%2F514qeBDsYyL._AC_SL1000_.jpg&imgrefurl=https%3A%2F%2Fbermorzone.com.ph%2Fshop%2Fcooling-systems%2Faircooling-system%2Fbe-quiet-dark-rock-4-bk021-cpu-air-cooler%2F%3Fsrsltid%3DAfmBOorXALji5Un7hC60oEaumKKD-xPs6ir8eSaSAFbA2Qk-12rlsrmX&docid=QFIeG12QaNVqDM&tbnid=rwJ-CWQz1bdhjM&vet=12ahUKEwiZl7eF652RAxVFs6gCHSZeAM0QM3oECCEQAA..i&w=639&h=535&hcb=2&itg=1&ved=2ahUKEwiZl7eF652RAxVFs6gCHSZeAM0QM3oECCEQAA\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:17:11'),
(103, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 150)', 'product_images', 183, '{\"image_url\":\"https:\\/\\/www.google.com\\/imgres?q=be%20quiet!%20Dark%20Rock%204&imgurl=https%3A%2F%2Fbermorzone.com.ph%2Fwp-content%2Fuploads%2F2021%2F11%2F514qeBDsYyL._AC_SL1000_.jpg&imgrefurl=https%3A%2F%2Fbermorzone.com.ph%2Fshop%2Fcooling-systems%2Faircooling-system%2F\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:17:48'),
(104, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 150)', 'product_images', 289, '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2021\\/11\\/514qeBDsYyL._AC_SL1000_.jpg\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:18:02'),
(105, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 150)', 'product_images', 290, '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2021\\/11\\/514qeBDsYyL._AC_SL1000_.jpg\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:18:05'),
(106, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 150)', 'product_images', 291, '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2021\\/11\\/514qeBDsYyL._AC_SL1000_.jpg\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:18:07'),
(107, 'admin', 1, 'product_image_primary', 'Primary image changed for product (ID: 187)', 'product_images', 293, '{\"is_primary\":0}', '{\"is_primary\":1}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:19:30'),
(108, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 188)', 'product_images', 221, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxAQDxAQDxAOEBAXEBEPEBUQEBUVEhAWFxIXFxUSGBgYHSggGB0lGxUVIjMhJiorLi8uGCszODM4QystLisBCgoKDg0OGxAQGislICY1LS8tLysrLy0tLS0tLi0tLi0tKysvLy0uKy4tLy8wLS8vKy0tKy0rLi0tLy0tKy0vLv\\/AABEIAOEA4QMBEQACEQEDEQH\\/xAAbAAEAAQUBAAAAAAAAAAAAAAAAAQIEBQYHA\\/\\/EAD8QAAICAQMCAwYDBAgFBQAAAAECAAMRBBIhBTEGE0EiMlFhcYGRobEHFCNyQkNSU2OCosEWM9Hh8CRisrPS\\/8QAGwEBAAIDAQEAAAAAAAAAAAAAAAIEAQMFBgf\\/xAA9EQACAQIDBAgEBAQFBQAAAAAAAQIDEQQSIQUxQVETImFxobHB8AYygZEU0eHxJDNCchUjNFOyFlJic5L\\/2gAMAwEAAhEDEQA\\/AO4wBAEAQBAEAQBAEAQCIAgCAIAgCAIAgCATAEAQBAEAQBAEAiAIBMAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAx+q61pq+HuTPwU7j\\/pzIOpFcTNmYrUeN9Ihx\\/Gb6IMfmRIOvEzlZ5r460x\\/oXfcD\\/rI\\/iFyM5Cv\\/jfS+vmD7D\\/rH4hchkZVX420ZOM2D6qD+hmViIjIzJ6brmms925P83s\\/rJqrB8SNmZAHPabDBMAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQCCcDMA07XW6nVEnPl05IAyRkfHH9KcjH7So4Zf5r37kt\\/vvNsIOW4pp6JSvvb3PzOF\\/Ac\\/nPO1viT\\/AGqf\\/wBP0X5m9UObI1PQtPYeUYD4JY6D\\/SQT9zKEtuY2b6rS7or1ubFRgiF8P6Uf1I7Y9pnP6maJ7Sxy1lOS8PQkoRIPh\\/Sf3CD6Fh\\/vMf4tjP8AcY6OHIgdA0wbcKz9N74\\/AnE2Q21jI\\/1X70g6cWelvRKGHAZP5W4\\/Bsy9S+I6i\\/mQT7rr8zW6C4M8UGp0ftVObKxyy\\/L5r\\/uJ3cFtnD1moxdnyfuxonSaNy6fqhdUlg4DLn6fGegi7q5oLiZAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIBDDII+0A19qwvsjsoCj6AYE+VbSlKWKm5O+p0YfKjH9d6vVoqDfdkjIStAQGtc9kBPb4k+gE6vw7sKe1K9npCO9+nv1NOJxCoxvxNEs6p1jWeay3PpUCaxRTp0CNXdSqtXWzkF23b15yOxxPpSjsrZuWnThHfT15xm2r\\/S3aUIurVTb7fAttS3XNG+6vV6i4BqU2XsLUs\\/9KLdRYTZwlat7Ocjv34530MZsvHwyThGzTf0c3GC7XK17CUKtPVP3a7Nu8O+M9Jq9Mt9ltGlsGFurutVApxkMhcjcjDkfh6TxO2\\/g3EU8T\\/BRzRfh75cO4uUcZFx671Lp\\/FfTQcHX6P8Ay27v\\/jmc6PwZtVr5Eu9v8jY8XSXE9b\\/EuhrbZZqq62wDixLUOD2OGQcfOZj8GbSmrxyvub\\/Ig8dSW9lzousaS4hadVp7X9FWwbzgZOFPJlTGfC20sJTdWcNFq2vaJQxdKbsnqbL0vTCqpUXt7TD5bmLY+gzj7T22Cv8AhqbfJeRWn8zLqWiIgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgGEalnZtuM\\/M4nzlbNq4\\/FVejaVnrftLvSKEVc5z1W+rqXVBp91T1UI1TU3LavmEn+O6soyrKQqjOM7OODPoeGpT2HsXMr5nq5Ryuz4XUmrx4aa27TmSaxGIty4MvfEfierQbUORwo3MCXs2qBnj3jgDk4HbntPKbP2NjdtSdT5Y6vioq7vp2X1segvhsLSUqru3uStd24sxa\\/tE0RrYag+arLg1pUzFh6owcBfsTidSh8GbSo1lKlNRs99\\/FWTd9XZ2uuBWxOOwUodS77Gv1OfeI7k1LvqqateVLFrLdRtNeOyqvloFQDt7x7AT6NgoyoU1SqShpolG\\/q22\\/M4VVZndIy1vga1Ok0dSTzXsZ\\/MsTaqpTQFciw5OWyQhyPRu3rNE9ox6d0nZR3X7QqXUut5lur9B6v1PXWtdp6a9QlNJdBYiqqMX8s++2SdrevpNWGxGGwtOyk2m+Xca6tOpVlqrWKvBvQtSmprteoqlOtr09+SMo+4cYzyORyOPaEhtbE0pYOpFPfCTX2ZHDUpRmm1uZ3ej3F\\/lH6TzOC\\/wBNT\\/tj5I6kvmZ6SyREAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEA0\\/rOssRnCMVw2hfjjO\\/qCow+hVcY+BM5mwaUegnPi5zv9FoSrSea3YjSusdB6jbf1S7S3ijTJqb2YI5Sy11rD7fYALZJUe0ccz1NOvhY04dLBSkt10nbXhfd9EUp06jm8rsv0Lfrf7PNJToNba112o6hTUrWAPhK7HClVxjJ4PqTnOZL\\/ABao5pRSUbmyNBJa7zKeIfC2h03Stdpzo6gaOnpcurZR5luoYWZAfG7hkTjOMWAYlN46tKrnzPV7v0Nipq1jbdT1Avrx050rbTv022+zIySfNSrb8Nu1m4xKbmoxdS+79yVr2RzfqvV9R\\/wx0wCwjfcNHdtAw9SecgrPH+GnPfiW6cYTxThLk5eT9SMm1C6N063e1ep6xZWxVhotCFKnBB8y7kH7ygsTBxiv\\/Jr\\/AIk8jv8AT8y5\\/dUr1Gusyxa7XaYgZOxVrbSA+z23FmPPfAmitjY1aLgv+2flIyqdnfu9DdKfdX+UfpJ4T\\/T0\\/wC1eRmW9lcsERAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBANT1mlWy+0PYtSBNE24495da7qnP9ooF+pnN2JK2Fl\\/fU9DNVdf6I1jxRqxVptQ7EhB4hqd\\/mqCqw5+PK5+07dC1SpGC3uMreJqm8sW+70L3xfT5Oj61qkdHW9KNRXg5H8Omuv7g+Wpz85x47Rp1K9Ognq5W8Swqbs2ah+1fxDRrtDU+n16spKFtIpXczHnfYM7ht\\/skYzzLuyViPx7pVqMtL9Zp5V3cHfnfcQqW6O6kvUueo\\/tD0K9VXVI1tta6GzS\\/w6yDvNyOPfxxhTzKkdi7Vr4WpDIoylJWu\\/6bNcLk+moxktTT+k+MWq6fb06yhLqmNjUMzANQXJbONpBIYlgRggmd3FfDlariaeJpVXFq2ZW0du3t3MrLFwjFpxvyMxq\\/G9+ps1JTTIDqK6qSoZnKisuRjAGSd59PSVYfDEMPCDrYj5ZOV2kk72XF8LEHj8zahDhb3obD4e8Qam24DUYr8\\/WU2eWdPaPcNSko5OMewCQc8g\\/GUK2xsHTpSnQq53ThO9pRe9SfWS14u27wNkMVOTtKNrtcH2HYKfdX+UfpJYX+RDuXkbZb2VzeYEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEA514v6pVRbtsbabBo9vBx\\/D129iT2AAB7\\/GcvYlKtUwknSje06t+zTT7szWnGM+s+C8zSf2ka+6u67RnyjTZcOoAgHfll2BSc4GPLb09RzOz8J06eNpxxt5Zo3hbS173b58UVdoTlT\\/y7aPUwut8Q019JGho81rrTnUs5OysBs7Ez8QFGAMcnnM3LYOIxG23jayiqcPkta8tN7tyd95OniYRw+RO7fgae3b54ntCkt5u9vSNLRe1bLpPIFBfS6i6\\/I1d\\/kgqH9vatZZmONoGUUE84PzxbTx2JoKpGVTO5WqU4wt0dPNZ5erdzslrmb1btpp0uipxlaytwfNl50jrGgqbaPJ\\/eDVp0sOn0+6k2rXqN77EXDpl6QwQjcVyOBKeN2XtSv13m6JOTj0k7SUXKFlmk7qTSk4uV8u56slGpTi+3Tcu8yWi6jwFXRarcqJpxYlBAdF0liDcGKjcrWP6jK\\/SU8Rs6+ssVTs25uLnezdSL0cVLSUVHg+t3mI1eCg+V7dnaefRuoizW6SoK42ainfvK+8iJVwFJAHsE9z3+U9DDZssPga9aUk80JWsnuk5T1vZt62Wi0XaVemU6sYpbmvyO41e6v0H6Sphv5MO5eRblvZXNxgQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQDi\\/wC19v41I\\/wm\\/wDsM3\\/BK\\/hav\\/skUtpvrLuNJ6d0i3UEN7tZbbvY9yByqj1OPtO\\/jtpUMBHLFdbekvN+7k9n7NrY2WZ\\/Kt7foZXX+HtKgO5XxuADM7bgBndwuAexA4PeeVe38bOV1O3YkreNz1tDYWEULZbvv+2631Ndv8OW7zsaoJglWsfarD0wSPkeD8PpOpgPiJKFsS23waXnbkUdobDebNhY6cY3u1+hRf4U11dbWvpitYUOW314IPbGG9o89hzOnT+Jdm1Kkaca15N2tZ7+3TRdr0PPyw9SPzLcbbR4s0VaaVVNjGtE\\/wCXWQEb9yalshyufbc+7jIBJPaeMl8NbRxFWtNpLM380t66RTVsua2i\\/qT5JFp4mnBR9O6x5Udd3ir92099tlf70EIqr\\/rhYAcBWYYFg9kNg7eczqL4aq55uvUioz6O6Tk\\/ky6XvFO9t7jdX0sVni1a0IttX5cb95feC+ga397pus016ILRY72VlAMHJPtY\\/ATrbaxmFpYCrBTXytJXvwsjRhaVR1U2uJ3ar3R9B+k4FD+VHuXkdKW8qm0wIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIBxr9q9LWanTIoyzIyjv8A3p5OPSS+EK0aOCrznuU5FfG0ZVq0KcN7sWug0yhv3ZH3rXWvslMbm3ZY8d+S\\/Hf2pzMXWnXqSqy4v2vse1wsIYWhCEVuWv533XbPC6q9d6r5b1gs9in2XQbRkn17beOVIErS0Wpci6cnfc9Nfv74Mx140+EG5sbt1YUsEXOQNw5JyPw5E1pSRvi6kle3v3wN+8L0JqtL\\/Ddq9jeWV4IQr6c9xn8vwmhbJp4iUqmZp+B5Ta1F067vx1M507w3o6M2GjSb8s72misMckkksRn8536E6tCgqc6jajxb4foclQzOyWpdvqSf+UGVfiSVB+ij\\/tPF7Y2pSqytQnO\\/NSeV\\/T9jo0qCh89vovU8adRuYqcbh8DkH4\\/cfCefnTk2m7689+pucVa8XobLV7o+g\\/SfV6fyLuRypb2VyZgQBAEAQBAEAQBAIgEwBAEAQBAEAQBAEAiAc+8WqHtrRax5n8QC0e8innaOQOWx\\/wCEzzuzHWhRqU2+rKbkl4HcwdGCfTvelZephKdEtRaqu5XU7gxA2tuwikrn1G1+3Jlupa+hfWdxUpR5Pnz3+BhtVvrJLtZZXtIsOweyDkA7mOPl6d5Dey9G04pKyfD9kYvqNtdltbadqzUTtO9duxiGypHpySR6ccRlypmylOSjaSd7\\/f3xMp+z3XhdYFDWlW3Y9rAzt95h6j2fzEnSeWabZp21SzYVysrq3nuT+p0Pr\\/UAr6dGP8Mi61++CalUqvHfuTj\\/ANsrbclOVBU4cXqecwFNdFVq8Y2X0d7vwt9TE0V227ydO5cAsjWWv5e70ChuMZOfUHH4ednUpUUkqiSdrpRV7drXjxRWScuBkOnVulmxjXwCQtagBAcAZwByeT9ppqTp1IxlFO7a1k73t9dy3FulBxpu\\/F6fQ3Wv3R9B+k+jQ+VHKlvZXJGBAJgCAIAgCAIAgEQCYAgCAIAgCAIAgEQCIBz3xQ5XUoVYbgVYcj2MMCCQfnn64nIUeiSXvmemwMVKi01pZ+JgLSLrCXbDuS1QKgqxCEkAEnAyhP8Am7CRnK+pbpt0Ul\\/StHrr7t+5g9dqbBlrGzTkYRU9pwuNxfgcKTgE+vp3krJrTeWaVOed6q3B8vP9jG6OyskGnZWzZDbhuRx3wVOQeQBjvk\\/KReZaMsVIJrNe69SqjqT6e6u9667AMsllG5V\\/skMCB6MPpnvMpX+VlapTlUpulPTx\\/Y6B0bq9HVKzU2a7EIdRu9sH0sRvlyD9fnNkodLHLL7PicPEYats2anB3T0emnc0ZxOn6jGP3ole2fLG\\/wDHOPylD\\/p7COWbXuKbx8Xr0av3u32\\/Uqq061MVXcSSCzMclj8SZx9qUYUsbCEFZLLYU8S53z\\/Q22vsPoP0nuY\\/KjnveVSRgmATAEAQBAEAQCDAEAmAIAgCAIAgCAIBEAiAc28YanymZ9p5facHHG3GeOeCfznOqrNKx6LBtRhd7tDVy2XLrg1+SWAb3iRndn4ZV2HOMyvw7Tpttuz3PwLK6+sUba6ntZiqW5bIWvlto+3P\\/gzK3Fu35kaspKoorVenG9yw6hoDSv8Ay0QDa7CyxQFZlyowAd+Rgjb8Oe0xmbdnvN0ZwSzRdl4aeRjtLY9jBAwG1yqZ4BCjkMRwOBzx6CSccupNVk19bd5t\\/gfUVUWWLYc2tjyyTgKpHqM4GTjB9cwqiWtjm7VpVaseq7patcfaOiN1GtCqk9wCT8OwEnVxtOjOEJf1eHeeYyluLt1xPOAcfhxPK7Sq9Ljr9qX2\\/UytNTcKvdH0H6T3cflRrKxJAmAIBMAQBAEAQCIAgEwBAEAQBAEAQBAIgEQDm\\/iajdeGdwEG8EFgMAck59Ocfh85zKz61j0uEdqehr9mmssFrIwTL5RM8EeUuc98n2CPiSftNLlG2pfpSlSk01fk\\/e5Fnoem2uDXVUq71IawsFyGwMflx\\/3mJO7NlSdCCu727DFdW6Ya7G095bzFXau\\/c3HuptOOAM7u2eTNjlJakKMKE4dXW\\/Ph+pZbBWleXB2mwvgYUlyCAwPOO349phSzSentEp0si6z\\/AC15+hRe+3HtDcwyDtHA7enbt2A9JsgsxGrKFKOVPV\\/U3zpupfUA2FGBWqrgke0SVX9W3fSUcRgnVqKae63mceps1RazTte\\/DdvZtvh5PO33OpUFioX1B\\/pZ+krxwMa2InVrLjou3mcurRlTk4S\\/ftNsr7D6CeoirJFYrmQSIBMAmAIAgCAIBEAQCYAgCAIAgCAIAgEQCIBzrxH02283lcCtCoYBsM+T2HHwwc\\/LEoVYvWXI9Dha8IZabvd+BiLOnXrWjGiwBeMuMKO+0kf2Rk9vqe0rdG2m2joSxNNVMkZJ35P3qYa7VPSzKwx7FbHCAixS201jtng9x6qYULq5tqSVR6XsvBlv1bX2ahlJI3JUtZyTuCf0SCfeLZHPfjt3iT01J4alClJxiu3uvyMR+9EV2CwHfgIX2gb8pwx+nA+o+URV5KxOrHLBuX39fv71PKjZa9FZdss6Iec4LMoJz\\/tN6TVynOrTeXXX76nSOjVWaoawIy1Kt9dVbMDtArtJKgAcnaE\\/KRlUhBdd2uV61SFF0m1m0ba71+5uvRtJ5KFTg+2zAjs24Ak\\/jmbISi3m4HDxFTpJX96GZUcCXymViASIAgEwBAEAQBAEAiATAEAQBAEAQBAEAQCIBoXW9Q62X0pYEL1XbcNtcOKmKOD9ePtK9FpYmN1dXOtWgngnLjbRngdHUbhZWjFQNWWyrOM2I6isPYh8tsJV7YfB5XHInRxNX+HnGXJdm7u38dLdpyMLH+Ig48+80Wy1rGFbEHcM15dS4Y8HkfE4nn7W3HvlKKvdW0+646dhYXMBUyjjywFtPGcF1QAfPLk\\/aIxu789RKrCGvDceOtWyoJ5qsdw2k7CEcckMG7E8enPaKcVJ9U1TxCXVlrwa9TI+EOm16liruUAZSp\\/pBgeOfrI4mq4NcLmm8VQzxV9fI6p0bRpQiAHcqm0E453lyzkj45JnPUlKsq0tUk0ux+\\/M4VebqN8G\\/LgZSu0qyqRkEOx590ZGD+s6OHTVlJc33a3uVJ2d7dhl0HA+gnXRVZXiZAgEwBAEAQBAEAQBAEAQBAEAQBAEAQBAIzANK8QdBbUOLtO6eYCQ6v6HHp6fY4795UacuvBnTw+LjCPR1VdGm9WHU97HU16soSeGDPWo\\/mQlQQPUGaZQdutc6tCrh210bS+y8zCecm5g\\/vD3GPDjk+pHIyB+M1SR01HV21fpyZ46m6trWdgfKsHl4QcntnjuTnHPqRGmW0XuNCjOLeZXT8zY+rdDp\\/dq7abzem8ZBb2g+3gYHOcE5B55mqMXHrJ3vyIU8S5VHCrDK1qu4suj9E1Nd+aNJqChBJyuFDeo3HCkduQZKtQliINNMfi8PRjkckk9dOD7t50Lo2nt0299Q1aUkAkPZkow7EHsBj5yeDwf4eDU7JHCx2IpVmuju33WJbqwvfbUCKsjcxGDZjsB8BOfitqU+k6Klu4vn+hClhmlmkbbWeB9BPSR+VHPe8qkjBMAQBAEAQBAEAQBAEAQBAEAQBAEAQCDAPG8ZVh8VI\\/ETDBoWou1FD7mW1SON3JDD0BPKn9ee8qxpdG7q\\/3Njm5KzLyvxVgcj8DNiqkLHrZ4kqI9pd3HqoP6zPSIyrrceLeItL38tSw\\/whn8cTGaPIlnnzf3IHixB2Ur9iP0EznS3Ed+88tR4jZvccL8zWWH4bgZFzfBmVbkYu6xHYNqLbryOQCFRF+g5H37zn18I6\\/zzduyyN8K+T5Yov8ASXu5C6eo47ZA3Eff3R+EhQ2RhoSUsrb7Xf8AJCeLqSVr27jedBWUqRT3CgHnP5+s7S3FUuRMgmAIBMAQBAEAQBAEAQBAEAQBAEAQBAIgFJWAeJqmAW93Tan96utv5kU\\/7RZAtX8PaU\\/1FY\\/lG39JHIuQueDeFtIf6kfZ3H6NGSPIzcDwtpP7n\\/XZ\\/wDqMiMXPZPD2lH9RX98kfnGVcgXFXS6U92qpf5a1H+0zZAuhXMg9lWZBUBAJgCATAEAQBAEAQBAEAQBAEAQBAEAQBAIgFJgEQBAEAQBAGIA2wCoQCYAgEwBAEAQBAEAQBAEAQBAEAQBAEAQBAIgEQBAIgCARAJgEwBAJgCAIBMAQBAEAQBAEAQBAEAQBAEAQBAEAQCIBEAQBAEAiAIBMAQCYAgCATAEAQBAEAQBAEAQBAEAQBAEAQBAEAQCIAgCAIBEAQCYAgCAIAgEwBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAIgCAIAgCAIBMAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEA\\/\\/9k=\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:21:32'),
(109, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 189)', 'product_images', 222, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxISEhUSEhMVFRUXFRcVFxUWFR0YFxcVFxUXFxUVFxgYHiggGB0lHRUVITEhJSkrLi4uFx8zODMxNyguLisBCgoKDg0OGxAQGy0lICUvLS8tLzItLy0tMS0tLS0tLS0tLS8tLS0tLy0tLS0vLS0tLS0tLy0tLS0tLS0tLS0tLf\\/AABEIAOEA4QMBEQACEQEDEQH\\/xAAcAAEAAgMBAQEAAAAAAAAAAAAABAUCAwYBBwj\\/xABSEAABAwIEAQUJCQoNBQEAAAABAAIDBBEFEiExBhMiQVFhFDJxgZGhscHRI0JScoKSk9LTBzNDRFNUg6LC4RUWJDRVYmN0hJSy4vBkc6PD8Rf\\/xAAbAQEAAwEBAQEAAAAAAAAAAAAAAQMEAgUGB\\/\\/EAEIRAAIBAgIFBwoDBwUAAwAAAAABAgMRBCEFEjFBURNhcZGh0eEGFCIyUoGSscHwFkJTFTNDYnLi8TSCorLSIyRj\\/9oADAMBAAIRAxEAPwD7igCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAICPNXRM7+RjfjPA9JQER\\/ENGN6qD6VntQGA4lpDtOw\\/FOb0IDazG4Ds4nwMf8AVQG3+EmdGY\\/IPrCAxOJt+BIfk+0oDA4r\\/ZS+RvrclwYnGP7Gb9T66A1nHP7Cb\\/x\\/XQGt3EB\\/N5fKz6yEGs8SH83f85ntQHreIXn8Wf8APZ7UJNjcbefxaT57PrIDY3F3\\/m0vzo\\/roDP+Fnfm03lj+0QHhxkj8Xn\\/APH9ogNZx4DeCcfJZ6noQa3cTxDvo5h8j2FBc0O42pB3xkH6J59AKE3MP4\\/Yf0zEeGGUfsIDJvHuGdNZE34xLf8AUAgJdLxZh8n3utpnHqE7CfJmQFtFK1wu0hw6wbjzIDNAEAQBAfP+MzVlz8k8sbbmwY7JYeFtioYPlOIUc73WfPI\\/473O9JUXJsZUXDzid2HzepLg6ag4cfp3vlPsUAvaLBpG7NB+V+5LEHSYfDKPwY+ePYpBbN5S2kQ+ePYpBqkkqOiBp\\/Sj2JYkg1NTXjvKSM\\/pwPUosLlTUYji3Rh8R\\/xAQEKTEsZ\\/o+H6ce1AR34hjP5hD9MPrIQaHV2MX\\/mUH0w+sgJEOI4wB\\/MoPpR9ZASY8Wxn8xp\\/p\\/3oSb2YxjP5hTf5myAkNxbGPzCm\\/wA1\\/tQGYxHFTvQ0w\\/xh+zQGTZcRd31JAP8AFn7JSQeS0lS4c6KJvgnJ\\/wDWgsUuIYPL08mPlk\\/sqBY5rEMHf1s8pP7KA5jEcOI98PIUuLHI4rDY7g+JLk2IVDXzQOzwyyRO+FG8sd5WkFdEH6y+5niU9ThlLNU3MrmG5O7g17msefjNDT40B06AIAgOC48kkEhyuIblGnRfVZq0pJ5M93RlCjUh6cU8z5pVtu6538noWN1pree7HRWEkvU7X3iKoc3ZOXqcSHoXBv8AL2vvLWhxiqdcRtDrC55ugHRckgDxlWQq1ZbDLX0Xo+ik6knG\\/P8ASzZvdxPUscWvY1rhuC1wPYe+27UderF2ZENC4OrHXpybXM0\\/oT6PjKYe8YfGQpjiZ8xXPQNFbJPsLVnGkn5IfPPsVnLy4Gd6Fh7b6vEO47kH4EfSH6qh4iS3ErQcX\\/E7PEiTfdBefwNv0n+1cPFS4IsXk8n\\/ABOzxIj+OXn3jvnD2LnzqfBdfgPw6\\/1OzxMTxs74LvKE86nwXX4D8Ov9Ts8TH+OLnG2VxPUCCU86kldpdfgQ\\/J5pXdRdXibP4fm\\/N5\\/DyZ9ir\\/aMOMfiRX+w4frR7O80P4qc02cx7T1O0PkKsWLcldJP3+B3HyecldVE\\/d4nn8b3fBd84J51PguvwOvw6\\/1OzxPf45P6nfO\\/cnnU+CJ\\/Dv8A+nZ4nh4zk+Cfn\\/7VHnU+COl5Ox\\/U7PEx\\/jlL8E\\/P\\/wBqecz5vv3nX4ep\\/qPqR6ONZvgj559iecz5vv3nX4epe2+pHj+NZz71nlJ9aecz5vv3nS8nqG+UuzuIc\\/E07twzyH6yec1DtaBwvGXWu4gS4i929vIfao84qcSxaDwi3PrINQMwuR6beBRy0+JbHQ+CT9TtfeU9RSxk6safFdd8pLiXvRWDisqa++k0GkjGzGfNHsUOcrbWcxwWHTypx6kfq2JoDQALAAAAaAC2wXpn58zNAEAQHD8d9\\/8AIHrWWttPd0W7Q95x8OBCSN8UkZZLNJFlLovdRTMN55Ig5hdtJuyxuG+PujTtFqSKNJYxVK0ZUpZJdt34GysoKVofUsgpzDI+kkjDoyAIs0MVTG2N7QYWnOXmQdNw63NvbqR4GDzmtZLXeXOymxiiaxgdGwtgEsrBfUB0TuRD5CR98cI8xJ6XOCxYlWSsrI+l0HNOcteV52ja7u7NXaX1NczbQQ5u+zyZAfyFo7H4ufPl8DraKmX7tX93QelT1fO6mps1Vrf1Xfbq7e3Myo1zEuqFqxuitMbeZpnYoZ3BlTUDVVSNsGaLf89QXBaXrcKhp2h9YTmIu2nYeeR1vPvR\\/wA7F56xFbFScMKsltm9nuW\\/76T5jS3lJSwi1YZv72Lhzv3I0ycTyjm07I4G9TGgu8biNT22C1w0PReddub53l7kvE+CxflBi68r3t2vt+iREOPVV78vJ84+haVo3CWtyUepHn\\/tDFXvyj6yTFxRUbSFszelsrA4eXdUT0PhXnBOD4xbXga8PpzGUZXUr\\/fFWZIjpaar0h\\/k8\\/RE43jeepjvens83SsdR4rB51fTh7S9ZdK3n2uifKqNZqnW29vue\\/oeZS1ED43Fj2lrhoWnce3wrbCpGpFSg7pn2UJxnHWi7o1rs7CAsMNqomNc2WMuvexFrj3N7RYntd692hdRaW0y16VSUk4St\\/lP6fTY2bmYhCxz8kd2O5MEEWGUZxJpmNiQ5ttd2300U6yWxHDw9WUVrSzV+vK27mzy2Ox6yvptLwdDb2aO+BGY3LtW7m1gToL2GrWjwIdCvunx3vZu3bee\\/Pa4biUN78g23NtZrRbnEuJGt780WJ0AIvqmtHgHh6tvXfW\\/d9d3B2PanHGHaBlgHAA2s29g21m7AC3jPUutdPcRDBS3ze7x372UeNYlyumTLZxdvfQtDbaNF9r3Oqm9zTSw3JZ3vlbZzt8X1bCpsToBcnYDfyKGdNqOb2H6nZsPAvVPzVnqAIAgOH46PunyAddtzus1V2lc9rR8NejKPG67DkKviIse90MVi90khMrxKGyyyQOcQMo5gbCQBvdwJ2UPExSdi2noStOUddq2+223Vt6TRTcU5SwvgMh5CGCW5YM7W\\/zgi1rl2jhe1j1BT51DnOP2BieMet9xNwziiMQjlHSskZLPMY2XtMZnvflcQLEAyW1IsRdcxrwau3vZ3W0TiVJRhFNOMVf2WrX+XDNPiczVVT5ZHSyG7nG56gOho7ANP\\/qxzm5yuz6bDYaGGpKnDd2veyRRqYkVS3j2Vhie0wnGiHUCnqt1TI3Uy2wljaaE1kgBeSW07D8LW8h8\\/k7QvKrqWLr+awdorOb5uHv+9jPnPKPS6wtJwjt+vDoW19RXYzh1Q0Col90ZLzhM05mOPVf3pFrZSBa1raL6GnRjSgoQVkth+Y4iFVvlZu+tv+9nQV0EeZwbrqQOaMxt0kNG\\/gXRRGOs0jp3\\/c9ruVdG1jS0bSlwDCDsbd94RZd6jNz0bW1tVbOJOxn7nE8UMboTy0lyJGiwA6QWZrXA1BvqbjRS6btkWVtGTjBOGb3nIVuHzQG0sb4z0Zmlt\\/ATv4lw1xPPnSqU36SaL6F\\/d8BY7WphbdjumWMbtPWfXbrK+cr0v2fWU4\\/upvNey+PR98D7zyY022+Rqv749K38VznOL0j9BCAIAgCA201M+Q2jY552s1pd6ESb2HE6kKavNpdLsXtHwRWSC5YIx\\/XOvzW389ldGhNnm1tM4ankm5Pm72b3cCxs1lkc89QGVvrPnC0Rw\\/FnmYjygqyVqcVFdb7uwl09DHFpGxrfANT41fGEVsPEq4mrVd5ybPrIVpkPUAQBAcPx598HxB6XLLX2nvaK9T39x82rN1ikfT0thDcuDQjFCTJqEMn0asiZqpbx7KwxM1z7IdQ2lTLGXODRu4ho8JNh6VRUkopye42xkoxu9xN4ymHLCFveQsbG0dF7Ak+gfJWfQtNrD8rL1ptt\\/T75z8g09ipVsW093zeb++YvuDKlkWH1L6vnUznBjIju+SxzBnTrzdRsWk6WK9uGUXcrwclDDydX1dy5+Y6ThfinDSAyINpnfBe0Mv8ALGjvGbruMom3DYvDPKPo9nadkuz0AgImKTwMjJqDGIzoeUtlPZZ2\\/gUO28rqSgo+na3OfFa\\/EIIq7lqO4iDgQLEaWs8AOJNjr1b7CywYyhHEUpUuK7d3afPrEQo4pVaWxP8AyauJ6QR1Mgb3riJG+B4v6bryNHVXUw8XLasn7sj9mwFXlcPGXu6vAq1tNgQEjDqcSSxxkkBzgCRva+tr9NrolmU16jp0pTW5H0zDuHKBgvyGc9b3F\\/mOnkC2xhTW4+TraRxc\\/wA9ujLxLyCZjQGsjDW7AAADyAaK1SSySMElKTvKV2bJK8ajKVPK8xzyPOc9i9XvzLdtt9bKFU5g6fOUb6s3286nXI5M+rBXmU9QBAEBw\\/Hn3wfEHpcstfae9or1H09x83rN1ikfT0thCcuDQjxCS74Zo4ZBO6Zpc2OPPZriDpe+xF9l52PrVoOnCi0nKVs1c8nS+MnhKPKR3Xvsexc5LhrsOG0U4+Vf9tXxwmlF+eHU+4+Nl5Yp7U+qPeTW4jQfBm83tWhYbSO9w7e44\\/FlN8erxMZK\\/Dz0Teb2rmeH0lbJw7TqPlZSXHq8SMyqw1r2v93u1wcNrXabi\\/kWOrhtKTi4vUzVt+80fi6lKLjxy2eJzuK1IkmkkGznucL72J081l7OEpOlQhTe1JLsPhsVVVWtOa2NvqNdRWPe1jXOJbGMrG7NaNzYDS5OpO56VouVynKSSexbDSPKoOEWVRxDVvkMhqJQ427x5YLDYANsAFOsy+WKqylrazJeFcV1MUrZHzTShtzybpnFrjlIbmudgSD4lKkyyjjKkJ6zk3zXZT1lU+V7pJHFznEkk9ZNzbqGuy52medSU5OUjShwdVNXUEwjdMZuUbEyN2UaXaNfOSvnFg8fSlNUtXVcm1fnPusD5UU8Nh40+CV8t9lfeas2F\\/8AUeZd8jpT+TtNX4yj9x8TzlML+DUeUe1OQ0pxh29xz+Mo8\\/wrvNtNXYbE9r2sqC5pDhqNx1jNqpWG0pf1odvcVVfLCM4uDTs+Zd50tBjbJoZHxNcMha3n26ba6E6WXMa2OpYunRrTi1K+xcE+ZE4LF0sYnKCatxJcFbKGvJDBa5bc6OvqNTbsHZova1pZ7DXqQdrGP8JEtEgDWuIBLXOt0bF1jqNQLaG6mMna7Dp7ijx\\/FXAZgASe8B6TluASNgmuxyK4lPJVTOByN52W4Opbmv3pI8fmXes3sOHCK2s+3t2C2nmHqAIAgOI4978f9sf6nLLX2nu6J9R9PcfN6zdYpH09LYQXLg0I8Q6L\\/hj71Wf3c+hy83HfvsP\\/AFr6HzvlN\\/o30S+RlwNhjJ53Z252xxPlyfDc2wa09l3eZfURPyrA0Y1aj1leyvbiMQr4poGu5KKKZstjyTcgdG5pIOUdRFr9oVhVWq06tK+qlJPdlkRZMIeKUVVxlMvJAdPeklx7LiyNlfm0uR5bdexspeHDNSSVUcgJi7+LIQQBqSHXsRl18RVTV8zRTwmvRdWL2bUQY8MYaZ1RywBa8MMeQ3zODi0B21iGuN+xcWyucqlF0uU1ua1ifwNSwTVTYJ4hI14dY5nNLS1rnXGUi97W17FMLN2ZbgoQnVUJq6fSV+P4cYaqWBo72Qhg35pN4\\/1S1cyVnYqr0tSq4Lj\\/AIL3j7CaekMMMUVnlge+TO4knVpAaTYAkX8i6mkskasfRp0dWMVnxKCTCpG0zao2yOkMTeu4BJPg0I8RXNsrmR0JKkqj2N2J2G8PNlpnVLqiONjXhjgWPJa4kBt8o6bg3F91KWV7ltLCqdPlHJJGuq4efDVMpZntbny5ZAC5hD9GOFtbE6diONnZkSwrhVVOT27ya3hQd2dxd0N5S2\\/Juy5sucsvf4Ot9uhNXO1y3zJctyWtn0EOjwDNVOpJZOSe0uaCWFwJbc9B0BaLg+BLZ2KoYa9V0pOzNWG4QJeVk5TJBDq6Yt1NzZjWsvq53VfTpPXCVzmnQ19Z3tFb\\/llzkqXh5pjjnilzwPfybnFmV8b7XyvbcjXSxBtqOsXnV3ljwqcVOMrxfWukvuFoGxx1LAcwzNHbzhbXwb9GnUvDxytpGh0S+TPotBRUYzSe9HtRUszNjvI8mMtBYPc2tG7Qdm+96b7L0XJWPoYU7O6ViKamWTI8xgMyBujiCZA4hzXtA1AsSO0lJSTSZ0oWbRU1kt2M5VnupJAAsSxxuCG6kNGW2l+pdJplcsmTqmcgnWwB8XiV0HkYprM+zN2WsxHqAIAgOJ4979v\\/AGx\\/qcstfae7on1X09x82rN1jkfT0thCcqzQjFDov+GPvVZ\\/dz6HLzcd++w\\/9a+h855Tf6N9EvkaOE8aNHUNltmbYse0blhte3aCAfEvqIn5PhcTyFXX3bzpOOsKgMcddTWySmzgNsxBIcB706EEdfjVqNWkqFNxWIpbHt7+8kiikOGzwOY5rY4YZmOLTYuN5pcp2NrkLll6py81lTaaSSa+bKbhDGO5WNe772+oEcoO2R0R1I7DY+I9arvYpwNbkoJvY5WfUaOJ8G7kbURDvDUU74z1xujqreSxb8lcyVjnE0ORU47rxa6PSKrhwkSvc02LaepcD1EU8liuUU4X12+Z\\/JnX8Rwh9RTYiG8x1Oah3x4GZ2tPhc6JviXctqkejXipVIV7ZWv1faRV\\/dE\\/EyTvSM\\/551E9xn0j\\/D6Cc+mc7C54Cxw7nbTzNJBAJkbnlsem2aRT+W3AucG8LKFvVs+\\/6kPh2ifPhlTEzLmdURAZnBoJJZYXdpfs6VCV4tIqw8HPCyiuKPeKakHEKWEX\\/k\\/c8LnEWzODgSR2ahJP0kicTNecQh7NkZY48txidzSQ4MkII3B7idYjtuj9f74Cs2sZJrg\\/+pY1LBV9y4lGBm1hqAOh4Y5od57eBzF161pF7Sq6mIW3Y\\/v73FOGZcEu339XzvE2wH6rVyvUM1rYLLfIy4W52HYix3etayQfG5x9LGpH1WMJ6WHqxfM\\/vqMOEZwymqXEgAGM67b21XgaQyx2Hf8AV8j2PJz1Z9K+TNUcU4eJI3Zmkuc5rrlwPQxhtzWnm3uOgLeoqR9UpprI8\\/hBscpY4yMznPmc27RpYiMjQ7nfUEXO4TVSzDk5ZFXiPJ8uOfzLNbZpNg5zrmQEanSxN9V3aGRTUg5K7JrnMLDYHQ988Fxd1kHYDzK26sUWdz7k3Zbzyz1AEAQHE8fd+34n7Tlmr7T3NE+q+k+b1m6xSPqKWwguVZoRih0X\\/DH3qs\\/u59D15uO\\/fYf+tfQ+d8pv9G+iXyNXDoheyaCV7Yy9rHRvd3okYTYOI2BDnC6+oifk+H5OUZU5u19j50XlRLF3NBQcvGSZTJLIHe5sbzuaHEamxvp0+FWGiThyMMNrLbdvcl0kjBMRYK6p5aaMQPbI25kGTK8jIGXOtm6abaqC3D1V5zU15LVd9+Weyxz1TRBtE5vKwOe2ozZWzMJMYYWZmgHXUjTe3QqnsM7p6uHaur63FbCXiuNiowuKNxHKxTtYdec6MRyZHdZFjbwjtUN3iWVa\\/KYWKe1P6Mr+E6fM6Yl8bB3PMwGSRrLvkjcxjRmIvuddgoirlWEim5NtLJrN2zaLR+Kk4SKW45TunkbZh3l+Vvmva2awve2im\\/oWNDqvzTk997fUmcWUAnNCxskTgImQykSsOQgAuJ521g837O0KZK9i3FU+UdNJrg80bcAxCSSrrIaia0D45WWfMDGzM73PJd1u9JHNUxb1mmTQqSlVqQm\\/Rz35cxAw+mfHhtUwvjbLyzHsbyrMx5ItLnNs7W1jbrtouUnqtFVOLhhpK6ve+1bjdjrGVU9LWwvj90MYmaZGtMcjCCS4OI0yi1\\/6o6wpebTR1WUatSFaDWdr57Gj3FYmPxWSTloRE+N5EhmZlsacxWvm3zG1t+nZGvSuRVUXi3K6s1tuuFiFwNjHc0k1PK5ojlY5pOYFjZGtOVwcDlsdRcb81RB2dmVYKvyUpQk8n8zTw7XRyUk9BK9sZeRLDI82YJBa7XO96DlGvaey8Rfo2ZGHqRlSlRk7XzT3XPHVLaWilpw9j5qh7S\\/k3h7Y4magF7eaXE30BOhU3srEOSo0HTunKXDOy6SVwO48jU2tfmd8Mw99uCvn9JxcsZh0v5vkj1tAJOFVP+X6k+sw6GR+fnN5mtpLHN0dOotprroOpbo4WpGLSZ7STjsZXVeFQPN3h92t0ObOdN+0A3v4lROlio7Myy816WsUxwcucAA4sLiOdYOy9BOXQW6ytMaVRRTmhLEVfauTZaprSWtzF+a2Y7Fo7NjcaaAK+LLZRkug+4N2XoHlnqAIAgOK4+HOaf6lvOVmr7T3NE+q+k+b1g1WKR9PSZAcqzSjBDo6PhGJz2VbWi7nQZQOsnMAF5WkZxhUoTk7JTu+w+f8o4SnhdWO1qXyIQ4eqhvC\\/wAVj6Cvbp6Vwb\\/io\\/KZ6Lxa\\/hs9OD1I\\/AS\\/McfQFrWOwz2VI\\/EjO8Bil\\/Dl1M0yYZP+Rl+jd7Eli8P+pH4l3kLB4hfw5dTIslDKN4pPmO9ireIovZNdaOvNqy2wfUzSaZ43Y75pTlIPeush0prc+oxMbuo+Rday4kakluMS3sU5HJ4lgEAsgPch6j5FF0TZnQAU\\/wDJLMByvYZ7RuN2+55s2muofprufApc4K12jdqwepZb1fJ8wip4jM8mN\\/JuYGNtC7mlzADKQBoWkXIGhJNhZcOvRTzkutExopzbcXZ5bObb7v8ABripLwZDTScoGkteInauc83a\\/TobYhw21HTpx53h0s5x60Fh5unbk3f+lm6uoXviaxlPIXe4WtAW5MkGWYF2UZsz7O6e9vuVw8fhUs6sfiXedVMLWlBKNOW78ryyzztvZffc\\/wALkZyrZoy0PyWDhvbPfTxheVWxNGtj8NyclKzle3OkeronD1aNOrykWr2t2nZtwqL4DfIvqDWZnDYx70eRSLFJjlK0NNh0WVdVXjax3CTjJNHC1sBuIwzUgu5S+oN9Om508Wq87Wb9XtNXKTlmfcG7BeoYz1AEAQHO8UtcS0DLzi2PUXsXlxB6dBkPRs4qmqejgWkm3fLPq\\/ycbM2Zkkj+TbJne2TICS4tGRkmUZbG7asM+USL2uczum39\\/eZ7cXSlCMdZqyavuvm1fPc4X9265y+MTZi3O0tka2xFhYhz5JA641PNkYB2DwLPN32nr4aGqnqu8X9El807lYuDWb6WpfGbse5hO+Vxbfw2Vc6UKitNJ9KuV1KcZ+sk+k63BKmV4GaWQ\\/LJ9Kx1MNQjspx6keNiqdOLyiuo6NjH2++yfqn0tVDjTX5F2955zUPZXb3mqoL2guNQ5oGpLhHYDtJas1SnRlkqSb\\/3d5K5NZuK633kSCse9ueOrD2\\/CaI3N07W6LDVpUoPVlRs+mS+ZZF0ZK6iut95thnmcMzaljh1iNpHlDlXKNCLtKk1\\/ufcP\\/geer\\/y8DYHVB2njP6H2SLh+bLbTfxf2i1D2X8XgZZKr8vF9AftVzrYX9OXxf2kf\\/X9h\\/F\\/ae8lV\\/lof8u77VNfCexL4l\\/5IvhvYfxL\\/wAnhjq\\/y0P+Xd9qp18L7EviX\\/klebew\\/iX\\/AJMCaofhovoD9qieFf8ADl8X9pNsP7L+L+08L6r8tH9CftF3bDew\\/i\\/tJ1aHsv4v7TAzVH5dviiHrcV0o4f9N\\/F4InVo+z2+BqdUTa\\/yjbezGadOtxorFTofp9rOtWj7Ha+81maYi4qXkEXBDY7EHYjmLtQoJ25Jdcu86iqT\\/Iut95GOIzxuDjM94HvXBlj81oW7D0aF78nHtfzZZLD0qkdVRtzq\\/wBWzpMBx1kmpy36rAWPqX0eDwuH9eNOKa3pK54GPoyoPVdzo2va7Y2PUvUPPMZGkKAUWMtuCgOOnpnkm4Fr3VPIreX8u9x9earig9QBAEByHHM7mOjLXEaZhb4TSbH9Y+VZ67aPZ0XCMlK6ODfjMrXAk5gHNNtBo0xnICBzW+4xaDTmDtvkc2n9\\/e4+gWEpyi0stvbfPnfpPrKfE6rlZDJly3DdLk7NDSdeu17bC9hsqpO7ubqFPk4KN77fnf747SGuS8yahyzruH9gstY8bF7Tq49lhkeYzneJ9aiia\\/70Zn5ge9MgjJhB6+de3aFdQuqFaUfWsrdF\\/S7DPW\\/eQT2X7bZFdxfTsMtHG5oEU1UOWFrCRzYzyTJPhAlux3yjqWHBTkoVZp+lGPo813m1w8TuulrRT2N5\\/Qi46xsVY9kQDRLh9Q6ZjRZpyAiOQtGl9S2\\/VousNJzw6lPPVqR1X07V9TiqtWo0t6dygwCJr6Wsla0RZMLZC+KwBlcYTI2qdbTUXAOp3vZb8VJxr0oN616rafD0ranfu4Gemrxk9no\\/TadPhVdJHPT4fVG80M4dFIfw9PyMwa\\/47dA4enUry69GE6U8VR9WUfSXsy1o3XQ9qLFJpqEtq7UVmG0wGH18nc4Dslc3unM3MQJHWjt3w28HNWqtUbxdGGvlen6OfBZ8P8lcV6EnbjmTpKOOmdhc1O0RvmdHFKGaCWN8N3OeBo4tIvc66rOqs66xNOq7qKbjfc1LK3C\\/A7tquDjvJHFOFwOxGgLoY3cq6oEl2NPKZafmZ7jnWsLX2sq8DiKscHWUZNaurbN5XlnbhcsqQi6sctt\\/kSOGgBVYiP8AqIz4jA2y4xmdCh\\/S\\/wDsy2j68+n6HNU9LOI6OoptZYaCI8kdpo3Hnx36DoCO0BenKpS16tKt6sqjz9l7n3lMYztGUNqisuJNhxZlRTTOiD7VNTyQaBaQB0UXLAD4TWNl+aq5YeVGtFTt6Eb82Ter7m7dZdGopwbW9259iv8AUlcF1BNMYH3D6d5gIcLHK3WIkD+oWjxFV4+C5blI7JrW9+\\/tLsJL0NV7Y5dxNrlZhz06ZzklQ6N+ZhIPp7COlexRnKGcWbpYelXp6lRXX3s4F9hnGL2WD\\/aPJuPEvQp4tPKaPnsV5Pzj6VCV+Z7evY+w6uh40a4a2PgPqK1RlGXqs8KtQq0XapFrpMK\\/iGFw1FvF7F1YpuU4xCJzgGnUkADtJsAosLn1QISEAQBAQcXoRNGW2Ga2lx5lDSe06jOUfVbR8I40iqKaQh7XRAnQloyn4riLHxKt0YPcaoaQxUNlR\\/P53KPD8Rc82c4HxW9CreGga4acxcdrT6V3WOmo8NZJbnkeQrh4SPE1R8oq35oR7V3lxFwdm1bOPHH6w5c+ac\\/YXLyiX5qf\\/LwLrDuG6iPvXwu8Jc0+gqmeAct5VU0tQqbVJdT+qLYUdUPwUZ8Evtas8tFSf5ijzrDv8z6vEhYhRTPaWSUmdp3bykbhptoSFQ9FV4vWpys\\/vnO+VwslZzXvT7iqkw8ZHRPoZSxxDnateS4WyuzcoXXFhY3uLaLLLReNUlOMlde7stbpLEsK1blI9vcaaeCCISA01VeVuSRzxJI9zbEZeUc5zgLHYFU1NHY+Tje3o5pJWV+NlFI6VCjnapDP+bvNApqEC3c9QB3P3KbMl1g15hsdd99+1Q8HpO98vW193rcdnZsI8zp7pw2W9dbOssamupJJIpZI5s8Li6N3IyAtLm5XDQagg7dgWSGjMfThKEVlLar8CZYPWaetHL+aPeQIoqBrJYw6qEcrZGvjImye6m8hDctgTc6ja5V08NpGUoycI3jazyv6OzM4Wj5WaTWf80e8you4InxyDuiR8TOTiMjZX8kwgAhgIsCQACbXt0qKmE0jUjKGqkpO7tZXfP3bCY6PcXe8fij3kmsxGkkkilc2YvhLjGRFILF7crtLWOnWq6ejMdCEoJK0rX2bndFjwl2m5Ry\\/mj3kGvbRyyOlLKpr3tDJDGJoxI1uweGEZtyOu2i1UsHpCEFBJWWauk7PmunYiWDg3dzj8a7yW2viDg5kM1wwRi0ZADAbhoBIAXC0TjJKz439\\/Ud8nSi7upBf7kaIQxrs0dG8EvdJcBjee8APfq7cgWutX7LxclaUtyW\\/YtiISwsc+Vj2\\/RG6KGTM97KPK99s7s8Yc7KLNzEG5sFYtD4hpRlLJbObtIVbBxd+UV+aMu4wqKKpd+Djb8aW\\/wDpaVqpaKnDedrSODj+Zvoj3tFRU4I\\/d8kY8Fz6QFsjhJLeWft6hHKMZPqX1ZVVcLY93g+K3rViwvOVS8ovZp\\/8vA5+vxos73L49fWrFhYrezNPyhrtWjCPvu\\/qipjxmunfycBke8+8iYXu8QAJWiMNXe+s8qvipVtsYroil27T6n9zH7nmId0MrMRe9jIznZAX3c9471z2tNmgHWx1uBouzKfa0AQBAEAQGMkYcC1wBB3BFwfCCgOequA8MkJcaOFpOpMbeSJPWTHZAaG\\/c\\/om94JWeCQn\\/XdASI+E2N72WTx5T6AEBLiwZzdpT42\\/vQG7uB\\/wx5P3oDVLh8p2c3x3QFbPg9X710Xjc4fsqLAqKzAsS96IT+kI9LUsLlXJguLj8Ax3gmb+0QosLkaShxkfiLj4JofXIFNhc0vpsY\\/o+T6WE\\/8AtSwND6XGP6Pl+kh+0UWBr7ixj+j5fpIvtE1Sbnhw3GTth8njlh+0TVFzdFgmNH8Ty+GaL1PKaouSYeHcb\\/IxN8M7fUCpsRcnQ8MYydzTN\\/TOPojU2BudwRib++qoG+APd6glgav\\/AMtqX\\/fcQHyID6XSepLIZm6H7jlMTeWqqpOwFjAfIy\\/nQFxh\\/wBy7CYjfuVsh65nvl\\/Ve4t8yA6qioYoW5IY2RtGzY2BjfI0AICQgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCAIAgCA\\/\\/Z\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:22:22'),
(110, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 190)', 'product_images', 223, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxITEhMTEhISFRUVEhUSFxUVEBAWFhIWFxYXFhYVFRcaHSggGBolGxUVITEhJSkrLjAuFx8zODMtNygtLisBCgoKDg0OGxAQGzIlICUtLi0uLS41Mi0vLy0tLy8tLS4tLTEtLS03Ly0tLy0uLTUtLS0tLS0tLS0tLy0tLS0tLf\\/AABEIAOgA2QMBEQACEQEDEQH\\/xAAcAAEAAgMBAQEAAAAAAAAAAAAABAUDBgcCAQj\\/xABOEAACAgECAwMFBxAJAwUBAAABAgADEQQSBSExBhNBIlFhcYEHFDKRobHRFSMkQlJTVGJyc5KTorLB0hYlMzREdIKjs2OU02TCw+HwF\\/\\/EABsBAQACAwEBAAAAAAAAAAAAAAAEBQIDBgEH\\/8QARBEAAgECAwQGBwUGBQMFAAAAAAECAxEEITEFEkFREzJhcYGhFCKRscHR8AYVQlPhIzM0UmKCcpKy0vEkQ8IWJTVjov\\/aAAwDAQACEQMRAD8A7jAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEA1Lj3bhNNe1HcWOyhSSrKB5QB9fiJonXUZWsW2F2TKvSVXeSTK1vdHb7XRMfXcR81ZmPpHYSlsOP4qvl+qMZ90a78CH\\/cP\\/wCKeekPkZfcdL83yX+4+f8A9Fu\\/A1\\/XP\\/449IfI9+46X5vkvmfD7ot\\/4Kn6yz+SeekPkPuSl+Z5L5nhvdFv\\/Bk\\/SsP8I9IlyPfuSj+Y\\/IxH3RtV+DVfHbPfSHyPPuSn\\/P7gPdG1X4LX8dv0R6Q+R59yU\\/zPd8zIvuiao9NEp\\/12\\/wAkekPkefctP8z3fMyDt\\/q\\/wBf1zj\\/2T3p3yPPuej+b5fqev6f6vx0C\\/wDcn+SedPL+U9WxqH5vl+p8p90m3vFR9Ft3MFyLycZOM\\/2fPr554sS72cT2Ww6e45Rq3suX6nRJLOdEAQBAEAQBAEAQBAEAQBAEAQBAOSce58W1Y9FY\\/wBqqQZ\\/vWddhMsBT8fezzptbsyuB1hOwnS3syR9UfQJ7vGvoDwdaIuZdEeTrhPN496JmJuLhfATzeM1hmyUvEVwOQ6T3eNfRSPX1SX7kfHG8jzoZcweJL5hG8h0UuZ6TiS+KiN5B0ZPiQdXx5QxGwTxzRthhJNXueKn3GpsfCvqXHmy4ELOx7JbsZLsfuOxSeccIAgCAIAgCAIAgCAIAgCAIAgCAcl4u39b6r1p\\/wAVUgy\\/es67DL\\/2+n4++RX8TqKWH085jLJm+jJSiRzZPLmzdMFmpnlzNQI9mqnlzYqZFtvJmLZtjAshq1CjP3I8epxG8jSqMnIz6Km2w05ArW4WFLCA6Hu1YkeS3I5XGDg884ODN27CCcpu9t26Wq32lG9123yusmrlBi9sRi3ToRe9vNeto91O7VnzVs7PO+ZhNrKK2ZQO8p98BVLM1decBrQB5APXOcefEzdC+90b3t2Ti+V0rtJ8baPtT1NmF2xSqycanqabrb1T7LZfK17B9YoGScSMncu+ilqVfvgO5KnkTPXFp2aM6coygt1p9xs+g6af\\/NUf8gm2PDvIFX8f+GXuOyyecYIAgCAIAgCAIAgCAIAgCAIAgCAce46f621P5S\\/8NcgT\\/es7HC\\/\\/AB9Px\\/1M+ceGVVvGJnuG1aKR7OU1kxLMgW2TFs3xiYS88NliPqbiMBRlmYKPWZso03UmoriRcbiVhqMqj4K5tq9jyH2DWUvbWGaytqXK1tWosI5nFifanpLingIQcamflnfLw8zjMR9oauIp1MPJRzVsr3XHufLRLsZl7PXm3S26\\/wB61dzW+5qF3FSVC99bSpGxDtfOD1weY5kxsVs+tOKhTrtTs7Sst5q+UZSVpWvy53dyqpVYJNygmssuF+LUXly9mXbb6rgzvYtbOtC3077K6KwvehQvd6eq+w7LCd5zgAeSeXM5kUMFCFOMptzlBtJt6b2srLNaau8s9TW6rVS0Va6va3LRJvJ92mWaMen4Tp6lp1L6d0Wi+xNRZc7PtIXZW5TkhQWOCdo5FPHElxoUoNxha9k42889dOZnVx+KxCTqyk1dqSbyy09VerryRqfaSys6tWS9L3ZFNz1BBV3nTCbQAfJCk+k+yQdpKLs0ra5cbdvjcvvs3Kqt9N3WWfDe428Ei1F2DpF\\/9VQf9wSsvp3nROOVR\\/0y9x2yWJxIgCAIAgCAIAgCAIAgCAIAgCAIByDjif1pqmPQMP8AirEgTX7RnYYV\\/wDQ019asw8YbNa+vMS0M8OrTZQWnlNTJ8UQbDMTejxB6RtbUWAI6g59PsmylUdOSkuBExuGWIpOD0eT8S+p7ea3erWPU+1GTY+mOx94AZ7ApG98KBk8sZ5c5ZLHxtbc9jOXf2ebz6X2xy8uJk0\\/a21V2KdIiE3E1rprwjd8MMpUNjaB0mf3jFu7i75ceX1maf8A09NKyqK2f4Xx1\\/Q8N2t1X1vbqXHdKUQUaVKx5QwzMH+Exx18DNU9oXbtBZ63bZJo\\/Z6NlvTk7aWSX1cpb7bH+EbG8ovm253yzc2YpnG4nnmR6mNrTVnLLsy8C1w2xcLRalGndrjJt587aXPejpwwJOT6gMewSLvXLTolHM2O0+Xpfz9X76zJ6oi\\/hn3P3Hc5ZHDCAIAgCAIAgCAIAgCAIAgCAIAgHI+0f9\\/1X5Q\\/crkGp12dfg\\/4On9cWQ9QpsNVQ5F7FQE9AWIUfPMXnZG1SVNSm+Cb9h9u4fTzA0vEHA5bg9K7uYGduw46jlnxEnrA0Ws6qKF7dxqllR8v1I\\/1LoOB704ioJxu30MF6ZO3YN2MjlkTx4GhbKqjOO38dfOj5P5ns8G0wO0afiFnPaGDULvPoXaSM+aQnQkvwS8i2jtLeV+mprs9Z+Z8XhOnOMaTiJycDFun5nlyHkczzHL0x0Mv5JeRl94f\\/fT9kiJrez\\/JXrYVoxdduquoqdWTbkAkgOMOvMDlzB8CcZ0nG18u\\/I34faCqNx67Vs4JtZ+F0+\\/wIydndQ39mtVv5nU6aw\\/oq5b5JgoN6Z+KJLxlKPXvH\\/FGS82rFdfS6MVsRkYdVdWVh61IzMWrakiMozW9F3XNZniD0yUdYRjLQvdT\\/hz\\/ANVP3hNj4EBfjXYzuksjhhAEAQBAEAQBAEAQBAEAQBAEAQDknaL+\\/av8ofuJINTrs6\\/CfwlP64siaQ\\/X9N\\/mKv31nkesu8yrfuan+F+4ytTQgqxqKdxVVtBO0Vsl2nfzeVyoYHxyRyj1VbPv9q+Rr\\/6ipvfs3a7cbcU4zWef9SfKxh4NZTVZUzXUsFVQQjUkk93pgVIdCCN1TjIG7GOeTmeQcYtZ\\/WXZ2GWLpV6tOa6Nq7vmstZu\\/W1tJa5XvlYxldOtekT3zSXRQtobavcsLtM5A2oCwxQ4ydzZbzTpLTk5Pdeensa59pwO9CKScll818iJpO5Bqzbp\\/JNQPl8l2e8tz8hkg+9renPyvTM5Rm7+q+PnvfNGEZQVvWXD\\/wAfkbb2I0qNT8Gl\\/LKgqN3SulcZPUAjaD12qN2Tkzh\\/th0jqUIU73bkraZtq31zLfZ03GEmnlloWx4To9QDtq09uGNZKIpIZcZXcADnmPjnP4rZ+1cDKEZNty0Sbfkyyw+1Klm6dR2Xbl8iDxDs+Qh2ultC5LVamwulQA8pqrxmyhgAemfVLvA1NpdJGhiaTe9o\\/ny8LdzJENp0c5z9Vr8UMv8ANHKMl7DSNfwnSk3e9dWbe7q7\\/aaWA7sFQy97kZcbh9oM+gzoK+zqtGn0ktORv2f9o6eKrRobub4rS\\/d+uRS09ZXnRy0L4HNdefCxTNnAgNetLuZ3SWRwogCAIAgCAIAgCAIAgCAIAgCAIByPtH\\/ftX+UP3EkGp12dfhP4Sn9cWU2uPJZrZLprNmal9TarWG2hEUhWtvr0+CxGQu41s7vgE9CeXOb6NOtWdoK5X4uez8Ek611fRJy928l9ZFxouL6AailFtNpYpUpr0VSbrWYDvXY7WHM8lQDA88lYjZGMnTe5NQstbJs5qe2MPNbkYttvnKyXKzftbv4G0jh2mtsZQNNZbnLjND2DnjLjm3tM5OS+0VKKu3a9r+q+y+nn7TNPDSbStc1riHaDhNWdtQuIJDd1pqgq45c2cDOfDHXE6fC7H2s1+3xNuxKPyfuRX1Mdhl1I3J93GX7ynT8Mprd3oXVbrBtWuo81G3IwfKX2t6zGF2JTi3icfNzmnZPlZ5WWn6+ftTFzlJU6CWl2aRRxS2vh7IuV7\\/X2rYVYKdorpJr3HkoJPU+bzZnTOlCVffeqjl4t\\/IqlOSoqK4vPyyJXC6Aja4VtWitw65mpTUG\\/oFwWsUbCQTnOeWSB1mM23ub1+ss2reWpsgkt9Rt1dE7+ehbcC0S+8dIpAFWqL0XeQu7fZYwov3YzlWVAM8sGcztXGv7x9Gk8nG6772+u5nT7BhGNBzivXj6yfNLrLxjc0oVlWKsMMrFWHmYHBHxgyCdy5KUbrRl0TikHzMD882cCFa9Sx3aWRwggCAIAgCAIAgCAIAgCAIAgCAIByTtMMa7V\\/lL8tdZ\\/jINTrs6\\/BfwlLx97KHVfazWybDiX\\/ZvQV2pVTdULVt1hKqWsXYK6s3WZQgnka1weWZIoYueGzi+s0ik2xhKWJvKf4I38W7Je9mtcK1Zo0GqesAWNqKqBZtG9EZLC21uoztx7Z1lSClXinok3bxOApzcaDa1btfwJvAdIq6zQOhppPeIDt1Lai23ON28JlU3AlceTgMeXKa60m6U07vwsvn7zdSilUhay7nd+PAl9n+H22cJ11aVsXfUclxgvsaknGeuMP7QZoxFenDG096SWTMqNKcsI0lndfAl6fhIsvqrp1dmn1VOgqq1CrWW5KER1VwwGRuQEdMgEHlNWKxkcNQlWqxvC7a+GRthR6Se7CVpWs\\/+TYtN2W0tGlsotG+kO2pc3HylO0DeCmGXCqBy5nJ8+Jzk9r7VxWJpyw1HdTVvXyv4Xv773J0cLh6VJxm7rU+aPVaDSpp+4UbNXYKqzSpJfntLWFzuKqWwQckc+U2ywe18ZUm69VQ3M1u8cuN\\/do\\/YYxq4akoqCvvGbtMPrIA6m\\/TKvr7+vGPZOH2fWrVtpqVWW87tN+DXsudHs9KNTLTdl\\/pZzDjLA6vUkdDqryPV3r4nYS6z72dJh1bD00\\/5Y+5E3iHLTcvX8hmUuqaKb\\/bHd5ZHCCAIAgCAIAgCAIAgCAIAgCAIAgHKu1qY1+p9IrP+2g\\/hIVXrs6vAO+Ep+PvZR6pBgTWybB5s2rsmwD6In7zqz7e\\/TP7O2Qdo1lRjRqS0U033ZlbjU3TrJc4f6X8T52Y7LdzRqKdT3Vq3WAlVLkbV+Cd2AQ2STy6YHPzStufaulTnTlg5KUlrytyvz+mufKYLZzjTcKvEwcNfR6TXX6evTLWKtO1r373ss5IrsF3E4Xa2MDGcdfCX2Ko4jG4FWqOMp204X+uzwI9KdKjWlFRyjncseK9rqq9EmtRHtWx+7VHIRgQbA24jd97PTzzn6P2VdfFyp4uq5qKVteP12dpKqbRUKUZwjqyl4nx2ynVcUatUHd0VlStaBt26qtXZgMsQLWPMkdJ1dPC050qMZZ58XfS7+HxK+pXnCVRrs88viZOyXCNAWpsfUd9qb6X3obw27vKz3qlQMhgpcYY+BOOmIm0MXjqe90dJbkWs72dk+CtbuzWfntw1HDtq8rya+rkDsXwll1tqu++vQtZXWc8t9jMBjw6ByfMcTz7Q4\\/0bZ8qkF60l8Phr3JmOAo71fN5RyL\\/tJxEK4PIrpR76cZ5G0gppavWXO71JmfPfs5hWnLES0WS+u+3mdthKLcHzn6q7tZvwWXezmNOc8ySfEnqT4kzpDo5aZF\\/emaAPPymyXVK69qlzucsjhxAEAQBAEAQBAEAQBAEAQBAEAQDmHbRca63001t\\/D+Eh1euzqNmu+Ej3s13XP5ImplhSWbJ\\/AOIHZ5IJfTWHUBR1sodQmoRfSuEfHoMi4zD+k4aVLjqvr6yuasRSW\\/Z5Ka3b8pLOLffnE3\\/T2B1DoQVIDBsjGD0OZwlLA4ivUdOnBuS1XIoKn7JtTyaNE1lBt4vxBEwWbRWoOYA3GitACeg8ogT7VRkqWCpOeVrXOYlFzxFRR4p\\/Ar9Lw7W6jS08POlspSq0u99isowWsPIMBkjvG5AnOB0myviMNhZTxU5rNJewwhSrVYxpbtrPU3NeC1JqtTe7hxqkFXcsg+D5IYdSXJKrjAGMzjcR9qemoQp4KDdRNarJZ8e9X49uVi4pbPtUlOWjHBuH6LTsr6ejaXwA571iQT0DWHIXl9r5uci47bO2J0ukqQUIRs3256ePd4m+ls+lTb3dSNfVRplNFCB7XdtRtsckIfG+5z8CtQB1648SSZHntPG7ZqxcV0cEmnbjz4f8exEvAbLhCLlLqX14t8o82\\/1ZovHuJizFSOXRXNjWEYOouPJrSPtVA8lF8F9JMtYwhTgqcFZI6zD0XH15KztZL+WPLv4yfF9xWU9Z6SJaGyVDKVDz2IPjYCbeCKypk5PsZ22WJxQgCAIAgCAIAgCAIAgCAIAgCAIBzDt+ca\\/16ZP3rP5ZDrdfwOp2VnhP7n8DUeJWclmiRa0Y5sg6fVvW62VsVdGDKw6gj5x4EdCCQZgm07o3ypxnFwkrp6m0aXV6XV0Wadmahndbe5V0VDYNwPvc2EKFfdnumZcHoTJ2BxEcPUlUjFXaz7bdvzOb2zsqpiIxUndL8XG3DfSzduaT4XSLLs7VotCWDd\\/Ta42ltVWUJUH4KMBs25APInOBz5DFR9pNo47F0+ghTtDi75vw+vnAwmwpUfXpNT7Yu\\/lk\\/IteJcaoKju9RpmOTlW1aVggo6jJGTyYq3IZ8mc1s6NWlW3sTSlOKTSTi3n45E2OCrr\\/ALcl\\/a+ZXLxFGOF1JZ\\/JOzR6c3OSqsuWdlcMTvfmQPDGMS5hjMa1uYWgoLt+St8TZ6DVSvONlzm91e9ckQdbrlrYbrHowR5L6h9TqGOMDFO4108uQ3nlgEDMkxw2IqQccZUunrFJL9bezxJNHCxaulv+G7D\\/ADW3pf2rsuQuG1HVCzIevSo6BwrGy7VWkgIttmMu2SD0CjIwM8xPpU979nTVl8EZ47FRwaUn61RrLK0Yr+mPDlzfF8Czu4HWV+t6ekKBzPdO5U46d7zLevJnl6eevgVH3hi277\\/h+mhRcS7PmuvvkDBQwDKSDgE4Dow+EhOPTzHpx40k8nct8BtKVd9HVXrcHzsZtGcrWR4W1n9oTZwXgbq34u5nbJYnFCAIAgCAIAgCAIAgCAIAgCAIAgHLvdEP2cP8snz3SHX651OyP4T+5\\/A1vXMtaodod2GQDnCjznHM+qRZO5Z0oSqt2dkiNp+MV\\/BvpXH3VYIK\\/wCljz+MTxJGVTDSWdOTv2k1eB03jOntVvxc4YetDzHxT3dfA0+l1KWVWNu39T7TptfpxtqttVfuQ5KfoHK\\/JPVOURKeErO84pvnx9upifiOvHUrnz+9dJn4+7zHSv6S+RmqOF7f80v9wGu1znFllzIRgpuKqc\\/iLhfknkqknxPHSwsc4JJ8\\/wBXmKOzb9VXoOnTHpMxzYljo8WbXwSu3TaSuscu8a0ORnO452+0qAB6ptp03N2vb618Dndp1ozxDl3W9nzJdWktZXYO2wE4HvoKHXeSFAHwQAQASM+TzGTLZYjDwSSa8EUzp1G8yv4havd2B3UA1uvk7tgNlle3Gftsi1s+YiQK06Lp\\/s+a11438NEWGBjV9Jh2FBpEKZVvCxP3xNMHdHT1WpK65P3HbpZHEiAIAgCAIAgCAIAgCAIAgCAIAgHLPdE\\/v6\\/mE\\/8AmkOt1\\/A6bZn8LH\\/G\\/ca3xssO7tXpgDI+1YeB9n8ZDLrBuNpU5a\\/An6HtPSy7NVQreG9VHyj6JsU1+JEers+rF71CduxkxuBcP1IzRaqt1Azgg+ozK0JaMj+k4ug7VY3Rj+oGvr5Vaiwjwy28ewNkCNyaHpWEn1or3e49VjiSHy9r+umr+CiY2muB5JYSXUy8WZDqteceSieHKpSfZmLz5GCpYfnfxMduj4nYCO8ZB+KEUj2qBznqjUPVPCR7fP4knhfBraVs7\\/Ughxki1yRkeOScz3dlF729ZkbGOliUo04Z9iPF3HdOM7r1JwRyoNjE4OG3\\/BY5I+EPCYJr8UU37F7P1Iy2Vi31VZdrXz+Bq\\/F+InUMKqEIBbluOWc\\/dOfAD5AIb3ndlxg8FHBQc5u8vrTtLXXWA9DnDLk+fBE9joZU4tLPkztctDihAEAQBAEAQBAEAQBAEAQBAEAQDnPug6Am83A9KlUjzfD5\\/tSHW650Wyqq6FQa4tryOd3axwrIDyMjLJl7Uob6UouzKY6x15MuR5x19ome4noYLF1aeVVX7UZa9dWfHn6eRmDg0SIYylLRk+ji1ifAusX1WOPkzPLNaHslQn1kn4Im19ptUP8AE2e1s\\/PMt6XM0ywmGf4USNZ2p1BwBqH85ww+ieKU+LNVPBUFduKIN\\/H9Q3wtRb6hYw+YxeRujh8PHSK9hW6nXDq75P4zEn5YUWzOValT4pEJ+JZ5IpPpPITNU+ZGljr5U1cncMtdMsTzIx6p5Jq1keU6FSpLfqvwNk0q\\/Yzt456\\/LPL2gKskqqR3WWhwwgCAIAgCAIAgCAIAgCAIAgCAIBz\\/ALaa0rqXTAK9yhP7UhV1eR0OzaadBS7X8DQ9VoEsyamAP3MhbzTsy+jKUNSNouDb2K2MqYGcZXJAIGckgDmR5z6JsipS6nteS+vq5U4\\/b1CjN0ILena75Lv+RZHsXpzyZieuStoYdMjpVjn64c93WrFef\\/kUs9rV56wiu5P4spOP8EopxXVuDZDElmyBjpjwyT5vtfTPKdbfbad1wdrd5YbKp4jEylOcmorJcM8nw5LnzRbcI4JS+m0ZNas41Ja5j1eoPaCpOeY+B8UmwSlFOx5i61ShXnTc3ord9kyToOztQs07PUpVbtX3oOCHrbd3G4Z5gYXHrmap9hGljZbskpvSNu\\/K\\/wATUOI8M+vWgMQotsCjJwF3naMerEjSnZtF\\/h8LKpSjOUnmk\\/IxV8NQeEwdRkmGBpxLDScNZuSIT7Jg5Nmxyo0i5o4Djnc4Ufcrgt7T0E8bSI8sVOeVNeJYcW4lp6dLtRM4yQM9Tj7YzPdcokFRmqubO1S0OUEAQBAEAQBAEAQBAEAQBAEAQBAOQe6Pcw4hYASPsWo8vymmDqRT3ZxuvP2lthKE3RVSlNxld9qfevrxNAXXOpyf0l\\/iJrlgo1M6Dv2PJlpT2xOhaONhu\\/1LOL+KLLh\\/GipJVjlupGwnpg9RylfXo3tGpHTg7oiQ2BhK854ijWd5tttbrWbbto9LloOJLYMG6wH0sT05dDymhUox0gvBG+l9n6VN3lKU+928lYiPwrPNbQfX1mzpOwuIN01uxjZckW\\/DtM61KuealunpYt\\/H5JZYWSlC3I5XbSl6RvvRpeWRLRXAyc4knIqE3wNeu4Y7OzF0ALFufXBOZTzqRcm0d5h5ThRhDkkvYjMnc1\\/CdSfQBMLt6I9lTnPVmDV9qUQYT6BMlCT1PFQpxzZQani11xwM49HICTqOAm1vNWXN5FdiNr0Kb6Ol60uUc2WPFdPt0g3HJIbPxTfJ0aS9T1nzensIcY4nETvW9RfyrXxfy8j9H1nkPUJmUbPUAQBAEAQBAEAQBAEAQBAEAQBAON+6W39YXf5WofK0jVOsdDs7+HX+J\\/A0FDzkZuzuXlNJqzJdHDjbyWt3IHPYjEgec7Ry9ZkiOPqpbs7SX9Wfnr7yBX2Lgk+kjLoZc4vd8tPZYyngF+CV3nHXKFtvrxzHtmSq4KprFxfZmvrwIe9j6LtSr06q\\/q9V\\/LzI3vXUDmACPQ0y9FoT6lVeOXvNv3pjqeVXDS\\/tal7iXwrX6qm1H7tyoYbl6hkz5Q+L5cTZT2fOMrwnF+JExW2KNek6dSjUXK8dHzN090\\/U2VrTTp1OH3O7L5lwFX1Ekn\\/SJk8PKrG0Wlzu7FfgsVSw1TpJwlJ8N1Xs+fyOeGnUt4EeszV6DCPWqxXjcuFtqvP91hpvvW6fBwmw\\/CcD0DnFsFDWTl3K3vPU9r19Kcaa\\/qd35XJFHB0HXLH0zF4+MP3NNLteb+vabY7ClVzxlaU+xerH5+4nDSgdBgeqR5ValV3m7k6OGoYaO7Rgors+L1fiZe0S\\/Yvxj5Jk9CF+M\\/QGmPkL+SPmk05V6mWDwQBAEAQBAEAQBAEAQBAEAQBAOLe6kfs+38xV\\/GRqvWOi2b+4XezVezfDhqNRXUxIUtliBk7RzbA8\\/wBMiyLStX6Gi5rXh3m76LdXUGrptFZyxxelQrGRtL5YZ6MD1xknljMV6tKi1Ro1YqrfO6b4aLLm8u63Ycq51K83UqptcCWdRexDZ06bThnfV3M1ZVnyR5JBGVIOT0wfACYUsZGM10tXevolHVNLtvnlw7M9RKjeL3Iv68CLxtlsrFrBRclpocouEuwu4OCOW7mOnXr6JvrqG8pQ0kk13FpsevUvKjLNLyat5fEqCORmou75lx2rt3OvoDD5ZvxOqKfYj9Wfea84kUv4ljRw6pqxYatYV25ZkFGwFcb8EnIAw3X0TNQVr2ZHlXqKo4KUL8E73z0+B6bhddY+u16pWwzddORhQWPxDB+Oe7iWqYWJnUfqSi1l\\/Nxy9554ppK6+QTUoxbl3wrAKjIONvU7vZ1myyRH6Sc824tf03+JV9qV+xfb\\/AzOWhFh1zu+hP1uv8hfmEmI5iWrM8HggCAIAgCAIAgCAIAgCAIAgCAcT91I\\/Z935qr5pGq9Y6PZv7hd7NU4TrGptS2s4dDkH2EEeogke2RpFs6aqQcJaM2zTcYodw7BlyymxcseRsGXB8QpbOPDqMATKLpyW7KEb31a5668zncfgMRhY9JGTcbpZeWRYJrdELK8KigEK7d0ueYyzjAydrEjl128vPJtDEQTaqNaZPt8CqWHxNaG9Ti2k7MjcT4otoREGEQscAnDEn4RyebY+fHnkbGSg6t4O6sjoNiYerTpSlVjZt5c7ETIxI5b8Sy7R43g\\/lfOJIxPAp9iaVF2r4lG2JEL9XNg4Zwqh6qzlS7lg5dnCVjlt6MOWc8+fPHTmZOw9KjKN5nL7S2piqNeUYyUUna1le1r72a0\\/wCODMg4ZUBgqhOSOTWbfNn+0zg\\/\\/vRnuYa\\/VkaltHFNfxMP\\/wA\\/7SH2l09NddLI3ltvDJvJCAMcEZJxnrjPjnxmqooK255k3Z2IrVpTU5KSVvWVrX5XSXDxVil435ekf0Q+qSY\\/vDuPCzmmo+epD+yJKWhzE+syVPTEQBAEAQBAEAQBAEAQBAEAQBAOIe6kpOvv\\/N1fuiRavWOk2a\\/2C72afRU3mkeSLim0T6tK\\/wByfimtpk6nUiuJMp07DwPxTGx5KUeBOqobzTJIizmiSunbHSZ2Zoc1ctO0enPknHR3Hy\\/\\/AFJGJWSKPYk7SmuaXl\\/yUD0t5pDaOkjJG0ngVQ6K36b\\/AEzLdKpY2pz8kY24JV9y\\/wCss+meZmaxlTmvYio7QcHrWl2VW3ADBLuftgPE+meq5nTxM5zSbyKrWrs0TE5PIST+E0N\\/tjuXBD9jUfmK\\/wBwSWtDmKnXfeTZ6YCAIAgCAIAgCAIAgCAIAgCAIBw73TdSq8SvBIHkVdT+IDItV+szptmwcsOrc2VvC+MUoPKCk+yaXURY+i1OBY19p6fMPkmLqIzWCmyS3aDTHmCo9onm+mY+i1VqZq+N0edPjE9U0apYeoSdPxmgsvNMbgM59MzU1c0ToVN1vsLHjXG9MV5Oh8vPwh45m6rOLRV7PwtaNXOLWRRtxmj8X4xIzki9WHqFye2el8zfsfzT3pEQlsytzXn8jwe2Wl\\/G+JP5o30ZfddfmvP5ETiXavR2Vsg3ZIHVRjqD5\\/RPVKIhs+vGSbKLVdoaTSa9mfZNm+mj14Sop7zO08DbOmoPnoqP7AktaHL1eu+9k6emAgCAIAgCAIAgCAIAgCAIAgCAR7dFUx3NXWxPiUUk+0ieWMlOS0Z8+p9P3qv9Wn0RZHvST5se8KvvVf6tPojdXI96Wf8AM\\/aPqfT96r\\/Vp9Ebq5Dpan8z9p5PDKPvNX6pPonm7HkeqtUWkn7TweC6Y8zp6P1Nf0RuR5GXpVbTfftZjt4BpG5NpqDn\\/pJ9EOEXwEcTWi7xm\\/azB\\/RPQfgmn\\/VLMeihyNnp+J\\/MftPLdkNAf8JR+rEdDDkZfeWL\\/MftPP8AQ3h\\/4JR+gJ50NPke\\/eeL\\/MftPn9DOH\\/gdH6AnvQw5GL2jin\\/ANx+0+WdiuHEEHR0YPmQA\\/GOYjooch94Yn8x+0vKalRVVQAqgKAOgAGAB7JsIjd3dnuDwQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEAQBAEA\\/\\/9k=\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:22:56'),
(111, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 190)', 'product_images', 223, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxITEhMTEhISFRUVEhUSFxUVEBAWFhIWFxYXFhYVFRcaHSggGBolGxUVITEhJSkrLjAuFx8zODMtNygtLisBCgoKDg0OGxAQGzIlICUtLi0uLS41Mi0vLy0tLy8tLS4tLTEtLS03Ly0tLy0uLTUtLS0tLS0tLS0tLy0tLS0tLf\\/AABEIAOgA2QMBEQACEQEDEQH\\/\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:24:09'),
(112, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 190)', 'product_images', 294, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxITEhMTEhISFRUVEhUSFxUVEBAWFhIWFxYXFhYVFRcaHSggGBolGxUVITEhJSkrLjAuFx8zODMtNygtLisBCgoKDg0OGxAQGzIlICUtLi0uLS41Mi0vLy0tLy8tLS4tLTEtLS03Ly0tLy0uLTUtLS0tLS0tLS0tLy0tLS0tLf\\/AABEIAOgA2QMBEQACEQEDEQH\\/\"}', NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:24:12');
INSERT INTO `activity_logs` (`log_id`, `user_type`, `user_id`, `action_type`, `action_description`, `table_affected`, `record_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(113, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 190)', 'product_images', 295, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxITEhMTEhISFRUVEhUSFxUVEBAWFhIWFxYXFhYVFRcaHSggGBolGxUVITEhJSkrLjAuFx8zODMtNygtLisBCgoKDg0OGxAQGzIlICUtLi0uLS41Mi0vLy0tLy8tLS4tLTEtLS03Ly0tLy0uLTUtLS0tLS0tLS0tLy0tLS0tLf\\/AABEIAOgA2QMBEQACEQEDEQH\\/\"}', '{\"image_url\":\"https:\\/\\/boholgrocery.com\\/wp-content\\/uploads\\/2020\\/11\\/Purefoods-Tender-Juicy-Hotdog-Regular-Classic-230g.png\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:24:41'),
(114, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 189)', 'product_images', 222, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxISEhUSEhMVFRUXFRcVFxUWFR0YFxcVFxUXFxUVFxgYHiggGB0lHRUVITEhJSkrLi4uFx8zODMxNyguLisBCgoKDg0OGxAQGy0lICUvLS8tLzItLy0tMS0tLS0tLS0tLS8tLS0tLy0tLS0vLS0tLS0tLy0tLS0tLS0tLS0tLf\\/AABEIAOEA4QMBEQACEQEDEQH\\/\"}', '{\"image_url\":\"https:\\/\\/imartgrocersph.com\\/wp-content\\/uploads\\/2020\\/09\\/San-Marino-Corned-Tuna-180g.png\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:25:27'),
(115, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 188)', 'product_images', 221, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBxAQDxAQDxAOEBAXEBEPEBUQEBUVEhAWFxIXFxUSGBgYHSggGB0lGxUVIjMhJiorLi8uGCszODM4QystLisBCgoKDg0OGxAQGislICY1LS8tLysrLy0tLS0tLi0tLi0tKysvLy0uKy4tLy8wLS8vKy0tKy0rLi0tLy0tKy0vLv\\/AABEIAOEA4QMBEQACEQEDEQH\\/\"}', '{\"image_url\":\"https:\\/\\/k2pharmacy.ph\\/cdn\\/shop\\/files\\/ArgentinaCornedBeef175g1-fotor-20240627154056.jpg?v=1720416375\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:25:54'),
(116, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 196)', 'product_images', 229, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQ1KqMp2-c8DvxdhkAzrkwsWglNDVk_4n5IRA&s\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:26:32'),
(117, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 198)', 'product_images', 231, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.cdo.com.ph\\/wp-content\\/uploads\\/2024\\/08\\/Copy-of-CDO-KN-CB-150g-3D-DIGIMUP.png\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 02:27:04'),
(118, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 35)', 'product_images', 285, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBw8QEhUQDxAPDxAQFRUPEBUQEA8PEA8PFRUWFhUWFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGC0dIB0tLS0tLSsrLSstLS0rLS0tLS0tLS0tLS0rLS0tLSstLS0tLS0tLSstLS0tLS0tLS0tLf\\/AABEIAM8A9AMBEQACEQEDEQH\\/\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:13:25'),
(119, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 35)', 'product_images', 286, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBw8QEhUQDxAPDxAQFRUPEBUQEA8PEA8PFRUWFhUWFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGC0dIB0tLS0tLSsrLSstLS0rLS0tLS0tLS0tLS0rLS0tLSstLS0tLS0tLSstLS0tLS0tLS0tLf\\/AABEIAM8A9AMBEQACEQEDEQH\\/\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:13:28'),
(120, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 35)', 'product_images', 65, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544244015-0df4b3ffc6b0?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQOdvsn02OpIp6f0198dsEVQvCoLZ76n2Nqbw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:14:17'),
(121, 'admin', 1, 'product_image_update', 'Image URL updated for product (ID: 35)', 'product_images', 287, '{\"image_url\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAkGBw8QEhUQDxAPDxAQFRUPEBUQEA8PEA8PFRUWFhUWFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQGC0dIB0tLS0tLSsrLSstLS0rLS0tLS0tLS0tLS0rLS0tLSstLS0tLS0tLSstLS0tLS0tLS0tLf\\/AABEIAM8A9AMBEQACEQEDEQH\\/\"}', '{\"image_url\":\"https:\\/\\/d1rlzxa98cyc61.cloudfront.net\\/catalog\\/product\\/cache\\/1801c418208f9607a371e61f8d9184d9\\/1\\/8\\/182709_2020_2.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:14:33'),
(122, 'admin', 1, 'product_image_delete', 'Image deleted from product (ID: 36)', 'product_images', 298, '{\"image_url\":\"https:\\/\\/images.samsung.com\\/is\\/image\\/samsung\\/assets\\/ph\\/galaxy-watch6\\/feature\\/galaxy-watch6-safety-mo.jpg\"}', NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:15:27'),
(123, 'admin', 1, 'admin_login', 'Admin logged in: Admin User', 'admin_users', 1, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:38:37'),
(124, 'admin', 1, 'admin_logout', 'Admin logged out', 'admin_users', 1, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:48:32'),
(125, 'admin', 1, 'admin_login', 'Admin logged in: Admin User', 'admin_users', 1, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:53:55'),
(126, 'admin', 1, 'admin_logout', 'Admin logged out', 'admin_users', 1, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 04:56:42'),
(127, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:09:29'),
(128, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:11:17'),
(129, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:21:48'),
(130, 'admin', 2, 'admin_create', 'New admin user created: Ydzz (Ydrian Yayen)', 'admin_users', 3, NULL, '{\"username\":\"Ydzz\",\"email\":\"yayenydrian@gmail.com\",\"role\":\"admin\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:22:37'),
(131, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:22:41'),
(132, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:22:50'),
(133, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 154)', 'product_images', 187, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1527864550417-7fd91fc51a46?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/imgs.search.brave.com\\/RnF2GaNh7uKd6-H5KUW_rb6ptbN8EArD_iG3KfhA594\\/rs:fit:860:0:0:0\\/g:ce\\/aHR0cHM6Ly9jZG4u\\/bW9zLmNtcy5mdXR1\\/cmVjZG4ubmV0L2FZ\\/VTlzS1ZtdDZqQ0dL\\/YlFmeGdkeFYuanBn\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:52:04'),
(134, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 155)', 'product_images', 188, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/imgs.search.brave.com\\/t9RcFIv7q1PjfMm2UI4utPeKIbalPoEooRbURZD2wew\\/rs:fit:860:0:0:0\\/g:ce\\/aHR0cHM6Ly9tLm1l\\/ZGlhLWFtYXpvbi5j\\/b20vaW1hZ2VzL0kv\\/NDFlR25tb0FtY0wu\\/anBn\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:52:40'),
(135, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 156)', 'product_images', 189, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRBoLJiY7n29pPMzEZLI06JJ9kKwp9wSsdGcw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:53:16'),
(136, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 157)', 'product_images', 190, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTVr-63vsawb4q0fAKTKQZgwqIN5gWI5z1zfg&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:53:41'),
(137, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 158)', 'product_images', 191, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRfMR0L37_q3CRwkZWWnR4FOIv8yyKHvVSCKw&s\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:54:03'),
(138, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 159)', 'product_images', 192, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1442726934i\\/4865.jpg\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:54:40'),
(139, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:56:42'),
(140, 'customer', 2, 'cart_add', 'Added product to cart: Google Pixel 8 Pro (Qty: 1)', 'shopping_cart', 14, NULL, '{\"product_id\":39,\"product_name\":\"Google Pixel 8 Pro\",\"quantity\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:56:58'),
(141, 'customer', 2, 'order_create', 'Order created: ORD-20251202-BC9BD637 (Total: ₱50,598.90)', 'orders', 14, NULL, '{\"order_number\":\"ORD-20251202-BC9BD637\",\"total\":50598.9000000000014551915228366851806640625,\"items_count\":1}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:57:17'),
(142, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251202-BC9BD637 via Credit Card', 'payments', 14, NULL, '{\"transaction_id\":\"TXN-20251202135748-E1BDC18E\",\"amount\":\"50598.00\",\"payment_method\":\"Credit Card\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:57:48'),
(143, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251202-BC9BD637 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251202-BC9BD637\"}', '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 05:57:50'),
(144, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:11:04'),
(145, 'admin', 2, 'admin_create', 'New admin user created: adminigger (Baba Boui)', 'admin_users', 4, NULL, '{\"username\":\"adminigger\",\"email\":\"andrepagliawan0@gmail.com\",\"role\":\"admin\"}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:12:10'),
(146, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:12:32'),
(147, 'admin', 4, 'admin_login', 'Admin logged in: Baba Boui', 'admin_users', 4, NULL, NULL, '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:12:50'),
(148, 'admin', 4, 'settings_update', 'Site settings updated: currency_symbol: ₱ → ₱, enable_reviews: 1 → 1, free_shipping_threshold: 49.9 → 49.9, items...', 'site_settings', NULL, NULL, '{\"total_updates\":19}', '175.176.75.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:36:28'),
(149, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '112.202.115.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 06:37:35'),
(150, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:28:31'),
(151, 'admin', 3, 'settings_update', 'Site settings updated: currency_symbol: ₱ → ₱, enable_reviews: 1 → 1, free_shipping_threshold: 49.9 → 49.9, items...', 'site_settings', NULL, NULL, '{\"total_updates\":19}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:28:58'),
(152, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:29:11'),
(153, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:29:21'),
(154, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:29:32'),
(155, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:30:17'),
(156, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:30:31'),
(157, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:39:30'),
(158, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:42:36'),
(159, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:49:37'),
(160, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:53:16'),
(161, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:53:20'),
(162, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:56:44'),
(163, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 10:56:48'),
(164, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:03:31'),
(165, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:03:41'),
(166, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:04:32'),
(167, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:04:45'),
(168, 'admin', 3, 'settings_update', 'Site settings updated: currency_symbol: ₱ → ₱, enable_reviews: 1 → 1, free_shipping_threshold: 49.9 → 49.9, items...', 'site_settings', NULL, NULL, '{\"total_updates\":19}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:04:54'),
(169, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:08:07'),
(170, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:08:20'),
(171, 'admin', 3, 'settings_update', 'Site settings updated: currency_symbol: ₱ → ₱, enable_reviews: 1 → 1, free_shipping_threshold: 49.9 → 49.9, items...', 'site_settings', NULL, NULL, '{\"total_updates\":19}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:08:34'),
(172, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:08:50'),
(173, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:08:59'),
(174, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:09:06'),
(175, 'admin', 3, 'settings_update', 'Site settings updated: currency_symbol: ₱ → ₱, enable_reviews: 1 → 1, free_shipping_threshold: 49.9 → 49.9, items...', 'site_settings', NULL, NULL, '{\"total_updates\":19}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:09:59'),
(176, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:10:39'),
(177, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:10:47'),
(178, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:14:44'),
(179, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:14:59'),
(180, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:20:16'),
(181, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 11:20:52'),
(182, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:19:12'),
(183, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:19:47'),
(184, 'admin', 2, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:20:07'),
(185, 'admin', 2, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:21:00'),
(186, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:25:00'),
(187, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:25:42'),
(188, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:28:23'),
(189, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:30:04'),
(190, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:38:51'),
(191, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.106.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:39:04'),
(192, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:57:08'),
(193, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 12:57:37'),
(194, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:01:37'),
(195, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:02:55'),
(196, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:03:45'),
(197, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:04:03'),
(198, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:13:49'),
(199, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:13:54'),
(200, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:20:45'),
(201, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.105.114', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-02 13:21:12'),
(202, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 02:47:17'),
(203, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 02:52:28'),
(204, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 03:07:53'),
(205, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 03:58:06'),
(206, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 03:58:47'),
(207, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:38:37'),
(208, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:46:18'),
(209, 'admin', 4, 'admin_login', 'Admin logged in: Baba Boui', 'admin_users', 4, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:46:35'),
(210, 'admin', 4, 'product_update', 'Product updated: Razer BlackWidow V4 Pro', 'products', 125, NULL, '{\"product_name\":\"Razer BlackWidow V4 Pro\",\"price\":12999,\"sku\":\"SPRT-RAZR-BW4PRO\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:47:20'),
(211, 'admin', 4, 'product_update', 'Product updated: Garmin Forerunner 955', 'products', 126, NULL, '{\"product_name\":\"Garmin Forerunner 955\",\"price\":34999,\"sku\":\"SPRT-GARM-FR955\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:05'),
(212, 'admin', 4, 'product_update', 'Product updated: HyperX Cloud Alpha', 'products', 127, NULL, '{\"product_name\":\"HyperX Cloud Alpha\",\"price\":6999,\"sku\":\"SPRT-HYPR-CLDA\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:13'),
(213, 'admin', 4, 'product_update', 'Product updated: Corsair Vengeance RAM', 'products', 128, NULL, '{\"product_name\":\"Corsair Vengeance RAM\",\"price\":8999,\"sku\":\"SPRT-CORS-VEN32\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:21'),
(214, 'admin', 4, 'product_update', 'Product updated: Logitech G502 X Plus', 'products', 129, NULL, '{\"product_name\":\"Logitech G502 X Plus\",\"price\":9999,\"sku\":\"SPRT-LOGI-G502X\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:33'),
(215, 'admin', 4, 'product_update', 'Product updated: Logitech G502 X Plus', 'products', 129, NULL, '{\"product_name\":\"Logitech G502 X Plus\",\"price\":9999,\"sku\":\"SPRT-LOGI-G502X\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:41'),
(216, 'admin', 4, 'product_update', 'Product updated: SteelSeries Arctis Nova Pro', 'products', 130, NULL, '{\"product_name\":\"SteelSeries Arctis Nova Pro\",\"price\":19999,\"sku\":\"SPRT-STEL-ANOVA\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:47'),
(217, 'admin', 4, 'product_update', 'Product updated: SteelSeries Arctis Nova Pro', 'products', 130, NULL, '{\"product_name\":\"SteelSeries Arctis Nova Pro\",\"price\":19999,\"sku\":\"SPRT-STEL-ANOVA\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:53'),
(218, 'admin', 4, 'product_update', 'Product updated: ASUS ROG Strix Monitor', 'products', 131, NULL, '{\"product_name\":\"ASUS ROG Strix Monitor\",\"price\":49999,\"sku\":\"SPRT-ASUS-ROG27\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:48:59'),
(219, 'admin', 4, 'product_update', 'Product updated: ASUS ROG Strix Monitor', 'products', 131, NULL, '{\"product_name\":\"ASUS ROG Strix Monitor\",\"price\":49999,\"sku\":\"SPRT-ASUS-ROG27\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:49:05'),
(220, 'admin', 4, 'product_update', 'Product updated: NZXT Kraken AIO Cooler', 'products', 132, NULL, '{\"product_name\":\"NZXT Kraken AIO Cooler\",\"price\":8999,\"sku\":\"SPRT-NZXT-KRK240\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:11'),
(221, 'admin', 4, 'product_update', 'Product updated: EVGA Supernova PSU', 'products', 133, NULL, '{\"product_name\":\"EVGA Supernova PSU\",\"price\":9999,\"sku\":\"SPRT-EVGA-SN850\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:25'),
(222, 'admin', 4, 'product_update', 'Product updated: Samsung 980 Pro SSD', 'products', 134, NULL, '{\"product_name\":\"Samsung 980 Pro SSD\",\"price\":12999,\"sku\":\"SPRT-SAMS-980P2T\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:32'),
(223, 'admin', 4, 'product_update', 'Product updated: Cooler Master Case', 'products', 135, NULL, '{\"product_name\":\"Cooler Master Case\",\"price\":6999,\"sku\":\"SPRT-CMST-MT500\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:39'),
(224, 'admin', 4, 'product_update', 'Product updated: Thrustmaster T300RS', 'products', 136, NULL, '{\"product_name\":\"Thrustmaster T300RS\",\"price\":19999,\"sku\":\"SPRT-THRU-T300RS\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:45'),
(225, 'admin', 4, 'product_update', 'Product updated: Elgato Stream Deck', 'products', 137, NULL, '{\"product_name\":\"Elgato Stream Deck\",\"price\":6999,\"sku\":\"SPRT-ELGT-SDECK15\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:50:54'),
(226, 'admin', 4, 'product_update', 'Product updated: Blue Yeti Microphone', 'products', 138, NULL, '{\"product_name\":\"Blue Yeti Microphone\",\"price\":8999,\"sku\":\"SPRT-BLUE-YETI-BLK\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:51:07'),
(227, 'admin', 4, 'product_update', 'Product updated: Logitech C920 Webcam', 'products', 139, NULL, '{\"product_name\":\"Logitech C920 Webcam\",\"price\":4999,\"sku\":\"SPRT-LOGI-C920HD\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:51:22'),
(228, 'admin', 4, 'product_update', 'Product updated: Razer Viper V2 Pro', 'products', 140, NULL, '{\"product_name\":\"Razer Viper V2 Pro\",\"price\":9999,\"sku\":\"SPRT-RAZR-VP2PRO\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:51:37'),
(229, 'admin', 4, 'product_update', 'Product updated: SteelSeries QcK Mousepad', 'products', 141, NULL, '{\"product_name\":\"SteelSeries QcK Mousepad\",\"price\":1999,\"sku\":\"SPRT-STEL-QCKXXL\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:51:43'),
(230, 'admin', 4, 'product_update', 'Product updated: Corsair K100 Keyboard', 'products', 142, NULL, '{\"product_name\":\"Corsair K100 Keyboard\",\"price\":14999,\"sku\":\"SPRT-CORS-K100\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:52:06'),
(231, 'admin', 4, 'product_update', 'Product updated: HyperX Pulsefire Mouse', 'products', 143, NULL, '{\"product_name\":\"HyperX Pulsefire Mouse\",\"price\":3999,\"sku\":\"SPRT-HYPR-PULSE\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:52:12'),
(232, 'admin', 4, 'product_update', 'Product updated: NVIDIA RTX 4080', 'products', 144, NULL, '{\"product_name\":\"NVIDIA RTX 4080\",\"price\":89999,\"sku\":\"SPRT-NVDA-408016\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:52:17'),
(233, 'admin', 4, 'product_update', 'Product updated: AMD Ryzen 9 7950X', 'products', 145, NULL, '{\"product_name\":\"AMD Ryzen 9 7950X\",\"price\":49999,\"sku\":\"SPRT-AMD-R97950\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:52:24'),
(234, 'admin', 4, 'product_update', 'Product updated: AMD Ryzen 9 7950X', 'products', 145, NULL, '{\"product_name\":\"AMD Ryzen 9 7950X\",\"price\":49999,\"sku\":\"SPRT-AMD-R97950\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 04:53:28'),
(235, 'admin', 4, 'product_update', 'Product updated: Intel Core i9-14900K', 'products', 146, NULL, '{\"product_name\":\"Intel Core i9-14900K\",\"price\":45999,\"sku\":\"SPRT-INTL-I914900\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:02:10'),
(236, 'admin', 4, 'product_update', 'Product updated: Intel Core i9-14900K', 'products', 146, NULL, '{\"product_name\":\"Intel Core i9-14900K\",\"price\":45999,\"sku\":\"SPRT-INTL-I914900\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:02:28'),
(237, 'admin', 4, 'product_update', 'Product updated: ASUS ROG Motherboard', 'products', 147, NULL, '{\"product_name\":\"ASUS ROG Motherboard\",\"price\":29999,\"sku\":\"SPRT-ASUS-Z790E\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:02:34'),
(238, 'admin', 4, 'product_image_update', 'Image URL updated for product (ID: 147)', 'product_images', 180, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/dlcdnwebimgs.asus.com\\/gain\\/C2A10896-76C0-4772-9A3A-69D7B0C00441\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:03:08'),
(239, 'admin', 4, 'product_update', 'Product updated: G.Skill Trident RAM', 'products', 148, NULL, '{\"product_name\":\"G.Skill Trident RAM\",\"price\":15999,\"sku\":\"SPRT-GSKL-TRI64\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:03:26'),
(240, 'admin', 4, 'product_update', 'Product updated: Seagate FireCuda SSD', 'products', 149, NULL, '{\"product_name\":\"Seagate FireCuda SSD\",\"price\":19999,\"sku\":\"SPRT-SEAG-FC4TB\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:03:34'),
(241, 'admin', 4, 'product_update', 'Product updated: be quiet! Dark Rock 4', 'products', 150, NULL, '{\"product_name\":\"be quiet! Dark Rock 4\",\"price\":5999,\"sku\":\"SPRT-BQUI-DRK4\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:03:39'),
(242, 'admin', 4, 'product_update', 'Product updated: Lian Li Case Fans', 'products', 151, NULL, '{\"product_name\":\"Lian Li Case Fans\",\"price\":3999,\"sku\":\"SPRT-LIAN-FAN3PK\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:03:46'),
(243, 'admin', 4, 'product_image_update', 'Image URL updated for product (ID: 152)', 'product_images', 185, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1592417817098-8fd3d9eb14a5?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/bermorzone.com.ph\\/wp-content\\/uploads\\/2022\\/06\\/fractal-nano-5-600x450.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:07:23'),
(244, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:08:08'),
(245, 'admin', 4, 'product_update', 'Product updated: MSI Gaming Monitor', 'products', 153, NULL, '{\"product_name\":\"MSI Gaming Monitor\",\"price\":29999,\"sku\":\"SPRT-MSI-MON32Q\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:08:49'),
(246, 'admin', 4, 'product_update', 'Product updated: Glorious Model O Mouse', 'products', 154, NULL, '{\"product_name\":\"Glorious Model O Mouse\",\"price\":5999,\"sku\":\"SPRT-GLOR-MODELO\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:08:58'),
(247, 'admin', 4, 'product_update', 'Product updated: Yeti Tundra 45 Cooler', 'products', 23, NULL, '{\"product_name\":\"Yeti Tundra 45 Cooler\",\"price\":19999,\"sku\":\"SPRT-YETI-T45-WHT\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:10'),
(248, 'admin', 4, 'product_update', 'Product updated: Trek Marlin 7 Mountain Bike', 'products', 24, NULL, '{\"product_name\":\"Trek Marlin 7 Mountain Bike\",\"price\":32999,\"sku\":\"SPRT-TREK-M7-BLU-M\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:16'),
(249, 'admin', 4, 'product_update', 'Product updated: Trek Marlin 7 Mountain Bike', 'products', 24, NULL, '{\"product_name\":\"Trek Marlin 7 Mountain Bike\",\"price\":32999,\"sku\":\"SPRT-TREK-M7-BLU-M\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:23'),
(250, 'admin', 4, 'product_update', 'Product updated: Coleman Sundome Tent 4-Person', 'products', 25, NULL, '{\"product_name\":\"Coleman Sundome Tent 4-Person\",\"price\":4999,\"sku\":\"SPRT-COLM-SD4-GRN\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:30'),
(251, 'admin', 4, 'product_update', 'Product updated: Bowflex SelectTech 552 Dumbbells', 'products', 27, NULL, '{\"product_name\":\"Bowflex SelectTech 552 Dumbbells\",\"price\":24999,\"sku\":\"SPRT-BWFX-ST552\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:39'),
(252, 'admin', 4, 'product_update', 'Product updated: GoPro HERO12 Black', 'products', 28, NULL, '{\"product_name\":\"GoPro HERO12 Black\",\"price\":21999,\"sku\":\"SPRT-GPRO-H12-BLK\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:46'),
(253, 'admin', 4, 'product_update', 'Product updated: Wilson Evolution Basketball', 'products', 29, NULL, '{\"product_name\":\"Wilson Evolution Basketball\",\"price\":2499,\"sku\":\"SPRT-WILS-EVO-BBAL\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:09:51'),
(254, 'admin', 4, 'product_update', 'Product updated: Fractal Design Case', 'products', 152, NULL, '{\"product_name\":\"Fractal Design Case\",\"price\":7999,\"sku\":\"SPRT-FRAC-DESIGN\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:10:05'),
(255, 'customer', 5, 'register', 'New customer registered: lick mahballs (andrepagliawan0@gmail.com)', 'customers', 5, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:04'),
(256, 'customer', 5, 'email_sent', 'Welcome email sent to andrepagliawan0@gmail.com', NULL, NULL, NULL, '{\"to\":\"andrepagliawan0@gmail.com\",\"subject\":\"Welcome to JRD Malls\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:05'),
(257, 'customer', 5, 'login', 'Customer logged in successfully', 'customers', 5, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:32'),
(258, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:38'),
(259, 'admin', 4, 'customer_status_change', 'Customer deactivated: Andre Pagliawan (andrepagliawan@gmail.com)', 'customers', 4, '{\"is_active\":1}', '{\"is_active\":0}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:40'),
(260, 'admin', 4, 'customer_status_change', 'Customer activated: Andre Pagliawan (andrepagliawan@gmail.com)', 'customers', 4, '{\"is_active\":0}', '{\"is_active\":1}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:46'),
(261, 'admin', 4, 'customer_status_change', 'Customer deactivated: lick mahballs (andrepagliawan0@gmail.com)', 'customers', 5, '{\"is_active\":1}', '{\"is_active\":0}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:14:51');
INSERT INTO `activity_logs` (`log_id`, `user_type`, `user_id`, `action_type`, `action_description`, `table_affected`, `record_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(262, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:15:33'),
(263, 'customer', 5, 'cart_add', 'Added product to cart: Apple iPad Air 5th Gen (Qty: 1)', 'shopping_cart', 15, NULL, '{\"product_id\":35,\"product_name\":\"Apple iPad Air 5th Gen\",\"quantity\":1}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:15:48'),
(264, 'customer', 5, 'cart_update', 'Updated cart for product: Apple iPad Air 5th Gen (New Qty: 2)', 'shopping_cart', 15, NULL, '{\"product_id\":35,\"product_name\":\"Apple iPad Air 5th Gen\",\"quantity\":2}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:15:51'),
(265, 'customer', 5, 'address_add', 'New billing address added: asdfasdf, dfcvzxcv', 'addresses', 4, NULL, '{\"address_type\":\"billing\",\"city\":\"asdfasdf\",\"state_province\":\"dfcvzxcv\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:16:44'),
(266, 'customer', 5, 'profile_update', 'Profile information updated', 'customers', 5, '{\"first_name\":\"lick\",\"last_name\":\"mahballs\",\"phone\":\"09999999999\",\"date_of_birth\":null}', '{\"first_name\":\"lick\",\"last_name\":\"mahballs\",\"phone\":\"09999999999\",\"date_of_birth\":null}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:16:53'),
(267, 'customer', 5, 'address_add', 'New billing address added: asdfasdf, dfcvzxcv', 'addresses', 5, NULL, '{\"address_type\":\"billing\",\"city\":\"asdfasdf\",\"state_province\":\"dfcvzxcv\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:17:00'),
(268, 'customer', 5, 'order_create', 'Order created: ORD-20251203-B9B1255F (Total: ₱70,397.80)', 'orders', 15, NULL, '{\"order_number\":\"ORD-20251203-B9B1255F\",\"total\":70397.800000000002910383045673370361328125,\"items_count\":1}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:17:21'),
(269, 'customer', 5, 'payment_complete', 'Payment completed for order ORD-20251203-B9B1255F via Cash on Delivery', 'payments', 15, NULL, '{\"transaction_id\":\"COD-ORD-20251203-B9B1255F\",\"amount\":\"70397.00\",\"payment_method\":\"Cash on Delivery\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:17:25'),
(270, 'customer', 5, 'email_sent', 'Order confirmation email sent: ORD-20251203-B9B1255F to andrepagliawan0@gmail.com', NULL, NULL, NULL, '{\"to\":\"andrepagliawan0@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251203-B9B1255F\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 05:17:26'),
(271, 'admin', 4, 'product_image_update', 'Image URL updated for product (ID: 199)', 'product_images', 232, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQ-ogKkL0ggdXAzfqBz-g4-F1RGHQo_gX7Kng&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:08:48'),
(272, 'admin', 4, 'product_image_update', 'Image URL updated for product (ID: 200)', 'product_images', 233, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/megaprimefoods.com.ph\\/wp-content\\/uploads\\/2021\\/03\\/Mega-Sardines-in-Natural-Oil-155G.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:09:19'),
(273, 'admin', 4, 'product_image_update', 'Image URL updated for product (ID: 201)', 'product_images', 234, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/zbga.shopsuki.ph\\/cdn\\/shop\\/files\\/4800088135276_1024x.jpg?v=1734520275\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:09:57'),
(274, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:11:58'),
(275, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:12:29'),
(276, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 185)', 'product_images', 218, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1563636619-e9143da7973b?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.nidolove.com\\/sites\\/default\\/files\\/2025-08\\/NIDO-Fortified_2.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:04'),
(277, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 203)', 'product_images', 236, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/happyhour.ph\\/cdn\\/shop\\/products\\/happy-classic-peanuts-real-garlic-chips-100g-238702.jpg?v=1708590954\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:12'),
(278, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 204)', 'product_images', 237, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1589923186741-b7d59d6b2c4a?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:56'),
(279, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 204)', 'product_images', 237, '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:56'),
(280, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 204)', 'product_images', 237, '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:56'),
(281, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 204)', 'product_images', 237, '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684714674504\\/f091213c278bdab2cf5839bfa7af9729_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:13:57'),
(282, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 221)', 'product_images', 254, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images-cdn.ubuy.co.in\\/64f2c80cd687761f82030a46-96-packs-maggi-magic-sarap-all-in-one.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:15:10'),
(283, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 225)', 'product_images', 258, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.nestleprofessional.ph\\/sites\\/default\\/files\\/styles\\/np_product_detail\\/public\\/2023-03\\/Classic%2092g_0.png?itok=JexqKFCi\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:15:54'),
(284, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 226)', 'product_images', 259, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684702535617\\/402eafa1a500ddc43d4e01a7332d0388_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:16:38'),
(285, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 227)', 'product_images', 260, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61wGQXIupHL._SL1418_.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:16:58'),
(286, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 228)', 'product_images', 261, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/shopmetro.ph\\/basak-supermarket\\/wp-content\\/uploads\\/2025\\/08\\/SM9083975-5.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:17:21'),
(287, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 229)', 'product_images', 262, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/shopmetro.ph\\/lapulapu-supermarket\\/wp-content\\/uploads\\/2023\\/10\\/SM9198577-3.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:17:45'),
(288, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 230)', 'product_images', 263, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/gringo.ph\\/cdn\\/shop\\/products\\/Royal1.5Lcopy_720x.jpg?v=1627978246\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:18:12'),
(289, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 231)', 'product_images', 264, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/happyhour.ph\\/cdn\\/shop\\/products\\/mountain-dew-15l-617347.jpg?v=1708591289\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:18:50'),
(290, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 232)', 'product_images', 265, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/gringo.ph\\/cdn\\/shop\\/products\\/Sprite1.5Lcopy_720x.jpg?v=1627978183\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:19:09'),
(291, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 233)', 'product_images', 266, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/C2AppleGreenTea16.91fl.oz_500ml_1080x.png?v=1614379411\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:19:33'),
(292, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 234)', 'product_images', 267, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544145945-35046820424e?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcQn4BYaEXgyQkpYRcgWHxRFj_uf-ZBf1f04-A&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:19:57'),
(293, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 205)', 'product_images', 238, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcT-8c5n-_OYy1_GdUcNgPgi0t_cDTzpPxmVAw&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:20:45'),
(294, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 206)', 'product_images', 239, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/00039000086639\\/9ad0f1ed7e4eff6c6e844e68dc1e42a8_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:21:05'),
(295, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 207)', 'product_images', 240, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71a0amqwAsL._SL1500_.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:21:36'),
(296, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 208)', 'product_images', 241, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/3683\\/a2ada672b52c5d72552c60c995dc2135_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:22:03'),
(297, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 209)', 'product_images', 242, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/pampangasbest.store\\/cdn\\/shop\\/products\\/Tocino-220g-1.jpg?v=1633569805\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:22:28'),
(298, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 210)', 'product_images', 243, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/store.iloilosupermart.com\\/wp-content\\/uploads\\/2020\\/05\\/is-104.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:22:55'),
(299, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 211)', 'product_images', 244, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.cdo.com.ph\\/wp-content\\/uploads\\/2022\\/05\\/Funtastyk-pork-tocino-450g-digital-mockup.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:23:21'),
(300, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 212)', 'product_images', 245, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/images.freshop.ncrcloud.com\\/1564405684702504564\\/aae559881703949dda5507b07f8cff6c_large.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:23:45'),
(301, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 213)', 'product_images', 246, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/shopmetro.ph\\/marketmarket-supermarket\\/wp-content\\/uploads\\/2021\\/03\\/SM10062286-1.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:24:35'),
(302, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 214)', 'product_images', 247, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1562843467-e0e689b3d98d?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/files\\/20250107-125923_1200x.jpg?v=1742828761\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:25:07'),
(303, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 235)', 'product_images', 268, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSJRyQYVlJ_CoVCyvkNVXR4zFVEAivWC-jA9A&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:26:14'),
(304, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 236)', 'product_images', 269, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:27:09'),
(305, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 236)', 'product_images', 269, '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:27:09'),
(306, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 236)', 'product_images', 269, '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:27:10'),
(307, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 236)', 'product_images', 269, '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/SilverSwanSoySauce1L_1080x.png?v=1616007859\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:27:10'),
(308, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 237)', 'product_images', 270, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcRKCaHP8tJ7hyAp_1pny0djn0kzihPVYI6g8A&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:27:42'),
(309, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 238)', 'product_images', 271, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/shopmetro.ph\\/mandaluyong-supermarket\\/wp-content\\/uploads\\/2021\\/03\\/SM9863781-1.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:31:05'),
(310, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 239)', 'product_images', 272, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSHlNs4jEy-dU6IPWmfdxS5T86AQfLW1D9MQw&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:31:37'),
(311, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 240)', 'product_images', 273, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71mtKreJmtL._SL1500_.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:31:57'),
(312, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 241)', 'product_images', 274, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd58266d93de5d14102f7e07cf?_a=BAVAfVDW0\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:33:12'),
(313, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 242)', 'product_images', 275, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/pinoygroseri.com\\/cdn\\/shop\\/products\\/UFCBananaSauceHot_Spicy_BIG_19.40oz_500g_180x.jpg?v=1619725601\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:33:42'),
(314, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 243)', 'product_images', 276, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1563805042-7684c019e1cb?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/assets.unileversolutions.com\\/v1\\/130205778.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:34:04'),
(315, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 244)', 'product_images', 277, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1596040033221-a9816a92c3c1?w=800&q=80\"}', '{\"image_url\":\"Magi Magic Sarap\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:34:20'),
(316, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 244)', 'product_images', 277, '{\"image_url\":\"Magi Magic Sarap\"}', '{\"image_url\":\"https:\\/\\/www.nestleprofessional.ph\\/sites\\/default\\/files\\/styles\\/np_product_detail\\/public\\/2023-03\\/MAGGI%20Magic%20Sarap%208g.jpg?itok=oiR3Lr6c\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:35:00'),
(317, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 241)', 'product_images', 274, '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd5826\"}', '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd58266d93de5d14102f7e07cf?_a=BAVAfVDW0\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:35:28'),
(318, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 241)', 'product_images', 274, '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd5826\"}', '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd58266d93de5d14102f7e07cf?_a=BAVAfVDW0\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:35:44'),
(319, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 241)', 'product_images', 274, '{\"image_url\":\"https:\\/\\/res.cloudinary.com\\/kraft-heinz-whats-cooking-ca\\/image\\/upload\\/f_auto\\/q_auto\\/r_8\\/c_limit,w_3840\\/f_auto\\/q_auto\\/v1\\/dxp-images\\/heinz\\/products\\/00013000004664-tomato-ketchup\\/marketing-view-color-front_168cec44f198afb40bc1a563ff1cafe98c9fce51_205141dd5826\"}', '{\"image_url\":\"https:\\/\\/i5.walmartimages.com\\/asr\\/5874137b-683e-4cf2-829b-a675d35b0034.317f22b7ca16845bd14b2881bb99b151.jpeg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:36:04'),
(320, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 160)', 'product_images', 193, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/www.kobo.com\\/ph\\/en\\/ebook\\/the-subtle-art-of-not-giving-a-f-ck?srsltid=AfmBOook0Kqf1ZAej-A8ka63Isnvo6T51yFDo3HHKDeqSR4m1GP1LBUG\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:38:52'),
(321, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 160)', 'product_images', 193, '{\"image_url\":\"https:\\/\\/www.kobo.com\\/ph\\/en\\/ebook\\/the-subtle-art-of-not-giving-a-f-ck?srsltid=AfmBOook0Kqf1ZAej-A8ka63Isnvo6T51yFDo3HHKDeqSR4m1GP1LBUG\"}', '{\"image_url\":\"https:\\/\\/cdn.kobo.com\\/book-images\\/f68de379-e763-441c-8159-a949ea575237\\/1200\\/1200\\/False\\/the-subtle-art-of-not-giving-a-f-ck.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:39:15'),
(322, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 161)', 'product_images', 194, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/growthsummary.com\\/wp-content\\/uploads\\/2024\\/06\\/107.png\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:40:43'),
(323, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 162)', 'product_images', 195, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/static.wixstatic.com\\/media\\/8cc233_da3154cf2cdd4e979a841903fb3cf770~mv2.jpg\\/v1\\/fill\\/w_1585,h_2400,al_c,q_90\\/The%20Alchemist%20cover.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:42:03'),
(324, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 163)', 'product_images', 196, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"Man\'s Search for Meaning\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:42:25'),
(325, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 163)', 'product_images', 196, '{\"image_url\":\"Man\'s Search for Meaning\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1535419394i\\/4069.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:42:48'),
(326, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 164)', 'product_images', 197, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.kobo.com\\/book-images\\/5d4336ab-8c48-407f-8496-906eff1cd352\\/1200\\/1200\\/False\\/the-48-laws-of-power.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:45:16'),
(327, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 165)', 'product_images', 198, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/imgv2-1-f.scribdassets.com\\/img\\/document\\/527639903\\/original\\/91cc892fe7\\/1?v=1\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:45:37'),
(328, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 166)', 'product_images', 199, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcTeE93lZOuN7XNrBB2uUNF6RobuMsjEV2_VQg&s\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:46:27'),
(329, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 167)', 'product_images', 200, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.kobo.com\\/book-images\\/4684126b-8238-46f1-86d4-f5d860450e22\\/1200\\/1200\\/False\\/the-intelligent-investor-rev-ed.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:46:56'),
(330, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 168)', 'product_images', 201, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1436227012i\\/40745.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:47:30'),
(331, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 169)', 'product_images', 202, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/71Ha3OShqSL.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:48:01'),
(332, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 170)', 'product_images', 203, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/jamesclear.com\\/wp-content\\/uploads\\/2020\\/11\\/clear-habit-journal_gallery_hi-res_07.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:48:51'),
(333, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 171)', 'product_images', 204, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/61R1UgGxaLL._AC_UF1000,1000_QL80_.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:49:12'),
(334, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 172)', 'product_images', 205, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/simonsinek.com\\/wp-content\\/uploads\\/2022\\/02\\/StartwithWHY-680x1024.jpeg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:49:35'),
(335, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 173)', 'product_images', 206, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/jamesclear.com\\/wp-content\\/uploads\\/2016\\/06\\/The10xRule-by-GrantCardone-1.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:50:05'),
(336, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 174)', 'product_images', 207, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/I\\/81VpFFpZTtL._SL1500_.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:51:10'),
(337, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 175)', 'product_images', 208, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1630683326i\\/10534.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:51:32'),
(338, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 176)', 'product_images', 209, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1691172738i\\/195589455.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:52:01'),
(339, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 177)', 'product_images', 210, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/ph-test-11.slatic.net\\/p\\/5c77bc1e0839d749f3f4786b8500eef8.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:52:46'),
(340, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 178)', 'product_images', 211, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/cdn.kobo.com\\/book-images\\/ffa72d39-404c-4982-8931-65b2821eb4b0\\/1200\\/1200\\/False\\/extreme-ownership-3.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:53:14'),
(341, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 179)', 'product_images', 212, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/jamesclear.com\\/wp-content\\/uploads\\/2016\\/03\\/TheCompoundEffect-by-DarrenHardy.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:53:39'),
(342, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 180)', 'product_images', 213, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1390169859i\\/3828902.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:57:13'),
(343, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 181)', 'product_images', 214, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/gregmckeown.com\\/wp-content\\/uploads\\/2011\\/08\\/book-1225x1600.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:57:54'),
(344, 'admin', 2, 'product_image_update', 'Image URL updated for product (ID: 182)', 'product_images', 215, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/d-pdf.com\\/images\\/covers\\/2021\\/December\\/61aba71d49887\\/9781760630737.jpg\"}', '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 06:58:17'),
(345, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 183)', 'product_images', 216, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1643265644i\\/60222658.jpg\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:18:55'),
(346, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 184)', 'product_images', 217, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1545910967i\\/37502596.jpg\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:19:17'),
(347, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 30)', 'product_images', 59, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1544947950-fa07a98d237f?w=800\"}', '{\"image_url\":\"https:\\/\\/cdn2.penguin.com.au\\/covers\\/original\\/9781847941831.jpg\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:19:35'),
(348, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 32)', 'product_images', 61, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1512820790803-83ca734da794?w=800\"}', '{\"image_url\":\"https:\\/\\/m.media-amazon.com\\/images\\/S\\/compressed.photo.goodreads.com\\/books\\/1506026635i\\/35133922.jpg\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:20:03'),
(349, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 33)', 'product_images', 62, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1553729459-efe14ef6055d?w=800\"}', '{\"image_url\":\"https:\\/\\/cdn.kobo.com\\/book-images\\/5c5e77cc-1fb9-410b-a735-de95a9a5dd40\\/1200\\/1200\\/False\\/the-lean-startup-1.jpg\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:20:23'),
(350, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 34)', 'product_images', 63, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1495446815901-a7297e633e8d?w=800\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcToSXjIlW6SQN-6-9L8CbqtAG2GdaAoBuG9cg&s\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:20:40'),
(351, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 170)', 'product_images', 203, '{\"image_url\":\"https:\\/\\/jamesclear.com\\/wp-content\\/uploads\\/2020\\/11\\/clear-habit-journal_gallery_hi-res_07.jpg\"}', '{\"image_url\":\"https:\\/\\/encrypted-tbn0.gstatic.com\\/images?q=tbn:ANd9GcSv4RJUmozncSE5E6WnCtyu6KYGjhQFfhyM_Q&s\"}', '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:21:03'),
(352, 'admin', 3, 'admin_logout', 'Admin logged out', 'admin_users', 3, NULL, NULL, '112.202.121.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 11:28:25'),
(353, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:07:04'),
(354, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:07:45'),
(355, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:14:52'),
(356, 'admin', 3, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:15:58'),
(357, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:21:53'),
(358, 'admin', 3, 'admin_login', 'Admin logged in: Ydrian Yayen', 'admin_users', 3, NULL, NULL, '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:22:46'),
(359, 'admin', 3, 'product_image_update', 'Image URL updated for product (ID: 186)', 'product_images', 219, '{\"image_url\":\"https:\\/\\/images.unsplash.com\\/photo-1563636619-e9143da7973b?w=800&q=80\"}', '{\"image_url\":\"https:\\/\\/imartgrocersph.com\\/wp-content\\/uploads\\/2020\\/09\\/Bear-Brand-Sterilized-Milk-200mL.png\"}', '131.226.125.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-04 02:24:42'),
(360, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:52:41'),
(361, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:53:48'),
(362, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:57:48'),
(363, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:59:02'),
(364, 'customer', 2, 'wishlist_add', 'Added product to wishlist: Fitbit Charge 6', 'wishlist', 3, NULL, '{\"product_id\":42,\"product_name\":\"Fitbit Charge 6\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:59:36'),
(365, 'customer', 2, 'cart_add', 'Added product to cart: Fitbit Charge 6 (Qty: 1)', 'shopping_cart', 16, NULL, '{\"product_id\":42,\"product_name\":\"Fitbit Charge 6\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 04:59:54'),
(366, 'customer', 2, 'order_create', 'Order created: ORD-20251205-1BB37862 (Total: ₱16,497.80)', 'orders', 16, NULL, '{\"order_number\":\"ORD-20251205-1BB37862\",\"total\":16497.79999999999927240423858165740966796875,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:01:32'),
(367, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-1BB37862 via Cash on Delivery', 'payments', 16, NULL, '{\"transaction_id\":\"COD-ORD-20251205-1BB37862\",\"amount\":\"16497.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:01:51'),
(368, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-1BB37862 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-1BB37862\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:01:53'),
(369, 'admin', 2, 'admin_logout', 'Admin logged out', 'admin_users', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:03:24'),
(370, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:13:16'),
(371, 'customer', 2, 'cart_add', 'Added product to cart: Amazon Echo Dot 5th Gen (Qty: 1)', 'shopping_cart', 17, NULL, '{\"product_id\":40,\"product_name\":\"Amazon Echo Dot 5th Gen\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:13:39');
INSERT INTO `activity_logs` (`log_id`, `user_type`, `user_id`, `action_type`, `action_description`, `table_affected`, `record_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(372, 'customer', 2, 'order_create', 'Order created: ORD-20251205-22D742E2 (Total: ₱2,198.90)', 'orders', 17, NULL, '{\"order_number\":\"ORD-20251205-22D742E2\",\"total\":2198.90000000000009094947017729282379150390625,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:13:54'),
(373, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-22D742E2 via Cash on Delivery', 'payments', 17, NULL, '{\"transaction_id\":\"COD-ORD-20251205-22D742E2\",\"amount\":\"2198.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:13:58'),
(374, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-22D742E2 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-22D742E2\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:14:00'),
(375, 'customer', 2, 'cart_add', 'Added product to cart: Samsung Galaxy Watch 6 (Qty: 1)', 'shopping_cart', 18, NULL, '{\"product_id\":36,\"product_name\":\"Samsung Galaxy Watch 6\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:18:11'),
(376, 'customer', 2, 'cart_update', 'Updated cart for product: Samsung Galaxy Watch 6 (New Qty: 2)', 'shopping_cart', 18, NULL, '{\"product_id\":36,\"product_name\":\"Samsung Galaxy Watch 6\",\"quantity\":2}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:18:14'),
(377, 'customer', 2, 'order_create', 'Order created: ORD-20251205-A7A9ECA8 (Total: ₱28,597.80)', 'orders', 18, NULL, '{\"order_number\":\"ORD-20251205-A7A9ECA8\",\"total\":28597.79999999999927240423858165740966796875,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:18:29'),
(378, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-A7A9ECA8 via Cash on Delivery', 'payments', 18, NULL, '{\"transaction_id\":\"COD-ORD-20251205-A7A9ECA8\",\"amount\":\"28597.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:18:32'),
(379, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-A7A9ECA8 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-A7A9ECA8\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:18:34'),
(380, 'customer', 2, 'cart_add', 'Added product to cart: Bose QuietComfort 45 (Qty: 1)', 'shopping_cart', 19, NULL, '{\"product_id\":37,\"product_name\":\"Bose QuietComfort 45\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:46:20'),
(381, 'customer', 2, 'order_create', 'Order created: ORD-20251205-1264ECE9 (Total: ₱16,498.90)', 'orders', 19, NULL, '{\"order_number\":\"ORD-20251205-1264ECE9\",\"total\":16498.9000000000014551915228366851806640625,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:46:34'),
(382, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-1264ECE9 via Cash on Delivery', 'payments', 19, NULL, '{\"transaction_id\":\"COD-ORD-20251205-1264ECE9\",\"amount\":\"16498.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:46:37'),
(383, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-1264ECE9 via Cash on Delivery', 'payments', 19, NULL, '{\"transaction_id\":\"COD-ORD-20251205-1264ECE9\",\"amount\":\"16498.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:46:57'),
(384, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-1264ECE9 via Cash on Delivery', 'payments', 19, NULL, '{\"transaction_id\":\"COD-ORD-20251205-1264ECE9\",\"amount\":\"16498.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:51:14'),
(385, 'customer', 2, 'cart_add', 'Added product to cart: Apple iPad Air 5th Gen (Qty: 1)', 'shopping_cart', 20, NULL, '{\"product_id\":35,\"product_name\":\"Apple iPad Air 5th Gen\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:52:41'),
(386, 'customer', 2, 'order_create', 'Order created: ORD-20251205-B2FBD260 (Total: ₱35,198.90)', 'orders', 20, NULL, '{\"order_number\":\"ORD-20251205-B2FBD260\",\"total\":35198.9000000000014551915228366851806640625,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:52:53'),
(387, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-B2FBD260 via Cash on Delivery', 'payments', 20, NULL, '{\"transaction_id\":\"COD-ORD-20251205-B2FBD260\",\"amount\":\"35198.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 05:52:58'),
(388, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:04:08'),
(389, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:07:31'),
(390, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:08:45'),
(391, 'customer', 2, 'cart_add', 'Added product to cart: DJI Mini 3 Pro Drone (Qty: 1)', 'shopping_cart', 21, NULL, '{\"product_id\":41,\"product_name\":\"DJI Mini 3 Pro Drone\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:25:12'),
(392, 'customer', 2, 'order_create', 'Order created: ORD-20251205-755529A4 (Total: ₱47,298.90)', 'orders', 21, NULL, '{\"order_number\":\"ORD-20251205-755529A4\",\"total\":47298.9000000000014551915228366851806640625,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:25:34'),
(393, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-755529A4 via Cash on Delivery', 'payments', 21, NULL, '{\"transaction_id\":\"COD-ORD-20251205-755529A4\",\"amount\":\"47298.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:25:39'),
(394, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-755529A4 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-755529A4\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:25:40'),
(395, 'customer', 2, 'cart_add', 'Added product to cart: Samsung Galaxy Watch 6 (Qty: 1)', 'shopping_cart', 22, NULL, '{\"product_id\":36,\"product_name\":\"Samsung Galaxy Watch 6\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:31:31'),
(396, 'customer', 2, 'cart_update', 'Updated cart for product: Samsung Galaxy Watch 6 (New Qty: 2)', 'shopping_cart', 22, NULL, '{\"product_id\":36,\"product_name\":\"Samsung Galaxy Watch 6\",\"quantity\":2}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:31:34'),
(397, 'customer', 2, 'order_create', 'Order created: ORD-20251205-23F63866 (Total: ₱28,597.80)', 'orders', 22, NULL, '{\"order_number\":\"ORD-20251205-23F63866\",\"total\":28597.79999999999927240423858165740966796875,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:31:50'),
(398, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-23F63866 via Cash on Delivery', 'payments', 22, NULL, '{\"transaction_id\":\"COD-ORD-20251205-23F63866\",\"amount\":\"28597.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:31:53'),
(399, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-23F63866 to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-23F63866\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:31:55'),
(400, 'admin', 2, 'order_update', 'Order status updated: ORD-20251205-23F63866 from \'processing\' to \'shipped\'', 'orders', 22, '{\"order_status\":\"processing\"}', '{\"order_status\":\"shipped\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:42:21'),
(401, 'admin', 2, 'order_update', 'Order status updated: ORD-20251205-23F63866 from \'shipped\' to \'shipped\'', 'orders', 22, '{\"order_status\":\"shipped\"}', '{\"order_status\":\"shipped\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:42:21'),
(402, 'customer', 2, 'cart_add', 'Added product to cart: Samsung Galaxy Watch 6 (Qty: 1)', 'shopping_cart', 23, NULL, '{\"product_id\":36,\"product_name\":\"Samsung Galaxy Watch 6\",\"quantity\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:51:19'),
(403, 'customer', 2, 'order_create', 'Order created: ORD-20251205-A6392FEF (Total: ₱14,298.90)', 'orders', 23, NULL, '{\"order_number\":\"ORD-20251205-A6392FEF\",\"total\":14298.899999999999636202119290828704833984375,\"items_count\":1}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:51:35'),
(404, 'customer', 2, 'payment_complete', 'Payment completed for order ORD-20251205-A6392FEF via Cash on Delivery', 'payments', 23, NULL, '{\"transaction_id\":\"COD-ORD-20251205-A6392FEF\",\"amount\":\"14298.00\",\"payment_method\":\"Cash on Delivery\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:51:39'),
(405, 'customer', 2, 'email_sent', 'Order confirmation email sent: ORD-20251205-A6392FEF to yayenydrian@gmail.com', NULL, NULL, NULL, '{\"to\":\"yayenydrian@gmail.com\",\"subject\":\"Order Confirmation\",\"order_number\":\"ORD-20251205-A6392FEF\"}', '112.202.97.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 06:51:40'),
(406, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '112.202.101.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 09:17:22'),
(407, 'customer', 2, 'login', 'Customer logged in successfully', 'customers', 2, NULL, NULL, '112.202.101.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 09:35:00'),
(408, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '112.202.101.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 09:38:41'),
(409, 'admin', 2, 'admin_login', 'Admin logged in: System Administrator', 'admin_users', 2, NULL, NULL, '49.144.56.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-05 09:39:11'),
(410, 'admin', 2, 'maintenance_mode_toggle', 'Maintenance mode enabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"0\"}', '112.202.101.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 09:42:34'),
(411, 'admin', 2, 'maintenance_mode_toggle', 'Maintenance mode disabled', 'site_settings', NULL, NULL, '{\"maintenance_mode\":\"1\"}', '112.202.101.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-05 09:43:24');
=======
(1, 'customer', 2, 'logout', 'Customer logged out', 'customers', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-01 11:45:24');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address_type` enum('billing','shipping') NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state_province` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `customer_id`, `address_type`, `is_default`, `street_address`, `city`, `state_province`, `postal_code`, `country`, `created_at`) VALUES
(1, 3, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-24 02:54:32'),
(2, 2, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-28 10:44:57'),
<<<<<<< HEAD
(3, 4, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-29 00:44:47'),
(4, 5, 'billing', 0, 'asadf', 'asdfasdf', 'dfcvzxcv', 'qwetgsfdbzxc', 'Philippines', '2025-12-03 05:16:44'),
(5, 5, 'billing', 1, 'asadf', 'asdfasdf', 'dfcvzxcv', 'qwetgsfdbzxc', 'Philippines', '2025-12-03 05:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password_hash`, `email`, `full_name`, `is_active`, `created_at`) VALUES
(2, 'Ydzz', '$2y$10$O8l8wg8nM2JNPr8HU4B/wutyHt9hIG/Zcafv5nVxe0CY7R.t2pAv6', 'yayenydrian@gmail.com', 'Ydrian Yayen', 1, '2025-12-02 04:56:33');
=======
(3, 4, 'billing', 1, '123', 'Puerto Princesa', 'Palawan', '5300', 'Philippines', '2025-11-29 00:44:47');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('super_admin','admin','moderator') DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
<<<<<<< HEAD
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
=======
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

<<<<<<< HEAD
INSERT INTO `admin_users` (`admin_id`, `username`, `email`, `password_hash`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`, `reset_token`, `reset_token_expiry`) VALUES
(2, 'admin', 'admin@jrdmalls.com', '$2y$10$BS3i0G5xLmbdxmP4gciC3ORaUHLzkUlfjMvunlR7CnMG.afLNem/e', 'System Administrator', 'super_admin', 1, '2025-12-05 09:39:11', '2025-12-02 05:03:06', '2025-12-05 09:39:11', NULL, NULL),
(3, 'Ydzz', 'yayenydrian@gmail.com', '$2y$10$uq77U5I.1w.6fdXbh5pxhu4M8l6LY8wFhr1.8UoQ9sASGGIFHLvh6', 'Ydrian Yayen', 'admin', 1, '2025-12-04 02:22:46', '2025-12-02 05:22:37', '2025-12-04 02:22:46', NULL, NULL),
(4, 'adminigger', 'andrepagliawan0@gmail.com', '$2y$10$ZEovK1SpHQV20ZqGk0gIp.3AZTRr2bce1e6z4Y71odh7Bwe8s/O.2', 'Baba Boui', 'admin', 1, '2025-12-03 04:46:35', '2025-12-02 06:12:10', '2025-12-03 04:46:35', NULL, NULL);
=======
INSERT INTO `admin_users` (`admin_id`, `username`, `email`, `password_hash`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@jrdmalls.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'super_admin', 1, NULL, '2025-12-01 10:59:22', '2025-12-01 10:59:22');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_category_id`, `description`, `image_url`, `is_active`, `created_at`) VALUES
(1, 'Electronics', NULL, 'Latest gadgets, smartphones, laptops, and tech accessories', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800&q=80', 1, '2025-11-24 00:05:44'),
(2, 'Clothing', NULL, 'Fashion for every style and occasion - men, women, and kids', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80', 1, '2025-11-24 00:05:44'),
(3, 'Home & Garden', NULL, 'Transform your living space with furniture and decor', 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&q=80', 1, '2025-11-24 00:05:44'),
(4, 'Sports & Outdoors', NULL, 'Gear up for adventure and active lifestyle', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&q=80', 1, '2025-11-24 00:05:44'),
(5, 'Books', NULL, 'Knowledge and stories await in our book collection', 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&q=80', 1, '2025-11-24 00:05:44'),
(6, 'Grocery', NULL, '', NULL, 0, '2025-11-25 03:10:42'),
(29, 'Groceries', NULL, 'Fresh food, beverages, and household essentials', 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80', 1, '2025-11-25 05:31:02'),
(30, 'Snacks & Sweets', 29, 'Filipino chips, cookies, candies, and sweet treats', 'https://images.unsplash.com/photo-1621768216002-5ac171876625?w=800&q=80', 0, '2025-11-25 05:31:02'),
(31, 'Canned Goods', 29, 'Canned fish, meat, vegetables, and preserved foods', 'https://images.unsplash.com/photo-1562843467-e0e689b3d98d?w=800&q=80', 1, '2025-11-25 05:31:02'),
(32, 'Noodles & Pasta', 29, 'Instant noodles, pasta, and quick meal solutions', 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, '2025-11-25 05:31:02'),
(33, 'Beverages', 29, 'Coffee, tea, juices, soft drinks, and refreshments', 'https://images.unsplash.com/photo-1544145945-35046820424e?w=800&q=80', 1, '2025-11-25 05:31:02'),
(34, 'Condiments & Sauces', 29, 'Soy sauce, vinegar, cooking oils, and flavor enhancers', 'https://images.unsplash.com/photo-1596040033229-a0b8f3f5e5f5?w=800&q=80', 1, '2025-11-25 05:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_type` enum('percentage','fixed_amount') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `coupon_code`, `description`, `discount_type`, `discount_value`, `min_purchase_amount`, `max_discount_amount`, `usage_limit`, `usage_count`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
<<<<<<< HEAD
(2, '123', 'Test', 'percentage', '10.00', '10000.00', '1000.00', 2, 0, '2025-12-05', '2025-12-06', 1, '2025-12-05 04:58:40');
=======
(1, '1', 'Gadget', 'percentage', 10.00, 100.00, NULL, NULL, 0, '2025-11-28', '2025-11-29', 1, '2025-11-28 12:40:58');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `date_of_birth`, `created_at`, `updated_at`, `is_active`, `last_login`) VALUES
<<<<<<< HEAD
(2, 'yayenydrian@gmail.com', '$2y$10$.VYqTcirLgMMy5zONfCPBuP3A/BOqN2ui9sy8tgtktgmMOqDl7GBW', 'Ydrian', 'Yayen', '09461478420', '2002-05-18', '2025-11-24 00:16:42', '2025-12-05 09:35:00', 1, '2025-12-05 09:35:00'),
(3, 'johndoe@gmail.com', '$2y$10$UwyejG2ch57BFD.W5zxD5eDCGhmvfdjWncFQX5BfSs/5N/g9saymG', 'john', 'doe', '09123121231', NULL, '2025-11-24 02:52:43', '2025-11-24 02:52:52', 1, '2025-11-24 02:52:52'),
(4, 'andrepagliawan@gmail.com', '$2y$10$A.kIRqkRC4wvR4Fj1TQvMeftFcGwtdnY9pW.NCgjTgMlUGHkKgj/G', 'Andre', 'Pagliawan', '09123121231', NULL, '2025-11-29 00:25:52', '2025-12-03 05:14:46', 1, '2025-11-29 00:26:05'),
(5, 'andrepagliawan0@gmail.com', '$2y$10$WgxXd2FgAfCAOEq6lQvJG.I3alvEpEAyHrZ6v5b3bw5YVxvPid4y6', 'lick', 'mahballs', '09999999999', NULL, '2025-12-03 05:14:04', '2025-12-03 05:14:51', 0, '2025-12-03 05:14:32');
=======
(2, 'yayenydrian@gmail.com', '$2y$10$.VYqTcirLgMMy5zONfCPBuP3A/BOqN2ui9sy8tgtktgmMOqDl7GBW', 'Ydrian', 'Yayen', '09461478420', '2002-05-18', '2025-11-24 00:16:42', '2025-12-01 01:27:10', 1, '2025-12-01 01:27:10'),
(3, 'johndoe@gmail.com', '$2y$10$UwyejG2ch57BFD.W5zxD5eDCGhmvfdjWncFQX5BfSs/5N/g9saymG', 'john', 'doe', '09123121231', NULL, '2025-11-24 02:52:43', '2025-11-24 02:52:52', 1, '2025-11-24 02:52:52'),
(4, 'andrepagliawan@gmail.com', '$2y$10$A.kIRqkRC4wvR4Fj1TQvMeftFcGwtdnY9pW.NCgjTgMlUGHkKgj/G', 'Andre', 'Pagliawan', '09123121231', NULL, '2025-11-29 00:25:52', '2025-11-29 00:26:05', 1, '2025-11-29 00:26:05');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reserved_quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10,
  `last_restocked` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity`, `reserved_quantity`, `reorder_level`, `last_restocked`, `updated_at`) VALUES
(1, 1, 45, 5, 15, NULL, '2025-11-24 02:27:17'),
(2, 2, 30, 3, 10, NULL, '2025-11-24 02:27:17'),
(3, 3, 75, 8, 20, NULL, '2025-11-24 02:27:17'),
(4, 4, 20, 2, 8, NULL, '2025-11-24 02:27:17'),
(5, 5, 120, 10, 30, NULL, '2025-11-24 02:27:17'),
(6, 6, 26, 1, 5, '2025-11-29 04:18:12', '2025-11-29 04:18:12'),
(7, 7, 200, 15, 50, NULL, '2025-11-24 02:27:17'),
(8, 8, 19, 1, 3, '2025-11-29 04:17:42', '2025-11-29 04:17:42'),
(9, 9, 150, 12, 40, NULL, '2025-11-24 02:27:17'),
(10, 10, 200, 20, 50, NULL, '2025-11-24 02:27:17'),
(11, 11, 85, 9, 25, NULL, '2025-11-24 02:27:17'),
(12, 12, 60, 5, 20, NULL, '2025-11-24 02:27:17'),
(13, 13, 180, 15, 45, NULL, '2025-11-24 02:27:17'),
(14, 14, 95, 8, 30, NULL, '2025-11-24 02:27:17'),
(15, 15, 140, 11, 35, NULL, '2025-11-24 02:27:17'),
(16, 16, 35, 3, 10, NULL, '2025-11-24 02:27:17'),
(17, 17, 90, 7, 25, NULL, '2025-11-24 02:27:17'),
(18, 18, 25, 2, 8, NULL, '2025-11-24 02:27:17'),
(19, 19, 50, 4, 15, NULL, '2025-11-24 02:27:17'),
(20, 20, 18, 2, 6, NULL, '2025-11-24 02:27:17'),
(21, 21, 65, 5, 20, NULL, '2025-11-24 02:27:17'),
(22, 22, 24, 1, 4, '2025-11-29 04:17:50', '2025-11-29 04:17:50'),
(23, 23, 40, 3, 12, NULL, '2025-11-24 02:27:17'),
(24, 24, 22, 2, 7, NULL, '2025-11-24 02:27:17'),
(25, 25, 55, 4, 15, NULL, '2025-11-24 02:27:17'),
(26, 26, 80, 6, 25, NULL, '2025-11-24 02:27:17'),
(27, 27, 30, 2, 10, NULL, '2025-11-24 02:27:17'),
(28, 28, 45, 4, 15, NULL, '2025-11-24 02:27:17'),
(29, 29, 110, 9, 30, NULL, '2025-11-24 02:27:17'),
(30, 30, 250, 20, 60, NULL, '2025-11-24 02:27:17'),
(31, 31, 180, 15, 50, NULL, '2025-11-24 02:27:17'),
(32, 32, 160, 12, 45, NULL, '2025-11-24 02:27:17'),
(33, 33, 140, 10, 40, NULL, '2025-11-24 02:27:17'),
<<<<<<< HEAD
(34, 34, 200, 18, 55, NULL, '2025-11-24 02:27:17'),
(35, 35, 85, 5, 20, NULL, '2025-12-01 20:46:00'),
(36, 36, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(37, 37, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(38, 38, 40, 2, 10, NULL, '2025-12-01 20:46:00'),
(39, 39, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(40, 40, 200, 15, 50, NULL, '2025-12-01 20:46:00'),
(41, 41, 30, 2, 8, NULL, '2025-12-01 20:46:00'),
(42, 42, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(43, 43, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(44, 44, 45, 3, 12, NULL, '2025-12-01 20:46:00'),
(45, 45, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(46, 46, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(47, 47, 90, 6, 25, NULL, '2025-12-01 20:46:00'),
(48, 48, 220, 18, 55, NULL, '2025-12-01 20:46:00'),
(49, 49, 300, 25, 75, NULL, '2025-12-01 20:46:00'),
(50, 50, 25, 1, 6, NULL, '2025-12-01 20:46:00'),
(51, 51, 55, 4, 15, NULL, '2025-12-01 20:46:00'),
(52, 52, 85, 7, 25, NULL, '2025-12-01 20:46:00'),
(53, 53, 400, 30, 100, NULL, '2025-12-01 20:46:00'),
(54, 54, 120, 9, 30, NULL, '2025-12-01 20:46:00'),
(55, 55, 95, 6, 25, NULL, '2025-12-01 20:46:00'),
(56, 56, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(57, 57, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(58, 58, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(59, 59, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(60, 60, 80, 5, 20, NULL, '2025-12-01 20:46:00'),
(61, 61, 35, 2, 10, NULL, '2025-12-01 20:46:00'),
(62, 62, 50, 3, 12, NULL, '2025-12-01 20:46:00'),
(63, 63, 70, 5, 20, NULL, '2025-12-01 20:46:00'),
(64, 64, 160, 12, 40, NULL, '2025-12-01 20:46:00'),
(65, 65, 200, 15, 50, NULL, '2025-12-01 20:46:00'),
(66, 66, 45, 3, 12, NULL, '2025-12-01 20:46:00'),
(67, 67, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(68, 68, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(69, 69, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(70, 70, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(71, 71, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(72, 72, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(73, 73, 160, 11, 40, NULL, '2025-12-01 20:46:00'),
(74, 74, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(75, 75, 240, 18, 60, NULL, '2025-12-01 20:46:00'),
(76, 76, 90, 6, 25, NULL, '2025-12-01 20:46:00'),
(77, 77, 130, 9, 35, NULL, '2025-12-01 20:46:00'),
(78, 78, 170, 12, 45, NULL, '2025-12-01 20:46:00'),
(79, 79, 105, 7, 30, NULL, '2025-12-01 20:46:00'),
(80, 80, 60, 4, 15, NULL, '2025-12-01 20:46:00'),
(81, 81, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(82, 82, 190, 13, 50, NULL, '2025-12-01 20:46:00'),
(83, 83, 70, 5, 20, NULL, '2025-12-01 20:46:00'),
(84, 84, 115, 8, 30, NULL, '2025-12-01 20:46:00'),
(85, 85, 50, 3, 12, NULL, '2025-12-01 20:46:00'),
(86, 86, 35, 2, 10, NULL, '2025-12-01 20:46:00'),
(87, 87, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(88, 88, 30, 2, 8, NULL, '2025-12-01 20:46:00'),
(89, 89, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(90, 90, 120, 9, 30, NULL, '2025-12-01 20:46:00'),
(91, 91, 80, 5, 20, NULL, '2025-12-01 20:46:00'),
(92, 92, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(93, 93, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(94, 94, 100, 7, 25, NULL, '2025-12-01 20:46:00'),
(95, 95, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(96, 96, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(97, 97, 40, 2, 10, NULL, '2025-12-01 20:46:00'),
(98, 98, 55, 4, 15, NULL, '2025-12-01 20:46:00'),
(99, 99, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(100, 100, 130, 9, 35, NULL, '2025-12-01 20:46:00'),
(101, 101, 160, 11, 40, NULL, '2025-12-01 20:46:00'),
(102, 102, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(103, 103, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(104, 104, 60, 4, 15, NULL, '2025-12-01 20:46:00'),
(105, 105, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(106, 106, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(107, 107, 250, 18, 65, NULL, '2025-12-01 20:46:00'),
(108, 108, 90, 6, 25, NULL, '2025-12-01 20:46:00'),
(109, 109, 45, 3, 12, NULL, '2025-12-01 20:46:00'),
(110, 110, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(111, 111, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(112, 112, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(113, 113, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(114, 114, 170, 12, 45, NULL, '2025-12-01 20:46:00'),
(115, 115, 200, 14, 50, NULL, '2025-12-01 20:46:00'),
(116, 116, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(117, 117, 115, 8, 30, NULL, '2025-12-01 20:46:00'),
(118, 118, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(119, 119, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(120, 120, 40, 2, 10, NULL, '2025-12-01 20:46:00'),
(121, 121, 70, 5, 20, NULL, '2025-12-01 20:46:00'),
(122, 122, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(123, 123, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(124, 124, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(125, 125, 55, 4, 15, NULL, '2025-12-01 20:46:00'),
(126, 126, 40, 2, 10, NULL, '2025-12-01 20:46:00'),
(127, 127, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(128, 128, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(129, 129, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(130, 130, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(131, 131, 35, 2, 10, NULL, '2025-12-01 20:46:00'),
(132, 132, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(133, 133, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(134, 134, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(135, 135, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(136, 136, 45, 3, 12, NULL, '2025-12-01 20:46:00'),
(137, 137, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(138, 138, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(139, 139, 200, 14, 50, NULL, '2025-12-01 20:46:00'),
(140, 140, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(141, 141, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(142, 142, 60, 4, 15, NULL, '2025-12-01 20:46:00'),
(143, 143, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(144, 144, 25, 1, 6, NULL, '2025-12-01 20:46:00'),
(145, 145, 40, 2, 10, NULL, '2025-12-01 20:46:00'),
(146, 146, 50, 3, 12, NULL, '2025-12-01 20:46:00'),
(147, 147, 70, 5, 20, NULL, '2025-12-01 20:46:00'),
(148, 148, 90, 6, 25, NULL, '2025-12-01 20:46:00'),
(149, 149, 60, 4, 15, NULL, '2025-12-01 20:46:00'),
(150, 150, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(151, 151, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(152, 152, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(153, 153, 55, 4, 15, NULL, '2025-12-01 20:46:00'),
(154, 154, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(155, 155, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(156, 156, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(157, 157, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(158, 158, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(159, 159, 200, 14, 50, NULL, '2025-12-01 20:46:00'),
(160, 160, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(161, 161, 160, 11, 40, NULL, '2025-12-01 20:46:00'),
(162, 162, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(163, 163, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(164, 164, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(165, 165, 130, 9, 35, NULL, '2025-12-01 20:46:00'),
(166, 166, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(167, 167, 60, 4, 15, NULL, '2025-12-01 20:46:00'),
(168, 168, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(169, 169, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(170, 170, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(171, 171, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(172, 172, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(173, 173, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(174, 174, 65, 4, 15, NULL, '2025-12-01 20:46:00'),
(175, 175, 200, 14, 50, NULL, '2025-12-01 20:46:00'),
(176, 176, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(177, 177, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(178, 178, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(179, 179, 140, 10, 35, NULL, '2025-12-01 20:46:00'),
(180, 180, 85, 6, 25, NULL, '2025-12-01 20:46:00'),
(181, 181, 120, 8, 30, NULL, '2025-12-01 20:46:00'),
(182, 182, 95, 7, 25, NULL, '2025-12-01 20:46:00'),
(183, 183, 75, 5, 20, NULL, '2025-12-01 20:46:00'),
(184, 184, 110, 8, 30, NULL, '2025-12-01 20:46:00'),
(185, 185, 200, 15, 50, NULL, '2025-12-01 20:46:00'),
(186, 186, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(187, 187, 500, 40, 125, NULL, '2025-12-01 20:46:00'),
(188, 188, 450, 35, 110, NULL, '2025-12-01 20:46:00'),
(189, 189, 400, 30, 100, NULL, '2025-12-01 20:46:00'),
(190, 190, 250, 18, 65, NULL, '2025-12-01 20:46:00'),
(191, 191, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(192, 192, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(193, 193, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(194, 194, 400, 30, 100, NULL, '2025-12-01 20:46:00'),
(195, 195, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(196, 196, 600, 50, 150, NULL, '2025-12-01 20:46:00'),
(197, 197, 280, 20, 70, NULL, '2025-12-01 20:46:00'),
(198, 198, 420, 35, 105, NULL, '2025-12-01 20:46:00'),
(199, 199, 550, 45, 140, NULL, '2025-12-01 20:46:00'),
(200, 200, 480, 40, 120, NULL, '2025-12-01 20:46:00'),
(201, 201, 320, 25, 80, NULL, '2025-12-01 20:46:00'),
(202, 202, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(203, 203, 400, 30, 100, NULL, '2025-12-01 20:46:00'),
(204, 204, 250, 18, 65, NULL, '2025-12-01 20:46:00'),
(205, 205, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(206, 206, 280, 20, 70, NULL, '2025-12-01 20:46:00'),
(207, 207, 450, 35, 110, NULL, '2025-12-01 20:46:00'),
(208, 208, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(209, 209, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(210, 210, 190, 13, 50, NULL, '2025-12-01 20:46:00'),
(211, 211, 260, 18, 65, NULL, '2025-12-01 20:46:00'),
(212, 212, 380, 30, 95, NULL, '2025-12-01 20:46:00'),
(213, 213, 320, 25, 80, NULL, '2025-12-01 20:46:00'),
(214, 214, 420, 35, 105, NULL, '2025-12-01 20:46:00'),
(215, 215, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(216, 216, 250, 18, 65, NULL, '2025-12-01 20:46:00'),
(217, 217, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(218, 218, 200, 15, 50, NULL, '2025-12-01 20:46:00'),
(219, 219, 280, 20, 70, NULL, '2025-12-01 20:46:00'),
(220, 220, 180, 12, 45, NULL, '2025-12-01 20:46:00'),
(221, 221, 500, 40, 125, NULL, '2025-12-01 20:46:00'),
(222, 222, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(223, 223, 150, 10, 40, NULL, '2025-12-01 20:46:00'),
(224, 224, 320, 25, 80, NULL, '2025-12-01 20:46:00'),
(225, 225, 280, 20, 70, NULL, '2025-12-01 20:46:00'),
(226, 226, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(227, 227, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(228, 228, 400, 30, 100, NULL, '2025-12-01 20:46:00'),
(229, 229, 380, 30, 95, NULL, '2025-12-01 20:46:00'),
(230, 230, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(231, 231, 320, 25, 80, NULL, '2025-12-01 20:46:00'),
(232, 232, 380, 30, 95, NULL, '2025-12-01 20:46:00'),
(233, 233, 200, 15, 50, NULL, '2025-12-01 20:46:00'),
(234, 234, 250, 18, 65, NULL, '2025-12-01 20:46:00'),
(235, 235, 450, 35, 110, NULL, '2025-12-01 20:46:00'),
(236, 236, 420, 35, 105, NULL, '2025-12-01 20:46:00'),
(237, 237, 480, 40, 120, NULL, '2025-12-01 20:46:00'),
(238, 238, 350, 25, 90, NULL, '2025-12-01 20:46:00'),
(239, 239, 280, 20, 70, NULL, '2025-12-01 20:46:00'),
(240, 240, 320, 25, 80, NULL, '2025-12-01 20:46:00'),
(241, 241, 220, 15, 55, NULL, '2025-12-01 20:46:00'),
(242, 242, 380, 30, 95, NULL, '2025-12-01 20:46:00'),
(243, 243, 300, 20, 75, NULL, '2025-12-01 20:46:00'),
(244, 244, 420, 35, 105, NULL, '2025-12-01 20:46:00');
=======
(34, 34, 200, 18, 55, NULL, '2025-11-24 02:27:17');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `customer_id`, `order_id`, `type`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 4, 12, 'order_status', 'Order Shipped', 'Your order #ORD-20251129-2A1E86D9 has been shipped! It\'s on its way to you.', 1, '2025-11-29 01:52:44'),
(2, 2, 3, 'order_status', 'Order Cancelled', 'Your order #ORD-20251128-2057B79F has been cancelled.', 1, '2025-11-29 04:16:06'),
<<<<<<< HEAD
(3, 2, 13, 'order_status', 'Order Shipped', 'Your order #ORD-20251201-D6AEC454 has been shipped! It\'s on its way to you.', 1, '2025-12-01 07:07:29'),
(4, 2, 14, 'order_status', 'Order Shipped', 'Your order #ORD-20251202-BC9BD637 has been shipped! It\'s on its way to you.', 1, '2025-12-02 05:58:20'),
(5, 2, 20, 'order_status', 'Order Shipped', 'Your order #ORD-20251205-B2FBD260 has been shipped! It\'s on its way to you.', 1, '2025-12-05 06:08:05');
=======
(3, 2, 13, 'order_status', 'Order Shipped', 'Your order #ORD-20251201-D6AEC454 has been shipped! It\'s on its way to you.', 1, '2025-12-01 07:07:29');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_status` enum('pending','processing','shipped','delivered','cancelled','refunded') DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address_id` int(11) NOT NULL,
  `billing_address_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_number`, `order_status`, `subtotal`, `tax_amount`, `shipping_cost`, `total_amount`, `shipping_address_id`, `billing_address_id`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
<<<<<<< HEAD
(1, 2, 'ORD-20251128-27783FE6', 'cancelled', '49999.00', '5999.88', '0.00', '55998.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-28 10:45:23', '2025-11-28 11:45:42'),
(2, 2, 'ORD-20251128-0E65360C', 'cancelled', '209997.00', '25199.64', '0.00', '235196.00', 2, 2, 'Credit Card', 'pending', '', '2025-11-28 11:40:01', '2025-11-28 11:45:41'),
(3, 2, 'ORD-20251128-2057B79F', 'cancelled', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'pending', '', '2025-11-28 11:50:00', '2025-11-29 04:16:06'),
(4, 2, 'ORD-20251128-83F20F4B', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'pending', '', '2025-11-28 12:03:06', '2025-11-28 12:03:06'),
(5, 2, 'ORD-20251128-F2B74647', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'pending', '', '2025-11-28 12:10:24', '2025-11-28 12:10:24'),
(6, 2, 'ORD-20251128-313106AC', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-28 12:42:43', '2025-11-28 12:42:43'),
(7, 2, 'ORD-20251129-BFA4D1CC', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'pending', '', '2025-11-28 23:49:05', '2025-11-28 23:49:05'),
(8, 2, 'ORD-20251129-45AAC550', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'pending', '', '2025-11-28 23:52:14', '2025-11-28 23:52:14'),
(9, 2, 'ORD-20251129-C2A4DEBB', 'pending', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-29 00:03:43', '2025-11-29 00:03:43'),
(10, 2, 'ORD-20251129-A288F9B8', 'processing', '19498.00', '2339.76', '0.00', '21837.00', 2, 2, 'GCash', 'completed', '', '2025-11-29 00:06:33', '2025-11-29 00:07:39'),
(11, 2, 'ORD-20251129-A2573A98', 'shipped', '49999.00', '5999.88', '0.00', '55998.00', 2, 2, 'GCash', 'completed', '', '2025-11-29 00:10:25', '2025-11-29 00:20:41'),
(12, 4, 'ORD-20251129-2A1E86D9', 'shipped', '99998.00', '11999.76', '0.00', '111997.00', 3, 3, 'GCash', 'completed', '', '2025-11-29 00:44:59', '2025-11-29 01:52:44'),
(13, 2, 'ORD-20251201-D6AEC454', 'shipped', '99998.00', '9999.80', '0.00', '109997.00', 2, 2, 'Cash on Delivery', 'completed', '', '2025-12-01 01:27:39', '2025-12-01 07:07:41'),
(14, 2, 'ORD-20251202-BC9BD637', 'shipped', '45999.00', '4599.90', '0.00', '50598.00', 2, 2, 'Credit Card', 'completed', '', '2025-12-02 05:57:17', '2025-12-02 05:58:20'),
(15, 5, 'ORD-20251203-B9B1255F', 'processing', '63998.00', '6399.80', '0.00', '70397.00', 5, 5, 'Cash on Delivery', 'pending', '', '2025-12-03 05:17:21', '2025-12-03 05:17:25'),
(16, 2, 'ORD-20251205-1BB37862', 'processing', '14998.00', '1499.80', '0.00', '16497.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 05:01:32', '2025-12-05 05:01:51'),
(17, 2, 'ORD-20251205-22D742E2', 'processing', '1999.00', '199.90', '0.00', '2198.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 05:13:54', '2025-12-05 05:13:58'),
(18, 2, 'ORD-20251205-A7A9ECA8', 'processing', '25998.00', '2599.80', '0.00', '28597.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 05:18:29', '2025-12-05 05:18:32'),
(19, 2, 'ORD-20251205-1264ECE9', 'processing', '14999.00', '1499.90', '0.00', '16498.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 05:46:34', '2025-12-05 05:46:37'),
(20, 2, 'ORD-20251205-B2FBD260', 'shipped', '31999.00', '3199.90', '0.00', '35198.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 05:52:53', '2025-12-05 06:08:05'),
(21, 2, 'ORD-20251205-755529A4', 'processing', '42999.00', '4299.90', '0.00', '47298.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 06:25:34', '2025-12-05 06:25:39'),
(22, 2, 'ORD-20251205-23F63866', 'shipped', '25998.00', '2599.80', '0.00', '28597.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 06:31:50', '2025-12-05 06:42:21'),
(23, 2, 'ORD-20251205-A6392FEF', 'processing', '12999.00', '1299.90', '0.00', '14298.00', 2, 2, 'Cash on Delivery', 'pending', '', '2025-12-05 06:51:35', '2025-12-05 06:51:39');
=======
(1, 2, 'ORD-20251128-27783FE6', 'cancelled', 49999.00, 5999.88, 0.00, 55998.00, 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-28 10:45:23', '2025-11-28 11:45:42'),
(2, 2, 'ORD-20251128-0E65360C', 'cancelled', 209997.00, 25199.64, 0.00, 235196.00, 2, 2, 'Credit Card', 'pending', '', '2025-11-28 11:40:01', '2025-11-28 11:45:41'),
(3, 2, 'ORD-20251128-2057B79F', 'cancelled', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'pending', '', '2025-11-28 11:50:00', '2025-11-29 04:16:06'),
(4, 2, 'ORD-20251128-83F20F4B', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'pending', '', '2025-11-28 12:03:06', '2025-11-28 12:03:06'),
(5, 2, 'ORD-20251128-F2B74647', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'pending', '', '2025-11-28 12:10:24', '2025-11-28 12:10:24'),
(6, 2, 'ORD-20251128-313106AC', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-28 12:42:43', '2025-11-28 12:42:43'),
(7, 2, 'ORD-20251129-BFA4D1CC', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'pending', '', '2025-11-28 23:49:05', '2025-11-28 23:49:05'),
(8, 2, 'ORD-20251129-45AAC550', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'pending', '', '2025-11-28 23:52:14', '2025-11-28 23:52:14'),
(9, 2, 'ORD-20251129-C2A4DEBB', 'pending', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'Cash on Delivery', 'pending', '', '2025-11-29 00:03:43', '2025-11-29 00:03:43'),
(10, 2, 'ORD-20251129-A288F9B8', 'processing', 19498.00, 2339.76, 0.00, 21837.00, 2, 2, 'GCash', 'completed', '', '2025-11-29 00:06:33', '2025-11-29 00:07:39'),
(11, 2, 'ORD-20251129-A2573A98', 'shipped', 49999.00, 5999.88, 0.00, 55998.00, 2, 2, 'GCash', 'completed', '', '2025-11-29 00:10:25', '2025-11-29 00:20:41'),
(12, 4, 'ORD-20251129-2A1E86D9', 'shipped', 99998.00, 11999.76, 0.00, 111997.00, 3, 3, 'GCash', 'completed', '', '2025-11-29 00:44:59', '2025-11-29 01:52:44'),
(13, 2, 'ORD-20251201-D6AEC454', 'shipped', 99998.00, 9999.80, 0.00, 109997.00, 2, 2, 'Cash on Delivery', 'completed', '', '2025-12-01 01:27:39', '2025-12-01 07:07:41');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `order_coupons`
--

CREATE TABLE `order_coupons` (
  `order_coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `discount_applied` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Dumping data for table `order_coupons`
--

INSERT INTO `order_coupons` (`order_coupon_id`, `order_id`, `coupon_id`, `discount_applied`) VALUES
(1, 16, 2, '1000.00');

=======
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
<<<<<<< HEAD
(1, 1, 1, 1, '49999.00', '49999.00'),
(2, 2, 2, 3, '69999.00', '209997.00'),
(3, 3, 3, 1, '14999.00', '14999.00'),
(4, 3, 5, 1, '4499.00', '4499.00'),
(5, 4, 3, 1, '14999.00', '14999.00'),
(6, 4, 5, 1, '4499.00', '4499.00'),
(7, 5, 3, 1, '14999.00', '14999.00'),
(8, 5, 5, 1, '4499.00', '4499.00'),
(9, 6, 3, 1, '14999.00', '14999.00'),
(10, 6, 5, 1, '4499.00', '4499.00'),
(11, 7, 3, 1, '14999.00', '14999.00'),
(12, 7, 5, 1, '4499.00', '4499.00'),
(13, 8, 3, 1, '14999.00', '14999.00'),
(14, 8, 5, 1, '4499.00', '4499.00'),
(15, 9, 3, 1, '14999.00', '14999.00'),
(16, 9, 5, 1, '4499.00', '4499.00'),
(17, 10, 3, 1, '14999.00', '14999.00'),
(18, 10, 5, 1, '4499.00', '4499.00'),
(19, 11, 1, 1, '49999.00', '49999.00'),
(20, 12, 1, 2, '49999.00', '99998.00'),
(21, 13, 1, 2, '49999.00', '99998.00'),
(22, 14, 39, 1, '45999.00', '45999.00'),
(23, 15, 35, 2, '31999.00', '63998.00'),
(24, 16, 42, 2, '7999.00', '15998.00'),
(25, 17, 40, 1, '1999.00', '1999.00'),
(26, 18, 36, 2, '12999.00', '25998.00'),
(27, 19, 37, 1, '14999.00', '14999.00'),
(28, 20, 35, 1, '31999.00', '31999.00'),
(29, 21, 41, 1, '42999.00', '42999.00'),
(30, 22, 36, 2, '12999.00', '25998.00'),
(31, 23, 36, 1, '12999.00', '12999.00');
=======
(1, 1, 1, 1, 49999.00, 49999.00),
(2, 2, 2, 3, 69999.00, 209997.00),
(3, 3, 3, 1, 14999.00, 14999.00),
(4, 3, 5, 1, 4499.00, 4499.00),
(5, 4, 3, 1, 14999.00, 14999.00),
(6, 4, 5, 1, 4499.00, 4499.00),
(7, 5, 3, 1, 14999.00, 14999.00),
(8, 5, 5, 1, 4499.00, 4499.00),
(9, 6, 3, 1, 14999.00, 14999.00),
(10, 6, 5, 1, 4499.00, 4499.00),
(11, 7, 3, 1, 14999.00, 14999.00),
(12, 7, 5, 1, 4499.00, 4499.00),
(13, 8, 3, 1, 14999.00, 14999.00),
(14, 8, 5, 1, 4499.00, 4499.00),
(15, 9, 3, 1, 14999.00, 14999.00),
(16, 9, 5, 1, 4499.00, 4499.00),
(17, 10, 3, 1, 14999.00, 14999.00),
(18, 10, 5, 1, 4499.00, 4499.00),
(19, 11, 1, 1, 49999.00, 49999.00),
(20, 12, 1, 2, 49999.00, 99998.00),
(21, 13, 1, 2, 49999.00, 99998.00);
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE `order_notes` (
  `note_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `note_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `transaction_id`, `amount`, `payment_status`, `payment_date`, `created_at`) VALUES
<<<<<<< HEAD
(1, 1, 'Cash on Delivery', NULL, '55998.88', 'pending', NULL, '2025-11-28 10:45:23'),
(2, 2, 'Credit Card', NULL, '235196.64', 'pending', NULL, '2025-11-28 11:40:01'),
(3, 3, 'GCash', NULL, '21837.76', 'pending', NULL, '2025-11-28 11:50:00'),
(4, 4, 'GCash', NULL, '21837.76', 'pending', NULL, '2025-11-28 12:03:06'),
(5, 5, 'GCash', NULL, '21837.76', 'pending', NULL, '2025-11-28 12:10:24'),
(6, 6, 'Cash on Delivery', NULL, '21837.76', 'pending', NULL, '2025-11-28 12:42:43'),
(7, 7, 'GCash', NULL, '21837.76', 'pending', NULL, '2025-11-28 23:49:05'),
(8, 8, 'GCash', NULL, '21837.76', 'pending', NULL, '2025-11-28 23:52:14'),
(9, 9, 'Cash on Delivery', NULL, '21837.76', 'pending', NULL, '2025-11-29 00:03:43'),
(10, 10, 'GCash', 'TXN-20251129010739-77DDAF4E', '21837.76', 'completed', '2025-11-28 17:07:39', '2025-11-29 00:06:33'),
(11, 11, 'GCash', 'TXN-20251129011035-5E35E5F7', '55998.88', 'completed', '2025-11-28 17:10:35', '2025-11-29 00:10:25'),
(12, 12, 'GCash', 'TXN-20251129014517-0AA0838D', '111997.76', 'completed', '2025-11-28 17:45:17', '2025-11-29 00:44:59'),
(13, 13, 'Cash on Delivery', 'COD-ORD-20251201-D6AEC454', '109997.80', 'completed', '2025-11-30 18:27:41', '2025-12-01 01:27:39'),
(14, 14, 'Credit Card', 'TXN-20251202135748-E1BDC18E', '50598.90', 'completed', '2025-12-02 05:57:48', '2025-12-02 05:57:17'),
(15, 15, 'Cash on Delivery', 'COD-ORD-20251203-B9B1255F', '70397.80', 'pending', '2025-12-03 05:17:25', '2025-12-03 05:17:21'),
(16, 16, 'Cash on Delivery', 'COD-ORD-20251205-1BB37862', '16497.80', 'pending', '2025-12-05 05:01:51', '2025-12-05 05:01:32'),
(17, 17, 'Cash on Delivery', 'COD-ORD-20251205-22D742E2', '2198.90', 'pending', '2025-12-05 05:13:58', '2025-12-05 05:13:54'),
(18, 18, 'Cash on Delivery', 'COD-ORD-20251205-A7A9ECA8', '28597.80', 'pending', '2025-12-05 05:18:32', '2025-12-05 05:18:29'),
(19, 19, 'Cash on Delivery', 'COD-ORD-20251205-1264ECE9', '16498.90', 'pending', '2025-12-05 05:51:14', '2025-12-05 05:46:34'),
(20, 20, 'Cash on Delivery', 'COD-ORD-20251205-B2FBD260', '35198.90', 'pending', '2025-12-05 05:52:58', '2025-12-05 05:52:53'),
(21, 21, 'Cash on Delivery', 'COD-ORD-20251205-755529A4', '47298.90', 'pending', '2025-12-05 06:25:39', '2025-12-05 06:25:34'),
(22, 22, 'Cash on Delivery', 'COD-ORD-20251205-23F63866', '28597.80', 'pending', '2025-12-05 06:31:53', '2025-12-05 06:31:50'),
(23, 23, 'Cash on Delivery', 'COD-ORD-20251205-A6392FEF', '14298.90', 'pending', '2025-12-05 06:51:39', '2025-12-05 06:51:35');
=======
(1, 1, 'Cash on Delivery', NULL, 55998.88, 'pending', NULL, '2025-11-28 10:45:23'),
(2, 2, 'Credit Card', NULL, 235196.64, 'pending', NULL, '2025-11-28 11:40:01'),
(3, 3, 'GCash', NULL, 21837.76, 'pending', NULL, '2025-11-28 11:50:00'),
(4, 4, 'GCash', NULL, 21837.76, 'pending', NULL, '2025-11-28 12:03:06'),
(5, 5, 'GCash', NULL, 21837.76, 'pending', NULL, '2025-11-28 12:10:24'),
(6, 6, 'Cash on Delivery', NULL, 21837.76, 'pending', NULL, '2025-11-28 12:42:43'),
(7, 7, 'GCash', NULL, 21837.76, 'pending', NULL, '2025-11-28 23:49:05'),
(8, 8, 'GCash', NULL, 21837.76, 'pending', NULL, '2025-11-28 23:52:14'),
(9, 9, 'Cash on Delivery', NULL, 21837.76, 'pending', NULL, '2025-11-29 00:03:43'),
(10, 10, 'GCash', 'TXN-20251129010739-77DDAF4E', 21837.76, 'completed', '2025-11-28 17:07:39', '2025-11-29 00:06:33'),
(11, 11, 'GCash', 'TXN-20251129011035-5E35E5F7', 55998.88, 'completed', '2025-11-28 17:10:35', '2025-11-29 00:10:25'),
(12, 12, 'GCash', 'TXN-20251129014517-0AA0838D', 111997.76, 'completed', '2025-11-28 17:45:17', '2025-11-29 00:44:59'),
(13, 13, 'Cash on Delivery', 'COD-ORD-20251201-D6AEC454', 109997.80, 'completed', '2025-11-30 18:27:41', '2025-12-01 01:27:39');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `dimensions` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `sale_price`, `sku`, `brand`, `weight`, `dimensions`, `is_active`, `featured`, `created_at`, `updated_at`) VALUES
<<<<<<< HEAD
(1, 1, 'Samsung Galaxy S24 Ultra', '6.8-inch Dynamic AMOLED display, 200MP camera, 12GB RAM, 256GB storage', '54999.00', '49999.00', 'ELEC-SMSG-S24U-256', 'Samsung', '0.23', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(2, 1, 'Apple iPhone 15 Pro Max', 'A17 Pro chip, Titanium design, 48MP camera, 256GB', '69999.00', NULL, 'ELEC-APPL-IP15PM-256', 'Apple', '0.22', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(3, 1, 'Sony WH-1000XM5 Headphones', 'Premium noise cancelling wireless headphones with 30-hour battery', '16999.00', '14999.00', 'ELEC-SONY-WH1000XM5', 'Sony', '0.25', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(4, 1, 'Dell XPS 15 Laptop', '15.6\" 4K display, Intel i7-13700H, 16GB RAM, 512GB SSD, RTX 4050', '89999.00', NULL, 'ELEC-DELL-XPS15-I7', 'Dell', '1.86', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(5, 1, 'Logitech MX Master 3S Mouse', 'Wireless ergonomic mouse with 8K DPI sensor', '4999.00', '4499.00', 'ELEC-LOGI-MXM3S', 'Logitech', '0.14', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(6, 1, 'Samsung 55\" 4K Smart TV', 'Crystal UHD 4K display, Tizen OS, HDR10+', '32999.00', '29999.00', 'ELEC-SMSG-TV55-4K', 'Samsung', '15.50', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(7, 1, 'Anker PowerCore 20000mAh', 'High-capacity portable charger with fast charging', '2499.00', NULL, 'ELEC-ANKR-PC20K', 'Anker', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(8, 1, 'Canon EOS R6 Mark II', 'Full-frame mirrorless camera, 24.2MP, 4K 60fps video', '149999.00', NULL, 'ELEC-CANN-R6M2', 'Canon', '0.67', NULL, 0, 1, '2025-11-24 02:27:17', '2025-12-01 07:08:50'),
(9, 2, 'Levi\'s 501 Original Jeans', 'Classic straight fit denim jeans, 100% cotton', '3499.00', '2999.00', 'CLTH-LEVI-501-BLU-32', 'Levi\'s', '0.60', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(10, 2, 'Nike Dri-FIT Running Shirt', 'Moisture-wicking performance t-shirt, breathable fabric', '1499.00', NULL, 'CLTH-NIKE-DRIF-BLK-L', 'Nike', '0.15', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(11, 2, 'Adidas Ultraboost 23 Shoes', 'Premium running shoes with Boost cushioning technology', '8999.00', '7999.00', 'CLTH-ADID-UB23-WHT-10', 'Adidas', '0.75', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(12, 2, 'The North Face Resolve Jacket', 'Waterproof windbreaker with adjustable hood', '5999.00', NULL, 'CLTH-TNF-RSLV-GRN-M', 'The North Face', '0.40', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(13, 2, 'Uniqlo Heattech Thermal Wear', 'Heat-generating base layer for cold weather', '799.00', '599.00', 'CLTH-UNIQ-HEAT-GRY-M', 'Uniqlo', '0.20', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(14, 2, 'Ralph Lauren Polo Shirt', 'Classic fit cotton polo with signature pony logo', '2999.00', NULL, 'CLTH-RL-POLO-NVY-L', 'Ralph Lauren', '0.25', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(15, 2, 'H&M Cotton Chino Pants', 'Slim fit chinos with stretch fabric', '1299.00', '999.00', 'CLTH-HM-CHIN-KHK-32', 'H&M', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(16, 3, 'Dyson V15 Detect Cordless Vacuum', 'Laser dust detection, 60-minute runtime, HEPA filtration', '29999.00', '27999.00', 'HOME-DYSO-V15DET', 'Dyson', '3.10', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(17, 3, 'Philips Hue Smart Bulb Starter Kit', '4-pack color-changing LED bulbs with bridge', '6999.00', NULL, 'HOME-PHIL-HUE-4PK', 'Philips', '0.50', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(18, 3, 'KitchenAid Stand Mixer', '5-quart tilt-head mixer with 10 speeds, includes accessories', '18999.00', '16999.00', 'HOME-KA-MIXER-RED', 'KitchenAid', '10.20', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(19, 3, 'Nespresso Vertuo Coffee Maker', 'One-touch espresso and coffee machine with frother', '8999.00', NULL, 'HOME-NESP-VERT-BLK', 'Nespresso', '4.50', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(20, 3, 'iRobot Roomba j7+', 'Self-emptying robot vacuum with object recognition', '39999.00', '35999.00', 'HOME-IRO-J7PLUS', 'iRobot', '3.40', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(21, 3, 'Black+Decker 20V Drill Kit', 'Cordless drill with 2 batteries and carrying case', '3999.00', NULL, 'HOME-BD-DRILL-20V', 'Black+Decker', '2.00', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(22, 3, 'Weber Genesis Gas Grill', '3-burner propane grill with side burner and storage', '34999.00', NULL, 'HOME-WEBR-GEN-3B', 'Weber', '65.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(23, 1, 'Yeti Tundra 45 Cooler', 'Rotomolded construction, bear-resistant, 28-can capacity', '19999.00', NULL, 'SPRT-YETI-T45-WHT', '0', '10.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-12-03 05:09:10'),
(24, 1, 'Trek Marlin 7 Mountain Bike', '29-inch wheels, 21-speed, aluminum frame', '32999.00', '29999.00', 'SPRT-TREK-M7-BLU-M', '0', '13.50', NULL, 1, 1, '2025-11-24 02:27:17', '2025-12-03 05:09:16'),
(25, 1, 'Coleman Sundome Tent 4-Person', 'WeatherTec system, easy setup, fits 4 campers', '4999.00', NULL, 'SPRT-COLM-SD4-GRN', '0', '5.80', NULL, 1, 0, '2025-11-24 02:27:17', '2025-12-03 05:09:30'),
(26, 4, 'TRX Home2 Suspension Trainer', 'Total body resistance training system with workout guide', '7999.00', '6999.00', 'SPRT-TRX-HM2-BLK', 'TRX', '1.20', NULL, 0, 0, '2025-11-24 02:27:17', '2025-12-01 07:08:44'),
(27, 1, 'Bowflex SelectTech 552 Dumbbells', 'Adjustable dumbbells, 5-52.5 lbs per dumbbell', '24999.00', NULL, 'SPRT-BWFX-ST552', '0', '25.00', NULL, 1, 1, '2025-11-24 02:27:17', '2025-12-03 05:09:39'),
(28, 1, 'GoPro HERO12 Black', '5.3K60 video, HyperSmooth 6.0, waterproof to 33ft', '21999.00', '19999.00', 'SPRT-GPRO-H12-BLK', '0', '0.15', NULL, 1, 1, '2025-11-24 02:27:17', '2025-12-03 05:09:46'),
(29, 1, 'Wilson Evolution Basketball', 'Official size, composite leather, indoor use', '2499.00', NULL, 'SPRT-WILS-EVO-BBAL', '0', '0.62', NULL, 1, 0, '2025-11-24 02:27:17', '2025-12-03 05:09:51'),
(30, 5, 'Atomic Habits by James Clear', 'Proven framework for improving every day, hardcover', '899.00', '749.00', 'BOOK-ATML-HBIT-HC', 'Penguin Random House', '0.40', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(31, 5, 'The Psychology of Money', 'Timeless lessons on wealth and happiness by Morgan Housel', '699.00', NULL, 'BOOK-PSYC-MONY-PB', 'Harriman House', '0.35', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(32, 5, 'Educated: A Memoir', 'Tara Westover\'s powerful story of self-invention', '799.00', '649.00', 'BOOK-EDUC-MEMO-PB', 'Random House', '0.38', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(33, 5, 'The Lean Startup', 'How today\'s entrepreneurs build successful businesses', '999.00', NULL, 'BOOK-LEAN-STRT-HC', 'Crown Business', '0.45', NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(34, 5, 'Sapiens: A Brief History', 'Yuval Noah Harari\'s journey through human history', '1299.00', '999.00', 'BOOK-SAPI-HIST-HC', 'Harper', '0.65', NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(35, 1, 'Apple iPad Air 5th Gen', 'M1 chip, 10.9-inch Liquid Retina display, 64GB, Wi-Fi', '34999.00', '31999.00', 'ELEC-APPL-IPA5-64', 'Apple', '0.46', '24.8 x 17.8 x 0.6 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(36, 1, 'Samsung Galaxy Watch 6', '44mm, Bluetooth, health monitoring, sleep tracking', '14999.00', '12999.00', 'ELEC-SMSG-GW6-44', 'Samsung', '0.33', '44 x 44 x 9 mm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(37, 1, 'Bose QuietComfort 45', 'Noise cancelling headphones, 24-hour battery life', '16999.00', '14999.00', 'ELEC-BOSE-QC45-BK', 'Bose', '0.24', '18 x 16 x 8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(38, 1, 'Microsoft Surface Pro 9', '13-inch 2-in-1 laptop, Intel i5, 8GB RAM, 256GB SSD', '69999.00', '64999.00', 'ELEC-MSFT-SP9-I5', 'Microsoft', '0.88', '28.7 x 20.9 x 0.9 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(39, 1, 'Google Pixel 8 Pro', '6.7-inch display, Tensor G3 chip, 128GB, camera system', '49999.00', '45999.00', 'ELEC-GOOG-P8P-128', 'Google', '0.21', '16.3 x 7.6 x 0.9 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(40, 1, 'Amazon Echo Dot 5th Gen', 'Smart speaker with Alexa, improved audio quality', '2499.00', '1999.00', 'ELEC-AMZN-EDOT5-BL', 'Amazon', '0.30', '10 x 10 x 9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(41, 1, 'DJI Mini 3 Pro Drone', '4K camera, 34-min flight time, under 249g weight', '45999.00', '42999.00', 'ELEC-DJI-M3P-FLY', 'DJI', '0.25', '14.5 x 8.6 x 3.4 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(42, 1, 'Fitbit Charge 6', 'Advanced health & fitness tracker, GPS, Spotify', '8999.00', '7999.00', 'ELEC-FBIT-CRG6-BK', 'Fitbit', '0.03', '3.7 x 1.8 x 1.2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(43, 1, 'Razer BlackWidow V4', 'Mechanical gaming keyboard, RGB lighting, green switches', '8999.00', '7999.00', 'ELEC-RAZR-BWV4-GN', 'Razer', '1.10', '44.5 x 15.3 x 3.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(44, 1, 'LG UltraWide Monitor 34\"', '34-inch curved QHD monitor, 144Hz, HDR10', '34999.00', '31999.00', 'ELEC-LG-34UW-CURV', 'LG', '6.80', '81.5 x 36.5 x 24.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(45, 1, 'HP Envy x360 Laptop', '15.6-inch touchscreen, AMD Ryzen 7, 16GB RAM, 512GB', '54999.00', '49999.00', 'ELEC-HP-ENVY-R7', 'HP', '1.78', '35.8 x 24.2 x 1.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(46, 1, 'JBL Flip 6 Speaker', 'Portable Bluetooth speaker, waterproof, 12-hour battery', '6999.00', '5999.00', 'ELEC-JBL-FLP6-BL', 'JBL', '0.55', '17.8 x 7.2 x 7.2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(47, 1, 'Nintendo Switch OLED', '7-inch OLED screen, 64GB, enhanced audio, white joy-cons', '19999.00', '17999.00', 'ELEC-NINT-SWOL-WH', 'Nintendo', '0.42', '24.2 x 10.2 x 1.4 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(48, 1, 'SanDisk 1TB Extreme SSD', 'Portable SSD, 1050MB/s read, water and dust resistant', '8999.00', '7999.00', 'ELEC-SAND-1TB-EXT', 'SanDisk', '0.04', '9.6 x 5 x 0.9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(49, 1, 'Belkin Wireless Charger', '15W fast wireless charging pad, iPhone/android compatible', '2999.00', '2499.00', 'ELEC-BELK-WCHG15', 'Belkin', '0.10', '10 x 10 x 1 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(50, 1, 'ASUS ROG Gaming Laptop', '16-inch QHD, Intel i9, RTX 4070, 32GB RAM, 1TB SSD', '129999.00', '119999.00', 'ELEC-ASUS-ROG-I9', 'ASUS', '2.30', '35.5 x 24.3 x 2.1 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(51, 1, 'Garmin Fenix 7X', 'Multisport GPS watch, solar charging, 28-day battery', '44999.00', '41999.00', 'ELEC-GARM-FNX7X', 'Garmin', '0.09', '5.1 x 5.1 x 1.8 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(52, 1, 'Sonos One Speaker', 'Smart speaker with Alexa, rich sound, multi-room audio', '14999.00', '12999.00', 'ELEC-SONO-ONE-BK', 'Sonos', '1.85', '16.1 x 11.9 x 11.9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(53, 1, 'Wyze Cam v3 Pro', '2K security camera, color night vision, weatherproof', '3999.00', '3499.00', 'ELEC-WYZE-CAMV3P', 'Wyze', '0.18', '5.1 x 5.1 x 3.2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(54, 1, 'Logitech G Pro X Headset', 'Professional gaming headset, Blue VO!CE mic, 50mm drivers', '9999.00', '8999.00', 'ELEC-LOGI-GPX-BK', 'Logitech', '0.32', '19 x 17 x 8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(55, 1, 'Corsair K70 Keyboard', 'Mechanical keyboard, Cherry MX Red, RGB, aluminum frame', '8999.00', '7999.00', 'ELEC-CORS-K70-RED', 'Corsair', '1.20', '43.8 x 16.6 x 3.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(56, 1, 'Epson EcoTank Printer', 'Wireless color printer, cartridge-free, 2-year ink supply', '14999.00', '12999.00', 'ELEC-EPSN-ET4760', 'Epson', '6.80', '37.5 x 34.7 x 18.7 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(57, 1, 'SteelSeries Aerox 5', 'Wireless gaming mouse, 18K CPI, 180-hour battery', '6999.00', '5999.00', 'ELEC-STEL-AX5-WL', 'SteelSeries', '0.07', '12.7 x 6.6 x 3.9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(58, 1, 'HyperX Cloud II Headset', '7.1 virtual surround sound, memory foam ear cushions', '5999.00', '4999.00', 'ELEC-HYPR-CLD2-RD', 'HyperX', '0.32', '19 x 18 x 9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(59, 1, 'Anker 737 Power Bank', '24,000mAh, 140W output, GaNPrime technology', '7999.00', '6999.00', 'ELEC-ANKR-737-PB', 'Anker', '0.40', '10.8 x 5.4 x 2.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(60, 1, 'TP-Link Deco Mesh WiFi', 'Whole home coverage, 5,500 sq ft, 3-pack system', '12999.00', '11999.00', 'ELEC-TPLN-DECO-X60', 'TP-Link', '0.50', '10 x 10 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(61, 1, 'Acer Predator Monitor', '27-inch 4K, 144Hz, 1ms response, G-Sync compatible', '39999.00', '36999.00', 'ELEC-ACER-PRED27', 'Acer', '5.60', '61.2 x 36.9 x 22.7 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(62, 1, 'GoPro MAX 360 Camera', '360-degree capture, waterproof, 5.6K30 video', '29999.00', '27999.00', 'ELEC-GPRO-MAX360', 'GoPro', '0.16', '6.6 x 5.6 x 2.7 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(63, 1, 'Samsung Galaxy Tab S9', '11-inch AMOLED, Snapdragon 8 Gen 2, 256GB, S Pen included', '45999.00', '42999.00', 'ELEC-SMSG-TABS9', 'Samsung', '0.50', '25.4 x 16.5 x 0.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(64, 1, 'Apple AirPods Pro 2', 'Active noise cancellation, spatial audio, MagSafe case', '14999.00', '13999.00', 'ELEC-APPL-APRP2', 'Apple', '0.05', '6 x 4 x 2 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(65, 2, 'Under Armour Sportstyle Hoodie', 'Cotton-polyester blend, relaxed fit, kangaroo pocket', '2999.00', '2599.00', 'CLTH-UA-HOOD-GRY-L', 'Under Armour', '0.45', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(66, 2, 'Calvin Klein Slim Fit Suit', 'Modern slim fit suit, wool blend, includes jacket and pants', '12999.00', '11999.00', 'CLTH-CK-SUIT-BLK-40', 'Calvin Klein', '1.80', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(67, 2, 'Columbia Fleece Jacket', 'Full-zip fleece jacket, moisture-wicking, lightweight', '3999.00', '3499.00', 'CLTH-COL-FLCE-BLU-M', 'Columbia', '0.35', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(68, 2, 'Patagonia Better Sweater', '100% recycled polyester fleece, full-zip, quarter-zip', '6999.00', '6499.00', 'CLTH-PATG-BSWT-GRN-L', 'Patagonia', '0.55', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(69, 2, 'Lacoste Classic Polo', 'Iconic crocodile logo, pique cotton, regular fit', '3499.00', '2999.00', 'CLTH-LACO-POLO-WHT-M', 'Lacoste', '0.25', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(70, 2, 'Tommy Hilfiger Denim Jacket', 'Classic denim jacket, distressed wash, button front', '4999.00', '4499.00', 'CLTH-TOMY-DJKT-BLU-L', 'Tommy Hilfiger', '0.60', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(71, 2, 'New Balance Fresh Foam Shoes', 'Running shoes, Fresh Foam midsole, rubber outsole', '5999.00', '5499.00', 'CLTH-NBAL-FRSH-10', 'New Balance', '0.70', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(72, 2, 'Champion Reverse Weave Hoodie', 'Heavyweight cotton, oversized fit, embroidered logo', '3999.00', '3499.00', 'CLTH-CHMP-RWH-BLK-XL', 'Champion', '0.75', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(73, 2, 'Vans Old Skool Sneakers', 'Classic skate shoes, canvas and suede, side stripe', '3499.00', '2999.00', 'CLTH-VANS-OS-BLK-9', 'Vans', '0.65', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(74, 2, 'Nike Air Max 270', 'Lifestyle shoes, Max Air unit, breathable mesh', '7999.00', '6999.00', 'CLTH-NIKE-AM270-10', 'Nike', '0.68', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(75, 2, 'Converse Chuck Taylor All Star', 'Classic high-top canvas shoes, rubber toe cap', '2499.00', '2199.00', 'CLTH-CONV-CTAS-HI', 'Converse', '0.55', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(76, 2, 'Levi\'s Trucker Jacket', 'Classic denim jacket, slim fit, button closure', '4499.00', '3999.00', 'CLTH-LEVI-TRKR-MED', 'Levi\'s', '0.65', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(77, 2, 'Hugo Boss Dress Shirt', 'Non-iron cotton, regular fit, button-down collar', '2999.00', '2699.00', 'CLTH-HUGO-DRSH-WHT-16', 'Hugo Boss', '0.20', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(78, 2, 'Puma Cali Sport Sneakers', 'Women\'s fashion sneakers, leather upper, platform sole', '3999.00', '3499.00', 'CLTH-PUMA-CALI-8', 'Puma', '0.58', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(79, 2, 'Reebok Nano X3', 'Cross-training shoes, Floatride Energy foam, durable', '5999.00', '5499.00', 'CLTH-REEB-NANO-10', 'Reebok', '0.72', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(80, 2, 'Michael Kors Tote Bag', 'Leather tote bag, gold-tone hardware, zip closure', '8999.00', '7999.00', 'CLTH-MKRS-TOTE-BLK', 'Michael Kors', '0.85', '35 x 28 x 15 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(81, 2, 'Ray-Ban Aviator Sunglasses', 'Classic aviator style, polarized lenses, metal frame', '7999.00', '7499.00', 'CLTH-RAYB-AVT-GLD', 'Ray-Ban', '0.03', '14 x 5 x 2 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(82, 2, 'Skechers Go Walk Shoes', 'Slip-on walking shoes, lightweight, memory foam', '2999.00', '2699.00', 'CLTH-SKCH-GWALK-9', 'Skechers', '0.45', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(83, 2, 'Oakley Flak Jacket Sunglasses', 'Sport sunglasses, PRIZM lenses, durable frame', '6999.00', '6499.00', 'CLTH-OAKL-FLAK-BLK', 'Oakley', '0.04', '13 x 6 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(84, 2, 'The North Face Apex Flex', 'Soft shell jacket, windproof, stretch fabric', '7999.00', '7499.00', 'CLTH-TNF-APEX-M', 'The North Face', '0.48', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(85, 2, 'Timberland Premium Boots', 'Waterproof leather boots, seam-sealed construction', '9999.00', '8999.00', 'CLTH-TMBL-PREM-10', 'Timberland', '1.20', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(86, 2, 'Fossil Gen 6 Smartwatch', 'Smartwatch with Wear OS, heart rate, GPS, 44mm', '12999.00', '11999.00', 'CLTH-FOSL-GEN6-BK', 'Fossil', '0.08', '4.4 x 4.4 x 1.3 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(87, 2, 'Coach Signature Wallet', 'Leather wallet, multiple card slots, bill compartment', '4999.00', '4499.00', 'CLTH-COCH-WLT-BRN', 'Coach', '0.12', '10 x 8 x 1 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(88, 2, 'Arcteryx Beta AR Jacket', 'Gore-Tex Pro shell, storm hood, lightweight', '19999.00', '18999.00', 'CLTH-ARCT-BETA-L', 'Arcteryx', '0.42', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(89, 2, 'Salomon Speedcross 5', 'Trail running shoes, aggressive grip, waterproof', '7999.00', '7499.00', 'CLTH-SALO-SPD5-10', 'Salomon', '0.65', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(90, 2, 'Brooks Ghost 15', 'Neutral running shoes, DNA LOFT cushioning', '6999.00', '6499.00', 'CLTH-BROK-GHST-10', 'Brooks', '0.68', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(91, 2, 'Marmot PreCip Jacket', 'Rain jacket, waterproof breathable, pit zips', '5999.00', '5499.00', 'CLTH-MARM-PREC-M', 'Marmot', '0.32', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(92, 2, 'ASICS Gel-Kayano 30', 'Stability running shoes, Gel technology, breathable', '8999.00', '8499.00', 'CLTH-ASIC-KYNO-10', 'ASICS', '0.72', NULL, 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(93, 2, 'Oakley Holbrook Sunglasses', 'Classic square frame, PRIZM lenses, lightweight', '5999.00', '5499.00', 'CLTH-OAKL-HLBK-MT', 'Oakley', '0.03', '13 x 5 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(94, 2, 'Mizuno Wave Rider 27', 'Neutral running shoes, Wave plate technology', '7999.00', '7499.00', 'CLTH-MIZU-WAVE-10', 'Mizuno', '0.70', NULL, 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(95, 3, 'Ninja Foodi Air Fryer', '8-in-1 air fryer, dehydrator, roast, bake, grill', '9999.00', '8999.00', 'HOME-NINJ-FOODI8', 'Ninja', '5.80', '35 x 33 x 35 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(96, 3, 'Instant Pot Duo Nova', '7-in-1 electric pressure cooker, 6-quart capacity', '6999.00', '6499.00', 'HOME-INST-DUO6QT', 'Instant Pot', '5.20', '30 x 30 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(97, 3, 'Breville Barista Express', 'Espresso machine with grinder, milk frother, 15 bar', '39999.00', '37999.00', 'HOME-BREV-BAREXP', 'Breville', '12.50', '32 x 33 x 40 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(98, 3, 'Vitamix 5200 Blender', 'Professional-grade blender, 2.2 HP motor, 64oz jar', '29999.00', '27999.00', 'HOME-VITA-5200-BL', 'Vitamix', '6.20', '46 x 20 x 25 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(99, 3, 'Cuisinart Food Processor', '14-cup capacity, dough blade, slicing/shredding discs', '8999.00', '8499.00', 'HOME-CUIS-FP14C', 'Cuisinart', '4.80', '25 x 35 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(100, 3, 'Shark Navigator Vacuum', 'Upright vacuum, lift-away pod, HEPA filter, corded', '9999.00', '8999.00', 'HOME-SHRK-NAV-LA', 'Shark', '6.50', '45 x 30 x 25 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(101, 3, 'Keurig K-Elite Coffee Maker', 'Single-serve coffee maker, iced coffee setting, 75oz', '8999.00', '8499.00', 'HOME-KEUR-KELITE', 'Keurig', '4.20', '33 x 25 x 38 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(102, 3, 'Lodge Cast Iron Skillet', 'Pre-seasoned cast iron, 10.25-inch, oven safe', '1999.00', '1799.00', 'HOME-LODG-CISK10', 'Lodge', '2.10', '26 x 26 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(103, 3, 'Zojirushi Rice Cooker', '5.5-cup capacity, fuzzy logic, multiple settings', '7999.00', '7499.00', 'HOME-ZOJI-RC55-FL', 'Zojirushi', '3.50', '29 x 24 x 22 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(104, 3, 'All-Clad Stainless Pan Set', '3-piece stainless steel cookware set, induction ready', '14999.00', '13999.00', 'HOME-ALLCLAD-3PC', 'All-Clad', '4.80', 'Varies', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(105, 3, 'OXO Good Grips Tools', '14-piece kitchen tool set, comfortable handles', '2999.00', '2699.00', 'HOME-OXO-14PC-KT', 'OXO', '1.80', '40 x 25 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(106, 3, 'Crock-Pot Slow Cooker', '7-quart programmable slow cooker, digital timer', '3999.00', '3699.00', 'HOME-CROCK-P7QT', 'Crock-Pot', '4.50', '35 x 35 x 28 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(107, 3, 'KitchenAid Food Chopper', '3.5-cup food chopper, two-speed control, easy clean', '1999.00', '1799.00', 'HOME-KA-CHOP-35', 'KitchenAid', '1.50', '18 x 18 x 24 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(108, 3, 'Hamilton Beach Toaster Oven', '6-slice capacity, convection bake, broil, toast', '2999.00', '2699.00', 'HOME-HAMB-TOV6S', 'Hamilton Beach', '5.20', '45 x 35 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(109, 3, 'Wusthof Classic Knife Set', '8-piece German steel knife set, block included', '12999.00', '11999.00', 'HOME-WUST-CLASSIC8', 'Wusthof', '3.20', '30 x 20 x 15 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(110, 3, 'Rubbermaid Food Storage', '40-piece food storage set, BPA-free, microwave safe', '1999.00', '1799.00', 'HOME-RUBR-FS40PC', 'Rubbermaid', '2.50', '35 x 25 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(111, 3, 'Simplehuman Trash Can', 'Sensor can, stainless steel, 50-liter capacity', '6999.00', '6499.00', 'HOME-SIMP-SEN50', 'Simplehuman', '4.80', '30 x 30 x 60 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(112, 3, 'Mr. Coffee Espresso Maker', '15-bar pump espresso machine, milk frother', '4999.00', '4499.00', 'HOME-MRCOF-ESP15', 'Mr. Coffee', '3.50', '25 x 20 x 35 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(113, 3, 'Farberware Cookware Set', '12-piece non-stick cookware set, dishwasher safe', '5999.00', '5499.00', 'HOME-FARB-12PC-NST', 'Farberware', '8.50', 'Varies', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(114, 3, 'Pyrex Glass Storage Set', '18-piece glass storage set, freezer to oven safe', '2999.00', '2699.00', 'HOME-PYREX-18PC', 'Pyrex', '5.20', '35 x 25 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(115, 3, 'Oster Blender', '6-speed blender, 48oz glass jar, ice crush function', '1999.00', '1799.00', 'HOME-OSTR-BLND6S', 'Oster', '3.20', '22 x 18 x 38 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(116, 3, 'Sunbeam Stand Mixer', '4.5-quart stand mixer, 5 speeds, includes attachments', '4999.00', '4499.00', 'HOME-SUNB-SMIX45', 'Sunbeam', '6.80', '35 x 25 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(117, 3, 'Cuisinart Griddler', '4-in-1 contact grill, panini press, open grill', '5999.00', '5499.00', 'HOME-CUIS-GRDLR', 'Cuisinart', '5.50', '35 x 30 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(118, 3, 'Weber Charcoal Grill', '22-inch kettle grill, porcelain-enameled bowl', '4999.00', '4499.00', 'HOME-WEBR-KETTLE22', 'Weber', '18.50', '50 x 50 x 100 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(119, 3, 'GreenPan Cookware Set', '8-piece ceramic non-stick set, healthy cooking', '7999.00', '7499.00', 'HOME-GRNPN-8PC-CER', 'GreenPan', '6.50', 'Varies', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(120, 3, 'Blackstone Griddle', '36-inch outdoor griddle, 4 burners, stainless steel', '19999.00', '18999.00', 'HOME-BLSTN-GRD36', 'Blackstone', '45.00', '140 x 70 x 90 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(121, 3, 'Anova Sous Vide', 'Precision cooker, WiFi/Bluetooth, restaurant quality', '6999.00', '6499.00', 'HOME-ANOVA-SV-WIFI', 'Anova', '0.80', '38 x 6 x 6 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(122, 3, 'Magic Bullet Blender', '17-piece set, personal blender, 250-watt motor', '1999.00', '1799.00', 'HOME-MGBLT-17PC', 'Magic Bullet', '2.50', '25 x 25 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(123, 3, 'Cuisinart Coffee Maker', '14-cup programmable coffee maker, auto shut-off', '2999.00', '2699.00', 'HOME-CUIS-CM14C', 'Cuisinart', '3.20', '35 x 25 x 35 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(124, 3, 'T-fal Cookware Set', '12-piece non-stick set, thermo-spot heat indicator', '4999.00', '4499.00', 'HOME-TFAL-12PC-NS', 'T-fal', '7.50', 'Varies', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(125, 1, 'Razer BlackWidow V4 Pro', 'Mechanical gaming keyboard, Razer Yellow switches, RGB', '12999.00', '11999.00', 'SPRT-RAZR-BW4PRO', '0', '1.35', '45 x 15 x 4 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:47:20'),
(126, 1, 'Garmin Forerunner 955', 'GPS running watch, multi-band GNSS, training metrics', '34999.00', '32999.00', 'SPRT-GARM-FR955', '0', '0.05', '4.6 x 4.6 x 1.3 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:48:05'),
(127, 1, 'HyperX Cloud Alpha', 'Gaming headset, dual chamber drivers, detachable mic', '6999.00', '6499.00', 'SPRT-HYPR-CLDA', '0', '0.33', '20 x 18 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:48:13'),
(128, 1, 'Corsair Vengeance RAM', '32GB DDR5 6000MHz, RGB lighting, Intel XMP 3.0', '8999.00', '8499.00', 'SPRT-CORS-VEN32', '0', '0.08', '13.3 x 4.9 x 0.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:48:21'),
(129, 1, 'Logitech G502 X Plus', 'Lightspeed wireless gaming mouse, LIGHTFORCE hybrid', '9999.00', '8999.00', 'SPRT-LOGI-G502X', '0', '0.10', '13.2 x 7.5 x 4.1 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:48:33'),
(130, 1, 'SteelSeries Arctis Nova Pro', 'Wireless gaming headset, active noise cancellation', '19999.00', '18999.00', 'SPRT-STEL-ANOVA', '0', '0.38', '21 x 19 x 10 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:48:47'),
(131, 1, 'ASUS ROG Strix Monitor', '27-inch 4K gaming monitor, 160Hz, HDR600, G-Sync', '49999.00', '46999.00', 'SPRT-ASUS-ROG27', '0', '6.50', '61 x 37 x 23 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:48:59'),
(132, 1, 'NZXT Kraken AIO Cooler', '240mm AIO liquid cooler, RGB pump, 2x 120mm fans', '8999.00', '8499.00', 'SPRT-NZXT-KRK240', '0', '1.20', '27 x 12 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:50:11'),
(133, 1, 'EVGA Supernova PSU', '850W 80+ Gold power supply, fully modular, 10-year', '9999.00', '9499.00', 'SPRT-EVGA-SN850', '0', '1.80', '15 x 15 x 8.6 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:50:25'),
(134, 1, 'Samsung 980 Pro SSD', '2TB NVMe M.2 SSD, PCIe 4.0, 7000MB/s read', '12999.00', '11999.00', 'SPRT-SAMS-980P2T', '0', '0.01', '8 x 2.2 x 0.2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:50:32'),
(135, 1, 'Cooler Master Case', 'Mid-tower ATX case, tempered glass, RGB fans', '6999.00', '6499.00', 'SPRT-CMST-MT500', '0', '8.20', '49 x 23 x 47 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:50:39'),
(136, 1, 'Thrustmaster T300RS', 'Force feedback racing wheel, GT edition, 1080° rotation', '19999.00', '18999.00', 'SPRT-THRU-T300RS', '0', '4.50', '45 x 35 x 30 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:50:45'),
(137, 1, 'Elgato Stream Deck', '15-key programmable stream deck, LCD keys', '6999.00', '6499.00', 'SPRT-ELGT-SDECK15', '0', '0.30', '12 x 8 x 3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:50:54'),
(138, 1, 'Blue Yeti Microphone', 'USB condenser microphone, multiple pattern selection', '8999.00', '8499.00', 'SPRT-BLUE-YETI-BLK', '0', '1.20', '12 x 12 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:51:07'),
(139, 1, 'Logitech C920 Webcam', '1080p webcam, auto light correction, built-in mic', '4999.00', '4499.00', 'SPRT-LOGI-C920HD', '0', '0.16', '9.5 x 2.5 x 2.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:51:22'),
(140, 1, 'Razer Viper V2 Pro', 'Ultra-lightweight wireless mouse, 58g, 30K DPI', '9999.00', '8999.00', 'SPRT-RAZR-VP2PRO', '0', '0.06', '12.6 x 6.7 x 3.8 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:51:37'),
(141, 1, 'SteelSeries QcK Mousepad', 'XXL gaming mousepad, cloth surface, non-slip base', '1999.00', '1799.00', 'SPRT-STEL-QCKXXL', '0', '0.45', '90 x 40 x 0.4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:51:43'),
(142, 1, 'Corsair K100 Keyboard', 'Optical-mechanical keyboard, 4000Hz polling, PBT keys', '14999.00', '13999.00', 'SPRT-CORS-K100', '0', '1.35', '46 x 16 x 4 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:52:06'),
(143, 1, 'HyperX Pulsefire Mouse', 'Gaming mouse, 16000 DPI, RGB lighting, 6 buttons', '3999.00', '3499.00', 'SPRT-HYPR-PULSE', '0', '0.09', '12.4 x 6.8 x 3.9 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 04:52:12'),
(144, 1, 'NVIDIA RTX 4080', '16GB GDDR6X graphics card, DLSS 3, ray tracing', '89999.00', '84999.00', 'SPRT-NVDA-408016', '0', '2.10', '30 x 13 x 6 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:52:17'),
(145, 1, 'AMD Ryzen 9 7950X', '16-core 32-thread processor, 5.7GHz boost, AM5 socket', '49999.00', '47999.00', 'SPRT-AMD-R97950', '0', '0.05', '4 x 4 x 1 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 04:52:24'),
(146, 1, 'Intel Core i9-14900K', '24-core processor, 5.8GHz boost, LGA1700 socket', '45999.00', '43999.00', 'SPRT-INTL-I914900', '0', '0.05', '4.5 x 3.5 x 0.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 05:02:10'),
(147, 1, 'ASUS ROG Motherboard', 'Z790 motherboard, DDR5, WiFi 6E, PCIe 5.0', '29999.00', '28999.00', 'SPRT-ASUS-Z790E', '0', '1.20', '30 x 24 x 6 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:02:34'),
(148, 1, 'G.Skill Trident RAM', '64GB DDR5 6400MHz, RGB, CL32 latency', '15999.00', '14999.00', 'SPRT-GSKL-TRI64', '0', '0.12', '13.3 x 4.9 x 0.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:03:26'),
(149, 1, 'Seagate FireCuda SSD', '4TB NVMe Gen4 SSD, 7300MB/s, heatsink included', '19999.00', '18999.00', 'SPRT-SEAG-FC4TB', '0', '0.02', '8 x 2.2 x 0.2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:03:34'),
(150, 1, 'be quiet! Dark Rock 4', 'Air CPU cooler, 200W TDP, silent wings fans', '5999.00', '5699.00', 'SPRT-BQUI-DRK4', '0', '1.10', '13.6 x 13.6 x 16.3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:03:39'),
(151, 1, 'Lian Li Case Fans', '3-pack 120mm RGB fans, daisy chain, PWM control', '3999.00', '3699.00', 'SPRT-LIAN-FAN3PK', '0', '0.45', '12 x 12 x 2.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:03:46'),
(152, 1, 'Fractal Design Case', 'ATX mid-tower, tempered glass, silent optimized', '7999.00', '7499.00', 'SPRT-FRAC-DESIGN', '0', '9.20', '54 x 23 x 45 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:10:05'),
(153, 1, 'MSI Gaming Monitor', '32-inch QHD, 165Hz, 1ms, HDR400, curved', '29999.00', '27999.00', 'SPRT-MSI-MON32Q', '0', '6.20', '71 x 52 x 24 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-03 05:08:49'),
(154, 1, 'Glorious Model O Mouse', 'Wireless gaming mouse, honeycomb shell, 67g weight', '5999.00', '5499.00', 'SPRT-GLOR-MODELO', '0', '0.07', '12.8 x 6.7 x 3.7 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-03 05:08:58'),
(155, 5, 'The Four Agreements', 'Practical guide to personal freedom by Don Miguel Ruiz', '899.00', '799.00', 'BOOK-FOUR-AGRM-PB', 'Amber-Allen', '0.25', '21 x 14 x 1.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(156, 5, 'Thinking, Fast and Slow', 'Daniel Kahneman\'s groundbreaking work on decision-making', '1299.00', '1199.00', 'BOOK-THINK-FS-HC', 'Farrar, Straus and Giroux', '0.68', '24 x 16 x 3 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(157, 5, 'The 7 Habits of Highly Effective People', 'Stephen R. Covey\'s classic on personal and professional effectiveness', '1099.00', '999.00', 'BOOK-7HABITS-HC', 'Simon & Schuster', '0.45', '23 x 15 x 2.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(158, 5, 'The Power of Now', 'Spiritual guide to living in the present moment by Eckhart Tolle', '999.00', '899.00', 'BOOK-POWER-NOW-PB', 'New World Library', '0.32', '21 x 14 x 2 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(159, 5, 'How to Win Friends and Influence People', 'Dale Carnegie\'s timeless classic on human relations', '899.00', '799.00', 'BOOK-WIN-FRNDS-PB', 'Gallery Books', '0.28', '21 x 14 x 1.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(160, 5, 'The Subtle Art of Not Giving a F*ck', 'Counterintuitive approach to living a good life by Mark Manson', '999.00', '899.00', 'BOOK-SUBTLE-ART-PB', 'HarperOne', '0.30', '21 x 14 x 2 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(161, 5, 'Rich Dad Poor Dad', 'Robert Kiyosaki\'s guide to financial literacy and wealth building', '899.00', '799.00', 'BOOK-RICH-DAD-PB', 'Plata Publishing', '0.26', '21 x 14 x 1.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(162, 5, 'The Alchemist', 'Paulo Coelho\'s magical story about following your dreams', '799.00', '699.00', 'BOOK-ALCHMIST-PB', 'HarperOne', '0.22', '20 x 13 x 1.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(163, 5, 'Man\'s Search for Meaning', 'Viktor Frankl\'s profound memoir and psychological exploration', '899.00', '799.00', 'BOOK-MANS-SRCH-PB', 'Beacon Press', '0.20', '21 x 14 x 1.2 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(164, 5, 'The 48 Laws of Power', 'Robert Greene\'s distillation of 3,000 years of power dynamics', '1299.00', '1199.00', 'BOOK-48LAWS-HC', 'Penguin Books', '0.85', '24 x 16 x 3.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(165, 5, 'Deep Work', 'Rules for focused success in a distracted world by Cal Newport', '999.00', '899.00', 'BOOK-DEEP-WORK-HC', 'Grand Central Publishing', '0.42', '21 x 14 x 2.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(166, 5, 'The 5 Love Languages', 'Gary Chapman\'s guide to expressing heartfelt commitment', '799.00', '699.00', 'BOOK-5LOVE-LANG-PB', 'Northfield Publishing', '0.24', '21 x 14 x 1.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(167, 5, 'The Intelligent Investor', 'Benjamin Graham\'s definitive book on value investing', '1499.00', '1399.00', 'BOOK-INTEL-INV-HC', 'Harper Business', '0.75', '24 x 16 x 3 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(168, 5, 'Mindset: The New Psychology of Success', 'Carol Dweck\'s groundbreaking work on growth mindset', '999.00', '899.00', 'BOOK-MINDSET-PB', 'Ballantine Books', '0.30', '21 x 14 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(169, 5, 'The Body Keeps the Score', 'Bessel van der Kolk on trauma, memory, and healing', '1199.00', '1099.00', 'BOOK-BODY-SCORE-PB', 'Penguin Books', '0.40', '23 x 15 x 2.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(170, 5, 'Atomic Habits Journal', 'Companion journal to build good habits and break bad ones', '699.00', '599.00', 'BOOK-ATML-JRNL-PB', 'Avery', '0.35', '23 x 18 x 1.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(171, 5, 'The Miracle Morning', 'Hal Elrod\'s proven method to transform your life before 8AM', '899.00', '799.00', 'BOOK-MIRAC-MORN-PB', 'Hal Elrod International', '0.28', '21 x 14 x 1.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(172, 5, 'Start with Why', 'Simon Sinek on how great leaders inspire action', '999.00', '899.00', 'BOOK-START-WHY-PB', 'Portfolio', '0.32', '21 x 14 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(173, 5, 'The 10X Rule', 'Grant Cardone\'s principle of massive action', '899.00', '799.00', 'BOOK-10X-RULE-HC', 'Wiley', '0.38', '23 x 15 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(174, 5, 'Can\'t Hurt Me', 'David Goggins\' story of transforming pain into power', '1099.00', '999.00', 'BOOK-CANT-HURT-HC', 'Lioncrest Publishing', '0.45', '24 x 16 x 2.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(175, 5, 'The Art of War', 'Sun Tzu\'s ancient military strategy applied to modern life', '599.00', '499.00', 'BOOK-ART-WAR-PB', 'Shambhala', '0.18', '20 x 13 x 1 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(176, 5, 'Meditations', 'Marcus Aurelius\' personal writings on Stoic philosophy', '799.00', '699.00', 'BOOK-MEDIT-PB', 'Penguin Classics', '0.22', '20 x 13 x 1.5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(177, 5, 'Principles: Life and Work', 'Ray Dalio\'s unconventional principles for success', '1499.00', '1399.00', 'BOOK-PRIN-LIFE-HC', 'Simon & Schuster', '0.85', '24 x 16 x 3.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(178, 5, 'Extreme Ownership', 'Jocko Willink and Leif Babin on leadership lessons from Navy SEALs', '1199.00', '1099.00', 'BOOK-EXTREME-OWN-HC', 'St. Martin\'s Press', '0.42', '24 x 16 x 2.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(179, 5, 'The Compound Effect', 'Darren Hardy on multiplying your success one step at a time', '899.00', '799.00', 'BOOK-COMPOUND-PB', 'Vanguard Press', '0.26', '21 x 14 x 1.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(180, 5, 'Thinking in Systems', 'Donella Meadows\' primer on systems thinking', '1099.00', '999.00', 'BOOK-THINK-SYS-PB', 'Chelsea Green Publishing', '0.35', '23 x 15 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(181, 5, 'Essentialism', 'Greg McKeown on disciplined pursuit of less', '999.00', '899.00', 'BOOK-ESSENTIAL-PB', 'Crown Business', '0.30', '21 x 14 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(182, 5, 'The Courage to Be Disliked', 'Japanese phenomenon on finding happiness and freedom', '899.00', '799.00', 'BOOK-COURAGE-DIS-PB', 'Atria Books', '0.25', '21 x 14 x 1.8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(183, 5, 'The Millionaire Fastlane', 'MJ DeMarco on cracking the code to wealth', '1099.00', '999.00', 'BOOK-MILL-FAST-PB', 'Viperion Publishing', '0.38', '23 x 15 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(184, 5, 'The 5 AM Club', 'Robin Sharma on mastering your morning and elevating your life', '999.00', '899.00', 'BOOK-5AM-CLUB-HC', 'HarperCollins', '0.42', '24 x 16 x 2.5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(185, 29, 'Nestle Nido Fortified Milk', 'Full cream milk powder, 1.8kg tin, for kids and adults', '899.00', '849.00', 'GROC-NEST-NIDO18', 'Nestle', '1.80', '15 x 15 x 20 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(186, 29, 'Bear Brand Sterilized Milk', '324ml can, 6-pack, full cream, no sugar added', '299.00', '279.00', 'GROC-BEAR-MLK6PK', 'Bear Brand', '2.00', '30 x 20 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(187, 29, 'Century Tuna Flakes in Oil', '155g can, hot & spicy variant, drained weight 95g', '49.00', '45.00', 'GROC-CENT-TUNA-OIL', 'Century', '0.16', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(188, 29, 'Argentina Corned Beef', '150g can, luncheon meat, ready to eat', '55.00', '52.00', 'GROC-ARGI-CB150', 'Argentina', '0.15', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(189, 29, 'San Marino Corned Tuna', '180g can, Spanish style, in vegetable oil', '65.00', '59.00', 'GROC-SANM-CTUNA', 'San Marino', '0.18', '8 x 8 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(190, 29, 'Purefoods Classic Hotdog', '1kg pack, regular size, 100% pure beef', '199.00', '189.00', 'GROC-PURE-HOTDOG', 'Purefoods', '1.00', '25 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(191, 29, 'Magnolia Fresh Milk', '1L carton, full cream, UHT processed', '89.00', '85.00', 'GROC-MAGN-MILK1L', 'Magnolia', '1.00', '10 x 10 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(192, 29, 'Selecta Ice Cream 1.5L', 'Cookies and cream flavor, family size', '249.00', '229.00', 'GROC-SELC-IC15L', 'Selecta', '1.50', '20 x 20 x 15 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(193, 29, 'Nestle All-Purpose Cream', '250ml tetra pack, for cooking and desserts', '59.00', '55.00', 'GROC-NEST-APC250', 'Nestle', '0.25', '8 x 8 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(194, 29, 'Alaska Evaporated Milk', '370ml can, full cream, for cooking and drinks', '45.00', '42.00', 'GROC-ALAS-EVAP370', 'Alaska', '0.37', '8 x 8 x 12 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(195, 29, 'Birch Tree Fortified Milk', '300g sachet, choco flavor, for kids', '129.00', '119.00', 'GROC-BIRCH-FORT300', 'Birch Tree', '0.30', '20 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(196, 29, 'Knorr Pork Cube', '8g per cube, 6 cubes pack, flavor seasoning', '25.00', '23.00', 'GROC-KNORR-PORK6', 'Knorr', '0.05', '10 x 5 x 2 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(197, 29, 'Lady\'s Choice Mayonnaise', '220ml jar, real mayonnaise, creamy texture', '89.00', '85.00', 'GROC-LADY-MAYO220', 'Lady\'s Choice', '0.22', '8 x 8 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(198, 29, 'CDO Karne Norte', '150g can, Filipino-style corned beef', '52.00', '49.00', 'GROC-CDO-KN150', 'CDO', '0.15', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(199, 29, '555 Sardines in Tomato Sauce', '155g can, Spanish style, spicy variant', '28.00', '25.00', 'GROC-555-SARD155', '555', '0.16', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(200, 29, 'Mega Sardines in Oil', '155g can, natural oil, chili added', '32.00', '29.00', 'GROC-MEGA-SARD155', 'Mega', '0.16', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(201, 29, 'Swift Meatloaf', '250g can, ready to eat, for sandwiches and meals', '65.00', '59.00', 'GROC-SWIFT-MLOAF', 'Swift', '0.25', '10 x 10 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(202, 29, 'Nestle Yogurt Drink', '90ml bottle, strawberry flavor, 6-pack', '149.00', '139.00', 'GROC-NEST-YOG6PK', 'Nestle', '0.55', '25 x 15 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(203, 29, 'Happy Peanuts Salted', '100g pack, roasted, salted peanuts', '35.00', '32.00', 'GROC-HAPPY-PNUT100', 'Happy', '0.10', '15 x 10 x 3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(204, 29, 'Magnolia Chicken Nuggets', '500g pack, breaded, ready to cook', '199.00', '189.00', 'GROC-MAGN-NUG500', 'Magnolia', '0.50', '20 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(205, 31, 'Del Monte Pineapple Slices', '432g can, in syrup, natural sweetness', '65.00', '59.00', 'GROC-DELM-PINE432', 'Del Monte', '0.43', '10 x 10 x 8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(206, 31, 'Libby\'s Vienna Sausage', '340g can, mini sausages in brine', '89.00', '85.00', 'GROC-LIBB-VIENA340', 'Libby\'s', '0.34', '10 x 10 x 8 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(207, 31, 'Hunt\'s Tomato Sauce', '227g can, no preservatives, for cooking', '35.00', '32.00', 'GROC-HUNT-TOM227', 'Hunt\'s', '0.23', '8 x 8 x 6 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(208, 31, 'Spam Lite', '340g can, less fat, less sodium', '199.00', '189.00', 'GROC-SPAM-LITE340', 'Spam', '0.34', '12 x 8 x 4 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(209, 31, 'Pampanga\'s Best Tocino', '250g pack, sweet cured pork, ready to cook', '129.00', '119.00', 'GROC-PAMP-TOC250', 'Pampanga\'s Best', '0.25', '20 x 15 x 3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(210, 31, 'Purefoods Tender Juicy Hotdog', '1kg pack, jumbo size, skinless', '219.00', '209.00', 'GROC-PURE-TJ1KG', 'Purefoods', '1.00', '25 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(211, 31, 'CDO Funtastyk Young Pork Tocino', '250g pack, sweet style, easy to cook', '89.00', '85.00', 'GROC-CDO-FYT250', 'CDO', '0.25', '20 x 15 x 3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(212, 31, 'Argentina Beef Loaf', '150g can, luncheon meat variant', '48.00', '45.00', 'GROC-ARGI-BLOAF150', 'Argentina', '0.15', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(213, 31, 'San Marino Corned Beef Chili', '150g can, spicy variant with chili', '58.00', '55.00', 'GROC-SANM-CBCHILI', 'San Marino', '0.15', '8 x 8 x 4 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(214, 31, 'Century Tuna Sweet & Spicy', '180g can, flakes in sweet spicy sauce', '55.00', '52.00', 'GROC-CENT-TUNA-SS', 'Century', '0.18', '8 x 8 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(215, 32, 'Lucky Me Pancit Canton', '80g pack, chili-mansi flavor, 10 packs bundle', '99.00', '89.00', 'GROC-LUCKY-PC10', 'Lucky Me', '0.80', '25 x 15 x 10 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(216, 32, 'Indomie Mi Goreng', '85g pack, Indonesian style, 5 packs', '89.00', '85.00', 'GROC-INDO-MG5PK', 'Indomie', '0.43', '20 x 15 x 5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(217, 32, 'Lucky Me Instant Mami', '65g pack, chicken flavor, 10 packs bundle', '85.00', '79.00', 'GROC-LUCKY-MAMI10', 'Lucky Me', '0.65', '25 x 15 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(218, 32, 'Nissin Cup Noodles', '68g cup, seafood flavor, 6 cups pack', '149.00', '139.00', 'GROC-NISS-CUP6PK', 'Nissin', '0.41', '25 x 20 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(219, 32, 'Payless Pancit Canton', '60g pack, extra hot chili flavor, 10 packs', '89.00', '85.00', 'GROC-PAYL-PC10', 'Payless', '0.60', '25 x 15 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(220, 32, 'Lucky Me Supreme La Paz Batchoy', '70g pack, Ilonggo style, 6 packs', '109.00', '99.00', 'GROC-LUCKY-LPB6', 'Lucky Me', '0.42', '20 x 15 x 8 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(221, 32, 'Maggi Magic Sarap', '8g sachet, all-purpose seasoning, 12 packs', '35.00', '32.00', 'GROC-MAGGI-MS12', 'Maggi', '0.10', '15 x 10 x 3 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(222, 32, 'San Remo Pasta', '500g pack, spaghetti, durum wheat semolina', '89.00', '85.00', 'GROC-SANR-SPG500', 'San Remo', '0.50', '25 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(223, 32, 'Barilla Spaghetti', '500g pack, Italian durum wheat, #5 thickness', '129.00', '119.00', 'GROC-BARIL-SPG500', 'Barilla', '0.50', '25 x 15 x 5 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(224, 32, 'Quickchow Instant Noodles', '55g pack, beef flavor, 10 packs bundle', '75.00', '69.00', 'GROC-QUICK-CHW10', 'Quickchow', '0.55', '25 x 15 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(225, 33, 'Nescafe Classic', '50g jar, instant coffee, 100% pure soluble', '89.00', '85.00', 'GROC-NESC-CLASS50', 'Nescafe', '0.05', '8 x 8 x 10 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(226, 33, 'Great Taste White Coffee', '30g sachet, 3-in-1, 10 sachets pack', '65.00', '59.00', 'GROC-GT-WHITE10', 'Great Taste', '0.30', '20 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(227, 33, 'Kopiko Brown Coffee', '25g sachet, 3-in-1, 20 sachets pack', '89.00', '85.00', 'GROC-KOPIKO-BRN20', 'Kopiko', '0.50', '25 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(228, 33, 'Coca-Cola 1.5L', 'Regular flavor, plastic bottle', '65.00', '59.00', 'GROC-COKE-15L', 'Coca-Cola', '1.50', '10 x 10 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(229, 33, 'Pepsi 1.5L', 'Regular cola, plastic bottle', '62.00', '58.00', 'GROC-PEPSI-15L', 'Pepsi', '1.50', '10 x 10 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(230, 33, 'Royal 1.5L', 'Orange flavor, carbonated soft drink', '60.00', '56.00', 'GROC-ROYAL-15L', 'Royal', '1.50', '10 x 10 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(231, 33, 'Mountain Dew 1.5L', 'Citrus flavor, caffeinated soft drink', '65.00', '59.00', 'GROC-MTNDEW-15L', 'Mountain Dew', '1.50', '10 x 10 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(232, 33, 'Sprite 1.5L', 'Lemon-lime flavor, caffeine-free', '62.00', '58.00', 'GROC-SPRITE-15L', 'Sprite', '1.50', '10 x 10 x 30 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00');
INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `sale_price`, `sku`, `brand`, `weight`, `dimensions`, `is_active`, `featured`, `created_at`, `updated_at`) VALUES
(233, 33, 'C2 Green Tea', '500ml bottle, apple flavor, 6 bottles pack', '149.00', '139.00', 'GROC-C2-GTEA6PK', 'C2', '3.00', '30 x 20 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(234, 33, 'Bear Brand Sterilized Milk', '110ml bottle, chocolate flavor, 6 bottles', '89.00', '85.00', 'GROC-BEAR-CHOC6', 'Bear Brand', '0.66', '20 x 15 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(235, 34, 'Datu Puti Soy Sauce', '340ml bottle, naturally brewed', '25.00', '23.00', 'GROC-DATU-SOY340', 'Datu Puti', '0.34', '8 x 8 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(236, 34, 'Silver Swan Soy Sauce', '350ml bottle, premium quality', '28.00', '25.00', 'GROC-SILV-SOY350', 'Silver Swan', '0.35', '8 x 8 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(237, 34, 'Datu Puti Vinegar', '340ml bottle, sukang maasim', '22.00', '20.00', 'GROC-DATU-VIN340', 'Datu Puti', '0.34', '8 x 8 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(238, 34, 'Marca Piña Patis', '350ml bottle, fish sauce, premium quality', '35.00', '32.00', 'GROC-MARCA-PAT350', 'Marca Piña', '0.35', '8 x 8 x 20 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(239, 34, 'Mang Tomas All-Purpose Sauce', '325g bottle, for lechon and grilled meats', '55.00', '52.00', 'GROC-MANG-TOMAS325', 'Mang Tomas', '0.33', '8 x 8 x 15 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(240, 34, 'Jufran Banana Sauce', '320g bottle, sweet style, for hotdogs and burgers', '48.00', '45.00', 'GROC-JUFRAN-BAN320', 'Jufran', '0.32', '8 x 8 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(241, 34, 'Heinz Tomato Ketchup', '320g bottle, made from ripe tomatoes', '65.00', '59.00', 'GROC-HEINZ-KET320', 'Heinz', '0.32', '8 x 8 x 15 cm', 1, 1, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(242, 34, 'UFC Banana Ketchup', '320g bottle, Filipino-style sweet ketchup', '42.00', '39.00', 'GROC-UFC-KET320', 'UFC', '0.32', '8 x 8 x 15 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(243, 34, 'Lady\'s Choice Mayonnaise', '220ml jar, real mayonnaise', '89.00', '85.00', 'GROC-LADY-MYO220', 'Lady\'s Choice', '0.22', '8 x 8 x 10 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00'),
(244, 34, 'Magi Magic Sarap', '8g sachet, all-purpose seasoning, 24 packs', '65.00', '59.00', 'GROC-MAGGI-MS24', 'Magi', '0.20', '20 x 15 x 5 cm', 1, 0, '2025-12-01 20:46:00', '2025-12-01 20:46:00');
=======
(1, 1, 'Samsung Galaxy S24 Ultra', '6.8-inch Dynamic AMOLED display, 200MP camera, 12GB RAM, 256GB storage', 54999.00, 49999.00, 'ELEC-SMSG-S24U-256', 'Samsung', 0.23, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(2, 1, 'Apple iPhone 15 Pro Max', 'A17 Pro chip, Titanium design, 48MP camera, 256GB', 69999.00, NULL, 'ELEC-APPL-IP15PM-256', 'Apple', 0.22, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(3, 1, 'Sony WH-1000XM5 Headphones', 'Premium noise cancelling wireless headphones with 30-hour battery', 16999.00, 14999.00, 'ELEC-SONY-WH1000XM5', 'Sony', 0.25, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(4, 1, 'Dell XPS 15 Laptop', '15.6\" 4K display, Intel i7-13700H, 16GB RAM, 512GB SSD, RTX 4050', 89999.00, NULL, 'ELEC-DELL-XPS15-I7', 'Dell', 1.86, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(5, 1, 'Logitech MX Master 3S Mouse', 'Wireless ergonomic mouse with 8K DPI sensor', 4999.00, 4499.00, 'ELEC-LOGI-MXM3S', 'Logitech', 0.14, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(6, 1, 'Samsung 55\" 4K Smart TV', 'Crystal UHD 4K display, Tizen OS, HDR10+', 32999.00, 29999.00, 'ELEC-SMSG-TV55-4K', 'Samsung', 15.50, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(7, 1, 'Anker PowerCore 20000mAh', 'High-capacity portable charger with fast charging', 2499.00, NULL, 'ELEC-ANKR-PC20K', 'Anker', 0.35, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(8, 1, 'Canon EOS R6 Mark II', 'Full-frame mirrorless camera, 24.2MP, 4K 60fps video', 149999.00, NULL, 'ELEC-CANN-R6M2', 'Canon', 0.67, NULL, 0, 1, '2025-11-24 02:27:17', '2025-12-01 07:08:50'),
(9, 2, 'Levi\'s 501 Original Jeans', 'Classic straight fit denim jeans, 100% cotton', 3499.00, 2999.00, 'CLTH-LEVI-501-BLU-32', 'Levi\'s', 0.60, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(10, 2, 'Nike Dri-FIT Running Shirt', 'Moisture-wicking performance t-shirt, breathable fabric', 1499.00, NULL, 'CLTH-NIKE-DRIF-BLK-L', 'Nike', 0.15, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(11, 2, 'Adidas Ultraboost 23 Shoes', 'Premium running shoes with Boost cushioning technology', 8999.00, 7999.00, 'CLTH-ADID-UB23-WHT-10', 'Adidas', 0.75, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(12, 2, 'The North Face Resolve Jacket', 'Waterproof windbreaker with adjustable hood', 5999.00, NULL, 'CLTH-TNF-RSLV-GRN-M', 'The North Face', 0.40, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(13, 2, 'Uniqlo Heattech Thermal Wear', 'Heat-generating base layer for cold weather', 799.00, 599.00, 'CLTH-UNIQ-HEAT-GRY-M', 'Uniqlo', 0.20, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(14, 2, 'Ralph Lauren Polo Shirt', 'Classic fit cotton polo with signature pony logo', 2999.00, NULL, 'CLTH-RL-POLO-NVY-L', 'Ralph Lauren', 0.25, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(15, 2, 'H&M Cotton Chino Pants', 'Slim fit chinos with stretch fabric', 1299.00, 999.00, 'CLTH-HM-CHIN-KHK-32', 'H&M', 0.35, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(16, 3, 'Dyson V15 Detect Cordless Vacuum', 'Laser dust detection, 60-minute runtime, HEPA filtration', 29999.00, 27999.00, 'HOME-DYSO-V15DET', 'Dyson', 3.10, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(17, 3, 'Philips Hue Smart Bulb Starter Kit', '4-pack color-changing LED bulbs with bridge', 6999.00, NULL, 'HOME-PHIL-HUE-4PK', 'Philips', 0.50, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(18, 3, 'KitchenAid Stand Mixer', '5-quart tilt-head mixer with 10 speeds, includes accessories', 18999.00, 16999.00, 'HOME-KA-MIXER-RED', 'KitchenAid', 10.20, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(19, 3, 'Nespresso Vertuo Coffee Maker', 'One-touch espresso and coffee machine with frother', 8999.00, NULL, 'HOME-NESP-VERT-BLK', 'Nespresso', 4.50, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(20, 3, 'iRobot Roomba j7+', 'Self-emptying robot vacuum with object recognition', 39999.00, 35999.00, 'HOME-IRO-J7PLUS', 'iRobot', 3.40, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(21, 3, 'Black+Decker 20V Drill Kit', 'Cordless drill with 2 batteries and carrying case', 3999.00, NULL, 'HOME-BD-DRILL-20V', 'Black+Decker', 2.00, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(22, 3, 'Weber Genesis Gas Grill', '3-burner propane grill with side burner and storage', 34999.00, NULL, 'HOME-WEBR-GEN-3B', 'Weber', 65.00, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(23, 4, 'Yeti Tundra 45 Cooler', 'Rotomolded construction, bear-resistant, 28-can capacity', 19999.00, NULL, 'SPRT-YETI-T45-WHT', 'Yeti', 10.00, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(24, 4, 'Trek Marlin 7 Mountain Bike', '29-inch wheels, 21-speed, aluminum frame', 32999.00, 29999.00, 'SPRT-TREK-M7-BLU-M', 'Trek', 13.50, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(25, 4, 'Coleman Sundome Tent 4-Person', 'WeatherTec system, easy setup, fits 4 campers', 4999.00, NULL, 'SPRT-COLM-SD4-GRN', 'Coleman', 5.80, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(26, 4, 'TRX Home2 Suspension Trainer', 'Total body resistance training system with workout guide', 7999.00, 6999.00, 'SPRT-TRX-HM2-BLK', 'TRX', 1.20, NULL, 0, 0, '2025-11-24 02:27:17', '2025-12-01 07:08:44'),
(27, 4, 'Bowflex SelectTech 552 Dumbbells', 'Adjustable dumbbells, 5-52.5 lbs per dumbbell', 24999.00, NULL, 'SPRT-BWFX-ST552', 'Bowflex', 25.00, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(28, 4, 'GoPro HERO12 Black', '5.3K60 video, HyperSmooth 6.0, waterproof to 33ft', 21999.00, 19999.00, 'SPRT-GPRO-H12-BLK', 'GoPro', 0.15, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(29, 4, 'Wilson Evolution Basketball', 'Official size, composite leather, indoor use', 2499.00, NULL, 'SPRT-WILS-EVO-BBAL', 'Wilson', 0.62, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(30, 5, 'Atomic Habits by James Clear', 'Proven framework for improving every day, hardcover', 899.00, 749.00, 'BOOK-ATML-HBIT-HC', 'Penguin Random House', 0.40, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(31, 5, 'The Psychology of Money', 'Timeless lessons on wealth and happiness by Morgan Housel', 699.00, NULL, 'BOOK-PSYC-MONY-PB', 'Harriman House', 0.35, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(32, 5, 'Educated: A Memoir', 'Tara Westover\'s powerful story of self-invention', 799.00, 649.00, 'BOOK-EDUC-MEMO-PB', 'Random House', 0.38, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(33, 5, 'The Lean Startup', 'How today\'s entrepreneurs build successful businesses', 999.00, NULL, 'BOOK-LEAN-STRT-HC', 'Crown Business', 0.45, NULL, 1, 0, '2025-11-24 02:27:17', '2025-11-24 02:27:17'),
(34, 5, 'Sapiens: A Brief History', 'Yuval Noah Harari\'s journey through human history', 1299.00, 999.00, 'BOOK-SAPI-HIST-HC', 'Harper', 0.65, NULL, 1, 1, '2025-11-24 02:27:17', '2025-11-24 02:27:17');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `is_primary`, `display_order`, `created_at`) VALUES
(17, 1, 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=800', 1, 1, '2025-11-24 02:39:49'),
(18, 1, 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=800', 0, 2, '2025-11-24 02:39:49'),
(19, 1, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800', 0, 3, '2025-11-24 02:39:49'),
(20, 2, 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800', 1, 1, '2025-11-24 02:39:49'),
(21, 2, 'https://images.unsplash.com/photo-1592286927505-c3b0842d2b1f?w=800', 0, 2, '2025-11-24 02:39:49'),
(22, 3, 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800', 1, 1, '2025-11-24 02:39:49'),
(23, 3, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800', 0, 2, '2025-11-24 02:39:49'),
(24, 4, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800', 1, 1, '2025-11-24 02:39:49'),
(25, 4, 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800', 0, 2, '2025-11-24 02:39:49'),
(26, 5, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800', 1, 1, '2025-11-24 02:39:49'),
(27, 6, 'https://images.unsplash.com/photo-1593784991095-a205069470b6?w=800', 1, 1, '2025-11-24 02:39:49'),
(28, 6, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800', 0, 2, '2025-11-24 02:39:49'),
(29, 7, 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800', 1, 1, '2025-11-24 02:39:49'),
(30, 8, 'https://images.unsplash.com/photo-1606980395156-c1d49dd39ad6?w=800', 1, 1, '2025-11-24 02:39:49'),
(31, 8, 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=800', 0, 2, '2025-11-24 02:39:49'),
(32, 9, 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800', 1, 1, '2025-11-24 02:39:49'),
(33, 9, 'https://images.unsplash.com/photo-1475178626620-a4d074967452?w=800', 0, 2, '2025-11-24 02:39:49'),
(34, 10, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800', 1, 1, '2025-11-24 02:39:49'),
(35, 11, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800', 1, 1, '2025-11-24 02:39:49'),
(36, 11, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800', 0, 2, '2025-11-24 02:39:49'),
(37, 12, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=800', 1, 1, '2025-11-24 02:39:49'),
(38, 13, 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800', 1, 1, '2025-11-24 02:39:49'),
(39, 14, 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=800', 1, 1, '2025-11-24 02:39:49'),
(40, 15, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800', 1, 1, '2025-11-24 02:39:49'),
(41, 16, 'https://images.unsplash.com/photo-1558317374-067fb5f30001?w=800', 1, 1, '2025-11-24 02:39:49'),
(42, 16, 'https://images.unsplash.com/photo-1605726045934-a89dd4352d42?w=800', 0, 2, '2025-11-24 02:39:49'),
(43, 17, 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=800', 1, 1, '2025-11-24 02:39:49'),
(44, 18, 'https://images.unsplash.com/photo-1578269174936-2709b6aeb913?w=800', 1, 1, '2025-11-24 02:39:49'),
(45, 18, 'https://images.unsplash.com/photo-1612967015325-c89d2ac2e9a0?w=800', 0, 2, '2025-11-24 02:39:49'),
(46, 19, 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800', 1, 1, '2025-11-24 02:39:49'),
(47, 20, 'https://images.unsplash.com/photo-1614963326505-843868e1d83a?w=800', 1, 1, '2025-11-24 02:39:49'),
(48, 21, 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800', 1, 1, '2025-11-24 02:39:49'),
(49, 22, 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800', 1, 1, '2025-11-24 02:39:49'),
(50, 23, 'https://images.unsplash.com/photo-1591154669695-5f2a8d20c089?w=800', 1, 1, '2025-11-24 02:39:49'),
(51, 24, 'https://images.unsplash.com/photo-1576435728678-68d0fbf94e91?w=800', 1, 1, '2025-11-24 02:39:49'),
(52, 24, 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=800', 0, 2, '2025-11-24 02:39:49'),
(53, 25, 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800', 1, 1, '2025-11-24 02:39:49'),
(54, 26, 'https://images.unsplash.com/photo-1598971861713-54ad16c9b881?w=800', 1, 1, '2025-11-24 02:39:49'),
(55, 27, 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800', 1, 1, '2025-11-24 02:39:49'),
(56, 28, 'https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=800', 1, 1, '2025-11-24 02:39:49'),
(57, 28, 'https://images.unsplash.com/photo-1519638399535-1b036603ac77?w=800', 0, 2, '2025-11-24 02:39:49'),
(58, 29, 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800', 1, 1, '2025-11-24 02:39:49'),
<<<<<<< HEAD
(59, 30, 'https://cdn2.penguin.com.au/covers/original/9781847941831.jpg', 1, 1, '2025-11-24 02:39:49'),
(60, 31, 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=800', 1, 1, '2025-11-24 02:39:49'),
(61, 32, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1506026635i/35133922.jpg', 1, 1, '2025-11-24 02:39:49'),
(62, 33, 'https://cdn.kobo.com/book-images/5c5e77cc-1fb9-410b-a735-de95a9a5dd40/1200/1200/False/the-lean-startup-1.jpg', 1, 1, '2025-11-24 02:39:49'),
(63, 34, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToSXjIlW6SQN-6-9L8CbqtAG2GdaAoBuG9cg&s', 1, 1, '2025-11-24 02:39:49'),
(64, 35, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(65, 35, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOdvsn02OpIp6f0198dsEVQvCoLZ76n2Nqbw&s', 0, 2, '2025-12-01 20:46:00'),
(66, 36, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(67, 37, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(68, 37, 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&q=80', 0, 2, '2025-12-01 20:46:00'),
(69, 38, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(70, 39, 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(71, 40, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqfqSIsCA88Gr4I9VF-eM1rtf-KMsJirxqUA&s', 1, 1, '2025-12-01 20:46:00'),
(72, 41, 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(73, 41, 'https://images.unsplash.com/photo-1502920514313-52581002a659?w=800&q=80', 0, 2, '2025-12-01 20:46:00'),
(74, 42, 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(76, 44, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(77, 45, 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(78, 46, 'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(79, 47, 'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(80, 47, 'https://images.unsplash.com/photo-1522865109860-215784a8b71c?w=800&q=80', 0, 2, '2025-12-01 20:46:00'),
(81, 48, 'https://villman.com/product_photos/gifffffffffff_l8f9e.gif', 1, 1, '2025-12-01 20:46:00'),
(82, 49, 'https://www.belkin.com/dw/image/v2/BGBH_PRD/on/demandware.static/-/Sites-master-product-catalog-blk/default/dwb3101a8b/images/hi-res/7/135cfdc88f5c66a4_WIZ009-BLK_Hero_WDevice_WEB.jpg?sfrm=png', 1, 1, '2025-12-01 20:46:00'),
(83, 50, 'https://dlcdnwebimgs.asus.com/gain/0A9C172B-6ACB-4C9F-BC29-D5219D513D4A', 1, 1, '2025-12-01 20:46:00'),
(85, 52, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeCrdBCH8fN55I1mk8aMSst1as_Wth35sp5Q&s', 1, 1, '2025-12-01 20:46:00'),
(86, 53, 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(88, 55, 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(89, 56, 'https://www.officewarehouse.com.ph/__resources/_web_data_/products/products/image_gallery/8944_7008.jpg', 1, 1, '2025-12-01 20:46:00'),
(91, 58, 'https://mms.businesswire.com/media/20201020005041/en/831125/5/1000-611.jpg?download=1', 1, 1, '2025-12-01 20:46:00'),
(92, 59, 'https://m.media-amazon.com/images/I/61FeCECR4wL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(93, 60, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCIYuycLxl6EyNb71vJ_8mEnONejeeZVIWfA&s', 1, 1, '2025-12-01 20:46:00'),
(94, 61, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(95, 62, 'https://static.gopro.com/assets/blta2b8522e5372af40/bltb59f1b72c0ffbd0f/6799e1bc3b4101d815031ec0/03-max_lenses_50-50_1920-375-v2.png', 1, 1, '2025-12-01 20:46:00'),
(96, 63, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(97, 64, 'https://cdn.outsideonline.com/wp-content/uploads/2022/09/AIRPODS_PRO2_s.jpg', 1, 1, '2025-12-01 20:46:00'),
(98, 65, 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(99, 66, 'https://calvinklein.scene7.com/is/image/CalvinKlein/LX000588_015_main', 1, 1, '2025-12-01 20:46:00'),
(100, 67, 'https://columbiasportswear.ph/cdn/shop/files/1000330554_01.jpg?v=1707883809', 1, 1, '2025-12-01 20:46:00'),
(101, 68, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(102, 69, 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(103, 70, 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(104, 71, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(105, 72, 'https://sportingbrandsonline.com.au/cdn/shop/files/IMG_0955_1200x.jpgSepiaRed.jpg?v=1729407358', 1, 1, '2025-12-01 20:46:00'),
(106, 73, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(107, 74, 'https://static.nike.com/a/images/t_web_pdp_936_v2/f_auto/gorfwjchoasrrzr1fggt/AIR+MAX+270.png', 1, 1, '2025-12-01 20:46:00'),
(108, 75, 'https://www.converse.ph/media/catalog/product/cache/9f24855fac20eb8d4a46102f0f20e4a1/0/8/0802-CONM9160C00010H-1.jpg', 1, 1, '2025-12-01 20:46:00'),
(109, 76, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTg3LbBoKs-fZnqMqk-zRc3tNoPx5v1SSfaZw&s', 1, 1, '2025-12-01 20:46:00'),
(110, 77, 'https://slimages.macysassets.com/is/image/MCY/products/3/optimized/27187953_fpx.tif', 1, 1, '2025-12-01 20:46:00'),
(111, 78, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRh7sPObWKR59HIcxs5B_i8V2qlyN9x2oXEVw&s', 1, 1, '2025-12-01 20:46:00'),
(112, 79, 'https://www.shopboxbasics.com/cdn/shop/articles/shoe-review-blog-featured-image-Rbk-NX3.jpg?v=1678412846', 1, 1, '2025-12-01 20:46:00'),
(113, 80, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiduIwSWajWil2W5HT5Dy-ntJ0_ECQUgK8Ng&s', 1, 1, '2025-12-01 20:46:00'),
(114, 81, 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(115, 82, 'https://www.skechers.com/dw/image/v2/BDCN_PRD/on/demandware.static/-/Library-Sites-SkechersSharedLibrary/default/dw8c529bad/images/Landing/Temp%20Files/SKX54719_Walking-Technologies-Images_Massage-Fit-124903-GYPL.jpg', 1, 1, '2025-12-01 20:46:00'),
(116, 83, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQA1Z3586IOOWN6EDDxMxGPfSUyRDji8kq-nw&s', 1, 1, '2025-12-01 20:46:00'),
(117, 84, 'https://m.media-amazon.com/images/I/61w3q+Q0hAL._AC_UF894,1000_QL80_.jpg', 1, 1, '2025-12-01 20:46:00'),
(118, 85, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSx8A1wMoCw3gTqkb3l1SdMwsoMt-K5sq2y9Q&s', 1, 1, '2025-12-01 20:46:00'),
(119, 86, 'https://www.fossil.com/on/demandware.static/-/Library-Sites-FossilSharedLibrary/default/dwb9c5cfb1/2022/FA22/set_0929_smartwatches_lm/Slices/Gen6/0929_Gen6_Learnmore_Hero8_Desktop_Mobile.jpg', 1, 1, '2025-12-01 20:46:00'),
(120, 87, 'https://dynamic.zacdn.com/uy9zdq8IW8JdJUfdmdoDLn2a5wA=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/coach-4248-2114913-1.jpg', 1, 1, '2025-12-01 20:46:00'),
(121, 88, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0Q6SxXxgtmK1SqfIi5JXNa7RnUISEyxkBcA&s', 1, 1, '2025-12-01 20:46:00'),
(122, 89, 'https://cdn11.bigcommerce.com/s-21x65e8kfn/images/stencil/original/products/8624/37556/SAL3763_1000_1__86614.1688135315.jpg', 1, 1, '2025-12-01 20:46:00'),
(123, 90, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKEKvkLk73TVrG_eKZgVFnngsF7oizTRuwXA&s', 1, 1, '2025-12-01 20:46:00'),
(124, 91, 'https://www.cleverhiker.com/wp-content/uploads/2024/09/IMG_E5396-scaled.jpg', 1, 1, '2025-12-01 20:46:00'),
(125, 92, 'https://images.asics.com/is/image/asics/1011B690_001_SR_RT_GLB?$zoom$', 1, 1, '2025-12-01 20:46:00'),
(126, 93, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGvU-tmvLxK32OLb4zy2xftyNmQd0FxdDARw&s', 1, 1, '2025-12-01 20:46:00'),
(127, 94, 'https://m.media-amazon.com/images/I/71vXk8hSAoL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(128, 95, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS-ou8Mf360jioJnoXTm0AQN4cQ2dwuwZqKFA&s', 1, 1, '2025-12-01 20:46:00'),
(129, 96, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV4VSJVxLMDvVaN-KicZvfDa30uP5IXuGdgg&s', 1, 1, '2025-12-01 20:46:00'),
(130, 97, 'https://www.breville.com.ph/image/cache/catalog/catalog/barista-express/barista-express-550x550.jpg', 1, 1, '2025-12-01 20:46:00'),
(131, 98, 'https://cdn.thewirecutter.com/wp-content/media/2023/07/vitamix5200-2048px-vitamix-3x2-v2.jpg?auto=webp&quality=75&crop=1:1,smart&width=1024', 1, 1, '2025-12-01 20:46:00'),
(132, 99, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjk0b_PVs2eZMPrr92FMB1HmLSkHmHmQvpVA&s', 1, 1, '2025-12-01 20:46:00'),
(133, 100, 'https://assets.sharkninja.com/image/upload/f_auto/q_auto/SharkNinja-NA/NV360_02.jpg', 1, 1, '2025-12-01 20:46:00'),
(134, 101, 'https://img.lazcdn.com/g/p/d86136a8e44ce4f02a469685c6c12d36.png_960x960q80.png_.webp', 1, 1, '2025-12-01 20:46:00'),
(135, 102, 'https://www.lodgecastiron.com/cdn/shop/files/LCCWND_800x800_84ffdd8e-33db-4ae2-8bb4-15c2973138ed.jpg?v=1734123207', 1, 1, '2025-12-01 20:46:00'),
(136, 103, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRP5-EhxeHBZIrHoLhp60ickJcvat6DToDaxw&s', 1, 1, '2025-12-01 20:46:00'),
(137, 104, 'https://m.media-amazon.com/images/I/81RLNY9ieZL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(138, 105, 'https://m.media-amazon.com/images/I/71oexBYw08L._AC_UF1000,1000_QL80_.jpg', 1, 1, '2025-12-01 20:46:00'),
(139, 106, 'https://m.media-amazon.com/images/I/91TInqFH83L._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(140, 107, 'https://strapi-ecm-assets.s3.ap-southeast-1.amazonaws.com/5_KFC_3516_PER_1_8ea929dbd3.webp', 1, 1, '2025-12-01 20:46:00'),
(141, 108, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpcSWtTMVNoMAN-vzEsH-IsrP5GMRtlzModA&s', 1, 1, '2025-12-01 20:46:00'),
(142, 109, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7VlJrnpPfjdICinGAkUXxDWb5ISLdstpzpw&s', 1, 1, '2025-12-01 20:46:00'),
(143, 110, 'https://m.media-amazon.com/images/I/917dBseIiwL.jpg', 1, 1, '2025-12-01 20:46:00'),
(144, 111, 'https://i5.walmartimages.com/seo/simplehuman-58-Liter-15-3-Gallon-Stainless-Steel-Rectangular-Kitchen-Step-Can-Dual-Compartment-Recycler-Brushed-Stainless-Steel_e4f4a844-10a3-4d3d-818f-aaab1851046c.3222efe0ef0564e0b9137a544eaaac1c.jpeg', 1, 1, '2025-12-01 20:46:00'),
(145, 112, 'https://m.media-amazon.com/images/I/71p2h853rfL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(146, 113, 'https://farberwarecookware.com/cdn/shop/products/luoqk6f2zhnadmibfvna_1000x1000.jpg?v=1748880976', 1, 1, '2025-12-01 20:46:00'),
(147, 114, 'https://m.media-amazon.com/images/I/710OfeaejzL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(148, 115, 'https://m.media-amazon.com/images/I/71tRoYzBJdL.jpg', 1, 1, '2025-12-01 20:46:00'),
(149, 116, 'https://www.sunbeam.ca/on/demandware.static/-/Sites-master-catalog/default/dw91051df5/images/highres/2379-33A-1.jpg', 1, 1, '2025-12-01 20:46:00'),
(150, 117, 'https://m.media-amazon.com/images/I/61UXQ82C8bL._AC_SL1024_.jpg', 1, 1, '2025-12-01 20:46:00'),
(151, 118, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTNmFeHxDpuDLyUUKsv1r9poqqAqxJp3MMeg&s', 1, 1, '2025-12-01 20:46:00'),
(152, 119, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZ4ROqusf5Gom6b4E4AMtqIuY6S21g8SbD5Q&s', 1, 1, '2025-12-01 20:46:00'),
(153, 120, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR86DEGd-V_gDUDo84x3ScIwsmcuwzEXTM1w&s', 1, 1, '2025-12-01 20:46:00'),
(154, 121, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQT4R5NX4-cWEg3Q5S7ru88n-Ru3FYssnRCYw&s', 1, 1, '2025-12-01 20:46:00'),
(155, 122, 'https://i5.walmartimages.com/seo/Magic-Bullet-NutriBullet-Nutrition-Extraction-12-Piece-Mixer-Blender-As-Seen-on-TV_7e178177-0f3f-4f1b-a78b-6c2cae048e11.e89c7d4f9ef203881164446b56003786.jpeg', 1, 1, '2025-12-01 20:46:00'),
(156, 123, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8Ha8pqwKsnRJVAS9SCWqLty7bQrKvRkb-ng&s', 1, 1, '2025-12-01 20:46:00'),
(157, 124, 'https://i5.walmartimages.com/seo/T-fal-Easy-Care-20-Piece-Non-Stick-Pots-and-Pans-Cookware-Set-Grey_5666016b-38d1-4e88-a91f-a634cc014214.555f2321d82ca0ac4ea7b3e938c9151a.jpeg', 1, 1, '2025-12-01 20:46:00'),
(158, 125, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRx1eA-Qzpr4TGwKPkMxbEK-TjxMnFxqjT_Zw&s', 1, 1, '2025-12-01 20:46:00'),
(159, 126, 'https://res.garmin.com/en/products/010-02638-10/g/46824-FR955-S2-F3.jpg', 1, 1, '2025-12-01 20:46:00'),
(160, 127, 'https://ecommerce.datablitz.com.ph/cdn/shop/products/hyperx_cloud_alpha_wireless_2_main_dongle_900x_71100e95-211e-4cc1-a00a-6523f4485c79.jpg?v=1676876185', 1, 1, '2025-12-01 20:46:00'),
(161, 128, 'https://cdn.shopify.com/s/files/1/0460/2567/0805/files/CORSAIR-CS-CMG16GX4M2D3600C18-BOX-CORSAIR-VENGEANCE-RGB-RS-16GB2X8GB-DDR4-3600-C18-MEMORY-KIT-RAM-12-MONTHS-WARRANTY-MEMORY-CARD.jpg?v=1714782603', 1, 1, '2025-12-01 20:46:00'),
(162, 129, 'https://ecommerce.datablitz.com.ph/cdn/shop/files/vsddsvsvdzx_800x.jpg?v=1758173426', 1, 1, '2025-12-01 20:46:00'),
(163, 130, 'https://gameone.ph/media/catalog/product/mpiowebpcache/d378a0f20f83637cdb1392af8dc032a2/s/t/steelseries-arctis-nova-pro-wireless-headset-_61520_-1_1.webp', 1, 1, '2025-12-01 20:46:00'),
(164, 131, 'https://dlcdnwebimgs.asus.com/gain/CD75D7C5-6A84-4B78-BA57-2F1AD1738010', 1, 1, '2025-12-01 20:46:00'),
(165, 132, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQYhXqWQmPPyPU_aKPxCL5BJ_uaVp6D3_J4Xg&s', 1, 1, '2025-12-01 20:46:00'),
(166, 133, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwx8MuiDnosnk2ZBJ76Q_BluKJjUVY0SBeZw&s', 1, 1, '2025-12-01 20:46:00'),
(167, 134, 'https://bermorzone.com.ph/wp-content/uploads/2021/11/MZ-V8P500BW_001_Front_Black.webp', 1, 1, '2025-12-01 20:46:00'),
(168, 135, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ1-hiwfceaA-YupIOC2KiaKc0qTUB4_LGxXA&s', 1, 1, '2025-12-01 20:46:00'),
(169, 136, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYktK9F7X24DPwbWOPgWnP6OCfiZaTGeQaCQ&s', 1, 1, '2025-12-01 20:46:00'),
(170, 137, 'https://m.media-amazon.com/images/I/61gtdFnK+UL._AC_SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(171, 138, 'https://d1rlzxa98cyc61.cloudfront.net/catalog/product/cache/1801c418208f9607a371e61f8d9184d9/1/8/182906_2022.jpg', 1, 1, '2025-12-01 20:46:00'),
(172, 139, 'https://jgsuperstore.com/cdn/shop/products/51o0BaAQeNL._AC_SL1023.jpg?v=1618985786&width=416', 1, 1, '2025-12-01 20:46:00'),
(173, 140, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcdJSswO_g3AQ5k7ZBcLVrLRRRW1j8g7Sl-Q&s', 1, 1, '2025-12-01 20:46:00'),
(174, 141, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK8w7C3icQOPEs9Bh0NCNszzocNSK3SKp6ow&s', 1, 1, '2025-12-01 20:46:00'),
(175, 142, 'https://tpucdn.com/review/corsair-k100-rgb-mechanical-keyboard/images/title.jpg', 1, 1, '2025-12-01 20:46:00'),
(176, 143, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSO7uCCvAGieCOlDr64_516sNyKN8cxsDuY5w&s', 1, 1, '2025-12-01 20:46:00'),
(177, 144, 'https://bermorzone.com.ph/wp-content/uploads/2022/09/msi-rtx-4080-suprim-x.webp', 1, 1, '2025-12-01 20:46:00'),
(178, 145, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTo7dbGB2bbmNYWenD_69PV1AfbbtYVmaaO3g&s', 1, 1, '2025-12-01 20:46:00'),
(179, 146, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(180, 147, 'https://dlcdnwebimgs.asus.com/gain/C2A10896-76C0-4772-9A3A-69D7B0C00441', 1, 1, '2025-12-01 20:46:00'),
(181, 148, 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(182, 149, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(184, 151, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(185, 152, 'https://bermorzone.com.ph/wp-content/uploads/2022/06/fractal-nano-5-600x450.jpg', 1, 1, '2025-12-01 20:46:00'),
(186, 153, 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(187, 154, 'https://imgs.search.brave.com/RnF2GaNh7uKd6-H5KUW_rb6ptbN8EArD_iG3KfhA594/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/bW9zLmNtcy5mdXR1/cmVjZG4ubmV0L2FZ/VTlzS1ZtdDZqQ0dL/YlFmeGdkeFYuanBn', 1, 1, '2025-12-01 20:46:00'),
(188, 155, 'https://imgs.search.brave.com/t9RcFIv7q1PjfMm2UI4utPeKIbalPoEooRbURZD2wew/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NDFlR25tb0FtY0wu/anBn', 1, 1, '2025-12-01 20:46:00'),
(189, 156, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBoLJiY7n29pPMzEZLI06JJ9kKwp9wSsdGcw&s', 1, 1, '2025-12-01 20:46:00'),
(190, 157, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVr-63vsawb4q0fAKTKQZgwqIN5gWI5z1zfg&s', 1, 1, '2025-12-01 20:46:00'),
(191, 158, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfMR0L37_q3CRwkZWWnR4FOIv8yyKHvVSCKw&s', 1, 1, '2025-12-01 20:46:00'),
(192, 159, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1442726934i/4865.jpg', 1, 1, '2025-12-01 20:46:00'),
(193, 160, 'https://cdn.kobo.com/book-images/f68de379-e763-441c-8159-a949ea575237/1200/1200/False/the-subtle-art-of-not-giving-a-f-ck.jpg', 1, 1, '2025-12-01 20:46:00'),
(194, 161, 'https://growthsummary.com/wp-content/uploads/2024/06/107.png', 1, 1, '2025-12-01 20:46:00'),
(195, 162, 'https://static.wixstatic.com/media/8cc233_da3154cf2cdd4e979a841903fb3cf770~mv2.jpg/v1/fill/w_1585,h_2400,al_c,q_90/The%20Alchemist%20cover.jpg', 1, 1, '2025-12-01 20:46:00'),
(196, 163, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1535419394i/4069.jpg', 1, 1, '2025-12-01 20:46:00'),
(197, 164, 'https://cdn.kobo.com/book-images/5d4336ab-8c48-407f-8496-906eff1cd352/1200/1200/False/the-48-laws-of-power.jpg', 1, 1, '2025-12-01 20:46:00'),
(198, 165, 'https://imgv2-1-f.scribdassets.com/img/document/527639903/original/91cc892fe7/1?v=1', 1, 1, '2025-12-01 20:46:00'),
(199, 166, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTeE93lZOuN7XNrBB2uUNF6RobuMsjEV2_VQg&s', 1, 1, '2025-12-01 20:46:00'),
(200, 167, 'https://cdn.kobo.com/book-images/4684126b-8238-46f1-86d4-f5d860450e22/1200/1200/False/the-intelligent-investor-rev-ed.jpg', 1, 1, '2025-12-01 20:46:00'),
(201, 168, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1436227012i/40745.jpg', 1, 1, '2025-12-01 20:46:00'),
(202, 169, 'https://m.media-amazon.com/images/I/71Ha3OShqSL.jpg', 1, 1, '2025-12-01 20:46:00'),
(203, 170, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSv4RJUmozncSE5E6WnCtyu6KYGjhQFfhyM_Q&s', 1, 1, '2025-12-01 20:46:00'),
(204, 171, 'https://m.media-amazon.com/images/I/61R1UgGxaLL._AC_UF1000,1000_QL80_.jpg', 1, 1, '2025-12-01 20:46:00'),
(205, 172, 'https://simonsinek.com/wp-content/uploads/2022/02/StartwithWHY-680x1024.jpeg', 1, 1, '2025-12-01 20:46:00'),
(206, 173, 'https://jamesclear.com/wp-content/uploads/2016/06/The10xRule-by-GrantCardone-1.jpg', 1, 1, '2025-12-01 20:46:00'),
(207, 174, 'https://m.media-amazon.com/images/I/81VpFFpZTtL._SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(208, 175, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1630683326i/10534.jpg', 1, 1, '2025-12-01 20:46:00'),
(209, 176, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1691172738i/195589455.jpg', 1, 1, '2025-12-01 20:46:00'),
(210, 177, 'https://ph-test-11.slatic.net/p/5c77bc1e0839d749f3f4786b8500eef8.jpg', 1, 1, '2025-12-01 20:46:00'),
(211, 178, 'https://cdn.kobo.com/book-images/ffa72d39-404c-4982-8931-65b2821eb4b0/1200/1200/False/extreme-ownership-3.jpg', 1, 1, '2025-12-01 20:46:00'),
(212, 179, 'https://jamesclear.com/wp-content/uploads/2016/03/TheCompoundEffect-by-DarrenHardy.jpg', 1, 1, '2025-12-01 20:46:00'),
(213, 180, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1390169859i/3828902.jpg', 1, 1, '2025-12-01 20:46:00'),
(214, 181, 'https://gregmckeown.com/wp-content/uploads/2011/08/book-1225x1600.jpg', 1, 1, '2025-12-01 20:46:00'),
(215, 182, 'https://d-pdf.com/images/covers/2021/December/61aba71d49887/9781760630737.jpg', 1, 1, '2025-12-01 20:46:00'),
(216, 183, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1643265644i/60222658.jpg', 1, 1, '2025-12-01 20:46:00'),
(217, 184, 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1545910967i/37502596.jpg', 1, 1, '2025-12-01 20:46:00'),
(218, 185, 'https://www.nidolove.com/sites/default/files/2025-08/NIDO-Fortified_2.png', 1, 1, '2025-12-01 20:46:00'),
(219, 186, 'https://imartgrocersph.com/wp-content/uploads/2020/09/Bear-Brand-Sterilized-Milk-200mL.png', 1, 1, '2025-12-01 20:46:00'),
(220, 187, 'https://images.unsplash.com/photo-1589923186741-b7d59d6b2c4a?w=800&q=80', 0, 1, '2025-12-01 20:46:00'),
(221, 188, 'https://k2pharmacy.ph/cdn/shop/files/ArgentinaCornedBeef175g1-fotor-20240627154056.jpg?v=1720416375', 1, 1, '2025-12-01 20:46:00'),
(222, 189, 'https://imartgrocersph.com/wp-content/uploads/2020/09/San-Marino-Corned-Tuna-180g.png', 1, 1, '2025-12-01 20:46:00'),
(224, 191, 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(225, 192, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(226, 193, 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(227, 194, 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(228, 195, 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(229, 196, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ1KqMp2-c8DvxdhkAzrkwsWglNDVk_4n5IRA&s', 1, 1, '2025-12-01 20:46:00'),
(230, 197, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(231, 198, 'https://www.cdo.com.ph/wp-content/uploads/2024/08/Copy-of-CDO-KN-CB-150g-3D-DIGIMUP.png', 1, 1, '2025-12-01 20:46:00'),
(232, 199, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-ogKkL0ggdXAzfqBz-g4-F1RGHQo_gX7Kng&s', 1, 1, '2025-12-01 20:46:00'),
(233, 200, 'https://megaprimefoods.com.ph/wp-content/uploads/2021/03/Mega-Sardines-in-Natural-Oil-155G.jpg', 1, 1, '2025-12-01 20:46:00'),
(234, 201, 'https://zbga.shopsuki.ph/cdn/shop/files/4800088135276_1024x.jpg?v=1734520275', 1, 1, '2025-12-01 20:46:00'),
(235, 202, 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(236, 203, 'https://happyhour.ph/cdn/shop/products/happy-classic-peanuts-real-garlic-chips-100g-238702.jpg?v=1708590954', 1, 1, '2025-12-01 20:46:00'),
(237, 204, 'https://images.freshop.ncrcloud.com/1564405684714674504/f091213c278bdab2cf5839bfa7af9729_large.png', 1, 1, '2025-12-01 20:46:00'),
(238, 205, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-8c5n-_OYy1_GdUcNgPgi0t_cDTzpPxmVAw&s', 1, 1, '2025-12-01 20:46:00'),
(239, 206, 'https://images.freshop.ncrcloud.com/00039000086639/9ad0f1ed7e4eff6c6e844e68dc1e42a8_large.png', 1, 1, '2025-12-01 20:46:00'),
(240, 207, 'https://m.media-amazon.com/images/I/71a0amqwAsL._SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(241, 208, 'https://images.freshop.ncrcloud.com/3683/a2ada672b52c5d72552c60c995dc2135_large.png', 1, 1, '2025-12-01 20:46:00'),
(242, 209, 'https://pampangasbest.store/cdn/shop/products/Tocino-220g-1.jpg?v=1633569805', 1, 1, '2025-12-01 20:46:00'),
(243, 210, 'https://store.iloilosupermart.com/wp-content/uploads/2020/05/is-104.jpg', 1, 1, '2025-12-01 20:46:00'),
(244, 211, 'https://www.cdo.com.ph/wp-content/uploads/2022/05/Funtastyk-pork-tocino-450g-digital-mockup.png', 1, 1, '2025-12-01 20:46:00'),
(245, 212, 'https://images.freshop.ncrcloud.com/1564405684702504564/aae559881703949dda5507b07f8cff6c_large.png', 1, 1, '2025-12-01 20:46:00'),
(246, 213, 'https://shopmetro.ph/marketmarket-supermarket/wp-content/uploads/2021/03/SM10062286-1.png', 1, 1, '2025-12-01 20:46:00'),
(247, 214, 'https://pinoygroseri.com/cdn/shop/files/20250107-125923_1200x.jpg?v=1742828761', 1, 1, '2025-12-01 20:46:00'),
(248, 215, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(249, 216, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(250, 217, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(251, 218, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(252, 219, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(253, 220, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(254, 221, 'https://images-cdn.ubuy.co.in/64f2c80cd687761f82030a46-96-packs-maggi-magic-sarap-all-in-one.jpg', 1, 1, '2025-12-01 20:46:00'),
(255, 222, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(256, 223, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(257, 224, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=800&q=80', 1, 1, '2025-12-01 20:46:00'),
(258, 225, 'https://www.nestleprofessional.ph/sites/default/files/styles/np_product_detail/public/2023-03/Classic%2092g_0.png?itok=JexqKFCi', 1, 1, '2025-12-01 20:46:00'),
(259, 226, 'https://images.freshop.ncrcloud.com/1564405684702535617/402eafa1a500ddc43d4e01a7332d0388_large.png', 1, 1, '2025-12-01 20:46:00'),
(260, 227, 'https://m.media-amazon.com/images/I/61wGQXIupHL._SL1418_.jpg', 1, 1, '2025-12-01 20:46:00'),
(261, 228, 'https://shopmetro.ph/basak-supermarket/wp-content/uploads/2025/08/SM9083975-5.jpg', 1, 1, '2025-12-01 20:46:00'),
(262, 229, 'https://shopmetro.ph/lapulapu-supermarket/wp-content/uploads/2023/10/SM9198577-3.jpg', 1, 1, '2025-12-01 20:46:00'),
(263, 230, 'https://gringo.ph/cdn/shop/products/Royal1.5Lcopy_720x.jpg?v=1627978246', 1, 1, '2025-12-01 20:46:00'),
(264, 231, 'https://happyhour.ph/cdn/shop/products/mountain-dew-15l-617347.jpg?v=1708591289', 1, 1, '2025-12-01 20:46:00'),
(265, 232, 'https://gringo.ph/cdn/shop/products/Sprite1.5Lcopy_720x.jpg?v=1627978183', 1, 1, '2025-12-01 20:46:00'),
(266, 233, 'https://pinoygroseri.com/cdn/shop/products/C2AppleGreenTea16.91fl.oz_500ml_1080x.png?v=1614379411', 1, 1, '2025-12-01 20:46:00'),
(267, 234, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn4BYaEXgyQkpYRcgWHxRFj_uf-ZBf1f04-A&s', 1, 1, '2025-12-01 20:46:00'),
(268, 235, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJRyQYVlJ_CoVCyvkNVXR4zFVEAivWC-jA9A&s', 1, 1, '2025-12-01 20:46:00'),
(269, 236, 'https://pinoygroseri.com/cdn/shop/products/SilverSwanSoySauce1L_1080x.png?v=1616007859', 1, 1, '2025-12-01 20:46:00'),
(270, 237, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKCaHP8tJ7hyAp_1pny0djn0kzihPVYI6g8A&s', 1, 1, '2025-12-01 20:46:00'),
(271, 238, 'https://shopmetro.ph/mandaluyong-supermarket/wp-content/uploads/2021/03/SM9863781-1.png', 1, 1, '2025-12-01 20:46:00'),
(272, 239, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHlNs4jEy-dU6IPWmfdxS5T86AQfLW1D9MQw&s', 1, 1, '2025-12-01 20:46:00'),
(273, 240, 'https://m.media-amazon.com/images/I/71mtKreJmtL._SL1500_.jpg', 1, 1, '2025-12-01 20:46:00'),
(274, 241, 'https://i5.walmartimages.com/asr/5874137b-683e-4cf2-829b-a675d35b0034.317f22b7ca16845bd14b2881bb99b151.jpeg', 1, 1, '2025-12-01 20:46:00'),
(275, 242, 'https://pinoygroseri.com/cdn/shop/products/UFCBananaSauceHot_Spicy_BIG_19.40oz_500g_180x.jpg?v=1619725601', 1, 1, '2025-12-01 20:46:00'),
(276, 243, 'https://assets.unileversolutions.com/v1/130205778.png', 1, 1, '2025-12-01 20:46:00'),
(277, 244, 'https://www.nestleprofessional.ph/sites/default/files/styles/np_product_detail/public/2023-03/MAGGI%20Magic%20Sarap%208g.jpg?itok=oiR3Lr6c', 1, 1, '2025-12-01 20:46:00'),
(278, 51, 'https://ph.garmin.com/m/ph/g/products/fenix-7x-pro-sapphire-carbongray-cf-lg.jpg', 1, 2, '2025-12-02 00:13:18'),
(280, 54, 'https://gameone.ph/media/catalog/product/mpiowebpcache/d378a0f20f83637cdb1392af8dc032a2/1/_/1_5_33.webp', 1, 3, '2025-12-02 00:14:21'),
(281, 57, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLHHCR0crFX-tSodoDOip-2jKXrQNfJeYOFQ&s', 1, 2, '2025-12-02 00:15:09'),
(282, 43, 'https://assets2.razerzone.com/images/pnx.assets/f4e4b271435e1b02702e6012ed1f72b7/razer-blackwidow-v4-macro-keys-desktop.webp', 1, 2, '2025-12-02 00:16:14'),
(283, 97, 'https://www.breville.com.ph/image/cache/catalog/catalog/barista-express/barista-express-sesame-black-550x550.jpg', 0, 2, '2025-12-02 01:15:12'),
(284, 97, 'https://www.breville.com.ph/image/cache/catalog/catalog/barista-express/barista-express-sesame-black-550x550.jpg', 0, 3, '2025-12-02 01:15:18'),
(287, 35, 'https://d1rlzxa98cyc61.cloudfront.net/catalog/product/cache/1801c418208f9607a371e61f8d9184d9/1/8/182709_2020_2.jpg', 0, 5, '2025-12-02 01:56:17'),
(288, 150, 'https://www.google.com/imgres?q=be%20quiet!%20Dark%20Rock%204&imgurl=https%3A%2F%2Fbermorzone.com.ph%2Fwp-content%2Fuploads%2F2021%2F11%2F514qeBDsYyL._AC_SL1000_.jpg&imgrefurl=https%3A%2F%2Fbermorzone.com.ph%2Fshop%2Fcooling-systems%2Faircooling-system%2F', 0, 2, '2025-12-02 02:17:17'),
(292, 150, 'https://bermorzone.com.ph/wp-content/uploads/2021/11/514qeBDsYyL._AC_SL1000_.jpg', 1, 6, '2025-12-02 02:17:52'),
(293, 187, 'https://cdn.store-assets.com/s/377840/i/35716122.jpg', 1, 2, '2025-12-02 02:19:22'),
(295, 190, 'https://boholgrocery.com/wp-content/uploads/2020/11/Purefoods-Tender-Juicy-Hotdog-Regular-Classic-230g.png', 1, 3, '2025-12-02 02:23:50'),
(296, 190, 'https://boholgrocery.com/wp-content/uploads/2020/11/Purefoods-Tender-Juicy-Hotdog-Regular-Classic-230g.png', 0, 4, '2025-12-02 02:24:32'),
(297, 36, 'https://images.samsung.com/is/image/samsung/assets/ph/galaxy-watch6/feature/galaxy-watch6-safety-mo.jpg', 0, 2, '2025-12-02 04:15:04'),
(299, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN7QrWKsPQEfQYNjCLUtn174qEvoXEHJJA6w&s', 0, 2, '2025-12-02 04:22:57');
=======
(59, 30, 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=800', 1, 1, '2025-11-24 02:39:49'),
(60, 31, 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=800', 1, 1, '2025-11-24 02:39:49'),
(61, 32, 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800', 1, 1, '2025-11-24 02:39:49'),
(62, 33, 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=800', 1, 1, '2025-11-24 02:39:49'),
(63, 34, 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800', 1, 1, '2025-11-24 02:39:49');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
<<<<<<< HEAD
  `rating` int(11) NOT NULL,
  `title` varchar(200),
  `comment` text,
  `is_verified_purchase` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`),
  KEY `customer_id` (`customer_id`)
=======
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `title` varchar(100) DEFAULT NULL,
  `comment` text NOT NULL,
  `is_verified_purchase` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `customer_id`, `order_id`, `rating`, `title`, `comment`, `is_verified_purchase`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, 5, 'Amazing phone!', 'This Samsung Galaxy S24 Ultra exceeded my expectations. The camera quality is outstanding and the battery life is incredible. Highly recommended!', 1, 1, '2025-11-28 02:30:00', '2025-12-01 10:45:52'),
(2, 1, 3, NULL, 4, 'Great but expensive', 'Excellent phone with top-notch features. The only downside is the price, but you get what you pay for.', 0, 1, '2025-11-27 06:20:00', '2025-12-01 10:45:52'),
(3, 3, 2, NULL, 5, 'Best headphones ever', 'The noise cancellation is phenomenal. I use these daily for work and travel. Worth every penny!', 1, 1, '2025-11-26 01:15:00', '2025-12-01 10:45:52'),
(4, 11, 3, NULL, 5, 'Super comfortable running shoes', 'These Adidas Ultraboost shoes are incredibly comfortable. Perfect for long runs and everyday wear.', 1, 1, '2025-11-25 08:45:00', '2025-12-01 10:45:52'),
(5, 30, 2, NULL, 5, 'Life-changing book', 'Atomic Habits helped me build better routines. The concepts are practical and easy to implement. Must read!', 1, 1, '2025-11-24 03:30:00', '2025-12-01 10:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `carrier` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_method` varchar(100) DEFAULT NULL,
  `shipped_date` timestamp NULL DEFAULT NULL,
  `estimated_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` timestamp NULL DEFAULT NULL,
  `status` enum('preparing','shipped','in_transit','delivered','failed') DEFAULT 'preparing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `order_id`, `carrier`, `tracking_number`, `shipping_method`, `shipped_date`, `estimated_delivery_date`, `actual_delivery_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 10:45:23', '2025-11-28 10:45:23'),
(2, 2, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 11:40:01', '2025-11-28 11:40:01'),
(3, 3, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 11:50:00', '2025-11-28 11:50:00'),
(4, 4, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 12:03:06', '2025-11-28 12:03:06'),
(5, 5, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 12:10:24', '2025-11-28 12:10:24'),
(6, 6, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 12:42:43', '2025-11-28 12:42:43'),
(7, 7, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 23:49:05', '2025-11-28 23:49:05'),
(8, 8, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-28 23:52:14', '2025-11-28 23:52:14'),
(9, 9, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-29 00:03:43', '2025-11-29 00:03:43'),
(10, 10, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-11-29 00:06:33', '2025-11-29 00:06:33'),
(11, 11, NULL, NULL, 'Standard', '2025-11-29 00:20:41', NULL, NULL, 'shipped', '2025-11-29 00:10:25', '2025-11-29 00:20:41'),
(12, 12, NULL, NULL, 'Standard', '2025-11-29 01:52:44', NULL, NULL, 'shipped', '2025-11-29 00:44:59', '2025-11-29 01:52:44'),
<<<<<<< HEAD
(13, 13, NULL, NULL, 'Standard', '2025-12-01 07:07:29', NULL, NULL, 'shipped', '2025-12-01 01:27:39', '2025-12-01 07:07:29'),
(14, 14, NULL, NULL, 'Standard', '2025-12-02 05:58:20', NULL, NULL, 'shipped', '2025-12-02 05:57:17', '2025-12-02 05:58:20'),
(15, 15, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-03 05:17:21', '2025-12-03 05:17:21'),
(16, 16, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 05:01:32', '2025-12-05 05:01:32'),
(17, 17, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 05:13:54', '2025-12-05 05:13:54'),
(18, 18, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 05:18:29', '2025-12-05 05:18:29'),
(19, 19, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 05:46:34', '2025-12-05 05:46:34'),
(20, 20, NULL, NULL, 'Standard', '2025-12-05 06:08:05', NULL, NULL, 'shipped', '2025-12-05 05:52:53', '2025-12-05 06:08:05'),
(21, 21, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 06:25:34', '2025-12-05 06:25:34'),
(22, 22, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 06:31:50', '2025-12-05 06:31:50'),
(23, 23, NULL, NULL, 'Standard', NULL, NULL, NULL, 'preparing', '2025-12-05 06:51:35', '2025-12-05 06:51:35');
=======
(13, 13, NULL, NULL, 'Standard', '2025-12-01 07:07:29', NULL, NULL, 'shipped', '2025-12-01 01:27:39', '2025-12-01 07:07:29');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `customer_id`, `product_id`, `quantity`, `added_at`, `updated_at`) VALUES
(3, 3, 1, 1, '2025-11-24 02:53:25', '2025-11-24 02:53:25'),
(4, 3, 2, 1, '2025-11-24 02:53:37', '2025-11-24 02:53:37'),
(5, 3, 3, 1, '2025-11-24 02:53:43', '2025-11-24 02:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(50) DEFAULT 'text',
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `description`, `updated_at`) VALUES
('currency_symbol', '₱', 'text', 'Currency symbol', '2025-11-24 14:17:43'),
('enable_email_notifications', '1', 'checkbox', 'Enable email notifications', '2025-12-01 01:06:27'),
('enable_order_emails', '1', 'checkbox', 'Send order confirmation emails', '2025-12-01 01:06:27'),
('enable_payment_emails', '1', 'checkbox', 'Send payment confirmation emails', '2025-12-01 01:06:27'),
('enable_reviews', '1', 'checkbox', 'Enable product reviews', '2025-11-24 13:58:30'),
('enable_shipping_emails', '1', 'checkbox', 'Send shipping notification emails', '2025-12-01 01:06:27'),
('free_shipping_threshold', '49.9', 'number', 'Free shipping minimum', '2025-11-28 03:29:00'),
('gmail_sender_email', 'jrd.malls@gmail.com', 'email', 'Gmail sender email address', '2025-12-01 01:07:40'),
('gmail_sender_name', 'JRD Malls', 'text', 'Email sender name', '2025-12-01 01:07:40'),
('gmail_sender_password', 'kcooqodzgkvynodo', 'password', 'Gmail app password (16 characters)', '2025-12-01 01:07:40'),
('items_per_page', '9', 'number', 'Products per page', '2025-12-01 10:36:49'),
<<<<<<< HEAD
('maintenance_mode', '0', 'checkbox', 'Maintenance mode', '2025-12-05 09:43:24'),
=======
('maintenance_mode', '0', 'checkbox', 'Maintenance mode', '2025-11-28 03:29:00'),
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
('require_email_verification', '1', 'checkbox', 'Require email verification', '2025-11-28 03:29:00'),
('shipping_cost', '5.99', 'number', 'Standard shipping cost', '2025-11-24 13:58:30'),
('site_email', 'jrd.malls@gmail.com', 'email', 'Contact email', '2025-12-01 00:26:48'),
('site_name', 'JRD Malls', 'text', 'Website name', '2025-11-28 03:37:27'),
('site_phone', '+63 992 607 2695', 'text', 'Contact phone', '2025-12-01 00:26:48'),
('tax_rate', '10', 'number', 'Tax rate (%)', '2025-12-01 00:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `customer_id`, `product_id`, `added_at`) VALUES
(1, 3, 1, '2025-11-24 02:53:26'),
<<<<<<< HEAD
(2, 2, 1, '2025-11-29 00:10:05'),
(3, 2, 42, '2025-12-05 04:59:36');
=======
(2, 2, 1, '2025-11-29 00:10:05');
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `idx_user` (`user_type`,`user_id`),
  ADD KEY `idx_action` (`action_type`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_table` (`table_affected`,`record_id`),
  ADD KEY `idx_log_search` (`user_type`,`action_type`,`created_at`),
  ADD KEY `idx_user_activity` (`user_id`,`user_type`,`created_at`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`customer_id`);

--
<<<<<<< HEAD
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
=======
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_category_id` (`parent_category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_customer_email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `idx_inventory_product` (`product_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `idx_customer_read` (`customer_id`,`is_read`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `shipping_address_id` (`shipping_address_id`),
  ADD KEY `billing_address_id` (`billing_address_id`),
  ADD KEY `idx_order_customer` (`customer_id`),
  ADD KEY `idx_order_status` (`order_status`),
  ADD KEY `idx_order_date` (`created_at`);

--
-- Indexes for table `order_coupons`
--
ALTER TABLE `order_coupons`
  ADD PRIMARY KEY (`order_coupon_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_product_category` (`category_id`),
  ADD KEY `idx_product_sku` (`sku`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
<<<<<<< HEAD
=======
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `idx_approved` (`is_approved`);

--
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `unique_cart_item` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `unique_wishlist_item` (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
<<<<<<< HEAD
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;
=======
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
<<<<<<< HEAD
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
<<<<<<< HEAD
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
<<<<<<< HEAD
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
=======
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
<<<<<<< HEAD
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
<<<<<<< HEAD
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
=======
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
<<<<<<< HEAD
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
<<<<<<< HEAD
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
=======
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `order_coupons`
--
ALTER TABLE `order_coupons`
<<<<<<< HEAD
  MODIFY `order_coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
=======
  MODIFY `order_coupon_id` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
<<<<<<< HEAD
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
=======
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `order_notes`
--
ALTER TABLE `order_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
<<<<<<< HEAD
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
=======
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
<<<<<<< HEAD
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
=======
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
<<<<<<< HEAD
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;
=======
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
<<<<<<< HEAD
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
=======
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
<<<<<<< HEAD
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
=======
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
<<<<<<< HEAD
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
=======
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
<<<<<<< HEAD
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
=======
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`address_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`address_id`);

--
-- Constraints for table `order_coupons`
--
ALTER TABLE `order_coupons`
  ADD CONSTRAINT `order_coupons_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_coupons_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_notes`
--
ALTER TABLE `order_notes`
  ADD CONSTRAINT `order_notes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
<<<<<<< HEAD
=======
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE SET NULL;

--
>>>>>>> 5b1f3061036619f6e03034d7b5c0c9fda0523dd1
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
