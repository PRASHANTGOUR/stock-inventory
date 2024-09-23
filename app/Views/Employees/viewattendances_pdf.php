<?php 
$this->db = db_connect();
?>
<style>
table, td, th {
    border: 1px solid black;
}
table {
    border-collapse: collapse;
    width: 100%;
}
td {
    height: 20px;
    vertical-align: middle;
    text-align: center;
}
</style>
<div class="card-body pt-0">
    <h3 style="text-align: center;"><?php echo $title;?></h3>
    <h3>Month Wise</h3>
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-70px">Month</th>
                <th class="min-w-70px">Total Hours</th>
                <th class="min-w-70px">Working Hours</th>
                <th class="min-w-70px">Extra Hours</th>
                <?php
                foreach($leave_type as $leave_type_val){
                    echo '<th class="" style="min-w-70px">'.$leave_type_val['name']."</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
        <?php
        $i = 1;
        foreach ($month_timesheet as $product) {
        ?>
            <tr>
            <td class=" align-middle"><?= $product['month_name']; ?></td>
            <td class=" align-middle"><?= $product['final_total_hours']; ?></td>
            <td class=" align-middle"><?= $product['total_hours']; ?></td>
            <td class=" align-middle"><?= $product['final_extra_hours']; ?></td>
            <?php
        foreach($leave_type as $leave_type_val){
            $query = $this->db->query("SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE_FORMAT(start_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(start_date,'%Y') = '".$product['current_year']."') OR (DATE_FORMAT(end_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(end_date,'%Y') = '".$product['current_year']."')) AND leave_type = '".$leave_type_val['name']."'")->getResultArray();
            $leave_day = 0;
            if($query){
            foreach ($query as $key => $query_value) {
                $start=date_create($query_value['start_date']);
                $end=date_create($query_value['end_date']);
                $diff=date_diff($start,$end);
                $end->modify('+1 day');
                $interval = $end->diff($start);
                $inner_leave_day = $interval->days;
                $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
                // echo '<pre>';
                // print_r($period);
                // echo '</pre>';
                if(strlen($selected_year) == 1){
                $selected_year = '0'.$selected_year;
                }  
                if(strlen($selected_month) == 1){
                $selected_month = '0'.$selected_month;
                }
                //echo '<br>--match_selected->';
                $match_selected = $selected_month.$selected_year;
                //echo '<hr><hr>';
                
                foreach($period as $dt) {
                $curr = $dt->format('D');
                $inner_year = $dt->format('Y');
                if(strlen($inner_year) == 1){
                    $inner_year = '0'.$inner_year;
                }  
                $inner_month = $dt->format('m');
                if(strlen($inner_month) == 1){
                    $inner_month = '0'.$inner_month;
                }
                //echo '<br>--match_selected->';
                $match_inner = $inner_month.$inner_year;
                if($selected_month == 'all' || $selected_year == 'all'){
                    //echo 'innnnnnnnnnnnn';
                    if ($curr == 'Sat' || $curr == 'Sun') {
                        $inner_leave_day--;
                    }
                }else{
                    if($match_selected == $match_inner){
                        //echo 'innnnnnnnnnnnn';
                        if ($curr == 'Sat' || $curr == 'Sun') {
                            $inner_leave_day--;
                        }
                    }else{
                        $inner_leave_day--;
                    }
                }     
                }
                $leave_day = $leave_day + $inner_leave_day;
            }
            }
            echo '<td class="">'.$leave_day."</td>";

        }
        ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <!--end::Table-->
</div>
<div class="card-body pt-0">
    <h3>Attendances List</h3>
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-70px">Check In</th>
                <th class="min-w-70px">Check Out</th>
                <th class="min-w-70px">Working Hours</th>
                <!--<th class="min-w-100px">Actions</th>-->
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
        <?php
        $i = 1;
        foreach ($products as $product) {
        ?>
            <tr>
            <td class=" align-middle"><?= $product['start_time']; ?></td>
            <td class=" align-middle"><?= $product['end_time']; ?></td>
            <td class=" align-middle"><?= $product['total_time']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <!--end::Table-->
</div>