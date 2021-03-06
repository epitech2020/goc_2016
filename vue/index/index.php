<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game of code 2016, team ADNEOM Be2</title>
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bower_components/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../assets/css/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js"></script>
  <script type="text/javascript" src="https://inorganik.github.io/countUp.js/dist/countUp.js"></script>
  <script>
    var lati = 0;
    var logi = 0;
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        $("#llat").val(position.coords.latitude);
        $("#flong").val(position.coords.longitude);
      });
    }
  </script>
</head>

<body data-spy="scroll" data-target="#site-nav">
  <nav id="site-nav" class="navbar navbar-fixed-top navbar-custom">
    <div class="container">
      <div class="navbar-header">
        <div class="site-branding">
          <a class="logo" href="index.php">
            Game of code 2016, team ADNEOM Be2
          </a>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbar-items">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a data-scroll href="#site-nav">Index</a></li>
          <li><a data-scroll href="#about">Our Goals</a></li>
          <li><a data-scroll href="#closestation">Find Station</a></li>
          <li><a data-scroll href="#contribution">Health</a></li>
        </ul>
      </div>
    </div>
    <!-- /.container -->
  </nav>
  <header id="site-header" class="site-header valign-center">
    <div class="intro">
      <h2><i class="ion-android-walk"></i> Walk ?  <i class="ion-android-bicycle"></i> Veloh ?  <i class="ion-android-bus"></i> Bus ?</h2>
      <h1>Find the best way to travel into Luxembourg</h1>
      <a class="btn btn-white" data-scroll href="#closestation">Test Now !</a>
    </div>
  </header>
  <section id="about" class="section about">
    <div class="container">
      <div class="row">
        <div class=".col-xs-4 .col-sm-8 .col-md-6 .col-md-offset-3">
          <h3 class="section-title multiple-title">What is Our Goals?</h3>
          <p class="text-center">Make your everyday life easier</p>
          <p class="text-center">
            <b>Find the closest and fastest way to travel.</b>
            <br>
            <b>Use your location to provide a plan to your destination.</b>
            <br>
            <b>Real time available VeloH per Station</b>
            <br>
          </p>
        </div>
        <!-- /.col-sm-6 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </section>
  <section id="facts" class="section bg-image-1 facts text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <i class="ion-android-bicycle"></i>
          <h3><div id="velo"></div><br>Veloh available</h3>
        </div>
        <div class="col-md-6">
          <i class="ion-ios-location"></i>
          <h3><div id="station"></div><br>Veloh station</h3>
        </div>
        <script>
          var easingFn = function(t, b, c, d) {
            var ts = (t /= d) * t;
            var tc = ts * t;
            return b + c * (tc * ts + -5 * ts * ts + 10 * tc + -10 * ts + 5 * t);
          }
          var options = {
            useEasing: true,
              easingFn: easingFn,
              useGrouping: true,
              separator: ',',
              decimal: '.'
          }
          var velo = new CountUp("velo", 0, <?php echo get_all_velo(); ?>, 0, 2, options);
          var station = new CountUp("station", 0, <?php echo get_total_station(); ?>, 0, 2, options);
          velo.start();
          station.start();
        </script>
      </div>
      <!-- row -->
    </div>
    <!-- container -->
  </section>

  <section id="closestation" class="section registration">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">Find the closest station</h3>
        </div>
        <br>
      </div>
      <form action="index.php#closestation" method="post">
        <div class="row">
          <div class="col-md-12" id="registration-msg">
            <div class="text-center" id="alert">Please activate your localisation or enter manualy your coordinates
            </div>
            <br>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Latitude" id="llat" name="latitude">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Longitude" id="flong" name="longitude">
            </div>
          </div>
          <!--<div class="col-sm-12">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Departure address" id="adresse" name="adresse">
            </div>
          </div>-->
          <div class="col-sm-12">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Arrival address" id="arrival" name="arrival">
            </div>
          </div>
          <div class="text-center mt20">
            <button type="submit" class="btn btn-black">Find</button>
          </div>
      </form>
      </div>
      <div class="container col-md-12">
        <br>
        <?php if (isset($_POST['longitude']) && isset($_POST['latitude']))
	  { ?>

        <script>
          var Center = new google.maps.LatLng(49.607232, 6.121065);
          var directionsDisplay;
          var directionsService = new google.maps.DirectionsService();
          var map;

          function initialize() {
            directionsDisplay = new google.maps.DirectionsRenderer();
            var properties = {
              center: Center,
              zoom: 8,
              mapTypeId: google.maps.MapTypeId.SATELLITE
            };

            map = new google.maps.Map(document.getElementById("gmap"), properties);
            directionsDisplay.setMap(map);

            Route();
          }

          function Route() {

            var start = new google.maps.LatLng(<?php echo $_POST['latitude'].', '.$_POST['longitude']; ?>);
            var end = new google.maps.LatLng(<?php echo $data['latitude'].', '.$data['longitude']; ?>);
            <?php if (isset($arrival)) { ?>
            var dest = new google.maps.LatLng(<?php echo $arrival['latitude'].', '.$arrival['longitude']; ?>);
            <?php } ?>
            var request = {
              origin: start,
              destination: end,
              travelMode: google.maps.TravelMode.WALKING
            };
            <?php /*if (isset($arrival)) { ?>
            var marker = new.google.maps.Marker({
              position: dest
            });
            marker.setMap(map);
            <?php } */?>
            directionsService.route(request, function(result, status) {
              if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
              } else {
                alert("couldn't get directions:" + status);
              }
            });
          }
          google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <div id="gmap" style="width:100%;height:450px;"></div>
        <br>
        <br>
        <div class="row">
          <div class="col-md-12">
            <h3 class="section-title text-center"><i class="ion-android-walk"></i> Departure Station</h3>
          </div>
          <br>
        </div>
        <div class="col-md-2 text-center">
          <h4>Name:</h4>
          <br>
          <b><?php echo $data['nom']; ?></b>
        </div>
        <div class="col-md-2 text-center">
          <h4>VeloH available:</h4>
          <br>
          <b><?php echo $data['nb_dispo']; ?></b>
        </div>
        <div class="col-md-2 text-center">
          <h4>Parking space:</h4>
          <br>
          <b><?php echo $data['nb_libre']; ?></b>
        </div>
        <div class="col-md-2 text-center">
          <h4>Payment point:</h4>
          <br><b><?php if ($data['banking']) { echo "<span style='color:green'>YES</span>"; } else { echo "<span style='color:red'>NO</span>"; }; ?></b>
        </div>
        <div class="col-md-2 text-center">
          <h4>Status:</h4>
          <br>
          <b><span style='color:green'><?php echo $data['status']; ?></span></b>
        </div>

        <?php } if (isset($arrival)) { ?>
        <div class="row">

          <div class="col-md-12">
            <h3 class="section-title text-center">          <br>
                      <br><i class="ion-android-bicycle"></i> Arrival Station</h3>
          </div>
        </div>
        <br>
      <div class="col-md-2 text-center">
        <h4>Name:</h4>
        <br>
        <b><?php echo $arrival['nom']; ?></b>
      </div>
      <div class="col-md-2 text-center">
        <h4>VeloH available:</h4>
        <br>
        <b><?php echo $arrival['nb_dispo']; ?></b>
      </div>
      <div class="col-md-2 text-center">
        <h4>Parking space:</h4>
        <br>
        <b><?php echo $arrival['nb_libre']; ?></b>
      </div>
      <div class="col-md-2 text-center">
        <h4>Payment point:</h4>
        <br><b><?php if ($arrival['banking']) { echo "<span style='color:green'>YES</span>"; } else { echo "<span style='color:red'>NO</span>"; }; ?></b>
      </div>
      <div class="col-md-2 text-center">
        <h4>Status:</h4>
        <br>
        <b><span style='color:green'><?php echo $data['status']; ?></span></b>
      </div>
      <?php } ?>

    </div>
  </section>
  <section id="contribution" class="section bg-image-2 contribution">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="text-uppercase mt0 font-400">Health</h3>

          <p>For 1 miles using a car: 0.099 kg/km CO2 rejected, using a bus: 0.014 kg/km CO2 rejected</p>
          <p>Using VeloH you loose approximately 40 calories per miles</p>

        </div>
      </div>
    </div>
  </section>

  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p class="site-info">
            Designed by <a href="http://technextit.com">Technext Limited</a></p>
          <!--<ul class="social-block">
            <li><a href=""><i class="ion-social-twitter"></i></a></li>
            <li><a href=""><i class="ion-social-facebook"></i></a></li>
            <li><a href=""><i class="ion-social-linkedin-outline"></i></a></li>
            <li><a href=""><i class="ion-social-googleplus"></i></a></li>
          </ul>-->
        </div>
      </div>
    </div>
  </footer>

  <!-- script -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>
