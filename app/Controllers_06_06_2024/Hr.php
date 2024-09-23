<?php

namespace App\Controllers;

# Add the Model
use App\Models\HrModel;

class Hr extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
      $this->encrypter = \Config\Services::encrypter();
    }

    public function EncryptionTest()
    {
        # Encryption Test
        $encrypter = \Config\Services::encrypter();

        $String = "Bob the builder";
        echo "Original: $String <br/>";
        $Encrypted = $encrypter->encrypt($String);
        echo "Encrypted: $Encrypted <br />";
        $Decrypted = $encrypter->decrypt($Encrypted);
        echo "Decrypted: $Decrypted <br />";
    }

  public function listStaff()
  {
    $Output = $this->db->table('_staff')
                        ->get()
                        ->getResultArray();

    $teams = $this->db->table('department')
                      ->get()
                      ->getResultArray();

    $departments = $this->db->table('_departments')
                      ->get()
                      ->getResultArray();

    $users = $this->db->table('users')
                      ->select('staff_id')
                      ->get()
                      ->getResultArray();


    $title = 'Staff';

    # Output results to template
    return view(
      "Hr/index",
      [
        "title" => $title,
        "staffs" => $Output,
        "teams" => $teams,
        "departments" => $departments,
        "users" => $users,
        //'pager_links' => $pager_links,

      ]
    );
  }

  public function addStaff()
  {
    if ($this->request->is('post')) {
      $encrypter = \Config\Services::encrypter();

      $this->request->getPost(NULL, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $aqId = $this->request->getPost('aqId');
      $name = base64_encode($encrypter->encrypt($this->request->getPost('name')));
      $department = $this->request->getPost('department');
      $team = $this->request->getPost('team');

      $data = [
        'aqId' => $aqId,
        'name' => $name,
        'team' => $team,
        'departmentId' => $department,

      ];

      $builder = $this->db->table('_staff');
      $builder->insert($data);
       
      return redirect()->to(url_to('Hr::listStaff'))
                        ->with("message", $this->request->getPost('name')."- Staff saved");

    } else {
    
      $teams = $this->db->table('department')
                         ->get()
                         ->getResultArray();

      $title = 'Add Staff';

      return view(
        "Hr/addStaff",
        [
          "title" => $title,
          "teams" => $teams,
          
        ]
      );
    }
  }

  #Search Units
  public function searchUnits()
  {
    $search = $this->request->getPost('search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Department Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `pnumber` LIKE '%".$search."%' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray(); 
        */
    $Output = $this->db->table('products')
      ->where('status', 'Design')
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
      "Design/index",
      [
        "title" => $title,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );
  }

  #Edit a P No
  public function editUnit()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzproducts WHERE product_id = '$id'")->getRowArray();
      $PN = $query['pnumber'];

      $title = "Edit Unit $PN";
      return view('Production/editUnit', [
        "title" => $title,
        "result"   => $query,
      ]);
    } else if ($this->request->is('post')) {
      $id = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_pnumber = $this->request->getPost('d_pnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_aqcode = $this->request->getPost('d_aqcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_productname = $this->request->getPost('d_productname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Notes = $this->request->getPost('Notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $status = $this->request->getPost('d_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Deadline = $this->request->getPost('deadline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $data = [
        'pnumber' => $d_pnumber,
        'aqcode' => $d_aqcode,
        'productname' => $d_productname,
        'Notes' => $Notes,
        'status' => $status,
        'Deadline' => $Deadline
      ];

      $builder = $this->db->table('products');
      $builder->where('product_id', $id);
      $builder->update($data);
  
      $data = [
        'EventType' => 'ProductEdit',
        'Product_Id' => $id,
        'EventDetails' => 'Product Edit (Design) - PN: ' . $d_pnumber . ' New Values:' . implode(",", $data),
        'User' => auth()->user()->username,
      ];
      $builder = $this->db->table('log');
      $builder->insert($data);

      return redirect()->to(url_to('Design::units'))
                        ->with("message", $d_pnumber . " - P Number updated");
    }
  }

}