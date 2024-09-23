<?php
function srting_encrypt($srting){
    $srting = strtolower($srting);
    $method = "AES-256-CBC";
    $key = "encryptionKey123";
    $options = 0;
    $iv = '1234567891011121';
    return $encryptedData = openssl_encrypt($srting, $method, $key, $options,$iv);
}
function srting_decrypt($srting){
    $method = "AES-256-CBC";
    $key = "encryptionKey123";  
    $options = 0;
    $iv = '1234567891011121';
    return $decryptedData = openssl_decrypt($srting, $method, $key, $options, $iv);
}
function reCalcMonth($team, $date) 
{
    $output = db_connect()->table('progress')
    ->selectSum('coefficent')
    ->where('team', $team)
    ->where('date', $date)
    ->get()
    ->getRowArray();
    $progress = (!empty($output['coefficent'])) ? $output['coefficent'] : 0;

    $output2 = db_connect()->table('product_modification')
    ->selectSum('coef')
    ->where('team', $team)
    ->where('date', $date)
    ->get()
    ->getRowArray();
    $modifications = (!empty($output2['coef'])) ? $output2['coef'] : 0;

    $total = $progress + $modifications;
    return $total;
}  
function UserPermissionCHeck($user_id, $permission_flage) 
{
    $output = db_connect()->table('8yxzauth_permissions_users')
    ->select('id')
    ->where('permission', $permission_flage)
    ->where('user_id', $user_id)
    ->get()
    ->getRowArray();
    $check_record = 0;
    if(!empty($output)){
        $check_record = 1;
    }
    return $check_record;
}  
function employees_how_many($employee_id, $year,$leavetype_id) 
{
    $output = db_connect()->table('8yxzemployees_how_many')
    ->select('value_data')
    ->where('employee_id', $employee_id)
    ->where('year', $year)
    ->where('leavetype_id', $leavetype_id)
    ->get()
    ->getRowArray();
    $value_data = 0;
    if(!empty($output)){
        $value_data = $output['value_data'];
    }
    return $value_data;
} 
function log_attendances_list($selected_date = '',$employee_id){
    $title = 'Leave Log';
    $Output_query = db_connect()->table('log');
    $Output_query->whereIn('EventType',array('Check In Time','Check Out Time'));//,'Leave Deleted'
    if($selected_date != ''){
        $selected_month = date('m',strtotime($selected_date));
        $selected_year = date('Y',strtotime($selected_date));
        //$Output_query->where('Month(8yxzlog.Date)',$selected_month);
        //$Output_query->where('Year(8yxzlog.Date)',$selected_year);
    }
    $Output_query->where('log.staffId',$employee_id);
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    $op_list = '';
    if($OutputData){
        foreach($OutputData as $OutputData_val){
            $EventDetails = $OutputData_val['EventDetails'];
            $EventDetails_decode = json_decode($EventDetails);
            $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
            $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
            $change_data = '';
            if($old_data){
                if($OutputData_val['EventType'] == 'Check In Time'){
                    $old_data_start_time = $old_data->start_time;
                    $old_data_start_time = date('d-m-Y h:i A',strtotime($old_data_start_time));
                    //$old_data_start_time = substr_replace($old_data_start_time, "", -3);
                    $new_data_start_time = $new_data->start_time;
                    //$new_data_start_time = substr_replace($new_data_start_time, "", -3);
                    //$new_data_start_time = str_replace('T',' ',$new_data_start_time);
                    $new_data_start_time = date('d-m-Y h:i A',strtotime($new_data_start_time));
                    $change_data = '<strong>'.$old_data_start_time.'</strong> TO <strong>'.$new_data_start_time.'</strong><br>';
                }  
                if($OutputData_val['EventType'] == 'Check Out Time'){
                    $old_data_end_time = $old_data->end_time;
                    //$old_data_end_time = substr_replace($old_data_end_time, "", -3);
                    $old_data_end_time = date('d-m-Y h:i A',strtotime($old_data_end_time));
                    $new_data_end_time = $new_data->end_time;
                    //$new_data_end_time = substr_replace($new_data_end_time, "", -3);
                    //$new_data_end_time = str_replace('T',' ',$new_data_end_time);
                    $new_data_end_time = date('d-m-Y h:i A',strtotime($new_data_end_time));
                    $change_data = '<strong>'.$old_data_end_time.'</strong> TO <strong>'.$new_data_end_time.'</strong><br>';
                }   
            }
            $op_list .= '<p>'.$OutputData_val['User'].' Changed '.$OutputData_val['EventType'].' '.$change_data.'</p>';
        }
    }
    if($op_list != ''){
        $op_list = '<h2>History</h2>'.$op_list;
    }
    return $op_list;
}
function log_leave_list($selected_date = '',$employee_id){
    $title = 'Leave Log';
    $Output_query = db_connect()->table('log');
    $Output_query->whereIn('EventType',array('Leave Updated'));//,'Leave Deleted'
    if($selected_date != ''){
        $selected_month = date('m',strtotime($selected_date));
        $selected_year = date('Y',strtotime($selected_date));
        //$Output_query->where('Month(8yxzlog.Date)',$selected_month);
        //$Output_query->where('Year(8yxzlog.Date)',$selected_year);
    }
    $Output_query->where('log.staffId',$employee_id);
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    $op_list = '';
    if($OutputData){
        foreach($OutputData as $product){
            if($product['EventType'] == 'Leave Updated'){
                $EventDetails = $product['EventDetails'];
                $op_list .= '<tr>';
                $op_list .= '<td>'.$product['User'].'</td>';
                $op_list .= '<td>'.$product['Date'].'</td>';
                $EventDetails_decode = json_decode($EventDetails);
                $td_detail = '';
                $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
                if($old_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>Old Data</b><br>';
                    foreach($old_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'employee_id' || $key == 'all_employee' || $key == 'updated_at' || $key == 'created_at' || $key == 'id'){
                            
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
                if($new_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>New Data</b><br>';
                    foreach($new_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'employee_id' || $key == 'all_employee' || $key == 'updated_at' || $key == 'created_at' || $key == 'id'){
                            
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $op_list .= '<td>'.$td_detail.'</td>';
                $op_list .= '</tr>';
            }   
        }
    }
    if($op_list != ''){
        $op_list = '<h2>History</h2><table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table"><thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th class="min-w-70px">User</th><th class="min-w-100px">Date</th><th class="min-w-100px">EventDetails</th></tr></thead><tbody class="fw-semibold text-gray-600">'.$op_list.'</tbody></table>';
    }
    return $op_list;
}
function log_Permission_list(){
    $title = 'Leave Log';
    $Output_query = db_connect()->table('log');
    $Output_query->whereIn('EventType',array('Employees Permission Updated'));//,'Leave Deleted'
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    $op_list = '';
    if($OutputData){
        foreach($OutputData as $product){
            $EventDetails = $product['EventDetails'];
            $op_list .= '<tr>';
            $op_list .= '<td>'.$product['User'].'</td>';
            $EventDetails_decode = json_decode($EventDetails);
            $employees_name = isset($EventDetails_decode->employees_name) ? $EventDetails_decode->employees_name : array();
            $permission_action = isset($EventDetails_decode->permission_action) ? $EventDetails_decode->permission_action : '';
            $permission_action_type = isset($EventDetails_decode->permission_action_type) ? $EventDetails_decode->permission_action_type : '';
            $op_list .= '<td>'.$product['Date'].'</td>';
            $td_detail = '';
            if($permission_action == 'all_check' || $permission_action == 'all_uncheck'){
                $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
                if($old_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>Old Data</b><br>';
                    foreach($old_data as $key=>$EventDetails_decode_old_data_val){
                        $permission = $EventDetails_decode_old_data_val->permission;
                        $permission = str_replace('_',' ',$permission);
                        $permission = ucwords(strtolower($permission), '\',. ');
                        $td_detail .= '<strong>'.$permission.'</strong> <br>';
                    }
                    $td_detail .= '</div>';
                }
                $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
                $td_detail .= '<div style="width:45%;float:left;"> <b>New Data</b><br>';
                if($permission_action == 'all_check'){
                    $td_detail .= '<strong>All Added</strong> <br>';
                }elseif($permission_action == 'all_uncheck'){
                    $td_detail .= '<strong>All Removed</strong> <br>';
                    if($new_data){
                        foreach($new_data as $key=>$EventDetails_decode_new_data_val){
                            $permission = $EventDetails_decode_new_data_val->permission;
                            $permission = str_replace('_',' ',$permission);
                            $permission = ucwords(strtolower($permission), '\',. ');
                            $td_detail .= '<strong>'.$permission.'</strong> <br>';
                        }
                    }
                }
                $td_detail .= '</div>';
                
            }else{
                $permission_action = str_replace('_',' ',$permission_action);
                $permission_action = ucwords(strtolower($permission_action), '\',. ');
                $td_detail = $permission_action.' '.$permission_action_type;
            }
            $op_list .= '<td><b>'.$employees_name.'</b><br>'.$td_detail.'</td>';
            $op_list .= '</tr>';
        }
    }
    if($op_list != ''){
        $op_list = '<h2>History</h2><table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table"><thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th class="min-w-70px">User</th><th class="min-w-100px">Date</th><th class="min-w-100px">EventDetails</th></tr></thead><tbody class="fw-semibold text-gray-600">'.$op_list.'</tbody></table>';
    }
    return $op_list;
}
function log_Employees_list($Employeesid){
    $title = 'Leave Log';
    $Output_query = db_connect()->table('log');
    $Output_query->whereIn('EventType',array('Employees Updated'));//,'Leave Deleted'
    $Output_query->where('Product_Id',$Employeesid);
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    $op_list = '';
    if($OutputData){
        foreach($OutputData as $product){
            
                $EventDetails = $product['EventDetails'];
                $op_list .= '<tr>';
                $op_list .= '<td>'.$product['User'].'</td>';
                $op_list .= '<td>'.$product['Date'].'</td>';
                $EventDetails_decode = json_decode($EventDetails);
                $td_detail = '';
                $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
                if($old_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>Old Data</b><br>';
                    foreach($old_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'id' || $key == 'department_id' || $key == 'created_at' || $key == 'updated_at'){
                            
                        }elseif($key == 'first_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'last_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'email'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
                if($new_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>New Data</b><br>';
                    foreach($new_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'id' || $key == 'department_id' || $key == 'created_at' || $key == 'updated_at'){
                            
                        }elseif($key == 'first_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'last_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'email'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $op_list .= '<td>'.$td_detail.'</td>';
                $op_list .= '</tr>';
        }
    }
    if($op_list != ''){
        $op_list = '<h2>History</h2><table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table"><thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th class="min-w-70px">User</th><th class="min-w-100px">Date</th><th class="min-w-100px">EventDetails</th></tr></thead><tbody class="fw-semibold text-gray-600">'.$op_list.'</tbody></table>';
    }
    return $op_list;
}
function log_all_Employees_list(){
    $title = 'Leave Log';
    $Output_query = db_connect()->table('log');
    $Output_query->whereIn('EventType',array('Employees Updated','Employees Added','Employees Delete'));//,'Leave Deleted'
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    $op_list = '';
    if($OutputData){
        foreach($OutputData as $product){
                $EventDetails = $product['EventDetails'];
                $op_list .= '<tr>';
                $op_list .= '<td>'.$product['User'].'</td>';
                $op_list .= '<td>'.$product['EventType'].'</td>';
                $op_list .= '<td>'.$product['Date'].'</td>';
                $EventDetails_decode = json_decode($EventDetails);
                $td_detail = '';
                $old_data = isset($EventDetails_decode->old_data) ? $EventDetails_decode->old_data : array();
                if($old_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>Old Data</b><br>';
                    foreach($old_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'id' || $key == 'department_id' || $key == 'created_at' || $key == 'updated_at'){
                            
                        }elseif($key == 'first_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'last_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'email'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $new_data = isset($EventDetails_decode->new_data) ? $EventDetails_decode->new_data : array();
                if($new_data){
                    $td_detail .= '<div style="width:45%;float:left;"> <b>New Data</b><br>';
                    foreach($new_data as $key=>$EventDetails_decode_old_data_val){
                        if($key == 'id' || $key == 'department_id' || $key == 'created_at' || $key == 'updated_at'){
                            
                        }elseif($key == 'first_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'last_name'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }elseif($key == 'email'){
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.srting_decrypt($EventDetails_decode_old_data_val).'<br>';
                        }else{
                            $key = str_replace('_',' ',$key);
                            $td_detail .= '<strong>'.$key.'</strong> :'.$EventDetails_decode_old_data_val.'<br>';
                        }    
                    }
                    $td_detail .= '</div>';
                }
                $op_list .= '<td>'.$td_detail.'</td>';
                $op_list .= '</tr>';
        }
    }
    if($op_list != ''){
        $op_list = '<h2>History</h2><table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table"><thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th class="min-w-70px">User</th><th class="min-w-70px">Type</th><th class="min-w-100px">Date</th><th class="min-w-100px">EventDetails</th></tr></thead><tbody class="fw-semibold text-gray-600">'.$op_list.'</tbody></table>';
    }
    return $op_list;
}
function TimeDifferent($start_time, $end_time) 
{
    $start_date = new DateTime(date('Y-m-d H:i',strtotime($start_time)));
    $end_date = new DateTime(date('Y-m-d H:i',strtotime($end_time)));
    $interval = $start_date->diff($end_date);
    // echo '<pre>';
    // print_r($interval);
    // echo '</pre>';
    $month   = $interval->format('%m');
    $month_hours = 0;
    $inner_days   = $interval->format('%days');
    if($inner_days > 0){
        $inner_days = str_replace('ays','',$inner_days);
        $month_hours = ($inner_days * 24);
    }
    $days   = $interval->format('%d');
    $hours   = $interval->format('%h'); 
    $final_hour = ($month_hours) + $hours;//+ ($days * 24)
    if(strlen($final_hour) == 1){
        $final_hour = '0'.$final_hour;
    } 
    $minutes = $interval->format('%i');
    if(strlen($minutes) == 1){
        $minutes = '0'.$minutes;
    } 
    return $final_hour.':'.$minutes;

    $date1 = strtotime($start_time);
    $date2 = strtotime($end_time);
    return $difference = abs($date1 - $date2) / 60;
    // Formulate the Difference between two dates
    $diff = abs($date2 - $date1);
    // To get the year divide the resultant date into
    // total seconds in a year (365*60*60*24)
    $years = floor($diff / (365*60*60*24));
    // To get the month, subtract it with years and
    // divide the resultant date into
    // total seconds in a month (30*60*60*24)
    $months = floor(($diff - $years * 365*60*60*24)
                                    / (30*60*60*24));
    // To get the day, subtract it with years and
    // months and divide the resultant date into
    // total seconds in a days (60*60*24)
    $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));
    // To get the hour, subtract it with years,
    // months & seconds and divide the resultant
    // date into total seconds in a hours (60*60)
    $hours = floor(($diff - $years * 365*60*60*24
            - $months*30*60*60*24 - $days*60*60*24)
                                        / (60*60));
    if(strlen($hours) == 1){
        $hours = '0'.$hours;
    }                                    
    // To get the minutes, subtract it with years,
    // months, seconds and hours and divide the
    // resultant date into total seconds i.e. 60
    $minutes = floor(($diff - $years * 365*60*60*24
            - $months*30*60*60*24 - $days*60*60*24
                                - $hours*60*60)/ 60);
    if(strlen($minutes) == 1){
        $minutes = '0'.$minutes;
    }                            
    // To get the minutes, subtract it with years,
    // months, seconds, hours and minutes
    $seconds = floor(($diff - $years * 365*60*60*24
            - $months*30*60*60*24 - $days*60*60*24
                    - $hours*60*60 - $minutes*60));
    return $hours.':'.$minutes;
}