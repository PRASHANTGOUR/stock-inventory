<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta Title Section 
echo $this->section('heading');
echo $title;
echo $this->endSection();

# Main Content
echo $this->section('content'); 
?>

<?php

$this->db = db_connect();

   function ColourScale($Output, $Expected) {
      $colour = NULL;

      if (empty($Expected)) {
        $Expected = "Not Set";
      } else if ($Output >= $Expected * 1.2) {
        $colour = "oneforty";
      } else if ($Output < $Expected * 1.2 AND $Output >= $Expected * 1.05) {
        $colour = "onethirty";
      } else if ($Output < $Expected * 1.05 AND $Output >= $Expected * 1) {
        $colour = "onetwenty";
      } else if ($Output == $Expected * 1) {
        $colour = "oneten";
      } else if ($Output < $Expected * 1 AND $Output >= $Expected * 0.9) {
        $colour = "hundred";
      } else if ($Output < $Expected * 0.9 AND $Output >= $Expected * 0.8) {
        $colour = "ninety";
      } else if ($Output < $Expected * 0.8) {
        $colour = "eighty";
      } 
      return $colour;
    }

    function percent($x, $y) {
      if(!empty($x) AND !empty($y)) {
        return number_format(($x / $y) * 100, 0, '.', '')."% ";
      } else {
        return $x;
      }
    }
?>
 
 <style>

/*
  .onefifty, .onefifty a {
    background-color: #01b0f1;
  }
  */

  .oneforty, .oneforty a {
    background-color: #42af4c !important;;
  }

  .onethirty, .onethirty a {
    background-color: #61fd00 !important;;
  }

  .onetwenty, .onetwenty a {
    background-color: #a9fd60 !important;;
  }

  .oneten, .oneten a{
    background-color: #d2fe97 !important;;
  }

  .hundred, .hundred a {
    background-color: #f5c100 !important;;
  }

  .ninety, .ninety a {
    background-color: #f39b9a !important;;
  }

  .eighty, .eighty a {
    background-color: #ee1f17 !important;;
  }

  /*
  .seventy, .seventy a {
    background-color: #ee1f17;
  }
  */

  table a, table td {
    color: black;
  }

  .weekend {
    font-weight: bold;
    background-color: #fffdd0;
  }

  /*
  .ThickBorderRight {
    ThickBorderRight: thick black solid;
  }
  */

  .table-striped > tbody > tr:nth-of-type(2n+1) > * {
	--bs-table-color-type: var(--bs-table-striped-color);
	/* --bs-table-bg-type: var(--bs-table-striped-bg); */
}
 </style>
 
 
 <!-- Begin Page Content -->
       <div class="container-fluid">


         <?php
                  #Output Factory Total for today so far
                  $query = $this->db->query("SELECT ROUND(SUM(`daily_output`),2) AS `factoryCoef`, ROUND(SUM(`expected`),2) AS `expected` FROM `8yxzteam_output` WHERE `date` = CURRENT_DATE() LIMIT 1");
                  $row = $query->getRow();
                  $TodayFactoryOutput = $row ? $row->factoryCoef : 0;
                  $TodayExpected = $row ? $row->expected : 0;
                  $Today = percent($TodayFactoryOutput, $TodayExpected)." ".$TodayFactoryOutput."(".$TodayExpected.")";

                  #Output Factory Total for yesterday
                  $query = $this->db->query("SELECT ROUND(SUM(`daily_output`),2) AS `factoryCoef`, ROUND(SUM(`expected`),2) AS `expected` FROM `8yxzteam_output` WHERE `date` = CURRENT_DATE()-1 LIMIT 1");
                  $row = $query->getRow();
                  $YesterdayFactoryOutput = $row ? $row->factoryCoef : 0;
                  $YesterdayExpected = $row ? $row->expected : 0;
                  $Yesterday = percent($YesterdayFactoryOutput, $YesterdayExpected)." ".$YesterdayFactoryOutput."(".$YesterdayExpected.")";

                  #Output Factory Total for this week so far
                  $query = $this->db->query("SELECT ROUND(AVG(`output`),2) AS `factoryCoef` FROM `8yxzfactory_output` WHERE  YEARWEEK(`date`, 1) = YEARWEEK(CURDATE(), 1)");
                  $row = $query->getRow();
                  $WeekFactoryOutput = $row ? $row->factoryCoef : 0;
                  $WeekFactoryOutput = number_format((float)$WeekFactoryOutput, 3, '.', '');  

                  #Output Factory Average
                  $query = $this->db->query("SELECT ROUND(AVG(`output`),2) AS `factoryCoef` FROM `8yxzfactory_output`");
                  $row = $query->getRow();
                  $AverageFactoryOutput = $row ? $row->factoryCoef : 0;
                  $AverageFactoryOutput = number_format((float)$AverageFactoryOutput, 3, '.', '');  
                  ?>

         <h2 class="h3 mb-0 text-gray-800"><a href="<?php echo site_url('/master/daily') ?>">Factory Output</a></h2>
         <br />

         <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
              <div class="card border-left-primary shadow h-100 py-2 rounded-0 border-4">
                <div class="card-body py-1">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold mb-1">Total Today</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Today;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
              <div class="card border-left-info shadow h-100 py-2 rounded-0 border-4">
                <div class="card-body py-1">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold mb-1">Total Yesterday</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $Yesterday?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
              <div class="card border-left-success shadow h-100 py-2 rounded-0 border-4">
                <div class="card-body py-1">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold mb-1">Average This Week</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $WeekFactoryOutput ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4">
              <div class="card border-left-danger shadow h-100 py-2 rounded-0 border-4">
                <div class="card-body py-1">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-lg font-weight-bold mb-1">Average Output</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $AverageFactoryOutput ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-id-badge fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

         <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <!-- Pie Chart -->
              <div class="col p-0">
                <div class="card shadow mb-4 rounded-0">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-muted">Factory Teams Overview <?php echo date('m-Y', strtotime($month));?>
                    </h6>
                    <div>
                      <a class="text-reset font-weight-bolder text-muted" title="Previous Month" href="<?php echo url_to('ProductionDashboard::index')."?date=".date('Y-m-d', strtotime($month. '-1 months'));?>"><i class="fa fa-arrow-left"></i><?php echo date('M-y', strtotime($month. '-1 months'));?></a>
                      <?php 
                      if($month < date("Y-m-d")) { ?>
                        <a class="text-reset font-weight-bolder text-muted" title="Next Month" href="<?php echo url_to('ProductionDashboard::index')."?date=".date('Y-m-d', strtotime($month. '+1 months'));?>"><?php echo date('M-y', strtotime($month. '+1 months'));?><i class="fa fa-arrow-right"></i></a>
                        <a class="text-reset font-weight-bolder text-muted" title="Next Month" href="<?php echo url_to('ProductionDashboard::index');?>">View Current</a>

                      <?php } ?>
                    </div>

                  </div>
                  <!-- Card Body -->
                  <div class="card-body overflow-auto" style="max-height: 700px;">
                    <table class="table table-bordered">
                      <thead class="bg-gradient-primary text-white">
                        <tr>
                          <th class="p-1" scope="col">Date</th>
                          <th class="text-center p-1" scope="col">Total</th>
                          <th class="text-center p-1" scope="col">Expected</th>
                          <?php
                          foreach ($teams_list as $team) { 
                            $team = $team['id'];
                            echo "<th class='text-center p-1'><a href='".url_to('Production::viewTeamsOuput')."?t=$team'>$team</a></th>";

                          } ?>

                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                         foreach ($days_list as $day) { 
                            $date = $day['date'];
                            $Colour = NULL;
                            $WeekDay = date('D', strtotime($date));

                            $RowColour = NULL;
                            if($WeekDay === "Sat" OR $WeekDay === "Sun") {
                              $RowColour = 'weekend';
                            }

                            ?>
                            <tr class="<?php echo $RowColour;?>">
                              <td class="p-1"><?php echo $WeekDay." ".date("d M", strtotime($date));?></td>
                            <?php
                              $DayTotal = $day['dayTotal'];
                              $DayExpected = $day['expected'];
                              ?>
                              <td class="text-center p-1 ThickBorderRight <?php echo ColourScale($DayTotal, $DayExpected);?>" ><?php echo $DayTotal; ?></td>
                              <td class="text-center p-1 ThickBorderRight" ><?php echo $DayExpected; ?></td>

                              <?php 
                              foreach ($teams_list as $team) { 

                                $team = $team['id'];
                                #Maybe better solution long term but for now query each date and team
                                $query = $this->db->query("SELECT ROUND(daily_output, 2) daily_output, ROUND(expected, 2) expected FROM 8yxzteam_output WHERE `date` = '$date' AND `team` ='$team';");
                                $row = $query->getRow();
                                $Output = $row ? $row->daily_output : null;
                                $Expected = $row ? $row->expected : null;
                                $Percent = percent($Output, $Expected);
                                ?>

                                <td class='text-center p-1 <?php echo ColourScale($Output, $Expected);?>' Title='Actual: <?php echo $Output." Expected: ".$Expected;?>'><a href='<?= url_to('Production::viewTeamDailyOutput')?>?t=<?php echo $team;?>&d=<?php echo $date;?>'><?php echo $Output;?><br />
                                </a></td> 
                              <?php } ?>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td><b>Total</b></td>
                            <?php 
                            # Need to add call for month total and Expected Placeholder for now
                            $query = $this->db->query("SELECT ROUND(SUM(daily_output), 2) AS `MonthTotal`, ROUND(SUM(expected), 2) AS `MonthExpected` FROM 8yxzteam_output WHERE `date`>= '$StartDate' AND `date` <= '$EndDate';");
                            $row = $query->getRow();
                            $MonthExpected = $row ? $row->MonthExpected : null;
                            $MonthTotal = $row ? $row->MonthTotal : null;

                            ?>
                            <td class="text-center ThickBorderRight <?php echo ColourScale($MonthTotal, $MonthExpected);?>" ><b><?php echo $MonthTotal; ?></b></td>
                            <td class="text-center ThickBorderRight" ><b><?php echo $MonthExpected; ?></b></td>

                            <?php
                            foreach ($teams_list as $team) { 
                              $team = $team['id'];
                              $query = $this->db->query("SELECT ROUND(SUM(daily_output), 2) AS `TeamTotal`, ROUND(SUM(expected), 2) AS `TeamExpected` FROM 8yxzteam_output WHERE `date`>= '$StartDate' AND `date` <= '$EndDate' AND `team` ='$team';");
                              $row = $query->getRow();
                              $TeamTotal = $row ? $row->TeamTotal : null;
                              $TeamExpected = $row ? $row->TeamExpected : null;
                              echo "<td class='text-center'><b>$TeamTotal</b><br />($TeamExpected)</td>";

                            } ?>
                          </tr>
                          <tr>
                            <td>Percentage</td>
                            <?php 
                            # Calc Month Percentage
                            $Percentage = percent($MonthTotal, $MonthExpected);

                            ?> 
                            <td class="text-center ThickBorderRight <?php echo ColourScale($MonthTotal, $MonthExpected);?>" ><?php echo $Percentage; ?></td>
                            <td></td>


                            <?php
                            foreach ($teams_list as $team) { 
                              $team = $team['id'];
                              $query = $this->db->query("SELECT SUM(daily_output) AS `TeamTotal`, SUM(expected) AS `TeamExpected`FROM 8yxzteam_output WHERE `date`>= '$StartDate' AND `date` <= '$EndDate' AND `team` ='$team';");
                              $row = $query->getRow();
                              $TeamTotal = $row ? $row->TeamTotal : null;
                              $TeamExpected = $row ? $row->TeamExpected : null;

                              $colour = NULL;
                              $symbol = NULL;
                              $Percentage = NULL;

                              if($TeamTotal > 0 AND $TeamExpected >0) {
                                $Percentage = percent($TeamTotal, $TeamExpected);
                              }
                              echo "<td class='text-center ".ColourScale($TeamTotal, $TeamExpected)."'><b>$Percentage</b></td>";

                            } ?>

                          </tr>
                      </tbody>
                    </table>
                    <?php 
                      if($month > "2023-10-01" AND auth()->user()->can('production.super')) { 
                        echo "<a href='".url_to('ProductionDashboard::ReCalcSelectedMonth')."?date=".$month."'><i class='bi-arrow-counterclockwise fs-3'></i>";
                      }

                    ?>
                  </div>
                </div>
              </div>
            </div>
         </div>


         <?php /* ?>
         <!-- Content Row -->
         <div class="row">

        
           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
             <!-- Pie Chart -->
             <div class="col p-0">
               <div class="card shadow mb-4 rounded-0">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-muted">Progress Log</h6>
                   <a class="text-reset font-weight-bolder text-muted" title="Go to Teams List" href="<?php echo site_url('/master/daily') ?>"><i class="fa fa-arrow-right"></i></a>
                 </div>
                 <!-- Card Body -->
                 <div class="card-body overflow-auto" style="max-height: 400px;">
                   <table class="table table-bordered table-striped">
                     <thead class="bg-gradient-primary text-white">
                       <tr>
                         <th class="text-center p-1" scope="col">P No</th>
                         <th class="text-center p-1" scope="col">Team</th>
                         <th class="text-center p-1" scope="col">Coef</th>
                         <th class="text-center p-1" scope="col">Date</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php 
                        foreach ($progress_list as $progress) : ?>
                          <tr>
                            <th class="text-center p-1"><?php echo $progress['pnumber'];?></th>
                            <td class="text-center p-1"><?php echo $progress['team'];?></td>
                            <td class="text-center p-1"><?php echo $progress['coefficent'];?></td>
                            <td class="text-center p-1"><?php echo $progress['date'];?></td>
                          </tr>
                        <?php endforeach; ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>

           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
             <!-- Pie Chart -->
             <div class="col p-0">
               <div class="card shadow mb-4 rounded-0">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-muted">Modifications Log</h6>
                   <a class="text-reset font-weight-bolder text-muted" title="Go to Teams List" href="<?= url_to('Production::viewModifications'); ?>"><i class="fa fa-arrow-right"></i></a>
                 </div>
                 <!-- Card Body -->
                 <div class="card-body overflow-auto" style="max-height: 400px;">
                   <table class="table table-bordered table-striped">
                     <thead class="bg-gradient-primary text-white">
                       <tr>
                         <th class="text-center p-1" scope="col">P No</th>
                         <th class="text-center p-1" scope="col">Team</th>
                         <th class="text-center p-1" scope="col">Coef</th>
                         <th class="text-center p-1" scope="col">Type</th>
                         <th class="text-center p-1" scope="col">Date</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php 
                        foreach ($mod_list as $mod) : ?>
                         <tr>
                           <th class="text-center p-1"><?php echo $mod['pnumber'];?></th>
                           <td class="text-center p-1"><?php echo $mod['team'];?></td>
                           <td class="text-center p-1"><?php echo $mod['modCoef'];?></td>
                           <td class="text-center p-1"><?php echo $mod['type'];?></td>
                           <td class="text-center p-1"><?php echo $mod['date'];?></td>
                         </tr>
                       <?php endforeach; ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <?php */ ?>



       </div>
       <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->

    </div>

<?php 
echo $this->endSection();