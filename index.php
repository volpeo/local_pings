<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>Ping status</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="favicon.png" />
</head>

<body>
  <div id="wrapper" class="container">
    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header text-center">Ping status</h1>
        </div>
      </div>

      <?php
      include("conf.php");


      $pingdead = 0;
      $pingslow = 0;
      $pinggood = 0;

      foreach($hotes as &$hote) {
        $ping = exec("ping -c 1 " . $hote['ip']);
        if($ping){
          $ping = explode("=",$ping);
          $ping = explode("/", $ping[1]);
          $ping = explode(".", $ping[0]);
          $ping = $ping[0];
        }
        $hote['ping'] = $ping;

        if(is_null($ping) or $ping == ''){
          $pingdead++;
        }
        if(isset($ping) AND $ping != '' AND $ping < $slow) {
          $pinggood++;
        }
        if( $ping > $slow) {
          $pingslow++;
        }
      }
      ?>
      <div class="col-lg-4 col-md-8">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-thumbs-up fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $pinggood ?></div>
              <div>Good connection(s)</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-8">
      <div class="panel panel-yellow">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-spinner fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $pingslow ?></div>
              <div>Slow connection(s)</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-8">
      <div class="panel panel-red">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-support fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $pingdead ; ?></div>
              <div>Connection Problem(s)</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>IP</th>
          <th>Latence (ms)</th>
        </tr>
      </thead>
      <tbody>
    <?php
    foreach($hotes as $hote) {
      echo "<tr class='";

      if($hote['ping'] < $slow) echo "success";
      if($hote['ping'] > $slow) echo "warning";
      if(is_null($hote['ping']) OR $hote['ping'] == '') echo "danger";

      echo "'><td>".$hote['nom']."</td><td>".$hote['ip']."</td><td> ".$hote['ping']." ms </td></tr>";

    }

    for($i = 0 , $i < 17 , $i++)
    echo $hotes[$i];
    ?>
    </table>

  </div>
</div>
</div>
</body>
</html>
