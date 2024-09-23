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
    <h3>Attendances List</h3>
    <!--begin::Table-->
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
            <?php 
            if($first_colum_array){
                foreach($first_colum_array as $first_colum_array_val){
                    ?>
                    <th class="min-w-70px"><?php echo $first_colum_array_val;?></th>
                    <?php
                }
            }
            ?>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
            <?php echo $month_timesheet_html;?>
        </tbody>
    </table>
    <!--end::Table-->
</div>
