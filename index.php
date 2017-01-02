<?php

    $truckinfo = "";

    $error = "";

    $googleapikey = "";

    $silentpassenderapikey = "";

    $ch = curl_init('http://api.silentpassenger.com/rest/v2/************/MapView/Vehicles?userid=19542');

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
    $xml = curl_exec($ch);
    curl_close($ch);
    $parsed = new SimpleXMLElement($xml);

    $mapsurl = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Washington,DC&destinations=New+York+City,NY&key=************************************************");
    $mapsjson = json_decode($mapsurl,true);


  //  for ($i = 0; $i < 67; $i++) {
  //  echo "Na broju ".$i." je kamion br: ".$parsed->LighterVehicle[$i]->VehicleName."<br>";
  //  }


    if($_GET['truckid']) {

      if ($_GET['truckid'] == "Optimus Prime") {

        $i = 66;

      } else if ($_GET['truckid'] == "Megatron") {

        $i = 65;

      } else {


                  $i = (int)$_GET['truckid'];




                  if (substr($parsed->LighterVehicle[$i]->VehicleName, 1 , 2) != 0) {

                     $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -2);

                  } else {

                     $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -1);

                  }


                  //echo "Truck id:".$_GET['truckid']."<br>";
                  //echo "vehicleNumber:".$vehicleNumber."<br>";

                  if ($vehicleNumber > $_GET['truckid']) {

                    if (substr($parsed->LighterVehicle[$i]->VehicleName, 1 , 2) != 0) {

                        while ($vehicleNumber != $_GET['truckid']) {
                        $i--;
                        $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -2);}
                      } else {
                        while ($vehicleNumber != $_GET['truckid']) {
                          $i--;
                          $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -1);}
                      }

                    }  else if ($vehicleNumber < $_GET['truckid']) {

                      while ($vehicleNumber != $_GET['truckid']) {
                      $i++;
                      $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -2);}
                    } else {
                      while ($vehicleNumber != $_GET['truckid']) {
                        $i++;
                        $vehicleNumber = substr($parsed->LighterVehicle[$i]->VehicleName, -1);}
                      }


              }


        //echo "vehicleNumber posle while:".$vehicleNumber."<br>";


        //echo "i = ".$i."<br>";


        $truckinfo = "Status for ".$parsed->LighterVehicle[$i]->VehicleName.": <br>";
        $truckinfo .= $parsed->LighterVehicle[$i]->VehicleStatus->Name."<br>";
        $truckinfo .= print_r($mapsjson);

       }
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Truck Scraper</title>

    <style type="text/css">

    html {
        background: url(background.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      body {

        background: none !important;

      }

      .container {

        text-align: center;
        margin-top: 100px;
        color: white;
        position: relative;
        width:50% !important;

      }

      #truckinfo {

        margin-top: 20px;
      }

       #map {
        height: 400px;
        width: 40%;
       }


    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css"
      integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">



  </head>
  <body>

    <div class="container">

      <h1>Which truck?</h1>

      <form>
        <div class="form-group">
          <label for="truckid" autocomplete="off">Number: </label>
          <input type="text" class="form-control" name="truckid" id="truckid" placeholder="Truck #" value =
          "<?php

            if(array_key_exists('truckid', $_GET)) {

echo ($_GET['truckid']); }

          ?>">

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

      <div id="truckinfo">

          <?php

            if ($truckinfo) {

              echo '<div class="alert alert-success" role="alert">'.$truckinfo.'
</div>';

            } else if ($error) {

              echo '<div class="alert alert-danger" role="alert">'.$error.'
</div>';

            }

           ?>

      </div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
  </body>
</html>
