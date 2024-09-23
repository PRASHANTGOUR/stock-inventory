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


}