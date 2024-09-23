<?php

namespace App\Controllers;

# Add the Model
use App\Models\AdminModel;

class Leave extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
    }

      #View All Units
  public function list()
  {
    // Leave Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
    /*$Output = $this->db->table('leave')
      ->select('leave.*,employees.first_name,employees.last_name')
      ->join('employees', 'employees.id = leave.employee_id')
      ->orderBy('employees.id', 'DESC')
      ->where('employees.id', auth()->user()->employees)
      ->get()
      ->getResultArray();*/
    $title = 'Leave';
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
    /*return view(
      "Leave/index",
      [
        "title" => $title,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );*/
        $id = auth()->user()->employees;
      $query = $this->db->query("SELECT * FROM 8yxzleave WHERE (employee_id = '$id') OR (employee_id = 0 AND all_employee = 1) ORDER BY start_date ASC")->getResultArray();
      $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$id'")->getRowArray();
      $employees_name = '';
      if($employees_detail){
        $employees_name = $employees_detail['first_name'].' '.$employees_detail['last_name'];
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
        "id"   => $id,
      ]);
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

    public function addLeave()
    {
        if ($this->request->is('post')) {
            $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $this->request->getPost('id');
            $employee_id = auth()->user()->employees;
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            $leave_type = $this->request->getPost('leave_type');
            $remark = $this->request->getPost('remark');
            
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
                    
            return redirect()->to(url_to('Leave::list'));
        } else {
            $leave_type = $this->db->table('leavetype')
            ->orderBy('name', 'ASC')
            ->limit(100)
            ->get()
            ->getResultArray();
            $title = "Add New Leave";
            return view('Leave/addLeave', [
                "title" => $title,
                 "leave_type" => $leave_type,
            ]);
        }
    }
    
    #Edit a P No
  public function editLeave()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzleave WHERE id = '$id'")->getRowArray();
      $PN = $query['id'];
      $title = "Edit Leave $PN";
       $leave_type = $this->db->table('leavetype')
            ->orderBy('name', 'ASC')
            ->limit(100)
            ->get()
            ->getResultArray();
      return view('Leave/editLeave', [
        "title" => $title,
        "result"   => $query,
         "leave_type" => $leave_type,
      ]);
    } else if ($this->request->is('post')) {
         $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $leave_type = $this->request->getPost('leave_type');
        $remark = $this->request->getPost('remark');
        
        $data = [
            // 'start_date' => $start_date,
            // 'end_date' => $end_date,
            'leave_type' => $leave_type,
            'remark' => $remark
        ];
      $builder = $this->db->table('leave');
      $builder->where('id', $id);
      $builder->update($data);

      return redirect()->to(url_to('Leave::list'))
                       ->with("message", $id . " - ID updated");
    }
  }
  
  public function checkLeave()
  {
    
    $employee_id = auth()->user()->employees;
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $leave_type = isset($_POST['leave_type']) ? $_POST['leave_type'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    
    $status = 'error';
    $field = '';
    $message = '';
    $url = '';
    // echo $start_date;die;
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
        
        $duplicates_found = 0;
        $duplicates_msg = '';
        
        $employees_detail = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employee_id'")->getRowArray();
        $employees_name = '';
        if($employees_detail){
            $employees_name = $employees_detail['first_name'].' '.$employees_detail['last_name'];
        }
        foreach($period as $dt) {
            $check_date = $dt->format('Y-m-d');
            $main_query = "SELECT * FROM 8yxzleave WHERE employee_id = '".$employee_id."' AND DATE(start_date) <= '".$check_date."' AND DATE(end_date) >= '".$check_date."'";
            $query = $this->db->query($main_query)->getResultArray();
            if(count($query) > 0){
                $duplicates_found = 1;
                $duplicates_msg .= $employees_name.' '.date('d-m-Y',strtotime($check_date)).' Date Allready assign.<br>';
            }    
        }  
        
        if($duplicates_found == 1){
            $status = 'error';
            $field = 'start_date_error';
            $message = $duplicates_msg;
        }else{
            
            if( $employee_id ){
                
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
                
                $status = 'success';
                $field = '';
                $message = '';
                $url = url_to('Leave::list');
                   
            } else {
                $status = 'error';
                $field = '';
                $message = 'Employee Not Found';
                $url = '';
            }
            
        }
    }
    
    $return_data['status'] = $status;
    $return_data['field'] = $field;
    $return_data['message'] = $message;
    $return_data['url'] = $url;
    echo json_encode($return_data);
  }


}