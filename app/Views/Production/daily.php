<?php 
# Call in main template
echo $this->extend('layouts/default');

# Meta title Section 
echo $this->section('heading');
echo $title;
echo $this->endSection();

echo $this->section('sidebar'); 

echo $this->endSection();

# Main Content
echo $this->section('content'); 

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
 </style>

<!--begin::Post-->
<div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div class="container-xxl">
        <!--begin::Products-->
        <div class="card card-flush">

        <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Team</th>
                      <th>Team Name</th>
                      <th>Average Output</th>
                      <th>Pnumbers</th>
                    </tr>
                  </thead>
                 
                  <tbody>
                    <?php

                    //natsort($department);
                    foreach ($department as $dpt) :

                    $Team = $dpt['id'];
                    $query = $this->db->query("SELECT AVG(`daily_output`) AS `average` FROM `8yxzteam_output` WHERE `team` = '$Team' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();");
                    $row = $query->getRow();
                    $Average = $row ? $row->average : 0;
                    if($Average > 0) {
                      $Average = number_format($Average, 2, '.', '');
                    }

                    //$Expected = $dpt['ExpectedOuput'];
                    $row = $this->db->query("SELECT AVG(`expected`)AS expected FROM `8yxzteam_output` WHERE `team` = '$Team' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW();")->getRowArray();
                    $Expected = $row['expected'];
                    $Percentage = percent($Average, $Expected);
                    
                    ?>
                      <tr>
                        <td class="align-middle"><?php echo $Team; ?></td>
                        <td class="align-middle"><?= $dpt['name']; ?></td>
                        <td class="align-middle <?= ColourScale($Average, $Expected);?>" title="Actual: <?=$Average?> Expected: <?=$Expected?>"><?=$Percentage;?><?php /* ?> <a href="<?php echo base_url('master/view_team_output/') . $dpt['id'];?>">History</a><?php */ ?></td>
                        <td class="align-middle text-center">
                            <a href="<?= url_to('Production::teamDaily').'?t='.$Team;?>" class="btn btn-primary">View Units</a>
                        </td>
                        
                      </tr>
                    <?php 
                     endforeach; ?>
                  </tbody>
                </table>

                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->



<?php 

echo $this->endSection();