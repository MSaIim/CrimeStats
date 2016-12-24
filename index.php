<!DOCTYPE html>
<html>
	<head>
		<title>CS336 - Crime Stats</title>

		<meta charset="utf-8"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<link rel="icon" type="image/png" href="assets/images/favicon.png">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<!-- FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Francois+One|Roboto|Open+Sans|Bungee" rel="stylesheet">
	</head>

<body data-target=".navbar-collapse">

	<!-- HEADER -->
	<header class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a href="index.php">
					<img src="assets/images/favicon.png" width="40" height="40" /> 
					<span class="title">Crime Statistics</span>
				</a>

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<nav class="navbar-collapse collapse" id="menu">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="index.php">Search Tables</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- FORMS -->
	<section class="container" id="db-form">
		<form class="form-horizontal" action="results.php" method="POST">
			<div class="row">
				<span class="info">Select any items you wish to know more about. You will only get results for the columns you fill out.
				<br /><u>Note:</u> Not all fields are required in a column unless otherwise mentioned.</span>
			</div>
		 
			<div class="row" id="db-form-sections">
				<!-- ARRESTS BY RACE FORM -->
				<div class="col-md-4" id="arrests-by-race">
					<div class="form-group">
						<span class="db-title"><img src="assets/images/arrests.png" width="30" height="30" />&nbsp;&nbsp;Arrests By Race</span>
						<span class="subtext">Check the number of offenses for each race and see how they compare to one another.</span>

						<br />
						<label for="arrests-offense">Offense:&nbsp;</label>
						<select class="form-control" name="arrests-offense">
							<option value=""></option>
							<option value="Murder and nonnegligent manslaughter">Murder</option>
							<option value="Rape3">Rape</option>
							<option value="Robbery">Robbery</option>
							<option value="Aggravated assault">Aggravated Assault</option>
							<option value="Burglary">Burglary</option>
							<option value="Larceny-theft">Larceny</option>
							<option value="Motor vehicle theft">Motor Vehicle Theft</option>
							<option value="Arson">Arson</option>
							<option value="Violent crime4">Violent Crime</option>
							<option value="Property crime4">Property Crime</option>
							<option value="Other assaults">Other Assults</option>
							<option value="Forgery and counterfeiting">Forgery</option>
							<option value="Fraud">Fraud</option>
							<option value="Embezzlement">Embezzlement</option>
							<option value="Stolen property; buying, receiving, possessing">Stolen Property</option>
							<option value="Vandalism">Vandalism</option>
							<option value="Weapons; carrying, possessing, etc.">Weapons</option>
							<option value="Prostitution and commercialized vice">Prostitution</option>
							<option value="Sex offenses (except rape and prostitution)">Sex Offenses</option> 
							<option value="Drug abuse violations">Drug Abuse</option>
							<option value="Gambling">Gambling</option>
							<option value="Offenses against the family and children">Offense Against Family</option>
							<option value="Driving under the influence">Driving Under Influence</option>
							<option value="Liquor laws">Liquor Laws</option>
							<option value="Drunkenness">Drunkenness</option>
							<option value="Disorderly conduct">Disorderly Conduct</option>
							<option value="Vagrancy">Vagrancy</option>
							<option value="Suspicion">Suspicion</option>
							<option value="Curfew and loitering law violations">Curfew and Loitering</option>
							<option value="All other offenses (except traffic)">All Other Offenses</option>
						</select>

						<br />
						<label for="arrests-race">Race:&nbsp;</label>
						<select class="form-control" name="arrests-race">
							<option value=""></option>
							<option value="White">White</option>
							<option value="Black">Black</option>
							<option value="Native">Native American</option>
							<option value="Asian">Asian</option>
							<option value="Pacific">Pacific Islander</option>
						</select>

						<hr />
						<span class="subtext">Compare with other race(s):</span> * A race must be selected above to compare. <br /><br />
						<label><input type="checkbox" name="arrests-compare-white" value="White">&nbsp;White</label><br />
						<label><input type="checkbox" name="arrests-compare-black" value="Black">&nbsp;Black</label><br />
						<label><input type="checkbox" name="arrests-compare-native" value="Native">&nbsp;Native American</label><br />
						<label><input type="checkbox" name="arrests-compare-asian" value="Asian">&nbsp;Asian</label><br />
						<label><input type="checkbox" name="arrests-compare-pacific" value="Pacific">&nbsp;Pacific Islander</label><br />
					</div>
				</div>

				<!-- PERSONS KILLED FORM -->
				<div class="col-md-4" id="people-killed">
					<div class="form-group">
						<span class="db-title"><img src="assets/images/killed.png" width="30" height="30" />&nbsp;&nbsp;People Killed</span>
						<span class="subtext">The people killed by police officers. Has the officer's agency and info about the victim.</span>

						<br />
						<label for="killed-states">State:&nbsp;</label>
						<select class="form-control" name="killed-state">
							<option value=""></option>
							<option value="All">All States</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option> 
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
						</select>

						<br />
						<div class="row">
							<div class="col-md-2"><label for="killed-race">Race:&nbsp;</label></div>
							<div class="col-md-10 text-right"><label><input type="checkbox" name="killed-race-count" value="CompareRace">&nbsp;Get Killed Count By Race</label></div>
						</div>
						<select class="form-control" name="killed-race">
							<option value=""></option>
							<option value="All">All Races</option>
							<option value="White">White</option>
							<option value="Black">Black</option>
							<option value="Native American">Native American</option>
							<option value="Asian/Pacific Islander">Asian/Pacific Islander</option>
						</select>

						<br />
						<label for="killed-gender">Gender:&nbsp;&nbsp;&nbsp;</label>
						<label><input type="radio" name="killed-gender" value="Any" checked="checked">&nbsp;Any&nbsp;&nbsp;</label>
						<label><input type="radio" name="killed-gender" value="Male">&nbsp;Male&nbsp;&nbsp;</label>
						<label><input type="radio" name="killed-gender" value="Female">&nbsp;Female</label>

						<br /><br />
						<div class="row">
							<div class="col-md-2"><label for="killed-month">Month:&nbsp;</label></div>
							<div class="col-md-10 text-right"><label><input type="checkbox" name="killed-month-count" value="MonthCount">&nbsp;Get Killed Count By Month</label></div>
						</div>
						<select class="form-control" name="killed-month">
							<option value=""></option>
							<option value="All">All Months</option>
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May</option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>

						<br />
						<label for="killed-classification">Classification:&nbsp;</label>
						<select class="form-control" name="killed-classification">
							<option value=""></option>
							<option value="Death in custody">Death In Custody</option>
							<option value="Gunshot">Gunshot</option>
							<option value="Struck by vehicle">Struck By Vehicle</option>
							<option value="Taser">Taser</option>
							<option value="Other">Other</option>
						</select>

						<br />
						<label for="killed-armed">Armed:&nbsp;</label>
						<select class="form-control" name="killed-armed">
							<option value=""></option>
							<option value="No">Not Armed</option>
							<option value="Firearm">Firearm</option>
							<option value="Non-lethal firearm">Non-Lethal Firearm</option>
							<option value="Vehicle">Vehicle</option>
							<option value="Knife">Knife</option>
							<option value="Unknown">Unknown</option>
							<option value="Disputed">Disputed</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>

				<!-- RACE POPULATION FORM -->
				<div class="col-md-4" id="race-population">
					<div class="form-group">
						<span class="db-title"><img src="assets/images/population.png" width="30" height="30" />&nbsp;&nbsp;Race Population</span>
						<span class="subtext">Population of each state by race. Able to compare the percentage of the population.</span>

						<br />
						<label for="population-states">State:</label>
						<select class="form-control" name="population-states">
							<option value=""></option>
							<option value="All">All States</option>
							<option value="United States">United States</option>
							<option value="Alabama">Alabama</option>
							<option value="Alaska">Alaska</option>
							<option value="Arizona">Arizona</option>
							<option value="Arkansas">Arkansas</option>
							<option value="California">California</option>
							<option value="Colorado">Colorado</option>
							<option value="Connecticut">Connecticut</option>
							<option value="Delaware">Delaware</option>
							<option value="District of Columbia">District of Columbia</option>
							<option value="Florida">Florida</option>
							<option value="Georgia">Georgia</option>
							<option value="Hawaii">Hawaii</option>
							<option value="Idaho">Idaho</option>
							<option value="Illinois">Illinois</option>
							<option value="Indiana">Indiana</option>
							<option value="Iowa">Iowa</option>
							<option value="Kansas">Kansas</option>
							<option value="Kentucky">Kentucky</option>
							<option value="Louisiana">Louisiana</option> 
							<option value="Maine">Maine</option>
							<option value="Maryland">Maryland</option>
							<option value="Massachusetts">Massachusetts</option>
							<option value="Michigan">Michigan</option>
							<option value="Minnesota">Minnesota</option>
							<option value="Mississippi">Mississippi</option>
							<option value="Missouri">Missouri</option>
							<option value="Montana">Montana</option>
							<option value="Nebraska">Nebraska</option>
							<option value="Nevada">Nevada</option>
							<option value="New Hampshire">New Hampshire</option>
							<option value="New Jersey">New Jersey</option>
							<option value="New Mexico">New Mexico</option>
							<option value="New York">New York</option>
							<option value="North Carolina">North Carolina</option>
							<option value="North Dakota">North Dakota</option>
							<option value="Ohio">Ohio</option>
							<option value="Oklahoma">Oklahoma</option>
							<option value="Pennsylvania">Pennsylvania</option>
							<option value=">Rhode Island">Rhode Island</option>
							<option value="South Carolina">South Carolina</option>
							<option value="South Dakota">South Dakota</option>
							<option value="Tennessee">Tennessee</option>
							<option value="Texas">Texas</option>
							<option value="Utah">Utah</option>
							<option value="Vermont">Vermont</option>
							<option value="Virginia">Virginia</option>
							<option value="Washington">Washington</option>
							<option value="West Virginia">West Virginia</option>
							<option value="Wisconsin">Wisconsin</option>
						</select>

						<br />
						<label for="population-race">Race:</label>
						<select class="form-control" name="population-race">
							<option value=""></option>
							<option value="All">All Races</option>
							<option value="White">White</option>
							<option value="Black">Black</option>
							<option value="Native">Native American</option>
							<option value="Asian">Asian</option>
							<option value="Pacific">Pacific Islander</option>
						</select>

						<hr />
						<label for="population-compare-states">Compare State:&nbsp;</label> * State must be selected above. 
						<select class="form-control" name="population-compare-states">
							<option value=""></option>
							<option value="United States">United States</option>
							<option value="Alabama">Alabama</option>
							<option value="Alaska">Alaska</option>
							<option value="Arizona">Arizona</option>
							<option value="Arkansas">Arkansas</option>
							<option value="California">California</option>
							<option value="Colorado">Colorado</option>
							<option value="Connecticut">Connecticut</option>
							<option value="Delaware">Delaware</option>
							<option value="District of Columbia">District of Columbia</option>
							<option value="Florida">Florida</option>
							<option value="Georgia">Georgia</option>
							<option value="Hawaii">Hawaii</option>
							<option value="Idaho">Idaho</option>
							<option value="Illinois">Illinois</option>
							<option value="Indiana">Indiana</option>
							<option value="Iowa">Iowa</option>
							<option value="Kansas">Kansas</option>
							<option value="Kentucky">Kentucky</option>
							<option value="Louisiana">Louisiana</option> 
							<option value="Maine">Maine</option>
							<option value="Maryland">Maryland</option>
							<option value="Massachusetts">Massachusetts</option>
							<option value="Michigan">Michigan</option>
							<option value="Minnesota">Minnesota</option>
							<option value="Mississippi">Mississippi</option>
							<option value="Missouri">Missouri</option>
							<option value="Montana">Montana</option>
							<option value="Nebraska">Nebraska</option>
							<option value="Nevada">Nevada</option>
							<option value="New Hampshire">New Hampshire</option>
							<option value="New Jersey">New Jersey</option>
							<option value="New Mexico">New Mexico</option>
							<option value="New York">New York</option>
							<option value="North Carolina">North Carolina</option>
							<option value="North Dakota">North Dakota</option>
							<option value="Ohio">Ohio</option>
							<option value="Oklahoma">Oklahoma</option>
							<option value="Pennsylvania">Pennsylvania</option>
							<option value=">Rhode Island">Rhode Island</option>
							<option value="South Carolina">South Carolina</option>
							<option value="South Dakota">South Dakota</option>
							<option value="Tennessee">Tennessee</option>
							<option value="Texas">Texas</option>
							<option value="Utah">Utah</option>
							<option value="Vermont">Vermont</option>
							<option value="Virginia">Virginia</option>
							<option value="Washington">Washington</option>
							<option value="West Virginia">West Virginia</option>
							<option value="Wisconsin">Wisconsin</option>
						</select>

						<br /><br />
						<span class="subtext">Other Options:</span>
						* A single race must be selected to see percentages.<br /><br />
						<label><input type="checkbox" name="population-percentage" value="White">&nbsp;Show Results As Percentages</label><br />
					</div>
				</div>
			</div>

			<!-- FORM SUBMIT -->
			<div class="row" id="db-form-submit">
				<div class="col-md-9" id="db-form-submit-info">
						<img src="assets/images/team.png" width="30" height="30" /> CS336 - Michael Reid, Stephen Eisen, Mohammad Salim
				</div>
				<div class="col-md-3" id="db-form-submit-btns">
					<button type="submit" class="btn btn-primary" name="submit">Submit</button>
					<button type="reset" class="btn btn-primary">Clear</button>
				</div>
			</div>
		</form>
	</section>

	<!-- FOOTER -->
	<footer></footer>

	<!-- JAVASCRIPT -->
	<script type="text/javascript">
		document.getElementsByName('killed-month-count')[0].onclick = function() {
			document.getElementsByName('killed-race-count')[0].checked = false;
		}
		document.getElementsByName('killed-race-count')[0].onclick = function() {
			document.getElementsByName('killed-month-count')[0].checked = false;
		}
	</script>

</body>
</html>