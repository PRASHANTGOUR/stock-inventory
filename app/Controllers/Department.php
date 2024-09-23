<?php



namespace App\Controllers;



# Add the Model

use App\Models\AdminModel;



class Department extends BaseController

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



    $Output_query = $this->db->table('departments');

    if($search != ''){

      $Output_query->like('department',$search);

    }

    $Output = $Output_query->get()->getResultArray();



    $title = 'Departments';

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

      "Departments/index",

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



    public function addDepartment()

    {

    if ($this->request->is('post')) {

        $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $id = $this->request->getPost('id');

        $department = $this->request->getPost('department');

        $color_code = $this->request->getPost('color_code');

        

        $data = [

            'department' => $department,

            'color_code' => $color_code

        ];

  

        $builder = $this->db->table('departments');

        $builder->insert($data);

        $product_id = $this->db->insertID();

                

        return redirect()->to(url_to('Department::list'));

    } else {

        $title = "Add New Department";

        return view('Departments/addDepartment', [

            "title" => $title,

        ]);

        }

    }

    

    #Edit a P No

  public function editDepartment()

  {

    if ($this->request->is('get')) {

      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = $this->db->query("SELECT * FROM 8yxzdepartments WHERE id = '$id'")->getRowArray();

      $PN = $query['id'];



      $title = "Edit Department $PN";

      return view('Departments/editDepartment', [

        "title" => $title,

        "result"   => $query,

      ]);

    } else if ($this->request->is('post')) {

      $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $department = $this->request->getPost('department', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $color_code = $this->request->getPost('color_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



      $data = [

        'department' => $department,

        'color_code' => $color_code

      ];



      $builder = $this->db->table('departments');

      $builder->where('id', $id);

      $builder->update($data);



      return redirect()->to(url_to('Department::list'))

                       ->with("message", $id . " - ID updated");

    }

  }
  public function deleteDepartment(){

    $id = $this->request->getPost('department_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query_department = $this->db->query("SELECT * FROM 8yxzdepartments WHERE id = '$id'")->getRowArray();
    $this->db->query("delete from `8yxzdepartments` WHERE `id` = '$id'");
    $query_department_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE department_id = '$id'")->getResultArray();
    $query_employees = array();
    $query_auth_identities = array();
    $query_leave = array();
    $query_task = array();
    if($query_department_employees){
      foreach($query_department_employees as $query_department_employees_val){
        $user_id = $query_department_employees_val['id'];
        $query_employees[$user_id] = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$user_id'")->getRowArray();
        $this->db->query("delete from `8yxzemployees` WHERE `id` = '$user_id'");
        $query_users = $this->db->query("SELECT * FROM 8yxzusers WHERE employees = '$user_id'")->getRowArray();
        
        if($query_users){
          $query_users_id = $query_users['id'];
          $query_auth_identities[$user_id] = $this->db->query("SELECT * FROM 8yxzauth_identities WHERE user_id = '$query_users_id'")->getRowArray();
          $this->db->query("delete from `8yxzauth_identities` WHERE `user_id` = '$query_users_id'");
        }
        $this->db->query("delete from `8yxzusers` WHERE `employees` = '$user_id'");
        $query_leave[$user_id] = $this->db->query("SELECT * FROM 8yxzleave WHERE employee_id = '$user_id'")->getResultArray();
        $this->db->query("delete from `8yxzleave` WHERE `employee_id` = '$user_id'");
        $query_task[$user_id] = $this->db->query("SELECT * FROM 8yxztask WHERE employee_id = '$user_id'")->getResultArray();
        $this->db->query("delete from `8yxztask` WHERE `employee_id` = '$user_id'");
      }
    }
    $data = [
      'EventType' => 'Department Deleted',
      'Product_Id' => $id,
      'EventDetails' => 'Status Changed to Deleted - Product ID:'.$id.'===='.json_encode($query_department).'===='.json_encode($query_employees).'===='.json_encode($query_leave).'===='.json_encode($query_task).'===='.json_encode($query_users).'===='.json_encode($query_auth_identities),
      'User' => auth()->user()->username,
    ];
    $builder = $this->db->table('log');
    $builder->insert($data);
    return redirect()->to(url_to('Department::list'))->with("message", "Department deleted");
  }




}