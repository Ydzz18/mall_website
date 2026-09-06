<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Choose a Mall website portal.">
	<title>Mall Portal</title>
    <link rel="icon" type="image/png" href="logo/favicon.ico?v=1">
	<style>
		:root {
			color-scheme: light;
			--ink: #17232d;
			--muted: #64727c;
			--paper: #f7f4ed;
			--line: #d9ddd8;
			--accent: #d9643d;
			--accent-dark: #a9442c;
			--teal: #277c78;
			--shadow: 0 24px 70px rgba(34, 45, 47, 0.14);
		}

		* { box-sizing: border-box; }

		body {
			margin: 0;
			min-width: 320px;
			min-height: 100vh;
			color: var(--ink);
			font-family: Georgia, 'Times New Roman', serif;
			background: var(--paper);
		}

		body::before {
			position: fixed;
			inset: 0;
			z-index: -1;
			content: '';
			background:
				linear-gradient(135deg, rgba(217, 100, 61, 0.09), transparent 38%),
				radial-gradient(circle at 88% 14%, rgba(39, 124, 120, 0.16), transparent 24%),
				repeating-linear-gradient(0deg, transparent 0 39px, rgba(23, 35, 45, 0.035) 40px);
		}

		.shell {
			width: min(1080px, calc(100% - 40px));
			margin: 0 auto;
			padding: 32px 0 42px;
		}

		.topbar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 24px;
			margin-bottom: clamp(58px, 10vw, 112px);
		}

		.brand {
			display: inline-flex;
			align-items: center;
			gap: 12px;
			color: var(--ink);
			font-size: 1.05rem;
			font-weight: bold;
			letter-spacing: 0.08em;
			text-decoration: none;
			text-transform: uppercase;
		}

		.brand img {
			width: 42px;
			height: 42px;
			object-fit: contain;
		}

		.eyebrow {
			margin: 0;
			color: var(--teal);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 0.74rem;
			font-weight: bold;
			letter-spacing: 0.18em;
			text-transform: uppercase;
		}

		.hero {
			max-width: 690px;
			margin-bottom: 42px;
		}

		h1 {
			max-width: 650px;
			margin: 12px 0 18px;
			font-size: clamp(3.2rem, 8vw, 6.6rem);
			font-weight: normal;
			letter-spacing: -0.055em;
			line-height: 0.91;
		}

		.intro {
			max-width: 520px;
			margin: 0;
			color: var(--muted);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 1.05rem;
			line-height: 1.65;
		}

		.portals {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 16px;
		}

		.portal {
			position: relative;
			display: flex;
			min-height: 250px;
			flex-direction: column;
			justify-content: space-between;
			padding: 25px;
			overflow: hidden;
			color: var(--ink);
			background: rgba(255, 255, 255, 0.72);
			border: 1px solid var(--line);
			box-shadow: 0 8px 30px rgba(34, 45, 47, 0.05);
			text-decoration: none;
			transition: transform 180ms ease, border-color 180ms ease, box-shadow 180ms ease;
		}

		.portal::after {
			position: absolute;
			right: -30px;
			bottom: -38px;
			width: 135px;
			height: 135px;
			content: '';
			border: 1px solid currentColor;
			border-radius: 50%;
			opacity: 0.16;
		}

		.portal:hover,
		.portal:focus-visible {
			transform: translateY(-6px);
			border-color: var(--accent);
			box-shadow: var(--shadow);
		}

		.portal:focus-visible {
			outline: 3px solid rgba(217, 100, 61, 0.35);
			outline-offset: 4px;
		}

		.portal--main { border-top: 5px solid var(--accent); }
		.portal--admin { border-top: 5px solid var(--ink); }
		.portal--rider { border-top: 5px solid var(--teal); }

		.portal-number {
			color: var(--muted);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 0.75rem;
			letter-spacing: 0.13em;
		}

		.portal h2 {
			margin: 42px 0 8px;
			font-size: 1.8rem;
			font-weight: normal;
		}

		.portal p {
			max-width: 220px;
			margin: 0;
			color: var(--muted);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 0.88rem;
			line-height: 1.5;
		}

		.enter {
			display: flex;
			align-items: center;
			gap: 9px;
			margin-top: 24px;
			color: var(--accent-dark);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 0.76rem;
			font-weight: bold;
			letter-spacing: 0.1em;
			text-transform: uppercase;
		}

		.portal--admin .enter { color: var(--ink); }
		.portal--rider .enter { color: var(--teal); }

		.arrow { font-size: 1.1rem; line-height: 0; }

		footer {
			margin-top: 34px;
			color: var(--muted);
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 0.76rem;
		}

		@media (max-width: 760px) {
			.shell { width: min(100% - 28px, 560px); padding-top: 22px; }
			.topbar { margin-bottom: 64px; }
			.portals { grid-template-columns: 1fr; }
			.portal { min-height: 190px; }
			.portal h2 { margin-top: 26px; }
		}

		@media (prefers-reduced-motion: reduce) {
			.portal { transition: none; }
		}
	</style>
</head>
<body>
	<main class="shell">
		<header class="topbar">
			<a class="brand" href="../index.php" aria-label="Mall website home">
				<img src="../logo/icon.png" alt="">
				<span>Mall</span>
			</a>
			<p class="eyebrow">One place, three ways in</p>
		</header>

		<section class="hero" aria-labelledby="page-title">
			<p class="eyebrow">Welcome to the mall</p>
			<h1 id="page-title">Where would you like to go?</h1>
			<p class="intro">Choose the space that matches your visit. Everything you need is just one step away.</p>
		</section>

		<nav class="portals" aria-label="Mall portals">
			<a class="portal portal--main" href="../index.php">
				<div>
					<span class="portal-number">01 / VISITORS</span>
					<h2>Main website</h2>
					<p>Explore stores, services, offers, and everything happening at the mall.</p>
				</div>
				<span class="enter">Enter site <span class="arrow" aria-hidden="true">&rarr;</span></span>
			</a>

			<a class="portal portal--admin" href="../admin/login.php">
				<div>
					<span class="portal-number">02 / OPERATIONS</span>
					<h2>Admin portal</h2>
					<p>Manage products, orders, customers, reports, and mall operations.</p>
				</div>
				<span class="enter">Sign in <span class="arrow" aria-hidden="true">&rarr;</span></span>
			</a>

			<a class="portal portal--rider" href="../rider/login.php">
				<div>
					<span class="portal-number">03 / DELIVERY</span>
					<h2>Rider portal</h2>
					<p>View assigned deliveries and keep every order moving smoothly.</p>
				</div>
				<span class="enter">Sign in <span class="arrow" aria-hidden="true">&rarr;</span></span>
			</a>
		</nav>

		<footer>Secure access for every part of the Mall experience.</footer>
	</main>
</body>
</html>