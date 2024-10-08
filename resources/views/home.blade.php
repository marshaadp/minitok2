<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta name="viewport" content="minimum-scale=1, initial-scale=1.0, width=device-width">
	<meta charset="UTF-8">
	<title>Home</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="author" content="templatemo">
	<!-- 
	Medigo Template
	http://www.templatemo.com/preview/templatemo_460_medigo
	-->

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
		rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="resources/home/bootstrap/bootstrap.css">
	<link rel="stylesheet" href="resources/home/css/misc.css">
	<link rel="stylesheet" href="resources/home/css/red-scheme.css">

	<!-- JavaScripts -->
	<script src="resources/home/js/jquery-1.10.2.min.js"></script>
	<script src="resources/home/js/jquery-migrate-1.2.1.min.js"></script>

	<link rel="shortcut icon" href="resources/home/images/minitok.jpeg" type="image/x-icon" />
	<link rel="stylesheet" href="resources/home/css/newupdate.css">

	<style>
		body,
		html {
			margin: 0;
			padding: 0;
			height: 100%;
			font-family: 'Montserrat';
		}

		.block-background {
			position: relative;
			width: 100%;
			height: 100vh;
			overflow: hidden;
		}

		.block-background video {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.block-background__overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.45);
		}

		.block-layout {
			display: grid;
			grid-template-rows: 1fr auto auto auto 1fr;
			grid-template-columns: 1fr 8fr 1fr;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			padding: 0 16px;
			box-sizing: border-box;
			z-index: 2;
		}

		.layout-element {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.text-box h1 {
			color: #ffffff;
			text-align: center;
		}

		.text-box p {
			color: #ffffff;
			text-align: center;
		}

		.grid-button {
			font-size: 20px;
			font-weight: 700;
			border-radius: 10px;
			padding: 12px 35px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			margin: 20px;
			border: 2px solid #800000;
			/* Red border */
			background-color: #800000;
			/* Red background */
			color: #ffffff;
			/* White text (always white) */
			transition: background-color 0.3s ease, border-color 0.3s ease;
			/* No color transition */
		}

		.grid-button:hover {
			background-color: #800000;
			/* Keep the background color the same on hover */
			border-color: #800000;
			/* Border also remains red */
			color: #ffffff !important;
			/* Keep the text white on hover */
		}

		body {
			font-family: 'Montserrat';
			margin: 0;
			padding: 0;
			background: #f4f4f4;
		}

		/* Table Section */
		.table-section {
			padding: 40px 20px;
			background: #fff;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.container {
			max-width: 1200px;
			margin: 0 auto;
		}

		/* Heading */
		h2 {
			font-size: 20px;
			margin-bottom: 20px;
			color: #333;
			font-family: 'Montserrat';
		}

		h2-hitam {
			font-size: 40px;
			margin-bottom: 20px;
			color: #000;
			font-weight: bold;
			font-family: 'Montserrat';
	
		}

		h2-merah {
			font-size: 40px;
			margin-bottom: 20px;
			color: #C80036;
			font-weight: bold;
			font-family: 'Montserrat';
		}


		/* Table Wrapper */
		.table-wrapper {
			overflow: auto;
			/* Allows both horizontal and vertical scrolling */
			-webkit-overflow-scrolling: touch;
			/* Smooth scrolling on touch devices */
		}

		/* Table Styles */
		table {
			width: 100%;
			border-collapse: collapse;
			border-radius: 8px;
			overflow: hidden;
			background: #fff;
			font-size: 12px;
			text-align: center;
			/* Reduced font size */
		}

		.table-container {
			max-height: 800px;
			/* Atur tinggi maksimum kontainer tabel */
			overflow-y: auto;
			/* Tambahkan scroll vertikal jika konten melebihi tinggi */
			border: 1px solid #ddd;
			/* Tambahkan border di sekitar kontainer */
			border-radius: 8px;
			/* Rounded corners */
			width: 120%;
		}

		thead {
			background-color: #333;
			color: #fff;
		}

		thead th {
			padding: 12px;
			/* Adjusted padding for smaller font size */
			text-align: left;
			font-weight: 600;
		}

		tbody tr {
			transition: background 0.3s ease;
		}

		tbody tr:hover {
			background-color: #f0f0f0;
		}

		tbody td {
			padding: 10px;
			/* Adjusted padding for smaller font size */
			border-bottom: 1px solid #ddd;
		}

		/* Responsive Styles */
		@media (max-width: 768px) {
			table {
				border: 0;
			}

			thead {
				display: none;
			}

			tbody,
			tbody tr,
			tbody td {
				display: block;
				width: 100%;
				box-sizing: border-box;
				border-bottom: 1px solid #ddd;
			}

			tbody tr {
				margin-bottom: 15px;
				padding: 10px;
				background-color: #fff;
			}

			tbody td {
				display: flex;
				justify-content: space-between;
				padding: 10px;
				border-top: 1px solid #ddd;
			}

			tbody td::before {
				content: attr(data-label);
				font-weight: 600;
				margin-right: 10px;
			}
		}
	</style>
</head>

<body>
	<div class="responsive_menu">
		<ul class="main_menu">
			<li><a href="index.html">Home</a></li>
			<li><a href="#">Portfolio</a>
				<ul>
					<li><a href="portfolio.html">Portfolio Grid</a></li>
					<li><a href="project-image.html">Project Image</a></li>
					<li><a href="project-slideshow.html">Project Slideshow</a></li>
				</ul>
			</li>
			<li><a href="#">Blog</a>
				<ul>
					<li><a href="blog.html">Blog Standard</a></li>
					<li><a href="blog-single.html">Blog Single</a></li>
					<li><a href="#">visit templatemo</a></li>
				</ul>
			</li>
			<li><a href="archives.html">Archives</a></li>
			<li><a href="contact.html">Contact</a></li>
		</ul> <!-- /.main_menu -->
	</div> <!-- /.responsive_menu -->

	<header class="site-header clearfix">
		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<div class="pull-left logo">
						<a href="index.html">
							<img src="resources/home/images/minitok.jpeg" alt="Minitok" width="50" height="auto">
						</a>
					</div> <!-- /.logo -->

					<div class="main-navigation pull-right">

						<div class="main-navigation pull-right"></div>
						<nav class="main-nav visible-md visible-lg">
							<ul class="sf-menu">
								@if(session("username") != "")
									<li><a href="{{url('/home')}}">Home</a></li>
								@endif
								<li><a href="#">Minimum Stock ONT</a>
									<ul>
										<li><a href="{{url('/rekap_delivery')}}">Rekap Minimum Stock ONT</a></li>
										<li><a href="{{url('/pengiriman_stb')}}">Report Delivery ONT</a></li>
									</ul>
								</li>
								<li><a href="#">Minimum Stock STB</a>
									<ul>
										<li><a href="{{url('/ap/rekap_delivery_ap')}}">Rekap Minimum Stock STB</a></li>
										<li><a href="{{url('/pengiriman_ap')}}">Report Delivery STB</a></li>
									</ul>
								</li>
								<li><a href="#">Minimum Stock AP</a>
									<ul>
										<li><a href="{{url('/ap/rekap_delivery_ap')}}">Rekap Minimum Stock Access
												Point</a></li>
										<li><a href="{{url('/pengiriman_ap')}}">Report Delivery Access Point</a></li>
									</ul>
								</li>
								<li><a href="#">Input Data</a>
									<ul>
										<li><a href="{{url('/input_data_stock')}}">Upload File Stock</a></li>
										<li><a href="{{url('/input_data_pengiriman')}}">Update File Delivery</a></li>
										<li><a href="{{url('/input_data_database')}}">Update File Minimum Stock</a></li>
									</ul>
								</li>
								<li><a href="{{url('/user_list')}}">User List</a></li>
								<li><a href="">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16"
											height="16" style="vertical-align: middle;">
											<path
												d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
										</svg>
									</a>
								</li>
								<li><a href="">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
											height="16" style="vertical-align: middle;">
											<path
												d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
										</svg>
									</a>
								</li>
								@if(session("username") != "")
									<li><a href="{{ url('/logout') }}">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
												height="16" style="vertical-align: middle;">
												<!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
												<path
													d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
											</svg>
										</a>
									</li>
								@endif
							</ul> <!-- /.sf-menu -->
						</nav> <!-- /.main-nav -->
						<div class="responsive-navigation visible-sm visible-xs">
							<a href="#nogo" class="menu-toggle-btn">
								<i class="fa fa-bars"></i>
							</a>
						</div> <!-- /responsive_navigation -->

					</div>
					<!-- This one in here is responsive menu for tablet and mobiles -->
					<div class="responsive-navigation visible-sm visible-xs">
						<a href="#nogo" class="menu-toggle-btn">
							<i class="fa fa-bars"></i>
						</a>
					</div> <!-- /responsive_navigation -->

				</div> <!-- /.main-navigation -->

			</div> <!-- /.col-md-12 -->

		</div> <!-- /.row -->

		</div> <!-- /.container -->
	</header> <!-- /.site-header -->

	<section id="" class="parallax first-widget" style="position: relative; overflow: hidden;">
		<video autoplay muted loop
			style="position: absolute; width: 100%; height: 100%; top: 50%; left: 50%; object-fit: cover; transform: translate(-50%, -50%); z-index: -1;">
			<source src="resources/home/images/video.mp4" type="video/mp4">
			Your browser does not support the video tag.
		</video>
		<div class="parallax-overlay">
			<div class="container home-intro-content">
				<div class="row">
					<div class="col-md-12">
							<h2>Telkom Presents</h2>
							<h2>MINITOK</h2>
							<p>Aplikasi Monitoring Stock Minium NTE.Solusi terbaik untuk memonitor kebutuhan NTE di Telkom Regional dengan efisien
							</p>
							<div class="layout-element" style="grid-row: 2 / 10; grid-column: 1/3;">
								<a class="grid-button" href="{{url('/login')}}">Login</a>
							</div>
					</div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</section> <!-- /#homeIntro -->

	<section class="header" id="about">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-xs-11">
				</div>
				<br />
				<div class="col-md-5 col-xs-12">
					<section>
						<!--for demo wrap-->
						<h2-hitam>Rekap</h2-hitam> <h2-merah>Delivery</h2-merah>
						<br />
						<div class="tbl-header">
							<div class="table-container" style="position: relative; max-height: 600px; width: 1000px;">
								<table class="table table-bordered" id="filterTable">
									<thead>
										<tr class="text-center"
											style="color:black; background-color:#800000; color:white;">
											<th rowspan="2" class="first-col sticky-col"
												style="min-width: 250px; text-align: center; vertical-align: middle;">
												Warehouse</th>
											<th rowspan="2" hidden>regional</th>
											<th rowspan="2" hidden>witel</th>
											<th rowspan="2" style="text-align: center; vertical-align: middle;"
												style="max-width:70px" hidden>Minimum Qty</th>
											<th colspan="2">Stock SCMT</th>
											<th colspan="2">GAP Stock</th>
											<th colspan="2">Kebutuhan</th>
											<th colspan="2">Minimum Stock Requirement Retail</th>
											<th colspan="2">On Delivery</th>
										</tr>
										<tr class="text-center" style="background-color:#982B1C; color:white;">
											<!-- <th  colspan="4" ></th> -->
											<th style="text-align: center; vertical-align: middle;">Total
												Retail</th>
											<th style="text-align: center; vertical-align: middle;">Total
												Premium</th>

											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Retail</th>
											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Premium</th>

											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Retail</th>
											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Premium</th>

											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Retail</th>
											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Premium</th>

											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Retail</th>
											<th style="max-width:100px; text-align: center; vertical-align: middle;">
												Total Premium</th>
										</tr>
									</thead>
									<tbody id="tableBiasa-body">
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG1</a>
											</td>
											<td hidden>WH TR TREG1</td>
											<td hidden>WH TR TREG1</td>
											<td hidden>8.380</td>

											<div class="text-center">
												<td>1.755</td>
												<td>2.684</td>

												<td class="blink-red ">
													<span>-2.865</span>
												</td>

												<td class="blink-yellow ">
													<span>-1.076</span>
												</td>

												<td>
													4.460 </td>
												<td>
													2.980 </td>

												<td>4.620</td>
												<td>3.760</td>

												<td><a onClick='setOnDelivery("WH TR TREG1","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG1","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:g=black;">1.736</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG2</a>
											</td>
											<td hidden>WH TR TREG2</td>
											<td hidden>WH TR TREG2</td>
											<td hidden>11.095</td>

											<div class="text-center">
												<td>635</td>
												<td>5.388</td>

												<td class="blink-red ">
													<span>-5.560</span>
												</td>

												<td class=" blink-green ">
													<span>488</span>
												</td>

												<td>
													6.920 </td>
												<td>
													2.820 </td>

												<td>6.195</td>
												<td>4.900</td>

												<td><a onClick='setOnDelivery("WH TR TREG2","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG2","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">1.514</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG3</a>
											</td>
											<td hidden>WH TR TREG3</td>
											<td hidden>WH TR TREG3</td>
											<td hidden>7.035</td>

											<div class="text-center">
												<td>1.431</td>
												<td>1.893</td>

												<td class="blink-red ">
													<span>-2.569</span>
												</td>

												<td class="blink-yellow ">
													<span>-1.142</span>
												</td>

												<td>
													3.980 </td>
												<td>
													1.920 </td>

												<td>4.000</td>
												<td>3.035</td>

												<td><a onClick='setOnDelivery("WH TR TREG3","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG3","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">1.203</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG4</a>
											</td>
											<td hidden>WH TR TREG4</td>
											<td hidden>WH TR TREG4</td>
											<td hidden>6.340</td>

											<div class="text-center">
												<td>2.335</td>
												<td>1.984</td>

												<td class="blink-yellow ">
													<span>-1.265</span>
												</td>

												<td class="blink-yellow ">
													<span>-756</span>
												</td>

												<td>
													3.360 </td>
												<td>
													1.900 </td>

												<td>3.600</td>
												<td>2.740</td>

												<td><a onClick='setOnDelivery("WH TR TREG4","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG4","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">920</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG5</a>
											</td>
											<td hidden>WH TR TREG5</td>
											<td hidden>WH TR TREG5</td>
											<td hidden>12.520</td>

											<div class="text-center">
												<td>6.368</td>
												<td>5.376</td>

												<td class="blink-yellow ">
													<span>-1.037</span>
												</td>

												<td class=" blink-green ">
													<span>261</span>
												</td>

												<td>
													6.500 </td>
												<td>
													2.900 </td>

												<td>7.405</td>
												<td>5.115</td>

												<td><a onClick='setOnDelivery("WH TR TREG5","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG5","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">1.230</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG6</a>
											</td>
											<td hidden>WH TR TREG6</td>
											<td hidden>WH TR TREG6</td>
											<td hidden>7.910</td>

											<div class="text-center">
												<td>8.831</td>
												<td>4.768</td>

												<td class=" bgc-green  ">
													4.186 </td>

												<td class=" blink-green ">
													<span>1.503</span>
												</td>

												<td>
													2.200 </td>
												<td>
													1.620 </td>

												<td>4.645</td>
												<td>3.265</td>

												<td><a onClick='setOnDelivery("WH TR TREG6","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG6","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">920</a>
												</td>
											</div>
										</tr>
										<tr>
											<td value="" class="first-col sticky-col"
												style="background-color:#982B1C; color:white; font-weight: bold;">
												<a style="text-decoration:none; color: white; font-weight: bold; cursor: pointer;"
													href="">WH
													TR TREG7</a>
											</td>
											<td hidden>WH TR TREG7</td>
											<td hidden>WH TR TREG7</td>
											<td hidden>7.365</td>

											<div class="text-center">
												<td>5.064</td>
												<td>2.552</td>

												<td class=" blink-green ">
													<span>79</span>
												</td>

												<td class="bgc-yellow  ">
													-153 </td>

												<td>
													3.720 </td>
												<td>
													1.480 </td>

												<td>4.985</td>
												<td>2.705</td>

												<td><a onClick='setOnDelivery("WH TR TREG7","retail")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">0</a>
												</td>
												<td><a onClick='setOnDelivery("WH TR TREG7","premium")'
														data-toggle='modal' data-target='#onDeliveryModal'
														style="cursor: pointer; color:black;">910</a>
												</td>
											</div>
										</tr>
										<tr style="font-weight: bold; background-color:#982B1C; color:white;">
											<td value="" class="sticky-col first-col text-center"
												style="background-color:#982B1C; color:white;">
												<div hidden>Z</div>Total
											</td>
											<td hidden></td>
											<td hidden></td>
											<td hidden>60.645</td>

											<div class="text-center">
												<td>26.419</td>
												<td>24.645</td>

												<td>-9.031</td>
												<td>-875</td>

												<td>31.140</td>
												<td>15.620</td>

												<td>35.450</td>
												<td>25.520</td>

												<td><a href="" style="color:white;">0 </a></td>
												<td><a href="" style="color:white;">8.433 </a></td>
											</div>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>
					<!-- follow me template -->
				</div>
			</div>
		</div>
	</section>

	<section class="cta clearfix">
		<div>
			<div>
				<div class="col-md-12">
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</section> <!-- /.cta -->

	<section class="light-content services">
		<div class="container">
		</div> <!-- /.container -->
	</section> <!-- /.services -->

	<section class="header">
		<h2-hitam>New Update</h2-hitam> <h2-merah>NTE Management</h2-merah>
		<p>Kanal Pemberitaan Terkait Update Pengelolaan NTE</p>
		<section class="dashboard">
			<div class="card">
				<img src="path_to_image1.jpg" alt="UAM dan UAR">
				<h3>UAM dan UAR</h3>
				<p>Aplikasi yang membantu unit pengelola NTE Telkom regional dalam memantau kebutuhan NTE.</p>
			</div>
			<div class="card">
				<img src="path_to_image2.jpg" alt="BISPO End to End">
				<h3>BISPO End to End</h3>
				<p>Aplikasi yang sangat membantu dalam memonitor kebutuhan NTE di Telkom regional secara efisien.</p>
			</div>
			<div class="card">
				<img src="path_to_image3.jpg" alt="Aplikasi NTE Lainnya">
				<h3>?</h3>
				<p>Aplikasi yang memudahkan unit pengelola NTE Telkom regional dalam memantau kebutuhan NTE.</p>
			</div>
		</section>
	</section>

	<section class="section" id="about">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div>
						<br />
						<h2-hitam>Aplikasi Monitoring</h2-hitam>
						<br/>
						<h2-merah>Stock Minimum NTE</h2-merah>
						<p class="testimonial-description">Solusi terbaik untuk memonitor kebutuhan NTE di Telkom
							Regional dengan efisien</p>
					</div>
				</div>
				<br />
				<section class="dashboard">
					<form>
						<div class="form-group">
							<label for="name">Monitor</label>
							<input type="text" id="name" name="name" placeholder="Masukkan nama Anda di sini"
								style="margin-top: 5px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 10px; width: 150%;">
						</div>
						<div class="form-group">
							<label for="email">Email*</label>
							<input type="email" id="email" name="email" placeholder="Masukkan email Anda di sini"
								style="margin-top: 5px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; width: 150%;">
						</div>
						<div class="form-group">
							<label for="message">Pesan*</label>
							<textarea id="message" name="message" placeholder="Tulis pesan Anda di sini"
								style="margin-top: 5px; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; width: 150%;"></textarea>
						</div>
						<button type="submit">Kirim</button>
					</form>
				</section>
			</div>
		</div>
	</section>

	<section id="blogPosts" class="parallax">
		<div class="parallax-overlay">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-header">
							<h2 class="section-title">Recent from our blog</h2>
							<p class="section-desc">Everything you need to create a professional website.</p>
						</div> <!-- /.section-header -->
					</div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
				<div class="row latest-posts">
					<div class="col-md-4 col-sm-6">
						<div class="blog-post clearfix">
							<div class="thumb-post">
								<a href="blog-single.html"><img src="images/includes/blogthumb1.jpg" alt=""
										class="img-circle"></a>
							</div>
							<div class="blog-post-content">
								<h4 class="post-title"><a href="blog-single.html">Aplikasi ini sangat membantu dalam
										memonitoring kebutuhan NTE di Telkom. Sangat direkomendasikan</a></h4>
								<span class="meta-post-date">rif</span>
							</div>
						</div> <!-- /.blog-post -->
					</div> <!-- /.col-md-4 -->
					<div class="col-md-4 col-sm-6">
						<div class="blog-post clearfix">
							<div class="thumb-post">
								<a href="blog-single.html"><img src="images/includes/blogthumb2.jpg" alt=""
										class="img-circle"></a>
							</div>
							<div class="blog-post-content">
								<h4 class="post-title"><a href="blog-single.html">Design Deliverables – easily share
										project</a></h4>
								<span class="meta-post-date">10 February 2084</span>
							</div>
						</div> <!-- /.blog-post -->
					</div> <!-- /.col-md-4 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</section> <!-- /#blogPosts -->

	<footer class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<nav class="footer-nav clearfix">
						<ul class="footer-menu">
							<li><a href="index.html">Home</a></li>
							<li><a href="portfolio.html">Portfolio</a></li>
							<li><a href="blog.html">Blog Posts</a></li>
							<li><a href="archives.html">Shortcodes</a></li>
							<li><a href="contact.html">Contact</a></li>
						</ul> <!-- /.footer-menu -->
					</nav> <!-- /.footer-nav -->
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
			<div class="row">
				<div class="col-md-12">
					<p class="copyright-text">Copyright &copy; 2084 Company Name
						| Design: templatemo</p>
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</footer> <!-- /.site-footer -->

	<!-- Scripts -->
	<script src="resources/home/js/min/plugins.min.js"></script>
	<script src="resources/home/js/min/medigo-custom.min.js"></script>

</body>

</html>