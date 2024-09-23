<?php

namespace App\Controllers;

# Add the Model
use App\Models\AdminModel;

class Calendaremployees extends BaseController
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
    return view(
      "Calendar/employeescalendar",
      [
        "title" => $title,
        'select_department_id' => $select_department_id,
        "departments" => $departments,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );
  }
}