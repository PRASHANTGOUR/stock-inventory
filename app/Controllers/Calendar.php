<?php

namespace App\Controllers;

# Add the Model
use App\Models\AdminModel;

class Calendar extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
    }

      #View All Units
  public function list()
  {
    // Calendar Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
        $select_department_id = $this->request->getGet('department_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      if($select_department_id != ''){
          $Output = $this->db->table('leave')
          ->select('leave.*,employees.first_name,employees.last_name,departments.department,departments.color_code')
          ->join('employees', 'employees.id = leave.employee_id','left')
          ->join('departments', 'departments.id = employees.department_id','left')
          ->where('departments.id', $select_department_id)
          ->orderBy('employees.id', 'DESC')
          ->get()
          ->getResultArray();
      }else{
          $Output = $this->db->table('leave')
          ->select('leave.*,employees.first_name,employees.last_name,departments.department,departments.color_code')
          ->join('employees', 'employees.id = leave.employee_id','left')
          ->join('departments', 'departments.id = employees.department_id','left')
          ->orderBy('employees.id', 'DESC')
          ->get()
          ->getResultArray();
      }
    $departments = $this->db->table('departments')
        ->orderBy('department', 'ASC')
        ->get()
        ->getResultArray();
    $title = 'Calendar';
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
      "Calendar/index",
      [
        "title" => $title,
        'select_department_id' => $select_department_id,
        "departments" => $departments,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );
  }
    public function detail()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
      $PN = $query['id'];
      $title = "View Employees Leave Detail $PN";
      $employees = $this->db->table('employees')
    ->orderBy('email', 'ASC')
    ->limit(100)
    ->get()
    ->getResultArray();
      return view('EmployeesLeave/detailEmployeesLeave', [
        "title" => $title,
        "result"   => $query,
        "employees"   => $employees,
      ]);
    } else{

      return redirect()->to(url_to('Calendar::list'));
    }
  }
}