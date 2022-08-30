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
	if ( $_POST[ 'cargeType' ] == "me" )$phone = $_POST[ 'myPhone' ];
	else $phone = $_POST[ 'otherPhone' ];

	$warning = "secret confirm error";
	$warningMessage = " Please confirm the secdret Number for the transaction<br><b>Phone No. : $phone <br>Amount : $amount</b>";
	$creditNumberConfirm = true;
}
if ( isset( $_POST[ 'confirmSecret' ] ) ) {
	$retryNo = $_POST[ 'retryNo' ] - 1;
	$secretNo = $_POST[ 'secretNo' ];
	$phone = $_POST[ 'confirmPhone' ];
	$amount = $_POST[ 'confirmAmount' ];

	if ( $secretNo == $memberRecored[ 'creditNumber' ] ) {

		$sql = "SELECT * FROM `card_store` WHERE `amount`=" . $amount . ";";
		$cardStorRecored = mysqli_query( $con, $sql );
		if ( mysqli_num_rows( $cardStorRecored ) == 0 ) {

			$error = 'fetch Error';
			$errorMessage = " Sorry We are out of $amount Bir cards";

		} else {
			$cardStorRecored = mysqli_fetch_assoc( $cardStorRecored );
			//print_r($cardStorRecored);

			$sql = "SELECT * FROM `status` WHERE `employeeID`='" . $_SESSION[ 'employeeID' ] . "';";
			if ( !$memberStatusRecored = mysqli_query( $con, $sql ) ) {
				$error = 'fetch Error';
				$errorMessage = " can't fetch status record";
			} else {
				$memberStatusRecored = mysqli_fetch_assoc( $memberStatusRecored );

				$flag = false;
				if ( $memberStatusRecored[ 'debitAmount' ] > $amount ) {
					$from = "Deposit";

					$deposit = $memberStatusRecored[ 'debitAmount' ] - $amount;
					$credit = $memberStatusRecored[ 'creditAmount' ];
					$flag = true;
				} elseif ( $memberStatusRecored[ 'creditAmount' ] > $amount ) {
					$from = "Credit";
					$deposit = $memberStatusRecored[ 'debitAmount' ];
					$credit = $memberStatusRecored[ 'creditAmount' ] - $amount;
					$flag = true;
				}
				else {
					$flag = false;
					$error = " Credit/Debit Error";
					$errorMessage = " No Credit or Debit. Please Contact efoita in Person.";
				}

				if ( $flag ) {
					$sql = "INSERT INTO `used_card`(`employeeID`, `amount`, `card`, `fromAccount`, `phone`) VALUES ('" . $_SESSION[ 'employeeID' ] . "',$amount," . $cardStorRecored[ 'voucher' ] . ",'$from',$phone)";
					if ( !mysqli_query( $con, $sql ) ) {
						$error = 'fetch Error';
						$errorMessage = "  can't insert the card into used record";
					} else {
						$sql = "UPDATE `status` SET `debitAmount` = $deposit, `creditAmount` = $credit WHERE `employeeID`='" . $_SESSION[ 'employeeID' ] . "'";
						if ( !mysqli_query( $con, $sql ) ) {
							$error = 'fetch Error';
							$errorMessage = "  can't updating status Debit/Credit";
						} else {
							$sql = "DELETE FROM `card_store` WHERE `id` = " . $cardStorRecored[ 'id' ];
							if ( !mysqli_query( $con, $sql ) ) {
								$error = 'fetch Error';
								$errorMessage = "  can't Delete Card form Store";
							} else {
								$star = '*';
								$hash = '%23';
								$success = " Secret No. confirmation success";
								$successMessage = " $amount Bir charged to $phone <br> Voucher No : " . $cardStorRecored[ 'voucher' ] . "<br><li class='visible-xs'><center><a href='tel:$star 805 $star ".$cardStorRecored['voucher']." $hash' ><img src='images/chargeMe.png' /></a></center></li>";
							}
						}
					}
				}
			}
		}

	} else {
		if ( $retryNo == 2 ) {
			$warning = "confirm secret number warning";
			$warningMessage = "Please enter the secret No carefully <br><center><b> ( " . ( $retryNo ) . " retry left ) </b></center> ";
			$creditNumberConfirm = true;
		} else if ( $retryNo == 1 ) {
			$warning = "confirm secret number warning";
			$warningMessage = "Please enter the secret number carefully<br><center><b> ( " . ( $retryNo ) . " retry left ) </b></center> ";
			$error = "confirm secret number error";
			$errorMessage = "Please enter the secret number carefully last retry <b> session will close </b>";
			$creditNumberConfirm = true;
		} else {
			header( "Location: assets/php/logout.php" );
		}
	}
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
					<a href="home.php" class="myLink"><i class="glyphicon glyphicon-stats home_1"></i> Status</a>&nbsp;&nbsp;
					<a href="services.php" class="myLink active"><i class="fa fa-cogs home_1" ></i> Services</a>
				</div>
			</b>

		</div>

	</div>
	<!-- //menu -->
	<!-- contains -->

	<!--Vertical Tab-->
	<div class="categories-section main-grid-border" id="mobilew3layouts" style="padding-top: 45px;">
		<div class="container">
			<div class="category-list">
				<div id="parentVerticalTab">
					<div class="agileits-tab_nav">
						<ul class="resp-tabs-list hor_1">
							<li><i class="icon fa fa-mobile" aria-hidden="true"></i>Mobile Card</li>
							<li><i class="icon glyphicon glyphicon-education" aria-hidden="true"></i>Education</li>
							<li><i class="icon glyphicon glyphicon-usd" aria-hidden="true"></i>Ekub Online</li>
							<li><i class="icon fa fa-bus" aria-hidden="true"></i>Transport</li>
							<li><i class="icon fa fa-lightbulb-o" aria-hidden="true"></i>Electricity</li>
							<li><i class="icon fa fa-tint" aria-hidden="true"></i>Water</li>
							<li><i class="icon fa fa-television" aria-hidden="true"></i>DSTV</li>
							<li><i class="icon glyphicon glyphicon-film" aria-hidden="true"></i>Cinema Ticket</li>
							<li><i class="icon glyphicon glyphicon-shopping-cart" aria-hidden="true"></i>Shopping</li>
						</ul>
					</div>
					<div class="resp-tabs-container hor_1">
						<!-- tab1 phone Charge glyphicon glyphicon-usd fa fa-connectdevelop -->
						<div>
							<div class="tabs-box">
								<div class="row">
									<img src="images/mobile.png" class="w3ls-mobile" alt="" data-pin-nopin="true" style="float: left;">
									<!-- messages -->
									<div style="float: left; width: auto; ">
										<?php
										if ( ( $info != '' ) || ( $warning != '' ) || ( $success != '' ) || ( $error != '' ) ) {
											if ( $success ) {
												?>
										<div class="alert alert-success alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button><i class="glyphicon glyphicon-check"></i> Success!
											<?php echo($successMessage); ?>.
										</div>
										<?php
										}
										?>
										<?php
										if ( $info != '' ) {
											?>

										<div class="alert alert-info alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button><i class="glyphicon glyphicon-info-sign"></i> Info!
											<?php echo($infoMessage); ?>.
										</div>
										<?php
										}
										?>
										<?php
										if ( $warning != '' ) {
											?>
										<style type="text/css">
											.full-width-div {
												left: 0;
												z-index: 1000;
												display: table-cell;
												vertical-align: middle;
												display: table;
											}
										</style>

										<div class="alert alert-warning alert-dismissable ">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button><i class="glyphicon glyphicon-warning-sign"></i> Warning !
											<?php echo($warningMessage); ?>.
										</div>

										<?php
										}
										?>
										<?php
										if ( $error != '' ) {
											?>
										<div class="alert alert-danger alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button><i class="glyphicon glyphicon-ban-circle"></i> Error !
											<?php echo($errorMessage); ?>.
										</div>
										<?php
										}
										}
										?>
									</div>
									<!--\\ messages -->
								</div>

								<div class="login-form">
									<?php
									if ( !$creditNumberConfirm ) {

										echo( '<div style="display: none;">' );

									} else {
										?>
									<div style="display: block;">
										<?php
										}
										?>
										<form action="" method="post" id="signup">
											<input name="retryNo" type="hidden" value="<?php echo($retryNo); ?>"/>
											<input name="confirmAmount" type="hidden" value="<?php echo($amount); ?>"/>
											<input name="confirmPhone" type="hidden" value="<?php echo($phone); ?>"/>
											<ol>
												<li>
													<h4>Enter your secret number</h4>
													<input type="password" id="tel" name="secretNo" pattern="\d{4}" placeholder="Enter Secret" required/>
													<p class="validation01">
														<span class="invalid">Please enter a valid 4 digit secret number</span>



														<span class="valid">That's what we wanted!</span>
													</p>
												</li>
												<li>
													<input name="confirmSecret" type="submit" class="submit" value="Confirm"/>
													<input type="button" class="submit" value="Cancel" style="background-color: red;" onclick="location.replace('services.php');"/>
												</li>
												<!-- location.reload(); -->

											</ol>
										</form>
									</div>
									<?php
									if ( $creditNumberConfirm ) {
										echo( '<div style="display: none;">' );

									} else {
										?>
									<div style="display: block;">
										<?php
										}
										?>
										<form action="" method="post" id="signup">
											<ol>
												<li>
													<ul class="tabs-menu">
														<li>
															<label id="labelMe" class="radio" style="color: black;">
																<input name="cargeType" type="radio" value="me" onclick="toglePhone(this);" checked="checked" />
																<i></i>For Me
															</label>
														</li>
														<li>
															<label id="labelOther" class="radio" style="color: !important;">
																<input name="cargeType" type="radio" value="other" onclick="toglePhone(this);" />
																<i></i>For Other
															</label>
														</li>
													</ul>
												</li>
												<li id="otherPhoneList" style=" display: none;">
													<h4>Other mobile number</h4>
													<input type="tel" id="tel" name="otherPhone" pattern="\d{10}" placeholder="Phone number ..."/>
													<p class="validation01">
														<span class="invalid">Please enter a valid phone number</span>
														<span class="valid">That's what we wanted!</span>
													</p>
												</li>
												<li id="myPhone" style="display: block;">
													<h4>Your mobile number</h4>
													<input name="myPhone" id="customer" type="tel" value="0913209238" readonly/>
												</li>
												<li>
													<div class="agileits-select">
														<select name="amount" class="selectpicker show-tick" data-live-search="true" required>
															<option value="">Select Amount</option>
															<option data-tokens="5" value="5">5 Bir</option>
															<option data-tokens="10" value="10">10 Bir</option>
															<option data-tokens="15" value="15">15 Bir</option>
															<option data-tokens="20" value="20">20 Bir</option>
															<option data-tokens="25" value="25">25 Bir</option>
															<option data-tokens="50" value="50">50 Bir</option>
															<option data-tokens="100" value="100">100 Bir</option>
														</select>
													</div>
												</li>
												<script>
													function toglePhone( obj ) {

														if ( obj.value == "me" ) {
															document.getElementById( 'labelMe' ).setAttribute( 'style', 'color: black;' );
															document.getElementById( 'labelOther' ).setAttribute( 'style', 'color: !important;' );
															document.getElementById( 'myPhone' ).setAttribute( 'style', 'display: block;' );
															document.getElementById( 'otherPhoneList' ).setAttribute( 'style', 'display: none;' );
															document.getElementsByName( "otherPhone" )[ 0 ].removeAttribute( 'required' );

														} else if ( obj.value == "other" ) {
															document.getElementById( 'labelOther' ).setAttribute( 'style', 'color: black;' );
															document.getElementById( 'labelMe' ).setAttribute( 'style', 'color: !important;' );
															document.getElementById( 'myPhone' ).setAttribute( 'style', 'display: none;' );
															document.getElementById( 'otherPhoneList' ).setAttribute( 'style', 'display: block;' );
															document.getElementsByName( "otherPhone" )[ 0 ].setAttribute( 'required', true );
														}
													}
												</script>
												<li>
													<input name="cardCharge" type="submit" class="submit" value="Recharge Now"/>
												</li>
											</ol>
										</form>
									</div>

								</div>
								<div class="clearfix"> </div>
							</div>
							<!-- script -->
							<script>
								$( document ).ready( function () {
									$( "#tab2" ).hide();
									$( "#tab3" ).hide();
									$( "#tab4" ).hide();
									$( ".tabs-menu a" ).click( function ( event ) {
										event.preventDefault();
										var tab = $( this ).attr( "href" );
										$( ".tab-grid" ).not( tab ).css( "display", "none" );
										$( tab ).fadeIn( "slow" );
									} );
								} );
							</script>

						</div>
						<!-- /tab1 -->

						<!-- tab3 education -->
						<div>

							<div class="login-form">
								<i class="icon glyphicon glyphicon-education inner-icon" aria-hidden="true"></i>
								<form action="commingSoon.html" method="post" id="signup">

									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Select Schols">Select Shools</option>
													<option data-tokens="A.A University">A.A University</option>
													<option data-tokens="School Of Tomorow">School Of Tomorow</option>
													<option data-tokens="School Of Tomorow">Unity University</option>
												</select>
											</div>
										</li>
										<li>
											<input type="text" id="customer" value="Enter Customer ID" onfocus="this.value = '';" onblur="if (this.value === '') {this.value = 'Enter Customer ID';}" required="">
										</li>
										<li>
											<input type="submit" class="submit" value="Pay Now"/>
										</li>
									</ol>
								</form>

							</div>
						</div>
						<!-- tab3 education -->
						
						<!-- tab7 ekub-->
						<div>
							<i class="icon glyphicon glyphicon-usd inner-icon" aria-hidden="true"></i>

							<div class="login-form">
								<form action="commingSoon.html" method="post" id="signup">
									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Water Provider">Select Ekub Amount</option>
													<option data-tokens="Provider1">100 bir </option>
													<option data-tokens="Provider1">200 bir </option>
													<option data-tokens="Provider1">500 bir </option>
													<option data-tokens="Provider1">1000 bir </option>
													<option data-tokens="Provider1">1500 bir </option>
												</select>
											</div>
										</li>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Water Provider">Select Ekub Period</option>
													<option data-tokens="Provider1">Daily Ekub</option>
													<option data-tokens="Provider1">Weekly Ekub</option>
													<option data-tokens="Provider1">Monthly Ekub</option>
												</select>
											</div>
										</li>
										<li>
											<div class="agileits-select">
												<label class="checkbox-inline">
													<input type="checkbox" />
														Take First Ekub
												</label>
											</div>
										</li>
										<li>
											<input type="submit" class="submit" value="Pay Now"/>
										</li>
									</ol>
								</form>

							</div>

						</div>
						<!-- /tab7 Ekub-->

						<!-- tab4 transport -->
						<div>
							<i class="icon fa fa-bus inner-icon " aria-hidden="true"></i>

							<div class="login-form">
								<form action="commingSoon.html" method="post" id="signup">
									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Select Operator">Select Buss</option>
													<option data-tokens="Operator1">Sky Buss</option>
													<option data-tokens="Operator2">Golden Buss</option>
													<option data-tokens="Operator3">Selam Buss</option>
												</select>
											</div>
										</li>
										<li>
											<input type="text" id="customer" value="Enter Buss Number" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter Metro Number';}" required="">
										</li>
										<li>
											<div class="mobile-right ">
												<h4>How Much To Pay?</h4>
												<div class="mobile-rchge">
													<input type="text" placeholder="Enter amount" name="amount" required="required"/>
												</div>
												<div class="clearfix"></div>
											</div>
										</li>
										<li>
											<input type="submit" class="submit" value="Pay Now"/>
										</li>
									</ol>
								</form>

							</div>

						</div>
						<!-- tab4 transport -->

						<!-- tab5 electricity-->
						<div>
							<i class="icon fa fa-lightbulb-o inner-icon" aria-hidden="true"></i>

							<div class="login-form">
								<form action="commingSoon.html" method="post" id="signup">
									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Water Provider">Electic Provider</option>
													<option data-tokens="Provider1">Ethiopian Electiv Utility</option>
												</select>
											</div>
										</li>
										<li>
											<input type="text" id="customer" value="Consumer Number" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Consumer Number';}" required="">
										</li>

										<li>
											<input type="submit" class="submit" value="Proceed"/>
										</li>
									</ol>
								</form>

							</div>

						</div>
						<!-- /tab5 electricity-->

						<!-- tab6 water-->
						<div>
							<i class="icon fa fa-tint inner-icon" aria-hidden="true"></i>

							<div class="login-form">
								<form action="commingSoon.html" method="post" id="signup">
									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Water Provider">Water Provider</option>
													<option data-tokens="Provider1">Ethiopian Water</option>
												</select>
											</div>
										</li>
										<li>
											<input type="text" id="customer" value="Consumer Number" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Consumer Number';}" required="">
										</li>

										<li>
											<input type="submit" class="submit" value="Proceed"/>
										</li>
									</ol>
								</form>

							</div>

						</div>
						<!-- /tab6 water-->
						<!-- tab7 DSTV phone Charge-->
						<div>

							<div class="login-form">
								<i class="icon fa fa-television inner-icon" aria-hidden="true"></i>
								<form action="commingSoon.html" method="post" id="signup">

									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Select Operator">DSTV Packages</option>
													<option data-tokens="Aircel">Monthly</option>
													<option data-tokens="Airtel">Annual</option>
											</div>
										</li>
										<li>
											<input type="text" id="customer" value="Enter Customer ID" onfocus="this.value = '';" onblur="if (this.value === '') {this.value = 'Enter Customer ID';}" required="">
										</li>
										<li>
											<div class="mobile-right ">
												<div class="mobile-rchge">
													<input type="text" placeholder="Enter amount" name="amount" required="required"/>
												</div>
												<div class="clearfix"></div>
											</div>
										</li>
										<li>
											<input type="submit" class="submit" value="Pay Now"/>
										</li>
									</ol>
								</form>

							</div>
						</div>
						<!-- /tab7 DSTV -->
						<!-- tab2 cinema -->
						<div>

							<div class="login-form">
								<i class="icon glyphicon glyphicon-film inner-icon" aria-hidden="true"></i>
								<form action="commingSoon.html" method="post" id="signup">

									<ol>
										<li>
											<div class="agileits-select">
												<select class="selectpicker show-tick" data-live-search="true">
													<option data-tokens="Select Operator">Select Cinema </option>
													<option data-tokens="Airtel">Alem Cinema</option>
													<option data-tokens="Airtel">Abasader Cinema</option>
													<option data-tokens="Airtel">Abel Cinema</option>
													<option data-tokens="Airtel">Edna Cinema</option>
													<option data-tokens="Aircel">Sebastopol Cinema</option>
												</select>
											</div>
										</li>
										<li>
											<i class="glyphicon glyphicon-money"></i><input type="submit" class="submit" value="Pay Now"/>
										</li>
									</ol>
								</form>

							</div>
						</div>
						<!-- /tab8 cinema  	glyphicon glyphicon-shopping-cart-->
						<!-- tab9 shop -->
						<div>

							<div class="login-form">
								<i class="icon glyphicon glyphicon-shopping-cart inner-icon" aria-hidden="true"></i>
								<form action="commingSoon.html" method="post" id="signup">

									<ol>
										<li>
											<h4>Which Shoppig Center Do You Use ?</h4>
										</li>
										<li>
											<a href="https://www.jumia.com.et/" target="_blank"><i class=" 	glyphicon glyphicon-certificate"></i> Jumia Shoping Site</a>
										</li>
										<li>
											<a href="https://www.qefira.com/" target="_blank"><i class=" 	glyphicon glyphicon-certificate"></i> Qefira Shoping Site</a>
										</li>
										<li>
											<a href="http://www.sheger.net/" target="_blank"><i class=" 	glyphicon glyphicon-certificate"></i> Sheger Net Shoping Site</a>
										</li>
									</ol>
								</form>

							</div>
						</div>
						<!-- /tab2 shop  	glyphicon glyphicon-shopping-cart-->
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!--Plug-in Initialisation-->
	<script type="text/javascript">
		$( document ).ready( function () {

			//Vertical Tab
			$( '#parentVerticalTab' ).easyResponsiveTabs( {
				type: 'vertical', //Types: default, vertical, accordion
				width: 'auto', //auto or any width like 600px
				fit: true, // 100% fit in a container
				//closed: 'accordion', // Start closed if in accordion view
				tabidentify: 'hor_1', // The tab groups identifier
				activate: function ( event ) { // Callback function if tab is switched
					var $tab = $( this );
					var $info = $( '#nested-tabInfo2' );
					var $name = $( 'span', $info );
					$name.text( $tab.text() );
					$info.show();
				}
			} );
		} );
	</script>

	<!-- //contains -->
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
						<li><a href="commingSoon.html">Faq</a>
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
					<h4>DSTV Chargs</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="#" class="scroll">Monthly Chargs</a>
						</li>
						<li><a href="#" class="scroll">Yearly Charges</a>
						</li>
						<li><a href="#" class="scroll">Diffrent Charges</a>
						</li>
					</ul>
				</div>
				<div class="col-md-2 agileits-amet-sed">
					<h4>School Payments</h4>
					<ul class="w3ls-nav-bottom">
						<li><a href="#" class="scroll"> Ethio-parents Shool</a>
						</li>
						<li><a href="#" class="scroll"> Addis Ababa University</a>
						</li>
						<li><a href="#" class="scroll"> Shool Of Tomoro</a>
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
					<p>© 2017 efoita. All Rights Reserved | Design by <a href="commingSoon.html">ETech</a> </p>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</footer>
	<!--//footer-->

	<!-- for bootstrap working -->
	<script src="js/bootstrap.js"></script>

	<!-- //Responsive-slider -->
	<!-- Bootstrap select option script -->
	<script src="js/bootstrap-select.js"></script>
	<script>
		$( document ).ready( function () {
			var mySelect = $( '#first-disabled2' );

			$( '#special' ).on( 'click', function () {
				mySelect.find( 'option:selected' ).prop( 'disabled', true );
				mySelect.selectpicker( 'refresh' );
			} );

			$( '#special2' ).on( 'click', function () {
				mySelect.find( 'option:disabled' ).prop( 'disabled', false );
				mySelect.selectpicker( 'refresh' );
			} );

			$( '#basic2' ).selectpicker( {
				liveSearch: true,
				maxOptions: 1
			} );
		} );
	</script>
	<!-- //Bootstrap select option script -->

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
		function chargeMe(voicher){
			alert("tel:* 805 * "+voicher+" #");
		}
	</script>
	<!-- start-smoth-scrolling -->
	<!-- //here ends scrolling icon -->
</body>
<!-- //body -->

</html>
<!-- //html -->