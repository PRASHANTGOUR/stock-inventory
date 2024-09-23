<?php



namespace App\Controllers;



# Add the Model

use CodeIgniter\Shield\Entities\User;

use App\Models\AdminModel;



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

    // Department Data

    /*

        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";

        $Output = $this->db->query($Query)->getResultArray();

        */

        

        $search = isset($_POST['search']) ? $_POST['search'] : '';

        $Output_query = $this->db->table('employees');

        if($search != ''){

            $Output_query->groupStart();

                $Output_query->like('first_name',$search);

                $Output_query->orLike('last_name',$search);

                $Output_query->orLike('email',$search);

                $Output_query->orLike('phone_number',$search);

            $Output_query->groupEnd();

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

        $how_many_holidays = $this->request->getPost('how_many_holidays');

        $address = $this->request->getPost('address');

        $password = $this->request->getPost('password');

        

        $data = [

            'department_id' => $department_id,

            'first_name' => $first_name,

            'last_name' => $last_name,

            'email' => $email,

            'phone_number' => $phone_number,

            'how_many_holidays' => $how_many_holidays,

            'address' => $address,

        ];

  

        $builder = $this->db->table('employees');

        $builder->insert($data);

        $employees = $this->db->insertID();

            

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

  public function editEmployee()

  {

    if ($this->request->is('get')) {

      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();

      $PN = $query['id'];



      $title = "Edit Employee $PN";

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

        $department_id = $this->request->getPost('department_id');

        $first_name = $this->request->getPost('first_name');

        $last_name = $this->request->getPost('last_name');

        $email = $this->request->getPost('email');

        $phone_number = $this->request->getPost('phone_number');

        $how_many_holidays = $this->request->getPost('how_many_holidays');

        $address = $this->request->getPost('address');

        

        $data = [

            'department_id' => $department_id,

            'first_name' => $first_name,

            'last_name' => $last_name,

            //'email' => $email,

            'phone_number' => $phone_number,

            'how_many_holidays' => $how_many_holidays,

            'address' => $address,

        ];



      $builder = $this->db->table('employees');

      $builder->where('id', $id);

      $builder->update($data);

      /////////////////////////

      $username = $first_name.''.$last_name;

            $email = $email;

      $data = [

            'username' => $username,

        ];



      $builder = $this->db->table('users');

      $builder->where('employees', $id);

      $builder->update($data);



      return redirect()->to(url_to('Employees::list'))

                       ->with("message", $id . " - ID updated");

    }

  }

  public function deleteEmployee()

  {

    $id = $this->request->getPost('employee_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

  

    return redirect()->to(url_to('Employees::list'))

    ->with("message", "Employee deleted");



  }
  public function permission_list(){
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $Output_query = $this->db->table('employees');
    if($search != ''){
        $Output_query->groupStart();
            $Output_query->like('first_name',$search);
            $Output_query->orLike('last_name',$search);
            $Output_query->orLike('email',$search);
            $Output_query->orLike('phone_number',$search);
        $Output_query->groupEnd();
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
    $main_query = "SELECT * FROM 8yxzauth_permissions_users WHERE user_id = '".$user_id."' AND permission = '".$permission."'";
    $query = $this->db->query($main_query)->getRowArray();
    if(!empty($query)){
      $this->db->query("delete from `8yxzauth_permissions_users` WHERE user_id = '".$user_id."' AND permission = '".$permission."'");
    }else{  
      $data = [
        'user_id' => $user_id,
        'permission' => $permission,
      ];
      $builder = $this->db->table('auth_permissions_users');
      $builder->insert($data);
    }
    $status = 'success';
    $return_data['status'] = $status;
    echo json_encode($return_data);
  }
}