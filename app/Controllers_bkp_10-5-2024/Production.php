<?php

namespace App\Controllers;

# Add the Model
use App\Models\ProductionModel;

class Production extends BaseController
{
  # Dumped from Boti version

  public function __construct()
  {
    //parent::__construct();
    //is_logged_in();
    //$this->load->library('form_validation');
    //$this->load->model('Public_model');
    //$this->load->model('Admin_model');
    $this->db = db_connect();
    $this->dbutil = \Config\Database::utils();
    helper('custom');
  }


  /*
    public function index(): string
    {
        # Call Data from Model
        $model = new ProductionModel;

        # Pass to array
        $data = $model->paginate();
        
        # Output results to template
        return view("Production/index",
            ["products" => $data,
            "pager" => $model->pager
        ]);
    }
    */


  # Dumped from Boti version
  public function teams()
  {
    // Department Data
    $Query = "SELECT * FROM `8yxzdepartment` ORDER BY `Position` ASC";
    $Output = $this->db->query($Query)->getResultArray();

    $title = 'Teams';
    //$d['account'] = auth()->user()->username;

    # Output results to template
    return view(
      "Production/teams",
      [
        "title" => $title,
        "department" => $Output,
      ]
    );
  }

  public function a_dept()
  {
    // Add Department
    $d['title'] = 'Teams';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_id', 'Department ID', 'required|trim');
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == true) {
      $this->_addDept();
    }
    $this->load->view('templates/hOutputeader', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/department/a_dept', $d); // Add Department Page
    $this->load->view('templates/footer');
  }

  private function _addDept()
  {
    $data = [
      'id' => $this->request->getPost('d_id'),
      'name' => $this->request->getPost('d_name'),
      'ExpectedOuput' => $this->request->getPost('ExpectedOuput')
    ];

    # Log Event
    $data = [
      'EventType' => 'TeamCreated',
      'EventDetails' => 'Team Created - ID:' . $this->request->getPost('d_id') . ' Name:' . $this->request->getPost('d_name') . ' Expected Output: ' . $this->request->getPost('ExpectedOuput'),
      'User' => auth()->user()->username,
    ];
    $this->db->insert('log', $data);

    $checkId = $this->db->get_where('department', ['id' => $data['id']])->num_rows();
    if ($checkId > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
        Failed to add, ID used!</div>');
    } else {
      $this->db->insert('department', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully added a new department!</div>');
      redirect('master/e_dept/' . $this->request->getPost('d_id'));
    }
  }

  public function e_dept($d_id)
  {
    // Edit Department
    $d['title'] = 'Department';
    $d['d_old'] = $this->db->get_where('department', ['id' => $d_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    // Form Validation
    $this->form_validation->set_rules('d_name', 'Department Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $d);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('master/department/e_dept', $d); // Edit Department Page
      $this->load->view('templates/footer');
    } else {
      $name = $this->request->getPost('d_name');
      $this->_editDept($d_id, $name);
    }
  }
  private function _editDept($d_id, $name)
  {
    $data = [
      'name' => $name,
      'ExpectedOuput' => $this->request->getPost('ExpectedOuput')
    ];
    $this->db->update('department', $data, ['id' => $d_id]);

    # Log Event
    $data = [
      'EventType' => 'TeamEdited',
      'EventDetails' => 'Team Edited - ID:' . $d_id . ' Name:' . $name . ' Expected Output: ' . $this->request->getPost('ExpectedOuput'),
      'User' => auth()->user()->username,
    ];
    $this->db->insert('log', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully edited a department!</div>');
    redirect('master/e_dept/' . $d_id);
  }
  public function d_dept($d_id)
  {
    $this->db->delete('department', ['id' => $d_id]);

    # Log Event
    $data = [
      'EventType' => 'TeamDeleted',
      'EventDetails' => 'Team Deleted - ID:' . $d_id,
      'User' => auth()->user()->username,
    ];
    $this->db->insert('log', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully deleted a department!</div>');
    redirect('master');
  }
  // End of department


  public function norm()
  {
    $d['title'] = 'norm';
    $d['norm'] = $this->db->get('norm')->getResultArray();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    $this->load->view('templates/table_header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/norm/index', $d);
    $this->load->view('templates/table_footer');
  }
  public function a_norm()
  {
    $d['title'] = 'norm';
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
    $this->form_validation->set_rules('l_name', 'norm Name', 'required|trim');
    if ($this->form_validation->run() == true) {
      $data['norm'] = $this->request->getPost('l_name');
      $this->_addnorm($data);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/norm/a_norm', $d);
    $this->load->view('templates/footer');
  }
  private function _addnorm($data)
  {
    $this->db->insert('norm', $data);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $id = $this->db->insert_id();
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully added a new norm!</div>');
      redirect('master/e_norm/' . $id);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
          Failed to add data!</div>');
    }
  }
  public function e_norm($l_id)
  {
    // Edit norm
    $d['title'] = 'norm';
    $d['l_old'] = $this->db->get_where('norm', ['id' => $l_id])->row_array();
    $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

    // Form Validation
    $this->form_validation->set_rules('l_name', 'norm Name', 'required|trim');

    if ($this->form_validation->run() == true) {
      $name = $this->request->getPost('l_name');
      $this->_editnorm($l_id, $name);
    }
    $this->load->view('templates/header', $d);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/norm/e_norm', $d); // Edit norm Page
    $this->load->view('templates/footer');
  }
  private function _editnorm($l_id, $name)
  {
    $data = ['norm' => $name];
    $this->db->update('norm', $data, ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
            Successfully edited a norm!</div>');
      redirect('master/e_norm/' . $l_id);
    } else {
      if (!empty($this->db->error()['message']))
        $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
          Failed to edit data!</div>');
      else
        $this->session->set_flashdata('message', '<div class="alert alert-warning rounded-0 mb-2" role="alert">
          No Changes!</div>');
    }
  }
  public function d_norm($l_id)
  {
    $query = 'ALTER TABLE `norm` AUTO_INCREMENT = 1';
    $this->db->query($query);
    $this->db->delete('norm', ['id' => $l_id]);
    $rows = $this->db->affected_rows();

    if ($rows > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
          Successfully deleted a norm!</div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger rounded-0 mb-2" role="alert">
          Failed to delete a data!</div>');
    }

    redirect('master/norm');
  }
  // end of norm


  ## Need to work on pagination 

  #View All Units
  public function units()
  {
    // Department Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
    $Output = $this->db->table('products')
      ->where('status', 'Production')
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
      "Production/index",
      [
        "title" => $title,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );
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
      ->where('status', 'Production')
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
      "Production/index",
      [
        "title" => $title,
        "products" => $Output,
        //'pager_links' => $pager_links,

      ]
    );
  }

  public function daily()
  {
    #Query is meant to sort by length and then no order but not working on daily output
    $department = $this->db->query("SELECT * FROM `8yxzdepartment` WHERE `departmentId` = 1 ORDER BY `Position` ASC")->getResultArray();

    $title = 'Daily Output';
    return view(
      "Production/daily",
      [
        "title" => $title,
        "department" => $department,

      ]
    );
  }

  public function teamDaily() 
  {
    $Search = $this->request->getGet('s', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Team = $this->request->getGet('t', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $products = $this->db->query("SELECT * FROM `8yxzproducts` WHERE `department_id` = '$Team' AND `status` = 'Production' AND `pnumber` LIKE '%$Search%'")->getResultArray();

    $title = 'Products for ' . $Team;
    return view(
      "Production/teamDaily",
      [
        "title" => $title,
        "products" => $products,
        'Team' => $Team,
      ]
    );
  }


  public function addUnit()
  {
    if ($this->request->getGet('q') AND !$this->request->is('post')) {
      $Qty = $this->request->getGet('q', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $title = "Add New Unit";
      return view('Production/addUnit', [
        "title" => $title,
        "Qty"   => $Qty,
      ]);
    } else if ($this->request->is('post')) {
      $PNumber = $this->request->getPost('d_pnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $AQCode = $this->request->getPost('d_aqcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $ProductName = $this->request->getPost('d_productname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Notes = $this->request->getPost('Notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Coef = $this->request->getPost('d_coef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Team = $this->request->getPost('d_department_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Status = $this->request->getPost('d_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Deadline = $this->request->getPost('deadline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


      #Bulk add function
      $Bulk = $this->request->getPost('Bulk');
      $BulkQty = $this->request->getPost('BulkQty');
      if ($Bulk == "Yes" and $BulkQty > 1) {
        # Set P No using base and then add _A to end for 1st
        $PNumber = $this->request->getPost('d_pnumber');
        # If over 26 go to AA
        /*
          if($BulkQty > 26 ) {
            $PNumber = $PNumber[0]."_AA";
          } else {
            $PNumber = $PNumber[0]."_A";
          } */
        $BaseP = $PNumber[0];
        $PNumber = $BaseP . "_A";
        $FirstP = $PNumber;
        $BulkUnallocate = $this->request->getPost('BulkUnallocate');
        if ($BulkUnallocate == "Yes") {
          $Team = "Unallocated";
        } else {
          $Team = $Team[0];
        }

        # loop though bulk qty adding each to DB 1 by 1
        for ($i = 0; $i < $BulkQty; $i++) {

          $data = [
            'pnumber' => $PNumber,
            'aqcode' => $AQCode[0],
            'productname' => $ProductName[0],
            'coef' => $Coef[0],
            'department_id' => $Team,
            'status' => $Status[0],
            'Deadline' => $Deadline[0],
            'Notes' => $Notes[0]
          ];

          //print_r($data);
          $checkId = $this->db->table('products')
            ->where(['pnumber' => $data['pnumber']])
            ->countAllResults();

          if ($checkId > 0) {
            return redirect()->to(url_to('Production::units'))
              ->with("message", $PNumber[$i] . " - P Number already exisits");
          } else {
            $builder = $this->db->table('products');
            $builder->insert($data);
            $product_id = $this->db->insertID();
          }

          # Add a letter to P No and change to _AA for over 26 items
          if ($i === 26) {
            $PNumber = $BaseP . "_AA";
          } else if ($i < $BulkQty) {
            $PNumber++;
          }
        }

        # Add Log Event
        $data = [
          'EventType' => 'ProductAdded',
          'EventDetails' => 'Bulk Product Added - P No:' . $FirstP . ' > ' . $PNumber . ' Qty:' . $BulkQty . ' Coef:' . $Coef[0] . ' AQ Code: ' . $AQCode[0] . ' Deadline: ' . $Deadline[0] . ' Name: ' . $ProductName[0] . ' Team: ' . $Team,
          'User' => auth()->user()->username,
        ];
        $builder = $this->db->table('log');
        $builder->insert($data);
      } else {

        $i = 0;
        for ($i; $i < count($PNumber); $i++) {
          $data = [
            'pnumber' => $PNumber[$i],
            'aqcode' => $AQCode[$i],
            'productname' => $ProductName[$i],
            'coef' => $Coef[$i],
            'department_id' => $Team[$i],
            'status' => $Status[$i],
            'Deadline' => $Deadline[$i],
            'Notes' => $Notes[$i]
          ];

          //print_r($data);
          $checkId = $this->db->table('products')
            ->where(['pnumber' => $data['pnumber']])
            ->countAllResults();

          if ($checkId > 0) {
            return redirect()->to(url_to('Production::units'))
              ->with("message", $PNumber[$i] . " - P Number already exisits");
          } else {
            $builder = $this->db->table('products');
            $builder->insert($data);

            $product_id = $this->db->insertID();

            /*
              # Add PN + Name + Progress Percentage 
              $query = $this->db->query("SELECT `product_id` FROM `8yxzproducts` WHERE `pnumber` = '$PNumber[$i]' LIMIT 1");
              $row = $query->getResultArray();
              $product_id = $row['product_id'];
              */

            $data = [
              'EventType' => 'ProductAdded',
              'Product_Id' => $product_id,
              'EventDetails' => 'Product Added - P No:' . $PNumber[$i] . ' Coef: ' . $Coef[$i] . ' AQ Code: ' . $AQCode[$i] . ' Deadline: ' . $Deadline[$i] . ' Name: ' . $ProductName[$i] . ' Team: ' . $Team[$i],
              'User' => auth()->user()->username,
            ];
            $builder = $this->db->table('log');
            $builder->insert($data);
          }
        }
      }
      return redirect()->to("/production/units");
    } else {
      $title = "Add New Unit";
      return view('Production/addUnit', [
        "title" => $title,
      ]);
    }
  }

  public function submitProgress()
  {
       // Check if the form has been submitted
       if ($this->request->getPost()) {
        // Get the submitted data
        $product_ids = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $OldProgress = $this->request->getPost('old_progress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $NewProgress = $this->request->getPost('new_progress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $progress_dates = $this->request->getPost('progress_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
        $team = $this->request->getPost('team', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
        // Check if the array is not empty
        if (!empty($product_ids) && !empty($NewProgress)) {
  
          // Loop through each product and its new progress value
          for ($i = 0; $i < count($product_ids); $i++) {
            $product_id = $product_ids[$i];
            //$serialNo = $productSn[$i];
            $new_progress = floatval($NewProgress[$i]);
            $previous_progress = floatval($OldProgress[$i]);
  
  
            if (!empty($progress_dates[$i])) {
              $date = $progress_dates[$i];
            } else {
              $date = date("Y-m-d");
            }
  
            #Co-Efficent Calculations
            $Coefficent = $new_progress - $previous_progress;
  
            # Check progress is not over 100% already
  
            # Add PN + Name + Progress Percentage 
            $query = $this->db->query("SELECT `pnumber`, `aqcode`, `productname`, `coef` FROM `8yxzproducts` WHERE `product_id` = '$product_id' LIMIT 1");
            $row = $query->getRowArray();
            $Pn = $row['pnumber'];
            $AQ = $row['aqcode'];
            $Name = $row['productname'];
            $Coef = $row['coef'];
            $Percent = ($new_progress / $Coef) * 100;
  
            $query = $this->db->query("SELECT SUM(`coefficent`) AS `CurrentProgress` FROM `8yxzprogress` WHERE `product_id` = '$product_id' LIMIT 1");
            $row = $query->getRowArray();
            $CurrentProgress = $row['CurrentProgress'];
  
            if ($CurrentProgress >= $Coef) {
              return redirect()->back()
                               ->with("message", $Pn . " - Progress is already at or over 100%s");
            }
  
            #Update if progress 
            if ($Coefficent > 0) {
  
              // Insert the progress data into the database
              $data = array(
                'product_id' => $product_id,
                'date' => $date,
                'coefficent' => $Coefficent,
                'team' => $team
              );
              $builder = $this->db->table('progress');
              $builder->insert($data);
  
              if ($Percent == 100) {
                $data = [
                  'EventType' => 'UnitComplete',
                  'Product_Id' => $product_id,
                  'EventDetails' => 'Product Progress has reached 100% - PN: ' . $Pn . ' AQ: ' . $AQ . ' Name:' . $Name . ' Total Progress:' . $Percent . '% Team: ' . $team . ' Date: ' . $date,
                  'User' => auth()->user()->username,
                ];
                $builder = $this->db->table('log');
                $builder->insert($data);
  
                # Set product as moved to testing
                $this->db->query("UPDATE `8yxzproducts` SET `status`='Testing' WHERE `product_id` = '$product_id'");
  
                $data = [
                  'EventType' => 'StatusChangeTesting',
                  'Product_Id' => $product_id,
                  'EventDetails' => 'Status Changed to testing - PN: ' . $Pn . ' AQ: ' . $AQ . ' Name:' . $Name,
                  'User' => auth()->user()->username,
                ];
                $builder = $this->db->table('log');
                $builder->insert($data);
  
                # Need to check the parent Split to see if complete
                # Check parent total coef
                $query = $this->db->query("SELECT `parent`, `department_id` FROM `8yxzproducts` WHERE `product_id` = '$product_id' LIMIT 1");
                $row = $query->getRowArray();
                $ParentID = $row['parent'];
                //$ParentTeam = $row['department_id'];
  
                # If Parent ID is set
                if (!empty($ParentID)) {
                  $query = $this->db->query("SELECT `pnumber`, `aqcode`, `productname` FROM `8yxzproducts` WHERE `product_id` = '$ParentID' LIMIT 1");
                  $row = $query->getRowArray();
                  $Pn = $row['pnumber'];
                  $AQ = $row['aqcode'];
                  $Name = $row['productname'];
  
                  # Check other shild splits total progress. Use simpler method of if all are marked as testing
                  $query =  $this->db->query("SELECT `status` FROM `8yxzproducts` WHERE `parent` = '$ParentID'")->getResultArray();
  
                  $Count = count($query);
                  $Complete = 0;
                  foreach ($query as $row) {
                    if ($row['status'] == "Testing") {
                      $Complete++;
                    }
                  }
  
                  $data = [
                    'EventType' => 'ProductProgress',
                    'Product_Id' => $ParentID,
                    'EventDetails' => $Complete . 'of' . $Count . ' Split Complete - PN: ' . $Pn . ' AQ: ' . $AQ . ' Name:' . $Name,
                    'User' => auth()->user()->username,
                  ];
                  $builder = $this->db->table('log');
                  $builder->insert($data);
  
                  if ($Complete == $Count) {
                    $this->db->query("UPDATE `8yxzproducts` SET `status`='Testing' WHERE `product_id` = '$ParentID'");
  
                    $data = [
                      'EventType' => 'StatusChangeTesting',
                      'Product_Id' => $ParentID,
                      'EventDetails' => 'Parent Set to Complete ' . $Complete . 'of' . $Count . '- PN: ' . $Pn . ' AQ: ' . $AQ . ' Name:' . $Name,
                      'User' => auth()->user()->username,
                    ];
                    $builder = $this->db->table('log');
                    $builder->insert($data);
                  }
                }
              } else {
                $data = [
                  'EventType' => 'ProductProgress',
                  'Product_Id' => $product_id,
                  'EventDetails' => 'Product Progress Submission - PN: ' . $Pn . ' AQ: ' . $AQ . ' Name:' . $Name . ' Progress in Coef: ' . $Coefficent . ' Total Progress:' . $Percent . '% Team: ' . $team . ' Date: ' . $date,
                  'User' => auth()->user()->username,
                ];
                $builder = $this->db->table('log');
                $builder->insert($data);
              }
  
  
              /*
              $query =  $this->db->query("CALL CalculateTeamDaily('$team', '$date');");
  
              foreach ($query->getResultArray() as $row) {
                $Output = $row['daysoutput'];
              }
              */

              $Output = reCalcMonth($team, $date);
  
              /*
              //mysqli_next_result($this->db->conn_id);
              $data = [
                'daily_output' => $Output,
                'team' => $team,
                'date' => $date,
              ];
              
              $builder = $this->db->table('team_output');
              if ($Output > 0) {
                $checkId = $builder->selectCount('daily_output')->where('team' == $team)->where('date' == $date)->get()->getResultArray();
                $builder = $this->db->table('team_output');
                if ($checkId > 0) {
                  $builder->where('team' == $team)->where('date' == $date);
                  $builder->update($data);
                } else {
                  $builder->insert($data);
                }
                dd($checkId);
                /*
                $builder = $this->db->table('team_output');
                $builder->where('team' == $team)
                        ->where('date' == $date)
                        ->upsert($data);

                $builder = $this->db->table('team_output');
                $builder->selectSum('daily_output')
                        ->where('date' == $date);
                $Output = $builder->get()->getRow();
                $factoryOutput = $Output->daily_output;

                $data = [
                  'output' => $factoryOutput,
                  'date' => $date,
                ];
                $builder = $this->db->table('factory_output');
                $builder->where('date' == $date)
                        ->upsert($data);
                */ 
                
                $query = $this->db->query("SELECT `daily_output` FROM 8yxzteam_output WHERE `team`='$team' AND `date`='$date'")->getNumRows();

                if($query > 0){
                  #Update the team totals 
                  $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
                } else {
                  #Update the team totals 
                  $this->db->query("INSERT INTO `8yxzteam_output`(`team`, `daily_output`, `date`) VALUES ('$team','$Output','$date')");
                }

                $query = $this->db->query("SELECT `output` FROM 8yxzfactory_output WHERE `date`='$date'")->getNumRows();
                if($query > 0){
                  #Sum Today output from all teams to give days out for factory.
                  $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");
                } else {
                  #Sum Today output from all teams to give days out for factory.
                  $this->db->query("INSERT INTO `8yxzfactory_output`(`date`, `output`) VALUES ('$date',(SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date')) ");
                }
              //}
            }
          }
          $message = "Successfully updated progress";
        } else {
          $message = "Failed to update progress! Please make sure the data is properly submitted";
        }
      } else {
          $message = "Failed to update progress! Form not submitted";
      }
  
      // Redirect back to the view_daily page to see the updated data
      // Replace 'your_controller_name' with the actual controller name handling view_daily method

    return redirect()->back()
                    ->with("message", $message);
  }

  #Edit a P No
  public function editUnit()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query = $this->db->query("SELECT * FROM 8yxzproducts WHERE product_id = '$id'")->getRowArray();
      $PN = $query['pnumber'];

      $row = $this->db->query("SELECT SUM(`coefficent`) AS `progress` FROM `8yxzprogress` WHERE `product_id`='$id'")->getRowArray();
      $progress = $row['progress'];

      $title = "Edit Unit $PN";
      return view('Production/editUnit', [
        "title" => $title,
        "result"   => $query,
        "progress" => $progress,
      ]);
    } else if ($this->request->is('post')) {
      $id = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_pnumber = $this->request->getPost('d_pnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_aqcode = $this->request->getPost('d_aqcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_productname = $this->request->getPost('d_productname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Notes = $this->request->getPost('Notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $OldCoef = $this->request->getPost('OldCoef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_coef = $this->request->getPost('d_coef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $status = $this->request->getPost('d_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $d_department_id = $this->request->getPost('d_department_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $CoefoNotes = $this->request->getPost('CoefNotes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Deadline = $this->request->getPost('deadline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $data = [
        'pnumber' => $d_pnumber,
        'aqcode' => $d_aqcode,
        'productname' => $d_productname,
        'Notes' => $Notes,
        'coef' => $d_coef,
        'status' => $status,
        'department_id' => $d_department_id,
        'Deadline' => $Deadline
      ];

      $builder = $this->db->table('products');
      $builder->where('product_id', $id);
      $builder->update($data);

      #Add to event log
      if ($d_coef != $OldCoef) {
        $data = [
          'EventType' => 'CoEfChange',
          'Product_Id' => $id,
          'EventDetails' => 'Coef Changed - PN: ' . $d_pnumber . ' Change: ' . $OldCoef . ' > ' . $d_coef . ' Reason: ' . $CoefoNotes,
          'User' => auth()->user()->username,
        ];
        $builder = $this->db->table('log');
        $builder->insert($data);
      }
  
      $data = [
        'EventType' => 'ProductEdit',
        'Product_Id' => $id,
        'EventDetails' => 'Product Edit - PN: ' . $d_pnumber . ' New Values:' . implode(",", $data),
        'User' => auth()->user()->username,
      ];
      $builder = $this->db->table('log');
      $builder->insert($data);

      return redirect()->to(url_to('Production::units'))
                       ->with("message", $d_pnumber . " - P Number updated");
    }
  }

  public function deleteUnit()
  {
    $id = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    #Remove Product
    $this->db->query("UPDATE `8yxzproducts` SET `status`='Deleted' WHERE `product_id` = '$id'");
  
    $data = [
      'EventType' => 'StatusChangeDeleted',
      'Product_Id' => $id,
      'EventDetails' => 'Status Changed to Deleted - Product ID:'.$id,
      'User' => auth()->user()->username,
    ];
    $builder = $this->db->table('log');
    $builder->insert($data);
  
    return redirect()->to(url_to('Production::units'))
    ->with("message", "P Number deleted");

    $this->session->set_flashdata('message', '<div class="alert alert-success rounded-0 mb-2" role="alert">
        Successfully deleted P Number</div>');
    redirect('master/UnitsInProduction/');
  }

  public function viewTeamsOuput() 
  {
    if ($this->request->is('get')) {
      $team = $this->request->getGet('t', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $title = "$team Teams Output (Last 30 Days)";
      $outputs = $this->db->query("SELECT * FROM `8yxzteam_output` WHERE `team` = '$team' AND `date` BETWEEN NOW() - INTERVAL 30 DAY AND NOW() AND `daily_output` > 0 ORDER BY `date` DESC")->getResultArray();	
      $startDate = date("Y-m-d");
      $endDate = date("Y-m-d");


    } else if ($this->request->is('post')) {
      $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $team = $this->request->getPost('t');
      $startDate = $this->request->getPost('s');
      $endDate = $this->request->getPost('e');
      $title = "$team Teams Output ($startDate - $endDate)";
      $outputs = $this->db->query("SELECT * FROM `8yxzteam_output` WHERE `team` = '$team' AND `date` >= '$startDate' AND `date` <= '$endDate' ORDER BY `date` DESC ")->getResultArray();	
    }

    return view(
      "Production/teamOutput",
      [
        "title" => $title,
        "outputs" => $outputs,
        'Team' => $team,
        'startDate' => $startDate,
        'endDate' => $endDate,

      ]
    );
  }
  
  public function viewTeamDailyOutput() 
  {
    $date = $this->request->getGet('d', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $team = $this->request->getGet('t', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // view_daily Data
    $query = $this->db->query("SELECT `expected` FROM `8yxzteam_output` WHERE `date` = '$date' AND `team` = '$team' LIMIT 1");
    $row = $query->getRowArray();
    $expected =  $row['expected'];


    #$d['outputs'] = $this->db->query("SELECT * FROM `8yxzprogress` WHERE `team` = '$team' AND `date` = '$date'")->getResultArray();	
    $outputs = $this->db->query("SELECT `pnumber`, `date`, `coefficent`, `8yxzprogress`.`product_id`, `productname`  FROM 
                                `8yxzprogress` INNER JOIN `8yxzproducts`
                                ON `8yxzprogress`.`product_id` = `8yxzproducts`.`product_id`
                                WHERE `team` = '$team' AND `date` LIKE '%$date%';")->getResultArray();

    $title = 'Production for ' . $team.' - '.$date;
    return view(
      "Production/teamDailyOutput",
      [
        "title" => $title,
        "outputs" => $outputs,
        'expected' => $expected,
        'team' => $team,
        'date' => $date,
      ]
    );
  }

  #View P Number Updates
  public function viewUnitProgressHistory()
   {
    $productId = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    #Lookup Product ID
    $query = $this->db->query("SELECT `pnumber`, `department_id`, `coef` FROM `8yxzproducts` WHERE `product_id` = '$productId' LIMIT 1");
    $row = $query->getRowArray();
    $PN  = $row['pnumber'];
    $department_id = $row['department_id'];
    $ProductCoef = $row['coef'];

    if ($row['department_id'] == "Split") {
      $outputs = $this->db->query("SELECT * FROM `8yxzprogress` LEFT JOIN `8yxzproducts` on `8yxzprogress`.`product_id` = `8yxzproducts`.`product_id` WHERE `parent` = '$productId' ORDER BY `8yxzproducts`.`product_id` DESC, `date` ASC;")->getResultArray();
      $modifciations = $this->db->query("SELECT * FROM `8yxzproduct_modification` LEFT JOIN `8yxzproducts` on `8yxzproduct_modification`.`product_id` = `8yxzproducts`.`product_id` WHERE parent = '$productId' ORDER BY `date` ASC")->getResultArray();
    } else {
      $outputs = $this->db->query("SELECT * FROM `8yxzprogress` LEFT JOIN `8yxzproducts` on `8yxzprogress`.`product_id` = `8yxzproducts`.`product_id` WHERE `8yxzprogress`.`product_id` = '$productId' ORDER BY `date` ASC, `unique_key` ASC")->getResultArray();
      $modifciations = $this->db->query("SELECT * FROM `8yxzproduct_modification` WHERE product_id = '$productId' ORDER BY `date` ASC")->getResultArray();
    }

    $eventLog = $this->db->table('log')
    ->where('Product_Id', $productId)
    ->orderBy('Date', 'ASC')
    ->get()
    ->getResultArray();

    $title = 'Unit Progress History ' . $PN;

    return view(
      "Production/unitProgress",
      [
        "title" => $title,
        'productId' => $productId,
        "PNumber" => $PN,
        "department_id" => $department_id,
        "ProductCoef" => $ProductCoef,
        "outputs" => $outputs,
        "modifciations" => $modifciations,
        "eventLog" => $eventLog,
      ]
    );
  }

  #Edit Progress submission
  public function editProductProgress()
  {
    if ($this->request->is('post')) {
      $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $ProductId = $this->request->getPost('sn', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $date = $this->request->getPost('date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $coefficent = $this->request->getPost('coef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $team = $this->request->getPost('team', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
      #Old Values
      $row = $this->db->query("SELECT * FROM `8yxzprogress` WHERE `unique_key`='$id'")->getRowArray();

      //$OldSn = $row['id'];
      $OldTeam = $row['team'];
      $OldDate = $row['date'];
      $OldCoef = $row['coefficent'];
      $OldProductId = $row['product_id'];
  
      #New Values
      $this->db->query("UPDATE `8yxzprogress` SET `coefficent`='$coefficent', `team` = '$team', `date` = '$date' WHERE `unique_key`='$id'");
  
      #Old Values
      $query = $this->db->query("SELECT `pnumber` FROM `8yxzproducts` WHERE `product_id`='$ProductId'");
      $row = $query->getRowArray();
      $PN = $row['pnumber'];
  
      #Add event to log
      $data = [
        'EventType' => 'ProgressChange',
        'Product_Id' => $ProductId,
        'EventDetails' => 'Progress Submission changed - PN:' . $PN . ' Progress Coef:' . $coefficent . ' Team: ' . $team . 'Date: ' . $date . ' Previous Data: Progress Coef:' . $OldCoef . ' Team: ' . $OldTeam . ' Date: ' . $OldDate,
        'User' => auth()->user()->username,
      ];
      $builder = $this->db->table('log');
      $builder->insert($data);
  
      #Recalculate team & factory output
      /*
      $query =  $this->db->query("CALL CalculateTeamDaily('$team', '$date');")->getResultArray();
  
      foreach ($query as $row) {
        $Output = $row['daysoutput'];
      }
      */

      $Output = reCalcMonth($team, $date);

  
      #Update the team totals 
      $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
      #Sum Today output from all teams to give days out for factory.
      $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");
  
      #Reca;ci;ate Old [rpgress]
      if ($team != $OldTeam or $date != $OldDate) {
        $team = $OldTeam;
        $date =  $OldDate;
  
        /*
        $query =  $this->db->query("CALL CalculateTeamDaily('$team', '$date');")->getResultArray();
  
        foreach ($query as $row) {
          $Output = $row['daysoutput'];
        }
        */
        $Output = reCalcMonth($team, $date);

  
        #Update the team totals 
        $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
        #Sum Today output from all teams to give days out for factory.
        $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");
      }
  
      return redirect()->to(url_to('Production::units'))
                        ->with("message", $PN." - Progress edit saved");
    } else {
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $output = $this->db->table('progress')
                         ->where(['unique_key' => $id])
                         ->get()->getRowArray();
      
      $title = 'Edit Unit Progres ' . $id;

      return view(
        "Production/editProgress",
        [
          "title" => $title,
          'output' => $output,
        ]
      );
    }
  }

  #Modification Co-Ef 
  public function addProductModification()
  {
    if ($this->request->is('post')) {
      $id = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $coef = $this->request->getPost('coef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $date = $this->request->getPost('date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $type = $this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $details = $this->request->getPost('details', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $team = $this->request->getPost('team', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $builder = $this->db->table('products')->select('aqcode')->where('product_id', $id)->get()->getRowArray();
      $sku = $builder['aqcode'];

      $data = [
        'product_id' => $id,
        'sku' => $sku,
        'date' => $date,
        'User' => auth()->user()->username,
        'coef' => $coef,
        'type' => $type,
        'details' => ucfirst(strtolower($details)),
        'team' => $team,
      ];

      $builder = $this->db->table('product_modification');
      $builder->insert($data);

      $data = [
        'EventType' => 'ProductModification',
        'Product_Id' => $id,
        'EventDetails' => 'Product Modification - Coef:' . $coef. ' Type: ' . $type . ' Details: ' . $details,
        'User' => auth()->user()->username,
      ];
      $builder = $this->db->table('log');
      $builder->insert($data);

      #Trigger recalc totals
      $team = $this->request->getPost('team');
      $date =  $this->request->getPost('date');

      /*
      $query =  $this->db->query("CALL CalculateTeamDaily('$team', '$date');")->getResultArray();

      foreach ($query as $row) {
        $Output = $row['daysoutput'];
      }
      */

      $Output = reCalcMonth($team, $date);


      if ($Output > 0) {
        #Update the team totals 
        $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
        #Sum Today output from all teams to give days out for factory.
        $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");
      }
       
      return redirect()->to(url_to('Production::units'))
                        ->with("message", $id." - Modification saved");

    } else {
    
      // Add daily work
      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Row = $this->db->table('products')
                         ->where(['product_id' => $id])
                         ->get()->getRowArray();

      $PNo = $Row['pnumber'];
      $team = $Row['department_id'];
      
      $title = 'Add Product Modification ' . $id;

      return view(
        "Production/productMod",
        [
          "title" => $title,
          'productId' => $id,
          "PNo" => $PNo,
          "team" => $team,
          
        ]
      );
    }
  }

  public function editProductModification()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('m', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $modification_id = $id;

      #Check for exisiting splits
      $row = $this->db->query("SELECT * FROM `8yxzproduct_modification`  WHERE `id`= '$id' LIMIT 1")->getRowArray();
      $productId = $row['product_id'];
      $Type = $row['type'];
      $Details = $row['details'];
      $Coef = $row['coef'];
      $CurrentTeam = $row['team'];
      $Edit = "1";
  
      #Check for exisiting splits
      $row = $this->db->query("SELECT `pnumber` FROM `8yxzproducts` WHERE `product_id`= '$productId' LIMIT 1")->getRowArray();
      $PNo = $row['pnumber'];
  
      # Get Norm for hours Calc 
      $row = $this->db->query("SELECT `norm` FROM `8yxznorm` WHERE `type` = 'Stitching';")->getRowArray();
      $Norm = $row['norm'];
    
      $title = 'Edit Modification ' . $id;

      return view(
        "Production/productMod",
        [
          "title" => $title,
          "modification_id" => $modification_id,
          "productId" => $productId,
          "Type" => $Type,
          "Details" => $Details,
          "Coef" => $Coef,
          "CurrentTeam" => $CurrentTeam,
          "Edit" => $Edit,
          "PNo" => $PNo,
          "Norm" => $Norm,
        ]
      );
    } else if ($this->request->is('post')) {
      $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $id = $this->request->getPost('mod_id');
      $coef = $this->request->getPost('coef');
      $productId = $this->request->getPost('product_id');
      $date = $this->request->getPost('date',);
      $User = auth()->user()->username;
      $type = $this->request->getPost('type');
      $details = ucfirst(strtolower($this->request->getPost('details')));
      $team = $this->request->getPost('team', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
      $data = [
        'product_id' => $productId,
        'date' => $date,
        'User' => $User,
        'coef' => $coef,
        'type' => $type,
        'details' => $details,
        'team' => $team,
      ];
  
      $builder = $this->db->table('product_modification');
      $builder->where('id', $id);
      $builder->update($data);

      $data = [
        'EventType' => 'ProductModification',
        'Product_id' => $productId,
        'EventDetails' => 'Product Modification Edited - Coef:' . $coef . ' Type: ' . $type . ' Details: ' . $details,
        'User' => auth()->user()->username,
      ];
      $builder = $this->db->table('log');
      $builder->insert($data);
  
      #Trigger recalc totals
      $team = $this->request->getPost('team');
      $date =  $this->request->getPost('date');
      /*
      $query =  $this->db->query("CALL CalculateTeamDaily('$team', '$date');")->getResultArray();
  
      foreach ($query as $row) {
        $Output = $row['daysoutput'];
      }
      */
  
      $Output = reCalcMonth($team, $date);

      if ($Output > 0) {
        #Update the team totals 
        $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
        #Sum Today output from all teams to give days out for factory.
        $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");
      }

      return redirect()->to(url_to('Production::viewUnitProgressHistory').'?p='.$productId)
                       ->with("message", $productId . " - Modification saved");
    }
  }

  public function viewModifications() 
  {
    if ($this->request->is('post')) {
      $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $StartDate = $this->request->getPost('StartDate');
      $EndDate = $this->request->getPost('EndDate');
      $EventType = $this->request->getPost('eventType');
      $title = 'Modification Log - '.$StartDate.' - '.$EndDate.' ('.$EventType.')';
    } else {
      $title = 'Modification Log - Last 30 Days';
      $StartDate = date("Y-m-d");
      $EndDate = date("Y-m-d");
      $EventType = NULL;
    }
    if(!empty($EventType)) {
      $event = "AND `type` = '$EventType'";
    } else {
      $event = NULL;
    }

    $events = $this->db->query("SELECT `8yxzproduct_modification`.`coef`, `pnumber`, `type`, `details`, `team`, `date` FROM `8yxzproduct_modification` INNER JOIN `8yxzproducts` ON `8yxzproduct_modification`.`product_id` = `8yxzproducts`.`product_id` WHERE `date`>= '$StartDate' AND `date`<= '$EndDate' $event ORDER BY `type` ASC, `date` DESC;")->getResultArray();

    # Get Norm for hours Calc 
    $row = $this->db->query("SELECT `norm` FROM `8yxznorm` WHERE `type` = 'Stitching';")->getRowArray();
    $Norm = $row['norm']  > 0 ? $row['norm'] : NULL;

    return view(
      "Production/modificationsReport",
      [
        "title" => $title,
        "events" => $events,
        "Norm" => $Norm,
        "StartDate" => $StartDate,
        "EndDate" => $EndDate,
        "EventType" => $EventType,

      ]
    );
  }

  public function ExportModificaitonsReport()
  {
    $this->request->getGet(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $StartDate = $this->request->getGet('S');
    $EndDate = $this->request->getGet('E');
    $EventType = $this->request->getGet('T');


   //$this->load->helper('file');
    //$this->load->helper('download');
    $delimiter = ",";
    $newline = "\r\n";
    $enclosure = '"';

    $filename = 'Modification_Log_Export_' . $EventType . '-' . $StartDate . '-' . $EndDate . '.csv';

    # Get Norm for hours Calc 
    $row = $this->db->query("SELECT `norm` FROM `8yxznorm` WHERE `type` = 'Stitching';")->getRowArray();
    $Norm = $row['norm'];

    // view_daily Data
    $query = $this->db->query("SELECT `pnumber` AS `P No`, `type` AS `Type`, `details` AS `Details`, `team` AS `Team`, `8yxzproduct_modification`.`coef` AS `Modification Coef`, ROUND(`8yxzproduct_modification`.`coef` / ($Norm / 8)) AS `Hours`, `date` AS `Date` FROM `8yxzproduct_modification` INNER JOIN `8yxzproducts` ON `8yxzproduct_modification`.`product_id` = `8yxzproducts`.`product_id` WHERE `date`>= '$StartDate' AND `date`<= '$EndDate' AND `type` = '$EventType' ORDER BY `date` DESC");

    $data = $this->dbutil->getCSVFromResult($query, $delimiter, $newline, $enclosure);
    return $this->response->download($filename, $data);
  }

  # Add Expected Team Outputs
  public function setExpected()
  {
    $team = $this->request->getPost('team');
    $date = $this->request->getPost('date');
    $expected = $this->request->getPost('expected');
    //$manualcoef = $this->request->getPost('manual');

    #Udpate
    $this->db->query("UPDATE `8yxzteam_output` SET `expected`='$expected' WHERE `team`='$team' AND `date`='$date'");

    #Log
    $data = [
      'EventType' => 'AddEpectedDailyOutput',
      'EventDetails' => 'Expected Output Added - Team: ' . $team . ' Expected Coef:' . $expected . ' Date: ' . $date,
      'User' => auth()->user()->username,
    ];
    $builder = $this->db->table('log');
    $builder->insert($data);

    return redirect()->back()
                      ->with("message", "Expected $team submitted");
  }

  # Split P No Form
  public function splitPNo()
  {
    if ($this->request->is('get')) {
      $id = $this->request->getGet('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      # Check if already split

      #Check for exisiting splits
      $SplitResults = $this->db->query("SELECT `pnumber`, SUM(`coef`) AS `StitchCoef` FROM `8yxzproducts` WHERE `parent`= '$id' ORDER BY `parent` DESC;")->getRowArray();
      $SplitCount = $SplitResults['pnumber'];
      if (!empty($SplitCount)) {
        return redirect()->back()
                        ->with("message", "This product has already been split ".$SplitResults['pnumber']);
      }

      #Lookup Product ID
      $row = $this->db->query("SELECT `pnumber`, `department_id`, `coef`, `Deadline` FROM `8yxzproducts` WHERE `product_id` = '$id' LIMIT 1")->getRowArray();
      $PNo = $row['pnumber'];

      $title = 'Split P No: ' . $PNo;

      return view(
        "Production/addSplit",
        [
          "title" => $title,
          "prod_id" => $id,
          "qty" => $this->request->getGet('q', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
          "PNo" => $PNo,
          "ParentTeam" => $row['department_id'],
          "ProductCoef" => $row['coef'],
        ]
      );

    } else if ($this->request->is('Post')) {
      # Need to copy the parent
      $ParentID = $this->request->getPost('ParentID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $SplitQty = $this->request->getPost('SplitQty', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $StitchCoef = $this->request->getPost('SplitStitchCoef', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Name = $this->request->getPost('SplitName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Team = $this->request->getPost('SplitTeam', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      # Get Parent
      $row = $this->db->query("SELECT * FROM `8yxzproducts` WHERE `product_id`='$ParentID' LIMIT 1")->getRowArray();
      //$OldSn = $row['id'];
      $ParentPNo = $row['pnumber'];
      $ParentAQ = $row['aqcode'];
      $Deadline = $row['Deadline'];
      $ParentName = $row['productname'];
      $ParentStitchCoef = $row['coef'];
      $ParentPfaff = $row['PfaffCoef'];
      $ParentCif = $row['CifCoef'];
      $ParentStatus = $row['status'];
      $ParentTeam = $row['department_id'];

      # Loop through Splits
      for ($i = 0; $i < $SplitQty; $i++) {

        $SplitPNo = $ParentPNo . "." . $i + 1;
        if ($i == 0) {
          $FirstChild = $SplitPNo;
        }

        # Copy to splits and set parent ID
        $data = [
          'parent' => $ParentID,
          'pnumber' => $SplitPNo,
          'aqcode' => $ParentAQ,
          'Deadline' => $Deadline,
          'productname' =>  $Name[$i] . "-" . $ParentName,
          'coef' => $StitchCoef[$i],
          'PfaffCoef' => $ParentPfaff,
          'CifCoef' => $ParentCif,
          'status' => $ParentStatus,
          'department_id' => $Team[$i],
          'DateAdded' => date("Y-m-d")
        ];
        $builder = $this->db->table('products');
        $builder->insert($data);

        //$AvaliableStitchCoef -= $AvaliableStitchCoef;

        # Get new prodcut ID of Child
        $product_id = $this->db->insertID();

        # Add PN + Name + Progress Percentage 

        # Event Log
        $data = [
          'EventType' => 'ProductSplit',
          'Product_Id' => $product_id,
          'EventDetails' => 'Product Split - Parent: ' . $ParentPNo . ' Split Part: ' . $i + 1 . ' Split P No: ' . $SplitPNo . ' Name: ' . $Name[$i] . '-' . $ParentName . ' Team: ' . $Team[$i] . ' Stitch Coef: ' . $StitchCoef[$i],
          'User' => auth()->user()->username,
        ];
        $builder = $this->db->table('log');
        $builder->insert($data);
      }

      # Update parent and set team to split
      if ($ParentTeam != "Split") {
        #Set parent team to split
        $this->db->query("UPDATE `8yxzproducts` SET `department_id`='Split' WHERE `product_id`='$ParentID'");

        # Update previous prgress to 1st child
        $row = $this->db->query("SELECT `product_id` FROM `8yxzproducts` WHERE `pnumber`='$FirstChild'")->getRowArray();

        $NewdId = $row['product_id'];
        $this->db->query("UPDATE `8yxzprogress` SET `product_id`='$NewdId' WHERE `product_id`='$ParentID'");
        $this->db->query("UPDATE `8yxzproduct_modification` SET `product_id`='$NewdId' WHERE `product_id`='$ParentID'");

        # Event Log
        $data = [
          'EventType' => 'ProductSplit',
          'Product_Id' => $ParentID,
          'EventDetails' => 'Product Split - Parent: ' . $ParentPNo . ' Team set to Split Split Count: ' . $SplitQty,
          'User' => auth()->user()->username,
        ];
        $builder = $this->db->table('log');
        $builder->insert($data);
      }

      return redirect()->to(url_to('Production::units'))
                       ->with("message", "Product split  $ParentPNo");

    }
  }

  # Newley Added Products Reports
  # List of new products added so can be sent to teams for days work as requested by Edina 22/11/23
  public function recentlyAdded()
  {
    if ($this->request->getGet('s')) {
      $this->request->getGet(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $Start = $this->request->getGet('s');
      $Finish = $this->request->getGet('f');
      $title =  'New Products - ' . $Start . ' - ' . $Finish;
    } else {
      $Start = date("Y-m-d") . "T00:00:00";
      $Finish = date("Y-m-d") . "T23:59:59";
      $title = 'New Products - Today';
    }

    $Output = $this->db->query("SELECT `DateAdded`,`pnumber`,`aqcode`,`productname`,`department_id`,`coef`, `Deadline`, `Notes` FROM `8yxzproducts` LEFT JOIN `8yxzdepartment` ON `8yxzproducts`.`department_id` = `8yxzdepartment`.`id` WHERE `DateAdded` BETWEEN '$Start' AND '$Finish' AND `department_id` <> 'Split' ORDER BY `8yxzdepartment`.`Position` ASC, `product_id` DESC;")->getResultArray();

    /*
    $Output = $this->db->table('products')
      ->select('DateAdded')
      ->select('pnumber')
      ->select('aqcode')
      ->select('productname')
      ->select('department_id')
      ->select('coef')
      ->select('Deadline')
      ->select('Notes')
      ->join('products', 'department_id' == 'department.id')
      ->where('DateAdded' >= $Start)
      ->where('DateAdded' <= $Finish)
      ->where('daparment_id' <> 'Split')
      ->orderBy('department.Position', 'ASC')
      ->orderBy('product_id', 'DESC')
      ->get()
      ->getResultArray();
      */

    return view(
      "Production/recentlyAdded",
      [
        "title" => $title,
        "products" => $Output,
        'Start' => $Start,
        'Finish' => $Finish,
        //'pager_links' => $pager_links,

      ]
    );
  }

  public function eventLog()
  {
    if ($this->request->is('post')) {
      $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $EventType = $this->request->getPost('eventType');
      $StartDate = $this->request->getPost('StartDate');
      $EndDate = $this->request->getPost('EndDate');
      $EndDate = date('Y-m-d', strtotime($EndDate. '1 days'));

      $title = 'Event Log - Type: '.$EventType.' Date: '.$StartDate.' - '.$EndDate;
      $events = $this->db->query("SELECT * FROM `8yxzlog` WHERE `EventType` = '$EventType' AND `date` BETWEEN '$StartDate' AND '$EndDate' ORDER BY `EventId` DESC")->getResultArray();
    } else {
      $StartDate = date("Y-m-d");
      $EndDate = date("Y-m-d");
      $EventType = NULL;
      $title = 'Event Log - Last Day';
      $events = $this->db->query("SELECT * FROM `8yxzlog` WHERE `date` BETWEEN NOW() - INTERVAL 1 DAY AND NOW() ORDER BY `EventId` DESC")->getResultArray();
    }

    return view(
      "Production/eventLog",
      [
        "title" => $title,
        "events" => $events,
        "StartDate" => $StartDate,
        "EndDate" => $EndDate,
        "EventType" => $EventType,

      ]
    );

  }

  #ViewEventLog
public function viewLog() {
  // view_daily Data
   $d['title'] = 'Event Log - Last Day';
   $d['events'] = $this->db->query("SELECT * FROM `log` WHERE `date` BETWEEN NOW() - INTERVAL 1 DAY AND NOW() ORDER BY `EventId` DESC")->result_array();	
   $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

  $this->load->view('templates/table_header', $d);
  $this->load->view('templates/sidebar');
  $this->load->view('templates/topbar');
  $this->load->view('report/event-log'); 
  $this->load->view('templates/table_footer');
}

#ViewEventLog
public function filterLogEvent() {
  $type = $this->input->post('eventType');
  $StartDate = $this->input->post('StartDate');
  $EndDate = $this->input->post('EndDate');
  $d['title'] = 'Event Log - Type: '.$type.' Date: '.$StartDate.' - '.$EndDate;
  $d['StartDate'] = $StartDate;
  $d['EndDate'] = $EndDate;
  $d['EventType'] = $type;
  $EndDate = date('Y-m-d', strtotime($EndDate. '1 days'));

  $d['events'] = $this->db->query("SELECT * FROM `log` WHERE `EventType` = '$type' AND `date` BETWEEN '$StartDate' AND '$EndDate' ORDER BY `EventId` DESC")->result_array();	
  $d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);

  $this->load->view('templates/table_header', $d);
  $this->load->view('templates/sidebar');
  $this->load->view('templates/topbar');
  $this->load->view('report/event-log'); 
  $this->load->view('templates/table_footer');
}
}
