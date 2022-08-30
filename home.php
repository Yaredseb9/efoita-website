<?php

$error = '';
$warning = '';
$info = '';
$success = '';
$creditNumberConfirm = false;
$retryNo = 3;

include( "assets/php/session.php" );
if ( !isset( $_SESSION[ 'employeeID' ] ) ) {
	header( 'Location:index.php' );
}

if ( isset( $_POST[ 'cardCharge' ] ) ) {
	$amount = $_POST[ 'amount' ];
	if ( isset( $_POST[ 'myPhone' ] ) )$phone = $_POST[ 'myPhone' ];
	else $phone = $_POST[ 'otherPhone' ];

	$warning = "secret confirm error";
	$warningMessage = " Please confirm the secdret Number for the transaction<br><b>Phone No. : $phone <br>Amount : $amount</b>";
	$creditNumberConfirm = true;
}
if ( isset( $_POST[ 'confirmSecret' ] ) ) {
	$retryNo = $_POST[ 'retryNo' ] - 1;
	if ( $retryNo == 2 ) {
		$warning = "confirm secret number warning";
		$warningMessage = "Please enter the secret No carefully <b> ( " . ( $retryNo ) . " retry left ) </b>";
		$creditNumberConfirm = true;
	} else if ( $retryNo == 1 ) {
		$warning = "confirm secret number warning";
		$warningMessage = "Please enter the secret number carefully <b> ( " . ( $retryNo ) . " retry left ) </b>";
		$error = "confirm secret number error";
		$errorMessage = "Please enter the secret number carefully last retry <b> session will close </b>";
		$creditNumberConfirm = true;
	} else {
		header( "Location: assets/php/logout.php" );
	}
}

$sql = "SELECT * FROM `status` WHERE `employeeID`='" . $_SESSION[ 'employeeID' ] . "';";
if ( !$memberStatusRecored = mysqli_query( $con, $sql ) ) {
	$error = 'fetch Error';
	$errorMessage = "Error : can't fetch status record";
} else {
	$memberStatusRecored = mysqli_fetch_assoc( $memberStatusRecored );
}

$sql = "SELECT * FROM `used_card` WHERE `employeeID`='" . $_SESSION[ 'employeeID' ] . "';";
if ( !$memberCardRecored = mysqli_query( $con, $sql ) ) {
	$error = 'fetch Error';
	$errorMessage = "Error : can't fetch status record";
} else {
	$memberCardRecoredNo = mysqli_num_rows( $memberCardRecored ); //mysqli_fetch_assoc($memberCardRecored);
}
mysqli_close( $con );
?>
<!DOCTYPE html>
<!-- html -->
<html>
<!-- head -->

<head>
	<title>efoita | home</title>
	<link rel="icon" href="images/logoOne.png" />
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
	<!-- bootstrap-CSS -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- bootstrap-select-CSS -->
	<link href="css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>
	<!-- Fontawesome-CSS -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type='text/javascript' src='js/jquery-2.2.3.min.js'></script>
	<!-- Custom Theme files -->
	<!--theme-style-->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<!--//theme-style-->
	<!--meta data-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="keywords" content="efoita Ethiopia, ethiopian online payment, top ethiopian online payment"/>
	<script type="application/x-javascript">
		addEventListener( "load", function () {
			setTimeout( hideURLbar, 0 );
		}, false );

		function hideURLbar() {
			window.scrollTo( 0, 1 );
		}
	</script>
	<!--//meta data-->
	<!-- online fonts -->
	<link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,vietnamese" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Oxygen:300,400,700&amp;subset=latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	<!-- /online fonts -->

</head>
<!-- //head -->
<!-- body -->

<body>
	<!--header-->
	<header>
		<div class="container">
			<!--logo-->
			<div class="logo">
				<a href="index.php"><img src="images/logoOne.png" class="logo visible-md visible-lg" style="width: 23%" /><h1 class="logo">efoita</a></h1>
			</div>
			<!--//logo-->
			<div class="w3layouts-login">
				<a href="assets/php/logout.php" style="float: right;"><i class="glyphicon glyphicon-log-out"> </i><b>Logout</b></a>
			</div>
			<div class="w3layouts-login">
				<a href="#"><i class="glyphicon glyphicon-user"> </i><?php echo($_SESSION['name']); ?>&nbsp;&nbsp; </a>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>
	<!-- //header -->
	<!-- innerbanner -->
	<div class="agileits-inner-banner">

	</div>
	<!-- //innerbanner -->
	<!-- menu -->
	<style type="text/css">
		.myLink {
			color: black;
			text-decoration: none;
		}
		
		.myLink:hover {
			color: white;
			text-decoration: none;
		}
		
		.myLink.active {
			color: white;
		}
	</style>
	<div class="w3layouts-breadcrumbs text-center ">
		<div class="container">
			<b>
				<div class=" agileinfo-dwld-app">
					<a href="index.php" class="myLink"><i class="fa fa-home home_1"></i>  </a>&nbsp;&nbsp;
					<a href="home.php" class="myLink active"><i class="glyphicon glyphicon-stats home_1"></i> Status</a>&nbsp;&nbsp;
					<a href="services.php" class="myLink "><i class="fa fa-cogs home_1" ></i> Services</a>
				</div>
			</b>
		</div>
	</div>
	<!-- //menu -->
	<!-- contains -->
	<div class="support w3layouts-content" style="padding-top: 0px;">
		<div class="container">
			<div class="col-md-2 agileits-support" style=" margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
						<h5>Salary</h45>
					</span>
				
				</div>
				<ul>
					<li>
					<center>
						<a class="w3-faq">
							<strong><?php echo(number_format($memberRecored['salary'])); ?></strong>
						</a>
					</center>
					</li>
				</ul>
			</div>

			<div class="col-md-2 agileits-support" style=" margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
						<h5>Debit</h45>
					</span>
				
				</div>
				<ul>
					<li>
					<center>
						<a class="w3-faq">
							<strong><?php echo(number_format(($memberRecored['salary'] * 0.25) * 0.25)); ?></strong>
						</a>
					</center>
					</li>
				</ul>
			</div>

			<div class="col-md-2 agileits-support" style=" margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
				<h5>Remaining  Debit</h45>
					</span>
				
				</div>
				<ul>
					<li>
						<center>
							<a class="w3-faq">
								<strong><?php echo(number_format($memberStatusRecored['debitAmount'] )); ?></strong>
							</a>
						</center>
						
					</li>
				</ul>
			</div>

			<div class="col-md-2 agileits-support" style=" margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
						<h5>Credit</h45>
					</span>
				
				</div>
				<ul>
					<li>
					<center>
						<a class="w3-faq">
							<strong><?php echo(number_format($memberRecored['salary'] * 0.25)); ?></strong>
						</a>
					</center>
					</li>
				</ul>
			</div>
			<div class="col-md-2 agileits-support" style=" margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
						<h5>Remaining Credit</h45>
					</span>
				
				</div>
				<ul>
					<li>
					<center>
						<a class="w3-faq">
							<strong><?php echo(number_format($memberStatusRecored['creditAmount'])); ?></strong>
						</a>
					</center>
					</li>
				</ul>
			</div>
			<div class="col-md-2 agileits-support" style="background-color: #3f06; margin-top: 0px">
				<div style="background-color: #28ece3; ">
					<span class="input-group-addon" style="background-color: #029c95; color: white">
						<h5>Total</h45>
					</span>
				
				</div>
				<ul>
					<li>
					<center>
						<?php 
						$total=$memberRecored['salary'] - (($memberRecored['salary'] * 0.25 * 0.25) + ($memberRecored['salary'] * 0.25)) + $memberStatusRecored['debitAmount'] + $memberStatusRecored['creditAmount'] 
						?>
						<a class="w3-faq">
							<b><?php echo(number_format($total)); ?></b>
						</a>
					</center>
					</li>
				</ul>
			</div>

		</div>
	</div>
<!--	<div class="container">
		<div class="progress" style=" background-color: #03a9f4">
			<div class="progress-bar progress-bar-success" style="width: 35%"><span class="progress-label">Default</span>60%</span>
			</div>
			<div class="progress-bar progress-bar-warning" style="width: 20%"><span class="sr-only">20% Complete (warning)</span>
			</div>
			<div class="progress-bar progress-bar-danger" style="width: 10%"><span class="sr-only">10% Complete (danger)</span>
			</div>
		</div>
	</div>-->
	
	<div class="container">
		<!-- Salary 
		<div class="progress progress-striped active">
			<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php //echo(($memberRecored['salary']/$memberRecored['salary'])*100); ?>%;"><span class="progress-label">Salary </span>(<?php //echo(($memberRecored['salary']/$memberRecored['salary'])*100); ?>%)</div>
		</div>
		<div class="progress progress-bar-inverse progress-striped active">
			<div class="progress-bar progress-bar-success" role="progressbar"style="width:<?php //echo(($total/$memberRecored['salary'])*100); ?>%;"><span class="progress-label">Balance </span>(<?php //echo($total/100); ?>%)</div>
		</div>
		<!--  //Salary -->
		<!--  Credit * 0.25) -->
		<div class="progress progress-striped progress-bar-success active" style="cursor:help" title="My Salary"><!--<span style="color: white; padding-left: 10% ">My Salary</span>-->
			<div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?php echo((($memberRecored['salary'] * 0.25)/$memberRecored['salary'])*100); ?>%; " title="25% of the salary is allowed"><span class="progress-label">Allowed Credit </span>(<?php echo((($memberRecored['salary'] * 0.25)/$memberRecored['salary'])*100); ?>%)</div>
		</div>
		<div class="progress progress-bar-success active" style="cursor: help" title="My Salary">
			<div class="progress-bar progress-bar-inverse progress-striped active" style="cursor:help; width: <?php echo((($memberRecored['salary'] * 0.25)/$memberRecored['salary'])*100); ?>%;" title="used credit">
				<div class="progress progress-bar progress-bar-warning " role="progressbar" style="cursor:help; width: <?php echo((($memberStatusRecored['creditAmount']/($memberRecored['salary'] * 0.25))*100)); ?>%;" title="remainig credit">
					<span class="progress-label">Remaining Credit </span>(<?php echo((($memberStatusRecored['creditAmount']/($memberRecored['salary'] * 0.25))*100)); ?>%)
				</div>
			</div>
		</div>
		<!-- // Credit * 0.25) -->
		<!--  Debit -->
		<div class="progress progress-striped progress-bar-success active" style="cursor: help" title="My Salary">
			<div class="progress-bar progress-bar-info" role="progressbar" style=" cursor: help; width: <?php echo(((($memberRecored['salary'] * 0.25)*0.25)/$memberRecored['salary'])*100); ?>%;" title="Debit: 1/16 of the salary"><span class="progress-label">Allowed Debit </span>(<?php echo((($memberRecored['salary'] * 0.25)/$memberRecored['salary'])*100); ?>%)</div>
		</div>
		<div class="progress progress-bar-success active"style="cursor: help" title="My Salary">
			<div class="progress-bar progress-bar-inverse progress-striped active" style=" cursor: help; width: <?php echo(((($memberRecored['salary'] * 0.25)*0.25)/$memberRecored['salary'])*100); ?>%;" title="Used debit">
				<div class="progress progress-bar progress-bar-info " role="progressbar" style=" cursor: help; width: <?php echo((($memberStatusRecored['debitAmount']/(($memberRecored['salary'] * 0.25)*0.25))*100)); ?>%;" title="This is the remaining debit u haven't used yet.">
					<span class="progress-label">Used Credit </span>(<?php echo((($memberStatusRecored['debitAmount']/(($memberRecored['salary'] * 0.25)*0.25))*100)); ?>%)
				</div>
			</div>
		</div>
		<!-- // Debit * 0.25) -->
	</div>
	<div class="agile-trains-list w3layouts-content" style="padding: 0px;">
		<div class="container" style="padding: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered agileinfo">
					<thead>
						<tr>
							<th>no.</th>
							<th>Service</th>
							<th>Phone No</th>
							<th>Card No</th>
							<th>Amount</th>
							<th>From</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ( $memberCardRecoredNo > 0 ) {
							$no = 1;
							while ( $ercord = mysqli_fetch_array( $memberCardRecored ) ) {
								?>
						<tr>
							<td class="t-one">
								<?php echo($no); ?>
							</td>
							<td class="seat"><i class="fa fa-phone-o"></i>
								<?php echo("Mobile Card"); ?> </td>
							<td class="seat">
								<?php echo("+251".$ercord['phone']); ?> </td>
							<td class="seat">
								<?php echo($ercord['card']); ?> </td>
							<td class="seat">
								<?php echo($ercord['amount']); ?> </td>
							<td class="seat">
								<?php echo($ercord['fromAccount']); ?>
							</td>
							<td class="seat">
								<?php echo($ercord['date']); ?>
							</td>
						</tr>
						<?php
						$no++;
						}
						} else {
							?>
						<tr>
							<td colspan=6 class="price us"> no service used yet ..
								<a href="services.php" class="seat-button two">Go To Services</a>
							</td>
						</tr>
						<?php
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- \\contains -->
	<!-- subscribe -->
	<div class="w3-subscribe agileits-w3layouts">
		<div class="container">
			<div class="col-md-6 social-icons w3-agile-icons">
				<h4>Join Us</h4>
				<ul>
					<li><a href="#" class="fa fa-facebook sicon facebook"> </a>
					</li>
					<li><a href="#" class="fa fa-twitter sicon twitter"> </a>
					</li>
					<li><a href="#" class="fa fa-google-plus sicon googleplus"> </a>
					</li>
					<li><a href="#" class="fa fa-dribbble sicon dribbble"> </a>
					</li>
					<li><a href="#" class="fa fa-rss sicon rss"> </a>
					</li>
				</ul>
			</div>
			<div class="col-md-6 w3-agile-subscribe-right">
				<h3 class="w3ls-title">Subscribe to Our <br><span>Newsletter</span></h3>
				<form action="#" method="post">
					<input type="email" name="email" placeholder="Enter your Email..." required="">
					<input type="submit" value="Subscribe">
					<div class="clearfix"> </div>
				</form>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- //subscribe -->

	<!--footer-->
	<footer>
		<div class="container-fluid">
			<div class="w3-agile-footer-top-at">
				<div class="col-md-2 agileits-amet-sed">
					<h4>efoita</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="commingSoon.html">About Us</a>
						</li>
						<li><a href="commingSoon.html">Support</a>
						</li>

						<li><a href="commingSoon.html">Terms & Conditions</a>
						</li>
						<li><a href="commingSoon.html">FAQ</a>
						</li>
						<li><a href="commingSoon.html" class="scroll">Mobile</a>
						</li>
						<li><a href="commingSoon.html">Feedback</a>
						</li>
						<li><a href="commingSoon.html">Contact</a>
						</li>
					</ul>
				</div>
				<div class="col-md-3 agileits-amet-sed ">
					<h4>Mobile Recharges</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="#" class="scroll">Ethio Telecom</a>
						</li>
						<li><a href="#" class="scroll">Charge Mobile Cards</a>
						</li>
						<li><a href="#" class="scroll">Charge For Other</a>
						</li>
					</ul>
				</div>
				<div class="col-md-3 agileits-amet-sed ">
					<h4>DSTV Charges</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="#" class="scroll">Monthly Charges</a>
						</li>
						<li><a href="#" class="scroll">Yearly Charges</a>
						</li>
						<li><a href="#" class="scroll">Different Charges</a>
						</li>
					</ul>
				</div>
				<div class="col-md-2 agileits-amet-sed">
					<h4>School Payments</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="#" class="scroll"> Ethio-parents School</a>
						</li>
						<li><a href="#" class="scroll"> Addis Ababa University</a>
						</li>
						<li><a href="#" class="scroll"> School Of Tomorrow</a>
						</li>
						<li><a href="#" class="scroll"> Adama University</a>
						</li>
						<li><a href="#" class="scroll"> Unity University</a>
						</li>
					</ul>
				</div>
				<div class="col-md-2 agileits-amet-sed ">
					<h4>Payment Options</h4>
					<ul class="w3ls-nav-bottom">
						<li>Credit</li>
						<li>Debit</li>
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<div class="w3l-footer-bottom">
			<div class="container-fluid">
				<div class="col-md-4 w3-footer-logo">
					<h2><a href="index.php">efoita</a></h2>
				</div>
				<div class="col-md-8 agileits-footer-class">
					<p>© 2017 efoita. All Rights Reserved | Design by <a href="commingSoon.html" >ETech</a> </p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</footer>
	<!--//footer-->

	<!-- for bootstrap working -->
	<script src="js/bootstrap.js"></script>

	<!-- easy-responsive-tabs -->
	<link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css "/>
	<script src="js/easyResponsiveTabs.js"></script>
	<!-- //easy-responsive-tabs -->
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$( document ).ready( function () {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/

			$().UItoTop( {
				easingType: 'easeOutQuart'
			} );

		} );
	</script>
	<!-- start-smoth-scrolling -->
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready( function ( $ ) {
			$( ".scroll" ).click( function ( event ) {
				event.preventDefault();
				$( 'html,body' ).animate( {
					scrollTop: $( this.hash ).offset().top
				}, 1000 );
			} );
		} );
	</script>
	<!-- start-smoth-scrolling -->
	<!-- //here ends scrolling icon -->
</body>
<!-- //body -->

</html>
<!-- //html -->