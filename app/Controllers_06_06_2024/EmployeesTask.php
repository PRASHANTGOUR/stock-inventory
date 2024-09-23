<?php

namespace App\Controllers;

# Add the Model
use App\Models\AdminModel;

class EmployeesTask extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
    }

      #View All Units
  public function list()
  {
    // EmployeesTask Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $Output_query = $this->db->table('task');
        if($search != ''){
            $Output_query->groupStart();
                $Output_query->like('employees.first_name',$search);
                $Output_query->orLike('employees.last_name',$search);
                $Output_query->orLike('task.remark',$search);
            $Output_query->groupEnd(); 
        }
        $Output_query->select('task.*,employees.first_name,employees.last_name');
        $Output_query->join('employees', 'employees.id = task.employee_id');
        $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
      if($Output){
        foreach ($Output as $key => $Output_value) {
          $start_end_detail = $this->db->query("SELECT * FROM 8yxztask_start_end WHERE task_id = '".$Output_value['id']."'")->getResultArray();
          $start_end_html = '';
          $timing = '';
          if($start_end_detail){
            foreach($start_end_detail as $start_end_detail_val){
              $start_time = $start_end_detail_val['start_time'];
              $end_time = $start_end_detail_val['end_time'];
              if($start_time != "0000-00-00 00:00:00"){
                if($end_time == "0000-00-00 00:00:00"){
                  $timing .= $start_time.'====NO END<br>';
                  $start_end_html = '<a href="'.url_to('EmployeesTask::addStartEnd').'?p='.$Output_value['id'].'&main='.$start_end_detail_val['id'].'&action_flage=end" class="btn btn-sm btn-danger bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">End Time </a>';

                }else{
                  $timing .= $start_time.'===='.$end_time.'<br>';
                  $start_end_html = '<a href="'.url_to('EmployeesTask::addStartEnd').'?p='.$Output_value['id'].'&main='.$start_end_detail_val['id'].'&action_flage=start" class="btn btn-sm btn-success bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">Start Time </a>';
                }
              }
            }
          }else{
            $start_end_html = '<a href="'.url_to('EmployeesTask::addStartEnd').'?p='.$Output_value['id'].'&main=0&action_flage=start" class="btn btn-sm btn-success bg-gradient-primary btn-icon-split mt-4 float-right rounded-0">Start Time </a>';
          }
          $Output[$key]['start_end_html'] = $timing.'<br>'.$start_end_html;
        }
      }
    $title = 'Employees Task';
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
      "EmployeesTask/index",
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

    public function addEmployeesTask()
    {
        if ($this->request->is('post')) {
            $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $this->request->getPost('id');
            $employee_id = $this->request->getPost('employee_id');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            $remark = $this->request->getPost('remark');
            
            $data = [
                'employee_id' => $employee_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'remark' => $remark
            ];
      
            $builder = $this->db->table('task');
            $builder->insert($data);
            $product_id = $this->db->insertID();
                    
            return redirect()->to(url_to('EmployeesTask::list'));
        } else {
            $title = "Add New Employees Task";
            $employees = $this->db->table('employees')
            ->orderBy('email', 'ASC')
            ->limit(100)
            ->get()
            ->getResultArray();
            return view('EmployeesTask/addEmployeesTask', [
                "title" => $title,
                "employees" => $employees,
            ]);
        }
    }
    
    #Edit a P No
  public function editEmployeesTask()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxztask WHERE id = '$id'")->getRowArray();
      $PN = $query['id'];
        $employees = $this->db->table('employees')
            ->orderBy('email', 'ASC')
            ->limit(100)
            ->get()
            ->getResultArray();
      $title = "Edit Employees Task $PN";
      return view('EmployeesTask/editEmployeesTask', [
        "title" => $title,
        "result"   => $query,
         "employees"   => $employees,
      ]);
    } else if ($this->request->is('post')) {
         $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $employee_id = $this->request->getPost('employee_id');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $remark = $this->request->getPost('remark');
        
        $data = [
            'employee_id' => $employee_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'remark' => $remark
        ];
      $builder = $this->db->table('task');
      $builder->where('id', $id);
      $builder->update($data);

      return redirect()->to(url_to('EmployeesTask::list'))
                       ->with("message", $id . " - ID updated");
    }
  }
  public function addStartEnd()
    {
      if ($this->request->is('get')) {
        https://sepsialma.hollybollygossip.com/employees_task/add-start_end?p=1&=3&=start

        $task_id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $main_id = $this->request->getGet('main', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $action_flage = $this->request->getGet('action_flage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_time = date('Y-m-d h:i:s');
        $start_end_detail = $this->db->query("SELECT * FROM 8yxztask_start_end WHERE id = '$main_id'")->getRowArray();
        if(empty($start_end_detail)){
          $data = [
            'task_id' => $task_id,
            'start_time' => $current_time,
            'end_time' => '',
          ];
          $builder = $this->db->table('task_start_end');
          $builder->insert($data);
          $product_id = $this->db->insertID();
        }else{
          if($action_flage == 'end'){
              $data = [
                'task_id' => $task_id,
                'end_time' => $current_time,
              ];
            $builder = $this->db->table('task_start_end');
            $builder->where('id', $main_id);
            $builder->update($data);
          }else{
            $data = [
              'task_id' => $task_id,
              'start_time' => $current_time,
              'end_time' => '',
            ];
            $builder = $this->db->table('task_start_end');
            $builder->insert($data);
            $product_id = $this->db->insertID();
          }
        }
        return redirect()->to(url_to('EmployeesTask::list'));
      } 
    }

}