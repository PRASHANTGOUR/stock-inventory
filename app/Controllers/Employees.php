<?php
namespace App\Controllers;
# Add the Model
use CodeIgniter\Shield\Entities\User;
use App\Models\AdminModel;
use Dompdf\Dompdf;
class Employees extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
    }
    #View All Units
  public function list()
  {
      $search = isset($_POST['search']) ? $_POST['search'] : '';
      $Output_query = $this->db->table('employees');
      if($search != ''){
        $search_array = explode(' ',$search);
        if(count($search_array) == 1){
          $Output_query->groupStart();
              $Output_query->like('first_name','%'.srting_encrypt($search).'%');
              $Output_query->orLike('last_name','%'.srting_encrypt($search).'%');
              $Output_query->orLike('email','%'.srting_encrypt($search).'%');
              $Output_query->orLike('phone_number','%'.srting_encrypt($search).'%');
          $Output_query->groupEnd();
        }else{
          $Output_query->groupStart();
              $Output_query->like('first_name','%'.srting_encrypt($search_array[0]).'%');
              $Output_query->orLike('first_name','%'.srting_encrypt($search_array[1]).'%');
              $Output_query->orLike('last_name','%'.srting_encrypt($search_array[0]).'%');
              $Output_query->orLike('last_name','%'.srting_encrypt($search_array[1]).'%');
              $Output_query->orLike('email','%'.srting_encrypt($search_array[0]).'%');
              $Output_query->orLike('phone_number','%'.srting_encrypt($search_array[0]).'%');
          $Output_query->groupEnd();
        }  
      }
      $Output_query->select('employees.*,departments.department');
      $Output_query->join('departments', 'departments.id = employees.department_id');
      $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
	  $title = 'Employees';
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

        /*if( $Output){
          foreach( $Output as  $product){
            $first_name = srting_encrypt($product['first_name']);
            $last_name = srting_encrypt($product['last_name']);
            $email = srting_encrypt($product['email']);
            $data = [
              'first_name' => $first_name,
              'last_name' => $last_name,
              'email' => $email,
          ];
          $builder = $this->db->table('employees');
          $builder->where('id', $product['id']);
          $builder->update($data);
            
          }
        }*/

    # Output results to template

    return view(

      "Employees/index",

      [

        "title" => $title,

        "products" => $Output,

        "search" => $search,

        //'pager_links' => $pager_links,



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



    public function addEmployee()

    { 

    if ($this->request->is('post')) {

        $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $id = $this->request->getPost('id');

        $department_id = $this->request->getPost('department_id');

        $first_name = $this->request->getPost('first_name');

        $last_name = $this->request->getPost('last_name');

        $email = $this->request->getPost('email');

        $phone_number = $this->request->getPost('phone_number');
        $badge_number = $this->request->getPost('badge_number');

        $how_many_holidays = $this->request->getPost('how_many_holidays');

        $address = $this->request->getPost('address');

        $password = $this->request->getPost('password');

        

        $data = [

            'department_id' => $department_id,

            'first_name' => srting_encrypt($first_name),

            'last_name' => srting_encrypt($last_name),

            'email' => srting_encrypt($email),

            'phone_number' => $phone_number,
            'badge_number' => $badge_number,    
            'how_many_holidays' => $how_many_holidays,

            'address' => $address,

        ];

  

        $builder = $this->db->table('employees');

        $builder->insert($data);

        $employees = $this->db->insertID();
        $old_data = array();
        $Output_query = $this->db->table('employees');
        $Output_query->where('employees.id', $employees);
        $Output_query->select('employees.*,departments.department');
        $Output_query->join('departments', 'departments.id = employees.department_id');
        $new_data = $Output_query->orderBy('employees.id', 'DESC')->get()->getRowArray();
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $new_data;
        $data_log = [
          'EventType' => 'Employees Added',
          'Product_Id' => $id,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
        ];                
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log);
        //Barcode
        $ch = curl_init('https://barcodeapi.org/api/'.$employees.'@'.$badge_number);
        $path_name = '/public/user_barcode/'.$employees.'.png';
        $fp = fopen('public/user_barcode/'.$employees.'.png', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        //end barcode


        $data_update = [
            'barcode' => $path_name,
        ];



      $builder = $this->db->table('employees');

      $builder->where('id', $employees);

      $builder->update($data_update);
            

            $username = $first_name.''.$last_name;

            $email = $email;

            $groups = array('employees');

            // Get the User Provider (UserModel by default)

            $users = auth()->getProvider();

            $user = new User([

                'username' => $username,

                'email'    => $email,

                'password' => $password,

                'employees' => $employees,

                'active' => '1',

            ]);

            $users->save($user);

            // To get the complete user object with ID, we need to get from the database

            $user = $users->findById($users->getInsertID());

            $user->syncGroups(...$groups);

            //$user->forcePasswordReset();

            

        return redirect()->to(url_to('Employees::list'));

    } else {

        $title = "Add New Employee";

        $departments = $this->db->table('departments')

        ->orderBy('department', 'ASC')

        ->limit(100)

        ->get()

        ->getResultArray();

        return view('Employees/addEmployees', [

            "title" => $title,

            "departments" => $departments,

        ]);

        }

    }

    

    #Edit a P No

  public function editEmployee(){
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();
      $employees_name = '';
      if($query){
        $employees_name = srting_decrypt($query['first_name']).' '.srting_decrypt($query['last_name']);

      }
      $PN = $query['id'];
      $title = "Edit Employee $employees_name";
      $departments = $this->db->table('departments')
        ->orderBy('department', 'ASC')
        ->limit(100)
        ->get()
        ->getResultArray();
      return view('Employees/editEmployees', [
        "title" => $title,
        "result"   => $query,
        "departments" => $departments,
      ]);
    } else if ($this->request->is('post')) {
        $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $Output_query = $this->db->table('employees');
        $Output_query->where('employees.id', $id);
        $Output_query->select('employees.*,departments.department');
        $Output_query->join('departments', 'departments.id = employees.department_id');
        $old_data = $Output_query->orderBy('employees.id', 'DESC')->get()->getRowArray();
        $department_id = $this->request->getPost('department_id');
        $first_name = $this->request->getPost('first_name');
        $last_name = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        $phone_number = $this->request->getPost('phone_number');
        $badge_number = $this->request->getPost('badge_number');
        $how_many_holidays = $this->request->getPost('how_many_holidays');
        $address = $this->request->getPost('address');
        $data = [
            'department_id' => $department_id,
            'first_name' => srting_encrypt($first_name),
            'last_name' => srting_encrypt($last_name),
            //'email' => $email,
            'phone_number' => $phone_number,
            'badge_number' => $badge_number,
            'how_many_holidays' => $how_many_holidays,
            'address' => $address,
        ];
        //Barcode
        $ch = curl_init('https://barcodeapi.org/api/'.$id.'A'.$badge_number);
        $path_name = '/public/user_barcode/'.$id.'.png';
        $fp = fopen('public/user_barcode/'.$id.'.png', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        //end barcode
        $builder = $this->db->table('employees');
        $builder->where('id', $id);
        $builder->update($data);
        /////////////////////////////////////
        $Output_query = $this->db->table('employees');
        $Output_query->where('employees.id', $id);
        $Output_query->select('employees.*,departments.department');
        $Output_query->join('departments', 'departments.id = employees.department_id');
        $new_data = $Output_query->orderBy('employees.id', 'DESC')->get()->getRowArray();
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $new_data;
        $data_log = [
          'EventType' => 'Employees Updated',
          'Product_Id' => $id,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
        ];                
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log);
        /////////////////////////
        $username = $first_name.''.$last_name;
        $email = $email;
        $data = [
            'username' => $username,
        ];
        $builder = $this->db->table('users');
        $builder->where('employees', $id);
        $builder->update($data);
        return redirect()->to(url_to('Employees::list'))->with("message", $id . " - ID updated");
    }
  }

  public function deleteEmployee()

  {

    $id = $this->request->getPost('employee_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Output_query = $this->db->table('employees');
    $Output_query->where('employees.id', $id);
    $Output_query->select('employees.*,departments.department');
    $Output_query->join('departments', 'departments.id = employees.department_id');
    $old_data = $Output_query->orderBy('employees.id', 'DESC')->get()->getRowArray();
    $query = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();

    $this->db->query("delete from `8yxzemployees` WHERE `id` = '$id'");



    $query_users = $this->db->query("SELECT * FROM 8yxzusers WHERE employees = '$id'")->getRowArray();

    $query_auth_identities = array();

    if($query_users){

      $query_users_id = $query_users['id'];

      $query_auth_identities = $this->db->query("SELECT * FROM 8yxzauth_identities WHERE user_id = '$query_users_id'")->getRowArray();

      $this->db->query("delete from `8yxzauth_identities` WHERE `user_id` = '$query_users_id'");

    }

    $this->db->query("delete from `8yxzusers` WHERE `employees` = '$id'");

  

    $query_leave = $this->db->query("SELECT * FROM 8yxzleave WHERE employee_id = '$id'")->getResultArray();

    $this->db->query("delete from `8yxzleave` WHERE `employee_id` = '$id'");



    $query_task = $this->db->query("SELECT * FROM 8yxztask WHERE employee_id = '$id'")->getResultArray();

    $this->db->query("delete from `8yxztask` WHERE `employee_id` = '$id'");



    $data = [

      'EventType' => 'Employee Deleted',

      'Product_Id' => $id,

      'EventDetails' => 'Status Changed to Deleted - Product ID:'.$id.'===='.json_encode($query).'===='.json_encode($query_leave).'===='.json_encode($query_task).'===='.json_encode($query_users).'===='.json_encode($query_auth_identities),

      'User' => auth()->user()->username,

    ];

    $builder = $this->db->table('log');

    $builder->insert($data);

    $new_data = array();
    $EventDetails['old_data'] = $old_data;
    $EventDetails['new_data'] = $new_data;
    $data_log = [
      'EventType' => 'Employees Delete',
      'Product_Id' => $id,                
      'EventDetails' => json_encode($EventDetails),
      'User' => auth()->user()->username,
    ];                
    $builder_log = $this->db->table('log');
    $builder_log->insert($data_log);

    return redirect()->to(url_to('Employees::list'))

    ->with("message", "Employee deleted");



  }
  public function permission_list(){
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $Output_query = $this->db->table('employees');
    if($search != ''){
      $search_array = explode(' ',$search);
      if(count($search_array) == 1){
        $Output_query->groupStart();
            $Output_query->like('first_name','%'.srting_encrypt($search).'%');
            $Output_query->orLike('last_name','%'.srting_encrypt($search).'%');
            $Output_query->orLike('email','%'.srting_encrypt($search).'%');
            $Output_query->orLike('phone_number','%'.srting_encrypt($search).'%');
        $Output_query->groupEnd();
      }else{
        $Output_query->groupStart();
            $Output_query->like('first_name','%'.srting_encrypt($search_array[0]).'%');
            $Output_query->orLike('first_name','%'.srting_encrypt($search_array[1]).'%');
            $Output_query->orLike('last_name','%'.srting_encrypt($search_array[0]).'%');
            $Output_query->orLike('last_name','%'.srting_encrypt($search_array[1]).'%');
            $Output_query->orLike('email','%'.srting_encrypt($search_array[0]).'%');
            $Output_query->orLike('phone_number','%'.srting_encrypt($search_array[0]).'%');
        $Output_query->groupEnd();
      } 
    }
    $Output_query->select('employees.*,departments.department,users.id as users_id');
    $Output_query->join('users', 'users.employees = employees.id');
    $Output_query->join('departments', 'departments.id = employees.department_id');
    $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
    $title = 'Employees Permission';
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
      "Employees/permission_index",
      [
        "title" => $title,
        "products" => $Output,
        "search" => $search,
      ]
    );
  }
  public function checkEmployeespermission(){
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
    $permission = isset($_POST['permission_flage']) ? $_POST['permission_flage'] : '';
    $status = 'error';
    $check = 1;
    $query_users = $this->db->query("SELECT employees FROM 8yxzusers WHERE id = '$user_id'")->getRowArray();
    $employees_id = 0;
    if($query_users){
      $employees_id = $query_users['employees'];
    }
    $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '".$employees_id."'")->getRowArray();
    $employees_name = '';
    if($employees_detail){
      $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
    }
    $parmissrion_array = array('admin_view','admin_edit','design_view','design_edit','products_view','products_edit','production_view','production_edit','staff_view','staff_edit','departments_view','departments_edit','employees_view','employees_edit','leave_view','leave_edit');
    if($permission == 'all_check'){
        $old_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        foreach($parmissrion_array as $parmissrion_array_val){
            $main_query = "SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '".$user_id."' AND permission = '".$parmissrion_array_val."'";
            $query = $this->db->query($main_query)->getRowArray();
            if(!empty($query)){
              //$this->db->query("delete from `8yxzauth_permissions_users` WHERE user_id = '".$user_id."' AND permission = '".$parmissrion_array_val."'");
            }else{  
              $data = [
                'user_id' => $user_id,
                'permission' => $parmissrion_array_val,
              ];
              $builder = $this->db->table('auth_permissions_users');
              $builder->insert($data);
            }
        }
        $new_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        $EventDetails['employees_name'] = $employees_name;
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $new_data;
        $EventDetails['permission_action'] = $permission;
        $data_log = [
          'EventType' => 'Employees Permission Updated',
          'Product_Id' => 0,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
          'staffId' => $user_id,
        ]; 
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log); 
    }elseif($permission == 'all_uncheck'){
        $old_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        foreach($parmissrion_array as $parmissrion_array_val){
            $main_query = "SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '".$user_id."' AND permission = '".$parmissrion_array_val."'";
            $query = $this->db->query($main_query)->getRowArray();
            if(!empty($query)){
              $this->db->query("delete from `8yxzauth_permissions_users` WHERE user_id = '".$user_id."' AND permission = '".$parmissrion_array_val."'");
            }else{  
            //   $data = [
            //     'user_id' => $user_id,
            //     'permission' => $permission,
            //   ];
            //   $builder = $this->db->table('auth_permissions_users');
            //   $builder->insert($data);
            }
        }
        $new_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        $EventDetails['employees_name'] = $employees_name;
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $new_data;
        $EventDetails['permission_action'] = $permission;
        $data_log = [
          'EventType' => 'Employees Permission Updated',
          'Product_Id' => 0,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
          'staffId' => $user_id,
        ]; 
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log); 
    }else{
        $old_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        $main_query = "SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '".$user_id."' AND permission = '".$permission."'";
        $query = $this->db->query($main_query)->getRowArray();
        if(!empty($query)){
          $this->db->query("delete from `8yxzauth_permissions_users` WHERE user_id = '".$user_id."' AND permission = '".$permission."'");
          $permission_action_type = 'Removed';
        }else{  
          $data = [
            'user_id' => $user_id,
            'permission' => $permission,
          ];
          $builder = $this->db->table('auth_permissions_users');
          $builder->insert($data);
          $permission_action_type = 'Added';
        }
        $new_data = $this->db->query("SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '$user_id'")->getResultArray();
        $EventDetails['employees_name'] = $employees_name;
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $new_data;
        $EventDetails['permission_action'] = $permission;
        $EventDetails['permission_action_type'] = $permission_action_type;
        $data_log = [
          'EventType' => 'Employees Permission Updated',
          'Product_Id' => 0,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
          'staffId' => $user_id,
        ]; 
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log); 
    }    
    $status = 'success';
    $return_data['status'] = $status;
    echo json_encode($return_data);
  }
  public function viewattendances(){
    $view_type = isset($_GET['view_type']) ? $_GET['view_type'] : '';
    if ($this->request->is('get')) {
       $current_date = date('Y-m-d');
        $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $selected_year = $this->request->getGet('selected_year', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($selected_year == ''){
          $selected_year = date('Y');
        }
        $selected_month = $this->request->getGet('selected_month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($selected_month == ''){
          $selected_month = date('m');
        }
        if($id == 'all' && ($selected_year == 'all' || $selected_month == 'all')){
          $leave_type = $this->db->table('leavetype')->orderBy('id', 'ASC')->limit(100)->get()->getResultArray();
          $Output_employees = $this->db->table('employees');
          $Output_employees->select('employees.*');
          $Output_employees = $Output_employees->orderBy('employees.id', 'DESC')->get()->getResultArray();
          $month_timesheet = array();
          $month_timesheet_html = '';
          if($Output_employees){
            foreach($Output_employees as $Output_employees_val){
              $employees_name = srting_decrypt($Output_employees_val['first_name']).' '.srting_decrypt($Output_employees_val['last_name']);
              $employees_id = $Output_employees_val['id'];
              $Output_query = $this->db->table('8yxztimesheet');
              $Output_query->where('employees.id',$employees_id);
              $Output_query->select('MONTH(8yxztimesheet.start_time) as month_digit,YEAR(8yxztimesheet.start_time) as mag_year');//,MONTHNAME(8yxztimesheet.start_time) as mag_month
              $Output_query->join('employees', 'employees.id = 8yxztimesheet.employee_id');
              $Output_month = $Output_query->groupBy('MONTH(8yxztimesheet.start_time), YEAR(8yxztimesheet.start_time)')->get()->getResultArray();//->orderBy('8yxztimesheet.start_time', 'DESC')
              if($Output_month){
                  foreach($Output_month as $key=>$Output_month_val){
                    $mag_year = $Output_month_val['mag_year'];
                    $month_digit = $Output_month_val['month_digit'];
                    $mag_month_date = $mag_year.'-'.$month_digit.'-1';
                    $mag_month = date('M',strtotime($mag_month_date));//$Output_month_val['mag_month'];
                    $Query = "SELECT * FROM `8yxztimesheet` WHERE 8yxztimesheet.employee_id = '".$employees_id."' AND Month(start_time) = '".$month_digit."' AND Year(start_time) = '".$mag_year."' ORDER BY `id` DESC";
                    $Output_month_time = $this->db->query($Query)->getResultArray();
                    $working_month_time = 0;
                    if($Output_month_time){
                      foreach($Output_month_time as $key=>$Output_month_time_val){
                        $start_time = $Output_month_time_val['start_time'];
                        $end_time = $Output_month_time_val['end_time'];
                        if($end_time != ''){
                          if($start_time <= $end_time){
                            $total_time = TimeDifferent($start_time,$end_time);
                            $total_time_array = explode(':',$total_time);
                            $hours = isset($total_time_array[0]) ? $total_time_array[0] : 0;
                            $minutus = isset($total_time_array[1]) ? $total_time_array[1] : 0;
                            $working_month_time = $working_month_time + ($hours * 60);
                            $working_month_time = $working_month_time + $minutus;
                          }  
                        }  
                      }
                    }
                    /////////////////////////////////////////
                      //$monthFirstDay = date($mag_year."-".$month_digit."-01");
                      //$monthLastDay = date("2024-4-30",strtotime($monthFirstDay));
                      //$days = date("d", strtotime($monthLastDay));
                      $leave_total_detail = $this->db->query("SELECT selected_hours,selected_mintus FROM 8yxzleave_total WHERE year = '".$mag_year."' AND month = '".$month_digit."'")->getRowArray();
                      $total_working_hour_month = 0;
                      if($leave_total_detail){
                        $hours = $leave_total_detail['selected_hours'];
                        $minutus = $leave_total_detail['selected_mintus'];
                        $total_working_hour_month = $total_working_hour_month + ($hours * 60);
                        $total_working_hour_month = $total_working_hour_month + $minutus;
                      }
                      ///////////////////////////////////////////
                    $working_hours = intdiv($working_month_time, 60);
                    if(strlen($working_hours) == 1){
                      $working_hours = '0'.$working_hours;
                    }  
                    $working_minutus = ($working_month_time % 60);
                    if(strlen($working_minutus) == 1){
                      $working_minutus = '0'.$working_minutus;
                    }
                    $total_hours = $working_hours.':'.$working_minutus;
                    ///////////////////////////////////////
                    $month_total_hours = intdiv($total_working_hour_month, 60);
                    if(strlen($month_total_hours) == 1){
                      $month_total_hours = '0'.$month_total_hours;
                    }  
                    $month_total_minutus = ($total_working_hour_month % 60);
                    if(strlen($month_total_minutus) == 1){
                      $month_total_minutus = '0'.$month_total_minutus;
                    }
                    $final_total_hours = $month_total_hours.':'.$month_total_minutus;
                    //////////////////////////////////////////
                    ///////////////////////////////////////
                    $total_extra_hour_month = $total_working_hour_month - $working_month_time;
                    $final_extra_hours = '00:00';
                    if($total_extra_hour_month > 0){
                      
                    } else{
                      $month_total_extra_hours = intdiv($total_extra_hour_month, 60);
                      if(strlen($month_total_extra_hours) == 1){
                        $month_total_extra_hours = '0'.$month_total_extra_hours;
                      }  
                      $month_total_extra_minutus = ($total_extra_hour_month % 60);
                      if(strlen($month_total_extra_minutus) == 1){
                        $month_total_extra_minutus = '0'.$month_total_extra_minutus;
                      }
                      $month_total_extra_hours = str_replace('-','',$month_total_extra_hours);
                      $month_total_extra_minutus = str_replace('-','',$month_total_extra_minutus);
                      $final_extra_hours = $month_total_extra_hours.':'.$month_total_extra_minutus;
                    }
                    $inner_colum_array = array();
                    $inner_td = '';
                    foreach($leave_type as $leave_type_val){
                      $query_leave_main = "SELECT * FROM 8yxzleave WHERE ((employee_id = '$employees_id') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE_FORMAT(start_date,'%c') = '".$month_digit."' AND DATE_FORMAT(start_date,'%Y') = '".$mag_year."') OR (DATE_FORMAT(end_date,'%c') = '".$month_digit."' AND DATE_FORMAT(end_date,'%Y') = '".$mag_year."')) AND leave_type = '".$leave_type_val['name']."'";
                      //echo $leave_type_val['name'].'<hr>';
                      $query_leave = $this->db->query($query_leave_main)->getResultArray();
                      $leave_day = 0;
                      if($query_leave){
                        foreach ($query_leave as $key => $query_value) {
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
                          $selected_year_inner = $month_digit;
                          if(strlen($month_digit) == 1){
                            $selected_year_inner = '0'.$month_digit;
                          }  
                          $selected_month_inner = $month_digit;
                          if(strlen($month_digit) == 1){
                            $selected_month_inner = '0'.$month_digit;
                          }
                          //echo '<br>--match_selected->';
                          $match_selected = $selected_month_inner.$selected_year_inner;
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
                            //if($month_digit == 'all' || $month_digit == 'all'){
                              if ($curr == 'Sat' || $curr == 'Sun') {
                                  $inner_leave_day--;
                              }
                            // }else{
                            //   if($match_selected == $match_inner){
                            //     //echo 'innnnnnnnnnnnn';
                            //     if ($curr == 'Sat' || $curr == 'Sun') {
                            //         $inner_leave_day--;
                            //     }
                            //   }else{
                            //     $inner_leave_day--;
                            //   }  
                            // }
                          }
                          $leave_day = $leave_day + $inner_leave_day;
                        }
                      }
                      $inner_colum_array[] = $leave_day;
                      $inner_td .= '<td class="">'.$leave_day."</td>";
                    }
                    //////////////////////////////////////////
                    $month_timesheet[] = array(
                      'employees_name'=> $employees_name,
                      'employees_id'=> $employees_id,
                      'month_name'=> $mag_month.' '.$mag_year,
                      'total_hours'=> $total_hours,
                      'current_month'=> $month_digit,
                      'current_year'=> $mag_year,
                      'month_time'=> $working_month_time,
                      'final_total_hours'=> $final_total_hours,
                      'final_extra_hours'=> $final_extra_hours,
                      'inner_colum_array'=> $inner_colum_array,
                    );
                    $month_timesheet_html .= '<tr><td>'.$employees_name.'</td><td>'.$mag_month.' '.$mag_year.'</td><td>'.$final_total_hours.'</td><td>'.$total_hours.'</td><td>'.$final_extra_hours.'</td>'.$inner_td.'</tr>';
                    //$start_time = $Output_val['start_time'];
                    // $end_time = $Output_val['end_time'];
                    // $Output[$key]['total_time'] = TimeDifferent($start_time,$end_time);
                    //printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months,$days, $hours, $minutes, $seconds);
                  }
                //   echo '<pre>';
                //   print_r($month_timesheet);
                //   echo '</pre>';
                //  exit;
              }
              //echo '<hr><hr>';
            }
          }
          $title = 'All Month Employees';
          $data[] = array($title);
          $data[] = array('');
          $data[] = array('Attendances List');
          $first_colum_array = array();
          $first_colum_array[] = 'Employees Name';
          $first_colum_array[] = 'Month';
          $first_colum_array[] = 'Total Hours';
          $first_colum_array[] = 'Working Hours';
          $first_colum_array[] = 'Extra Hours';
          foreach($leave_type as $leave_type_val){
              $first_colum_array[] = $leave_type_val['name'];
          }
          $data[] = $first_colum_array;
          if($view_type == 'pdf'){
            $data_pass = array();
            $data_pass['title'] = $title;
            $data_pass['first_colum_array'] = $first_colum_array;
            $data_pass['month_timesheet_html'] = $month_timesheet_html;
            $data_pass['id'] = $id;
            $dompdf = new Dompdf();
            $html = view('Employees/viewattendances_all_pdf',$data_pass);
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('attendances_report.pdf', [ 'Attachment' => false ]);
            //$dompdf->output('pdfview.pdf');  
            //$dompdf->stream();
          }elseif($view_type == 'exel'){
            foreach ($month_timesheet as $product) {
              $all_inner_colum_array = array();
              $all_inner_colum_array[] = $product['employees_name'];
              $all_inner_colum_array[] = $product['month_name'];
              $all_inner_colum_array[] = $product['final_total_hours'];
              $all_inner_colum_array[] = $product['total_hours'];
              $all_inner_colum_array[] = $product['final_extra_hours'];
              $inner_colum_array = isset($product['inner_colum_array']) ? $product['inner_colum_array'] : array();
              foreach($inner_colum_array as $inner_colum_array_val){
                $all_inner_colum_array[] = $inner_colum_array_val;
              }
              $data[] = $all_inner_colum_array;
            } 
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=month_attendances_report.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = fopen("php://output", "w");
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
          }else{
            $Output_query = $this->db->table('8yxztimesheet');
            //$Output_query->where('employees.id',$id);
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
                //if($selected_year == ''){
                  //$selected_year = $mag_year;
                //}
                $exit_year[$mag_year] = $mag_year;
                //$month_digit = $Output_month_val['month_digit'];
                //$mag_month_date = $mag_year.'-'.$month_digit.'-1';
                //$mag_month = date('M',strtotime($mag_month_date));//$Output_month_val['mag_month'];
              }
            }
          return view('Employees/viewattendances_all', ["leave_type"   => $leave_type,"title" => $title,"products" => array(),"month_timesheet" => $month_timesheet,"id" => $id,'exit_year' => $exit_year,'exit_month' => $exit_month,'selected_year' => '','selected_month' => '','products_leave' => array(),'Output_employees'=>$Output_employees]);
          //echo '<table border="1">'.$month_timesheet_html.'</table>';
          }
          exit;
        }else{
          if($selected_year == 'all' && $selected_month == 'all'){
            $leave_query_run = "SELECT * FROM 8yxzleave WHERE (employee_id = '".$id."') OR (employee_id = 0 AND all_employee = 1) ORDER BY start_date ASC";
          }elseif($selected_year == 'all'){
            $leave_query_run = "SELECT * FROM 8yxzleave WHERE (employee_id = '".$id."') OR (employee_id = 0 AND all_employee = 1) ORDER BY start_date ASC";
          }elseif($selected_month == 'all'){
            $start_selected_date = $selected_year.'-01-01';
            $end_selected_date = $selected_year.'-12-31';
            $leave_query_run = "SELECT * FROM 8yxzleave WHERE ((employee_id = '".$id."') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE(start_date) >= '".$start_selected_date."' AND DATE(start_date) <= '".$end_selected_date."') OR (DATE(end_date) >= '".$start_selected_date."' AND DATE(end_date) <= '".$end_selected_date."'))  ORDER BY start_date ASC";
          }else{
            $start_selected_date = $selected_year.'-'.$selected_month.'-01';
            $lastday = date('t',strtotime($start_selected_date));
            $end_selected_date = $selected_year.'-'.$selected_month.'-'.$lastday;
            $leave_query_run = "SELECT * FROM 8yxzleave WHERE ((employee_id = '".$id."') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE(start_date) >= '".$start_selected_date."' AND DATE(start_date) <= '".$end_selected_date."') OR (DATE(end_date) >= '".$start_selected_date."' AND DATE(end_date) <= '".$end_selected_date."')) ORDER BY start_date ASC";
          }
          //echo $leave_query_run;
          $leave_query = $this->db->query($leave_query_run)->getResultArray();
          ////////////////////////////
          if($leave_query){
            foreach ($leave_query as $key => $query_value) {
              $start=date_create($query_value['start_date']);
              $end=date_create($query_value['end_date']);
              $diff=date_diff($start,$end); 
              $end->modify('+1 day');
              $interval = $end->diff($start);
              $leave_day = $interval->days;
              $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
              foreach($period as $dt) {
                $curr = $dt->format('D');
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $leave_day--;
                }
              }
              if($leave_day > 0){
                $leave_query[$key]['leave_day'] = $leave_day;
              }else{
                unset($leave_query[$key]);
              }
            }
          }
          ///////////////////////////
          $Output_query = $this->db->table('8yxztimesheet');
          //$Output_query->where('employees.id',$id);
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
              //if($selected_year == ''){
                //$selected_year = $mag_year;
              //}
              $exit_year[$mag_year] = $mag_year;
              //$month_digit = $Output_month_val['month_digit'];
              //$mag_month_date = $mag_year.'-'.$month_digit.'-1';
              //$mag_month = date('M',strtotime($mag_month_date));//$Output_month_val['mag_month'];
            }
          }
          ////////////////////////////
          $month_timesheet = array();
          $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();
          $employees_name = '';
          if($employees_detail){
              $employees_name = srting_decrypt($employees_detail['first_name']).' '.srting_decrypt($employees_detail['last_name']);
          }
          $title = ' View Attendances - '.$employees_name;
          $Output_query = $this->db->table('8yxztimesheet');
          $Output_query->where('employees.id',$id);
          if($selected_month == 'all'){

          }else{
            $Output_query->where('Month(8yxztimesheet.start_time)',$selected_month);
          }  
          if($selected_year == 'all'){

          }else{
            $Output_query->where('Year(8yxztimesheet.start_time)',$selected_year);
          }  
          $Output_query->select('timesheet.*,employees.first_name,employees.last_name');
          $Output_query->join('employees', 'employees.id = 8yxztimesheet.employee_id');
          $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
          if($Output){
              foreach($Output as $key=>$Output_val){
                  $start_time = $Output_val['start_time'];
                  $end_time = $Output_val['end_time'];
                  if($end_time == ''){
                    $end_time = '-';
                    $Output[$key]['total_time'] = '0:00';
                  }else{
                      if($start_time <= $end_time){
                        $Output[$key]['total_time'] = TimeDifferent($start_time,$end_time);    
                      }else{
                        $end_time = '-';
                        $Output[$key]['total_time'] = '0:00';
                      }  
                  }
                  $Output[$key]['end_time'] = $end_time;
                  
                  //printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months,$days, $hours, $minutes, $seconds);
              }
          }
          $Output_query = $this->db->table('8yxztimesheet');
          $Output_query->where('employees.id',$id);
          $Output_query->select('MONTH(8yxztimesheet.start_time) as month_digit,YEAR(8yxztimesheet.start_time) as mag_year');//,MONTHNAME(8yxztimesheet.start_time) as mag_month
          $Output_query->join('employees', 'employees.id = 8yxztimesheet.employee_id');
          if($selected_month == 'all'){

          }else{
            $Output_query->where('Month(8yxztimesheet.start_time)',$selected_month);
          }  
          if($selected_year == 'all'){

          }else{
            $Output_query->where('Year(8yxztimesheet.start_time)',$selected_year);
          }  
          $Output_month = $Output_query->groupBy('MONTH(8yxztimesheet.start_time), YEAR(8yxztimesheet.start_time)')->get()->getResultArray();//->orderBy('8yxztimesheet.start_time', 'DESC')
          $month_timesheet = array();
          if($Output_month){
              foreach($Output_month as $key=>$Output_month_val){
                $mag_year = $Output_month_val['mag_year'];
                $month_digit = $Output_month_val['month_digit'];
                $mag_month_date = $mag_year.'-'.$month_digit.'-1';
                $mag_month = date('M',strtotime($mag_month_date));//$Output_month_val['mag_month'];
                $Query = "SELECT * FROM `8yxztimesheet` WHERE 8yxztimesheet.employee_id = '".$id."' AND Month(start_time) = '".$month_digit."' AND Year(start_time) = '".$mag_year."' ORDER BY `id` DESC";
                $Output_month_time = $this->db->query($Query)->getResultArray();
                $working_month_time = 0;
                if($Output_month_time){
                  foreach($Output_month_time as $key=>$Output_month_time_val){
                    $start_time = $Output_month_time_val['start_time'];
                    $end_time = $Output_month_time_val['end_time'];
                    if($end_time != ''){
                      if($start_time <= $end_time){
                        $total_time = TimeDifferent($start_time,$end_time);
                        $total_time_array = explode(':',$total_time);
                        $hours = isset($total_time_array[0]) ? $total_time_array[0] : 0;
                        $minutus = isset($total_time_array[1]) ? $total_time_array[1] : 0;
                        $working_month_time = $working_month_time + ($hours * 60);
                        $working_month_time = $working_month_time + $minutus;
                      }  
                    }  
                  }
                }
                /////////////////////////////////////////
                  //$monthFirstDay = date($mag_year."-".$month_digit."-01");
                  //$monthLastDay = date("2024-4-30",strtotime($monthFirstDay));
                  //$days = date("d", strtotime($monthLastDay));
                  $list=array();
                  $total_working_hour_month = 0;
                  for($d=1; $d<=31; $d++){
                      $time=mktime(12, 0, 0, $month_digit, $d, $mag_year);          
                      if (date('m', $time)==$month_digit){
                          $month_day = date('Y-m-d', $time);
                          $month_show_day = date('Y-m-d D', $time);
                          $month_only_day = date('D', $time);
                          if($month_only_day == 'Sat' || $month_only_day == 'Sun'){

                          }else{
                            //if(strtotime($month_day) <= strtotime($current_date)){
                              $list[] = $month_show_day;
                              $hours = 8;
                              $minutus = 0;
                              $total_working_hour_month = $total_working_hour_month + ($hours * 60);
                              $total_working_hour_month = $total_working_hour_month + $minutus;
                            //}
                          }  
                      }    
                  }
                  // echo "<pre>";
                  // print_r($list);
                  // echo "</pre>";
                  $leave_total_detail = $this->db->query("SELECT selected_hours,selected_mintus FROM 8yxzleave_total WHERE year = '".$mag_year."' AND month = '".$month_digit."'")->getRowArray();
                  $total_working_hour_month = 0;
                  if($leave_total_detail){
                    $hours = $leave_total_detail['selected_hours'];
                    $minutus = $leave_total_detail['selected_mintus'];
                    $total_working_hour_month = $total_working_hour_month + ($hours * 60);
                    $total_working_hour_month = $total_working_hour_month + $minutus;
                  }
                  ///////////////////////////////////////////
                $working_hours = intdiv($working_month_time, 60);
                if(strlen($working_hours) == 1){
                  $working_hours = '0'.$working_hours;
                }  
                $working_minutus = ($working_month_time % 60);
                if(strlen($working_minutus) == 1){
                  $working_minutus = '0'.$working_minutus;
                }
                $total_hours = $working_hours.':'.$working_minutus;
                ///////////////////////////////////////
                $month_total_hours = intdiv($total_working_hour_month, 60);
                if(strlen($month_total_hours) == 1){
                  $month_total_hours = '0'.$month_total_hours;
                }  
                $month_total_minutus = ($total_working_hour_month % 60);
                if(strlen($month_total_minutus) == 1){
                  $month_total_minutus = '0'.$month_total_minutus;
                }
                $final_total_hours = $month_total_hours.':'.$month_total_minutus;
                //////////////////////////////////////////
                ///////////////////////////////////////
                $total_extra_hour_month = $total_working_hour_month - $working_month_time;
                $final_extra_hours = '00:00';
                if($total_extra_hour_month > 0){
                  
                } else{
                  $month_total_extra_hours = intdiv($total_extra_hour_month, 60);
                  if(strlen($month_total_extra_hours) == 1){
                    $month_total_extra_hours = '0'.$month_total_extra_hours;
                  }  
                  $month_total_extra_minutus = ($total_extra_hour_month % 60);
                  if(strlen($month_total_extra_minutus) == 1){
                    $month_total_extra_minutus = '0'.$month_total_extra_minutus;
                  }
                  $month_total_extra_hours = str_replace('-','',$month_total_extra_hours);
                  $month_total_extra_minutus = str_replace('-','',$month_total_extra_minutus);
                  $final_extra_hours = $month_total_extra_hours.':'.$month_total_extra_minutus;
                }
                  
                
                //////////////////////////////////////////
                $month_timesheet[] = array(
                  'month_name'=> $mag_month.' '.$mag_year,
                  'total_hours'=> $total_hours,
                  'current_month'=> $month_digit,
                  'current_year'=> $mag_year,
                  'month_time'=> $working_month_time,
                  'final_total_hours'=> $final_total_hours,
                  'final_extra_hours'=> $final_extra_hours,
                );
                //$start_time = $Output_val['start_time'];
                // $end_time = $Output_val['end_time'];
                // $Output[$key]['total_time'] = TimeDifferent($start_time,$end_time);
                //printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months,$days, $hours, $minutes, $seconds);
              }
            //   echo '<pre>';
            //   print_r($month_timesheet);
            //   echo '</pre>';
            //  exit;
          }
          $Output_employees = $this->db->table('employees');
          $Output_employees->select('employees.*');
          //$Output_employees->where('employees.id',1);
          $Output_employees = $Output_employees->orderBy('employees.id', 'DESC')->get()->getResultArray();
          $leave_type = $this->db->table('leavetype')->orderBy('id', 'ASC')->limit(100)->get()->getResultArray();
          if($id == 'all' && ($view_type == 'exel' || $view_type == 'pdf' || $view_type == '')){
            $title = ' Month Attendances';
            $data[] = array($title);
            $data[] = array('');
            $data[] = array('Attendances List');
            $mag_month_date = $selected_year.'-'.$selected_month.'-1';
            $mag_month = date('M',strtotime($mag_month_date));//$Output_month_val['mag_month'];
            $first_column = $mag_month.' '.$selected_year;
            //$data[] = array($first_column,'TOTAL HOURS','WORKING HOURS');
            $first_colum_array = array();
            $first_colum_array[] = $first_column;
            $first_colum_array[] = 'TOTAL HOURS';
            $first_colum_array[] = 'WORKING HOURS';
            foreach($leave_type as $leave_type_val){
                $first_colum_array[] = $leave_type_val['name'];
            }
            $data[] = $first_colum_array;
            $leave_total_detail = $this->db->query("SELECT selected_hours,selected_mintus FROM 8yxzleave_total WHERE year = '".$selected_year."' AND month = '".$selected_month."'")->getRowArray();
            $total_working_hour_month = 0;
            if($leave_total_detail){
              $hours = $leave_total_detail['selected_hours'];
              $minutus = $leave_total_detail['selected_mintus'];
              $total_working_hour_month = $hours.':'.$minutus;
            }
            $month_timesheet_html = '';
            if($Output_employees){
              foreach($Output_employees as $Output_employees_val){
                $employees_name = srting_decrypt($Output_employees_val['first_name']).' '.srting_decrypt($Output_employees_val['last_name']);
                $employees_id = $Output_employees_val['id'];
                $Output_query_loop = $this->db->table('8yxztimesheet');
                $Output_query_loop->where('employees.id',$employees_id);
                $Output_query_loop->select('MONTH(8yxztimesheet.start_time) as month_digit,YEAR(8yxztimesheet.start_time) as mag_year');//,MONTHNAME(8yxztimesheet.start_time) as mag_month
                $Output_query_loop->join('employees', 'employees.id = 8yxztimesheet.employee_id');
                $Output_query_loop->where('Month(8yxztimesheet.start_time)',$selected_month);
                $Output_query_loop->where('Year(8yxztimesheet.start_time)',$selected_year);
                $Output_month_loop = $Output_query_loop->groupBy('MONTH(8yxztimesheet.start_time), YEAR(8yxztimesheet.start_time)')->get()->getResultArray();//->orderBy('8yxztimesheet.start_time', 'DESC')
                $month_timesheet = array();
                $total_hours = '00:00';
                if($Output_month_loop){
                    foreach($Output_month_loop as $key=>$Output_month_loop_val){
                      $mag_year = $Output_month_loop_val['mag_year'];
                      $month_digit = $Output_month_loop_val['month_digit'];
                      $mag_month_date = $mag_year.'-'.$month_digit.'-1';
                      $mag_month = date('M',strtotime($mag_month_date));//$Output_month_loop_val['mag_month'];
                      $Query = "SELECT * FROM `8yxztimesheet` WHERE 8yxztimesheet.employee_id = '".$employees_id."' AND Month(start_time) = '".$month_digit."' AND Year(start_time) = '".$mag_year."' ORDER BY `id` DESC";
                      $Output_month_loop_time = $this->db->query($Query)->getResultArray();
                      $working_month_time = 0;
                      if($Output_month_loop_time){
                        foreach($Output_month_loop_time as $key=>$Output_month_loop_time_val){
                          $start_time = $Output_month_loop_time_val['start_time'];
                          $end_time = $Output_month_loop_time_val['end_time'];
                          if($end_time != ''){
                            if($start_time <= $end_time){
                              $total_time = TimeDifferent($start_time,$end_time);
                              $total_time_array = explode(':',$total_time);
                              $hours = isset($total_time_array[0]) ? $total_time_array[0] : 0;
                              $minutus = isset($total_time_array[1]) ? $total_time_array[1] : 0;
                              $working_month_time = $working_month_time + ($hours * 60);
                              $working_month_time = $working_month_time + $minutus;
                            }  
                          }  
                        }
                      }
                      $working_hours = intdiv($working_month_time, 60);
                      if(strlen($working_hours) == 1){
                        $working_hours = '0'.$working_hours;
                      }  
                      $working_minutus = ($working_month_time % 60);
                      if(strlen($working_minutus) == 1){
                        $working_minutus = '0'.$working_minutus;
                      }
                      $total_hours = $working_hours.':'.$working_minutus;
                    }
                }
                $inner_td = '';
                $inner_colum_array = array();
                $inner_colum_array[] = $employees_name;
                $inner_colum_array[] = $total_working_hour_month;
                $inner_colum_array[] = $total_hours;
                foreach($leave_type as $leave_type_val){
                  $query_leave_main = "SELECT * FROM 8yxzleave WHERE ((employee_id = '$employees_id') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE_FORMAT(start_date,'%c') = '".$selected_month."' AND DATE_FORMAT(start_date,'%Y') = '".$selected_year."') OR (DATE_FORMAT(end_date,'%c') = '".$selected_month."' AND DATE_FORMAT(end_date,'%Y') = '".$selected_year."')) AND leave_type = '".$leave_type_val['name']."'";
                  //echo $leave_type_val['name'].'<hr>';
                  $query_leave = $this->db->query($query_leave_main)->getResultArray();
                  $leave_day = 0;
                  if($query_leave){
                    foreach ($query_leave as $key => $query_value) {
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
                      $selected_year_inner = $selected_year;
                      if(strlen($selected_year) == 1){
                        $selected_year_inner = '0'.$selected_year;
                      }  
                      $selected_month_inner = $selected_month;
                      if(strlen($selected_month) == 1){
                        $selected_month_inner = '0'.$selected_month;
                      }
                      //echo '<br>--match_selected->';
                      $match_selected = $selected_month_inner.$selected_year_inner;
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
                  $inner_colum_array[] = $leave_day;
                  $inner_td .= '<td class="">'.$leave_day."</td>";

                }
                $month_timesheet_html .= '<tr><td>'.$employees_name.'</td><td>'.$total_working_hour_month.'</td><td>'.$total_hours.'</td>'.$inner_td.'</tr>';
                //$data[] = array($employees_name,$total_working_hour_month,$total_hours);
                $data[] = $inner_colum_array;
              }
            }
            if($view_type == 'pdf'){
              $data_pass = array();
              $data_pass['title'] = $title;
              $data_pass['first_colum_array'] = $first_colum_array;
              $data_pass['month_timesheet_html'] = $month_timesheet_html;
              $data_pass['id'] = $id;
              $dompdf = new Dompdf();
              $html = view('Employees/viewattendances_all_pdf',$data_pass);
              $dompdf->loadHtml($html);
              $dompdf->render();
              $dompdf->stream('attendances_report.pdf', [ 'Attachment' => false ]);
              //$dompdf->output('pdfview.pdf');  
              //$dompdf->stream();
            }elseif($view_type == 'exel'){
              echo '<pre>';
              print_r($data);
              exit;
              header("Content-type: text/csv");
              header("Content-Disposition: attachment; filename=month_attendances_report.csv");
              header("Pragma: no-cache");
              header("Expires: 0");
              $output = fopen("php://output", "w");
              foreach ($data as $row) {
                  fputcsv($output, $row);
              }
              fclose($output);
            }else{
              return view('Employees/viewallattendances', ["id"   => $id,"title"   => $title,"first_colum_array" => $first_colum_array,"month_timesheet_html" => $month_timesheet_html,"leave_type" => $leave_type,'exit_year' => $exit_year,'exit_month' => $exit_month,'selected_year' => $selected_year,'selected_month' => $selected_month,'Output_employees'=>$Output_employees]);
            }
            exit;
          }elseif($view_type == 'exel'){
            $title = ' Attendances - '.$employees_name;
            $data[] = array($title);
            $data[] = array('Month Wise');
            //$data[] = array('');
            $first_colum_array = array();
            $first_colum_array[] = 'Month';
            $first_colum_array[] = 'TOTAL HOURS';
            $first_colum_array[] = 'WORKING HOURS';
            $first_colum_array[] = 'Extra Hours';
            foreach($leave_type as $leave_type_val){
                $first_colum_array[] = $leave_type_val['name'];
            }
            $data[] = $first_colum_array;
            foreach ($month_timesheet as $product) {
              ////////////////////////////
              $inner_colum_array = array();
              $inner_colum_array[] = $product['month_name'];
              $inner_colum_array[] = $product['final_total_hours'];
              $inner_colum_array[] = $product['total_hours'];
              $inner_colum_array[] = $product['final_extra_hours'];
              foreach($leave_type as $leave_type_val){
                $query_leave_main = "SELECT * FROM 8yxzleave WHERE ((employee_id = '$id') OR (employee_id = 0 AND all_employee = 1)) AND ((DATE_FORMAT(start_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(start_date,'%Y') = '".$product['current_year']."') OR (DATE_FORMAT(end_date,'%c') = '".$product['current_month']."' AND DATE_FORMAT(end_date,'%Y') = '".$product['current_year']."')) AND leave_type = '".$leave_type_val['name']."'";
                //echo $leave_type_val['name'].'<hr>';
                $query_leave = $this->db->query($query_leave_main)->getResultArray();
                $leave_day = 0;
                if($query_leave){
                  foreach ($query_leave as $key => $query_value) {
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
                    $selected_year_inner = $selected_year;
                    if(strlen($selected_year) == 1){
                      $selected_year_inner = '0'.$selected_year;
                    }  
                    $selected_month_inner = $selected_month;
                    if(strlen($selected_month) == 1){
                      $selected_month_inner = '0'.$selected_month;
                    }
                    //echo '<br>--match_selected->';
                    $match_selected = $selected_month_inner.$selected_year_inner;
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
                $inner_colum_array[] = $leave_day;
              
              }
              $data[] = $inner_colum_array;
              //////////////////////////////////////
              //$data[] = array($product['month_name'],$product['final_total_hours'],$product['total_hours'],$product['final_extra_hours']);
            }
            $data[] = array('');
            $data[] = array('Attendances List');
            $data[] = array('Check In','Check Out','Working Hours');
            foreach ($Output as $product) {
              $data[] = array($product['start_time'],$product['end_time'],$product['total_time']);
            }
            echo '<pre>';
            print_r($data);
            exit;
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=attendances_report.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = fopen("php://output", "w");
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
            exit;
          }elseif($view_type == 'pdf'){
            $data_pass = array();
            $title = ' Attendances - '.$employees_name;
            $data_pass['title'] = $title;
            $data_pass['products'] = $Output;
            $data_pass['leave_type'] = $leave_type;
            $data_pass['selected_year'] = $selected_year;
            $data_pass['selected_month'] = $selected_month;
            $data_pass['month_timesheet'] = $month_timesheet;
            $data_pass['id'] = $id;
            $dompdf = new Dompdf();
            $html = view('Employees/viewattendances_pdf',$data_pass);
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('attendances_report.pdf', [ 'Attachment' => false ]);
            //$dompdf->output('pdfview.pdf');  
            //$dompdf->stream();
            exit;
          }else{  
            return view('Employees/viewattendances', ["leave_type"   => $leave_type,"title" => $title,"products" => $Output,"month_timesheet" => $month_timesheet,"id" => $id,'exit_year' => $exit_year,'exit_month' => $exit_month,'selected_year' => $selected_year,'selected_month' => $selected_month,'products_leave' => $leave_query,'Output_employees'=>$Output_employees]);
          }  
      }    
    } else if ($this->request->is('post')) {
      $update_type = isset($_POST['update_type']) ? $_POST['update_type'] : '';
      $db_id = isset($_POST['db_id']) ? $_POST['db_id'] : 0;
      $p = isset($_POST['p']) ? $_POST['p'] : 0;
      $new_time = isset($_POST['new_time']) ? $_POST['new_time'] : '';
      $selected_year = isset($_POST['selected_year']) ? $_POST['selected_year'] : '';
      $selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : '';
      $current_date = date('Y-m-d H:i:s');
      if($update_type == "checkin"){
          $data = [
            'start_time' => $new_time,
        ];
        /************************ */
        $old_data = $this->db->query("SELECT * FROM 8yxztimesheet WHERE id = '$db_id'")->getRowArray();
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $data;
        $data_log = [
          'EventType' => 'Check In Time',
          'Date' => $current_date,
          'Product_Id' => $db_id,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
          'staffId' => $p,
        ];   
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log);
        /************************ */
        $builder = $this->db->table('timesheet');
        $builder->where('id', $db_id);
        $builder->update($data);
        $redirect_url = url_to('Employees::viewattendances').'?p='.$p.'&selected_year='.$selected_year.'&selected_month='.$selected_month;
        return redirect()->to($redirect_url);
      }elseif($update_type == "checkout"){
          $data = [
            'end_time' => $new_time,
        ];
        /****************************** */
        $old_data = $this->db->query("SELECT * FROM 8yxztimesheet WHERE id = '$db_id'")->getRowArray();
        $EventDetails['old_data'] = $old_data;
        $EventDetails['new_data'] = $data;
        $data_log = [
          'EventType' => 'Check Out Time',
          'Date' => $current_date,
          'Product_Id' => $db_id,                
          'EventDetails' => json_encode($EventDetails),
          'User' => auth()->user()->username,
          'staffId' => $p,
        ];    
        $builder_log = $this->db->table('log');
        $builder_log->insert($data_log);
        /****************************** */
        $builder = $this->db->table('timesheet');
        $builder->where('id', $db_id);
        $builder->update($data);
        $redirect_url = url_to('Employees::viewattendances').'?p='.$p.'&selected_year='.$selected_year.'&selected_month='.$selected_month;
        return redirect()->to($redirect_url);
      }
      return redirect()->to(url_to('Employees::list'));

    }else{
        return redirect()->to(url_to('Employees::list'));
    }
    

  }
   public function holidayEmployee(){
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();
      $employees_name = '';
        if($query){
            $employees_name = srting_decrypt($query['first_name']).' '.srting_decrypt($query['last_name']);
        }
      $PN = $query['id'];
      $title = "Holiday Employee $employees_name";
      $leave_type = $this->db->table('leavetype')->where('name','Holiday')->orderBy('name', 'ASC')->get()->getResultArray();
      return view('Employees/holidayEmployees', [
        "title" => $title,
        "result"   => $query,
        "leave_type"   => $leave_type,
      ]);
    } else if ($this->request->is('post')) {
        $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $how_many = isset($_POST['how_many']) ? $_POST['how_many'] : array();
          if($how_many){
            foreach($how_many as $key=>$how_many_val){
              foreach($how_many_val as $keyinner=>$how_many_val_val){
                if($how_many_val_val == ''){
                  $how_many_val_val = 0;
                }
                if($how_many_val_val >= 0){
                  $old_data = $this->db->query("SELECT * FROM 8yxzemployees_how_many WHERE employee_id = '".$id."' AND year = '".$key."' AND leavetype_id = '".$keyinner."'")->getRowArray();
                  if($old_data){
                    $data = [
                        'value_data' => $how_many_val_val,
                    ];
                    $builder = $this->db->table('employees_how_many');
                    $builder->where('employee_id', $id);
                    $builder->where('year', $key);
                    $builder->where('leavetype_id', $keyinner);
                    $builder->update($data);
                  }else{
                    $data = [
                        'employee_id' => $id,
                        'year' => $key,
                        'leavetype_id' => $keyinner,
                        'value_data' => $how_many_val_val
                    ];
                    $builder = $this->db->table('employees_how_many');
                    $builder->insert($data);
                  }
                 // echo $key.'---'.$keyinner.'--'.$how_many_val_val.'<br>';
                }   
              }
            }
          }
        //   echo '<pre>';
        //   print_r($_POST);
        //   exit;
        return redirect()->to(url_to('Employees::list'))->with("message", $id . " - ID holiday updated");

    }
}
public function delete_attendances(){
    $id = $this->request->getPost('main_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $employee_id = $this->request->getPost('employee_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = $this->db->query("SELECT * FROM 8yxztimesheet WHERE id = '$id'")->getRowArray();
    $this->db->query("delete from `8yxztimesheet` WHERE `id` = '$id'");
    $data = [

      'EventType' => 'Attendances Deleted',
      'Product_Id' => $id,
      'EventDetails' => json_encode($query),
      'User' => auth()->user()->username,
    ];
    $builder = $this->db->table('log');
    $builder->insert($data);
    $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
    $selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : '';
    $selected_year = isset($_POST['selected_year']) ? $_POST['selected_year'] : ''; 
    return redirect()->to(url_to('Employees::viewattendances').'?p='.$employee_id.'&selected_month='.$selected_month.'&selected_year='.$selected_year)->with("message", "Attendances deleted");
  }
}