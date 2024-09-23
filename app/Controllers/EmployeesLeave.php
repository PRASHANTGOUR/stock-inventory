<?php



namespace App\Controllers;



# Add the Model

use App\Models\AdminModel;



class EmployeesLeave extends BaseController

{

    public function __construct()

    {

      $this->db = db_connect();

      $this->dbutil = \Config\Database::utils();

    }



      #View All Units

  public function listOld()

  {
    
    // EmployeesLeave Data

    /*

        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";

        $Output = $this->db->query($Query)->getResultArray();

        */

    /*$Output = $this->db->table('leave')

      ->select('leave.*,employees.first_name,employees.last_name')

      ->join('employees', 'employees.id = leave.employee_id','left')

      ->orderBy('employees.id', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();*/

    $title = 'Employees Leave';

    //$d['account'] = auth()->user()->username;



    # Pagination for custom query but not working presently

    /*

        $pager = service('pager');



        $page    = (int) ($this->request->getGet('page') ?? 1);

        $perPage = 100;

        $total   = 200;



        // Call makeLinks() to make pagination links.

        $pager_links = $pager->makeLinks($page, $perPage, $total);

        */

        $search = isset($_POST['search']) ? $_POST['search'] : '';

        $Output_query = $this->db->table('leave');

        if($search != ''){
          $search_array = explode(' ',$search);
          if(count($search_array) == 1){
            $Output_query->groupStart();
                $Output_query->like('employees.first_name','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.email','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.phone_number','%'.srting_encrypt($search).'%');
            $Output_query->groupEnd();
          }else{
            $Output_query->groupStart();
                $Output_query->like('employees.first_name','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.first_name','%'.srting_encrypt($search_array[1]).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search_array[1]).'%');
                $Output_query->orLike('employees.email','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.phone_number','%'.srting_encrypt($search_array[0]).'%');
            $Output_query->groupEnd();
          }
        }

        $Output_query->select('leave.*,employees.first_name,employees.last_name');

        $Output_query->join('employees', 'employees.id = leave.employee_id');

        $Output = $Output_query->groupBy('leave.employee_id')->orderBy('employees.id', 'DESC')->get()->getResultArray();

    # Output results to template

    return view(

      "EmployeesLeave/index",

      [

        "title" => $title,

        "products" => $Output,

        "search" => $search,

        //'pager_links' => $pager_links,



      ]

    );

  }

  public function list()
  {
    // EmployeesLeave Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
    /*$Output = $this->db->table('leave')
      ->select('leave.*,employees.first_name,employees.last_name')
      ->join('employees', 'employees.id = leave.employee_id','left')
      ->orderBy('employees.id', 'DESC')
      ->limit(100)
      ->get()
      ->getResultArray();*/
    $title = 'Employees Leave';
    //$d['account'] = auth()->user()->username;

    # Pagination for custom query but not working presently
    /*
        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 100;
        $total   = 200;

        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        */
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $Output_query = $this->db->table('leave');
        if($search != ''){
          $search_array = explode(' ',$search);
          if(count($search_array) == 1){
            $Output_query->groupStart();
                $Output_query->like('employees.first_name','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.email','%'.srting_encrypt($search).'%');
                $Output_query->orLike('employees.phone_number','%'.srting_encrypt($search).'%');
            $Output_query->groupEnd();
          }else{
            $Output_query->groupStart();
                $Output_query->like('employees.first_name','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.first_name','%'.srting_encrypt($search_array[1]).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.last_name','%'.srting_encrypt($search_array[1]).'%');
                $Output_query->orLike('employees.email','%'.srting_encrypt($search_array[0]).'%');
                $Output_query->orLike('employees.phone_number','%'.srting_encrypt($search_array[0]).'%');
            $Output_query->groupEnd();
          }
        }
        $Output_query->select('leave.*,employees.first_name,employees.last_name');
        $Output_query->join('employees', 'employees.id = leave.employee_id');
        $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
        $employee_id_array = array();

        foreach($Output as $employees_id){
            $employee_id_array[] = $employees_id['employee_id'];
        }
        
        $OutputData = array();
        foreach(array_unique($employee_id_array) as $emp_id){
          $Output_query = $this->db->table('leave')->where('employee_id',$emp_id)->get()->getResultArray();
          $employees = $this->db->table('employees')->select('employees.*,employees.first_name,employees.last_name')->where('employees.id',$emp_id)->get()->getResultArray();
          if($Output_query[0]){
            $OutputData[] = array_merge($employees[0],$Output_query[0]);
          }
        }
        // if($search != ''){
        //     $Output_query->groupStart();
        //         $Output_query->like('employees.first_name',$search);
        //         $Output_query->orLike('employees.last_name',$search);
        //     $Output_query->groupEnd();
        // }
        
        

        // if (!empty($employee_id_array)) {
        //     $Output_query->whereIn('leave.id' , array_unique($employee_id_array));
        // }
        // $OutputData = $Output_query->get()->getResultArray();
        // echo"<pre>";print_r($OutputData);die;
    # Output results to template
    return view(
      "EmployeesLeave/index",
      [
        "title" => $title,
        "products" => $OutputData,
        "search" => $search,
        //'pager_links' => $pager_links,

      ]
    );
  }
  public function loglist() 
  {
    $title = 'Leave Log';
    $Output_query = $this->db->table('log');
    $Output_query->whereIn('EventType',array('Leave Updated'));//,'Leave Deleted'
    $OutputData = $Output_query->orderBy('log.Date', 'DESC')->get()->getResultArray();
    return view(
      "EmployeesLeave/log_index",
      [
        "title" => $title,
        "products" => $OutputData,

      ]
    );
  }

  #Search Units

  public function searchDepartment()

  {

    $search = $this->request->getPost('search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Department Data

    /*

        $Query = "SELECT * FROM `8yxzproducts` WHERE `pnumber` LIKE '%".$search."%' ORDER BY `DateAdded` DESC LIMIT 100";

        $Output = $this->db->query($Query)->getResultArray(); 

        */

    $Output = $this->db->table('products')

      ->like('pnumber', $search)

      ->orderBy('DateAdded', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();





    $title = 'Units';

    //$d['account'] = auth()->user()->username;



    # Pagination for custom query but not working presently

    /*

        $pager = service('pager');



        $page    = (int) ($this->request->getGet('page') ?? 1);

        $perPage = 100;

        $total   = 200;



        // Call makeLinks() to make pagination links.

        $pager_links = $pager->makeLinks($page, $perPage, $total);

        */



    # Output results to template

    return view(

      "Admin/index",

      [

        "title" => $title,

        "products" => $Output,

        //'pager_links' => $pager_links,



      ]

    );

  }



    public function addEmployeesLeave(){
        if ($this->request->is('post')) {
            $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $this->request->getPost('id');
            $employee_id_array = $this->request->getPost('employee_id');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            $leave_type = $this->request->getPost('leave_type');
            $remark = $this->request->getPost('remark');
            $all_employee = $this->request->getPost('all_employee');

            if($all_employee == 1){

                $data = [

                    'employee_id' => 0,

                    'all_employee' => 1,

                    'start_date' => $start_date,

                    'end_date' => $end_date,

                    'leave_type' => $leave_type,

                    'remark' => $remark

                ];

          

                $builder = $this->db->table('leave');

                $builder->insert($data);

                $product_id = $this->db->insertID();        

            }else{

                if( $employee_id_array){

                    foreach( $employee_id_array as $employee_id ){

                        $data = [

                            'employee_id' => $employee_id,

                            'start_date' => $start_date,

                            'end_date' => $end_date,

                            'leave_type' => $leave_type,

                            'remark' => $remark

                        ];

                  

                        $builder = $this->db->table('leave');

                        $builder->insert($data);

                        $product_id = $this->db->insertID();        

                    }

                }

            }

                    

            return redirect()->to(url_to('EmployeesLeave::list'));

        } else {

            $title = "Add New Employees Leave";

            $employees = $this->db->table('employees')

            ->orderBy('email', 'ASC')

            ->limit(100)

            ->get()

            ->getResultArray();

            $leave_type = $this->db->table('leavetype')

            ->orderBy('name', 'ASC')

            ->limit(100)

            ->get()

            ->getResultArray();

            return view('EmployeesLeave/addEmployeesLeave', [

                "title" => $title,

                "employees" => $employees,

                "leave_type" => $leave_type,

            ]);

        }

    }

    

    #Edit a P No

  public function editEmployeesLeave()

  {

    if ($this->request->is('get')) {

      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();

      $PN = $query['id'];

        $employees = $this->db->table('employees')

            ->orderBy('email', 'ASC')

            ->limit(100)

            ->get()

            ->getResultArray();

            $leave_type = $this->db->table('leavetype')

            ->orderBy('name', 'ASC')

            ->limit(100)

            ->get()

            ->getResultArray();
        $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '".$query['employee_id']."'")->getRowArray();
          $employees_name = '';
          if($employees_detail){
            $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
            $how_many_holidays = !empty($employees_detail['how_many_holidays']) ? $employees_detail['how_many_holidays'] : 0;
    
          }

      $title = "Edit Employees Leave $employees_name";

      return view('EmployeesLeave/editEmployeesLeave', [

        "title" => $title,

        "result"   => $query,

         "employees"   => $employees,

          "leave_type" => $leave_type,

      ]);

    } else if ($this->request->is('post')) {

         $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $employee_id = $this->request->getPost('employee_id');

        $start_date = $this->request->getPost('start_date');

        $end_date = $this->request->getPost('end_date');

        $leave_type = $this->request->getPost('leave_type');

        $remark = $this->request->getPost('remark');

        $all_employee = $this->request->getPost('all_employee');

        

        if($all_employee == 1){
              $old_data = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
                $data = [

                    'employee_id' => 0,

                    'all_employee' => 1,

                    // 'start_date' => $start_date,

                    // 'end_date' => $end_date,

                    'leave_type' => $leave_type,

                    'remark' => $remark

                ];

                $builder = $this->db->table('leave');

                $builder->where('id', $id);

                $builder->update($data);
                
                $EventDetails['old_data'] = $old_data;
                $EventDetails['new_data'] = $data;
                $data_log = [
                  'EventType' => 'Leave Updated',
                  'Product_Id' => $id,                
                  'EventDetails' => json_encode($EventDetails),
                  'User' => auth()->user()->username,
                ];                
                $builder_log = $this->db->table('log');
                $builder_log->insert($data_log);
            }else{
              $old_data = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
                $data = [

                    'employee_id' => $employee_id,

                    // 'start_date' => $start_date,

                    // 'end_date' => $end_date,

                    'leave_type' => $leave_type,

                    'remark' => $remark

                ];

                $builder = $this->db->table('leave');

                $builder->where('id', $id);

                $builder->update($data);
                
                $EventDetails['old_data'] = $old_data;
                $EventDetails['new_data'] = $data;
                $data_log = [
                  'EventType' => 'Leave Updated',
                  'Product_Id' => $id,                
                  'EventDetails' => json_encode($EventDetails),
                  'User' => auth()->user()->username,
                ];                
                $builder_log = $this->db->table('log');
                $builder_log->insert($data_log);
                $url = url_to('EmployeesLeave::ViewEmployeesLeavehistory').'?p='.$employee_id;

                return redirect()->to($url)->with("message", $id . " - ID updated");

            }

        return redirect()->to(url_to('EmployeesLeave::list'))->with("message", $id . " - ID updated");

    }

  }

  public function ViewEmployeesLeavehistory()

  {

    if ($this->request->is('get')) {

      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = $this->db->query("SELECT * FROM 8yxzleave WHERE (employee_id = '$id') OR (employee_id = 0 AND all_employee = 1) ORDER BY start_date ASC")->getResultArray();

      $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();

      $employees_name = '';

      if($employees_detail){

        $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
        $how_many_holidays = !empty($employees_detail['how_many_holidays']) ? $employees_detail['how_many_holidays'] : 0;

      }


      $title = "View Employees Leave History - ".$employees_name;

      if($query){

        foreach ($query as $key => $query_value) {

          $start=date_create($query_value['start_date']);

          $end=date_create($query_value['end_date']);

          $diff=date_diff($start,$end);

          //$leave_day = $diff->format("%R%a");

          //$leave_day = $leave_day + 1;

          $end->modify('+1 day');

          $interval = $end->diff($start);

          $leave_day = $interval->days;

          $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

          foreach($period as $dt) {

            $curr = $dt->format('D');

            // substract if Saturday or Sunday

            if ($curr == 'Sat' || $curr == 'Sun') {

                $leave_day--;

            }

            // (optional) for the updated question

            // elseif (in_array($dt->format('Y-m-d'), $holidays)) {

            //     $days--;

            // }

        }

          if($leave_day > 0){

            $query[$key]['leave_day'] = $leave_day;

          }else{

            unset($query[$key]);

          }

        }

      }

      $leave_type = $this->db->table('leavetype')

      ->orderBy('id', 'ASC')

      ->limit(100)

      ->get()

      ->getResultArray();

      return view('EmployeesLeave/viewEmployeesLeavehistory', [

        "title" => $title,

        "products"   => $query,

        "employees_name"   => $employees_name,

        "leave_type"   => $leave_type,

        "how_many_holidays"   => $how_many_holidays,

        "id"   => $id,

      ]);

    } else if ($this->request->is('post')) {

        



      return redirect()->to(url_to('EmployeesLeave::list'));

    }

  }

    public function deleteEmployeesLeave()

  {

    $id = $this->request->getPost('leave_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $employee_id = $this->request->getPost('employee_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();

    $this->db->query("delete from `8yxzleave` WHERE `id` = '$id'");



    

    $data = [

      'EventType' => 'Leave Deleted',

      'Product_Id' => $id,

      'EventDetails' => json_encode($query),

      'User' => auth()->user()->username,

    ];

    $builder = $this->db->table('log');

    $builder->insert($data);

    $url = url_to('EmployeesLeave::ViewEmployeesLeavehistory').'?p='.$employee_id;

    return redirect()->to($url)->with("message", "Leave deleted");



  } 

  public function checkEmployeesLeave(){
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    if($id){
        $employee_id = isset($_POST['employee_id']) ? array($_POST['employee_id']) : array();
    } else {
        $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : array();
    }
    $all_employee = isset($_POST['all_employee']) ? $_POST['all_employee'] : 0;
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $leave_type = isset($_POST['leave_type']) ? $_POST['leave_type'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $status = 'error';
    $field = '';
    $message = '';
    $url = '';
    $check = 1;
    if($start_date == ""){
        $status = 'error';
        $field = 'start_date_error';
        $message = 'Start Date is required field';
        $check = 0;
    }
    if($end_date == ""){
        $status = 'error';
        $field = 'end_date_error';
        $message = 'End Date is required field';
        $check = 0;
    }
    if($check){
        $start=date_create($start_date);
        $end=date_create($end_date);    
        $end->modify('+1 day');
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        if($all_employee == 1){
            $duplicates_found = 0;
            $duplicates_msg = '';
            foreach($period as $dt) {
                $check_date = $dt->format('Y-m-d');
                $main_query = "SELECT * FROM 8yxzleave WHERE DATE(start_date) <= '".$check_date."' AND DATE(end_date) >= '".$check_date."' AND id != '".$id."'";
                $query = $this->db->query($main_query)->getResultArray();
                if(count($query) > 0){
                    $duplicates_found = 1;
                    $duplicates_msg .= date('d-m-Y',strtotime($check_date)).' Date Allready assign.<br>';
                }    
            }  
            if($duplicates_found == 1){
                $status = 'error';
                $field = 'start_date_error';
                $message = $duplicates_msg;
            }else{
                
                if($id){
                  $old_data = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
                    $data = [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'leave_type' => $leave_type,
                        'remark' => $remark
                    ];
                    $builder = $this->db->table('leave');
                    $builder->where('id', $id);
                    $builder->update($data);
                    $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '".$old_data['id']."'")->getRowArray();
                    $employees_name = '';
                    if($employees_detail){
                         $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                    }
                    $data['employee_name'] = $employees_name;
                    $EventDetails['old_data'] = $old_data;
                    $EventDetails['new_data'] = $data;
                    $data_log = [
                      'EventType' => 'Leave Updated',
                      'Product_Id' => $id,                
                      'EventDetails' => json_encode($EventDetails),
                      'User' => auth()->user()->username,
                    ];                
                    $builder_log = $this->db->table('log');
                    $builder_log->insert($data_log);
                } else {
                    $Output_query = $this->db->table('employees');
                    $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
                    if($Output){
                    foreach($Output as $Output_val){    
                        $data = [
                            'employee_id' => $Output_val['id'],
                            'all_employee' => 1,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'leave_type' => $leave_type,
                            'remark' => $remark
                        ];
                        $builder = $this->db->table('leave');
                        $builder->insert($data);
                        $product_id = $this->db->insertID(); 
                        $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '".$Output_val['id']."'")->getRowArray();
                        $employees_name = '';
                        if($employees_detail){
                             $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                        }
                        $data['employee_name'] = $employees_name;
                        $old_data = array();
                        $EventDetails['old_data'] = $old_data;
                        $EventDetails['new_data'] = $data;
                        $data_log = [
                          'EventType' => 'Leave Added',
                          'Product_Id' => $product_id,                
                          'EventDetails' => json_encode($EventDetails),
                          'User' => auth()->user()->username,
                        ]; 
                        $builder_log = $this->db->table('log');
                        $builder_log->insert($data_log);   
                    }    
                    }
                }
                $status = 'success';
                $field = '';
                $message = '';
                $url = url_to('EmployeesLeave::list');
                if (auth()->user()->can('employees.access')) {
                  $url = url_to('Leave::list');
                }
            }
        }else{
            if($id){
                 $leave_detail = $this->db->query("SELECT * FROM 8yxzleave WHERE  id = '".$id."'")->getRowArray();
                  if($leave_detail){
                      $employee_id[] = $leave_detail['employee_id'];
                  }
            }
            if($employee_id && is_array($employee_id) && count($employee_id) == 0){
                $status = 'error';
                $field = 'employee_id_error';
                $message = 'Employee is required field';
            }
            $duplicates_found = 0;
            $duplicates_msg = '';
            foreach($employee_id as $employee_id_val){
                $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employee_id_val'")->getRowArray();
                $employees_name = '';
                if($employees_detail){
                    $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                }
                foreach($period as $dt) {
                    $check_date = $dt->format('Y-m-d');
                    $main_query = "SELECT * FROM 8yxzleave WHERE employee_id = '".$employee_id_val."' AND DATE(start_date) <= '".$check_date."' AND DATE(end_date) >= '".$check_date."'  AND id != '".$id."'";
                    $query = $this->db->query($main_query)->getResultArray();
                    if(count($query) > 0){
                        $duplicates_found = 1;
                        $duplicates_msg .= $employee_id_val.'----'.$employees_name.' '.date('d-m-Y',strtotime($check_date)).' Date Allready assign.<br>';
                    }    
                }  
            }
            if($duplicates_found == 1){
                $status = 'error';
                $field = 'start_date_error';
                $message = $duplicates_msg;
            }else{
                if( $employee_id ){
                    foreach( $employee_id as $emp_id ){
                        $data = [
                            'employee_id' => $emp_id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'leave_type' => $leave_type,
                            'remark' => $remark
                        ];
                        $builder = $this->db->table('leave');
                        if($id){
                            $old_data = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
                            $builder->where('id', $id);
                            $builder->update($data);
                            
                            $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '".$old_data['employee_id']."'")->getRowArray();
                            $employees_name = '';
                            if($employees_detail){
                                $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                            }
                            $old_data['employee_name'] = $employees_name;
                            $EventDetails['old_data'] = $old_data;
                            $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$emp_id'")->getRowArray();
                            $employees_name = '';
                            if($employees_detail){
                                $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                            }
                            $data['employee_name'] = $employees_name;
                            $EventDetails['new_data'] = $data;
                            $data_log = [
                              'EventType' => 'Leave Updated',
                              'Product_Id' => $id,                
                              'EventDetails' => json_encode($EventDetails),
                              'User' => auth()->user()->username,
                              'staffId' => $emp_id,
                            ];                
                            $builder_log = $this->db->table('log');
                            $builder_log->insert($data_log);
                        } else {
                            $builder->insert($data);
                             $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$emp_id'")->getRowArray();
                            $employees_name = '';
                            if($employees_detail){
                                $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
                            }
                            $data['employee_name'] = $employees_name;
                            $product_id = $this->db->insertID();  
                            $old_data = array();
                            $EventDetails['old_data'] = $old_data;
                            $EventDetails['new_data'] = $data;
                            $data_log = [
                              'EventType' => 'Leave Updated',
                              'Product_Id' => $product_id,                
                              'EventDetails' => json_encode($EventDetails),
                              'User' => auth()->user()->username,
                              'staffId' => $emp_id,
                            ]; 
                            $builder_log = $this->db->table('log');
                            $builder_log->insert($data_log);       
                        }       
                    }
                }
                $status = 'success';
                $field = '';
                $message = '';
                $url = url_to('EmployeesLeave::list');
                if (auth()->user()->can('employees.access')) {
                  $url = url_to('Leave::list');
                }
            }
        }
    }
    $return_data['status'] = $status;
    $return_data['field'] = $field;
    $return_data['message'] = $message;
    $return_data['url'] = $url;
    echo json_encode($return_data);
  }
  public function LeaveTotallist(){
      $Output_query = $this->db->table('leave_total');
      $Output_query->select('leave_total.*');
      $Output = $Output_query->orderBy('leave_total.year', 'DESC')->get()->getResultArray();
	    $title = 'Leave Total';
      # Output results to template
      return view(
      "EmployeesLeave/leave_total_index",
      [
        "title" => $title,
        "products" => $Output,
      ]
    );
  }
  public function addEmployeesLeaveTotal(){ 
    if ($this->request->is('post')) {
        $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = $this->request->getPost('id');
        $year = $this->request->getPost('year');
        $month = $this->request->getPost('month');
        $selected_hours = $this->request->getPost('selected_hours');
        $selected_mintus = $this->request->getPost('selected_mintus');
        $leave_total_detail = $this->db->query("SELECT id FROM 8yxzleave_total WHERE year = '".$year."' AND month = '".$month."'")->getRowArray();
        if($leave_total_detail){
          $leave_total_id = $leave_total_detail['id'];
          $data = [
            'selected_hours' => $selected_hours,
            'selected_mintus' => $selected_mintus,
          ];
          $builder = $this->db->table('leave_total');
          $builder->where('id', $leave_total_id);
          $builder->update($data);
  
        }else{
          $data = [
              'year' => $year,
              'month' => $month,
              'selected_hours' => $selected_hours,
              'selected_mintus' => $selected_mintus,
          ];
          $builder = $this->db->table('leave_total');
          $builder->insert($data);
          $leave_total_id = $this->db->insertID();
        }  
        return redirect()->to(url_to('EmployeesLeave::LeaveTotallist'));

    } else {
        $title = "Add New Leave Total";
        $Output_query = $this->db->table('8yxztimesheet');
        $Output_query->select('MONTH(8yxztimesheet.start_time) as month_digit,YEAR(8yxztimesheet.start_time) as mag_year');//,MONTHNAME(8yxztimesheet.start_time) as mag_month
        $Output_query->join('employees', 'employees.id = 8yxztimesheet.employee_id');
        $Output_month = $Output_query->groupBy('MONTH(8yxztimesheet.start_time), YEAR(8yxztimesheet.start_time)')->get()->getResultArray();//->orderBy('8yxztimesheet.start_time', 'DESC')
        $mag_year = 2023;
        $exit_year[$mag_year] = $mag_year;
        $exit_month = array(
          '1'=>'January',
          '2'=>'February',
          '3'=>'March',
          '4'=>'April',
          '5'=>'May',
          '6'=>'June',
          '7'=>'July',
          '8'=>'August',
          '9'=>'September',
          '10'=>'October',
          '11'=>'November',
          '12'=>'December',
        );
        if($Output_month){
          foreach($Output_month as $key=>$Output_month_val){
            $mag_year = $Output_month_val['mag_year'];
            $exit_year[$mag_year] = $mag_year;
          }
        }
        $selected_year = isset($_GET['year']) ? $_GET['year'] : '';
        $selected_month = isset($_GET['month']) ? $_GET['month'] : '';
        $leave_total_detail = $this->db->query("SELECT selected_hours,selected_mintus FROM 8yxzleave_total WHERE year = '".$selected_year."' AND month = '".$selected_month."'")->getRowArray();
        $selected_hours = 0;
        $selected_mintus = 0;
        if($leave_total_detail){
          $selected_hours = $leave_total_detail['selected_hours'];
          $selected_mintus = $leave_total_detail['selected_mintus'];
        }
        return view('EmployeesLeave/add_leave_total', [
            "title" => $title,
            "exit_year" => $exit_year,
            "exit_month" => $exit_month,
            "selected_year" => $selected_year,
            "selected_month" => $selected_month,
            "selected_hours" => $selected_hours,
            "selected_mintus" => $selected_mintus,
        ]);
        }
    }
  public function deleteEmployeesLeaveTotal(){
    $id = $this->request->getPost('leave_total_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $this->db->query("delete from `8yxzleave_total` WHERE `id` = '$id'");
    return redirect()->to(url_to('EmployeesLeave::LeaveTotallist'))->with("message", "Leave Total deleted");
  }
}