<?php

namespace App\Controllers;

# Add the Model
use App\Models\ProductionDashboardModel;

class ProductionDashboard extends BaseController
{
  private ProductionDashboardModel $model;

    // Constructor
  public function __construct()
  {

        /*
        parent::__construct();s
        is_weekends();
        is_logged_in();
        is_checked_in();
        is_checked_out();
        $this->load->library('form_validation');
        $this->load->model('Public_model');
        $this->load->model('Admin_model');
        */

        # Converted to CI4 
        $this->model = new ProductionDashboardModel;
        $this->db = db_connect();
        helper('custom');

  }

  // Dashboard
  public function index()
  {
        # $date = $this->input->get('date');
        $date = $this->request->getGet('date');

        if(isset($date)) {
        $month = $date;
        //$month = date('Y-m-d', strtotime($date. '1 months'));
        } else {
        $month = date("Y-m-d");
        }

        $StartDate = date('Y-m-01', strtotime($month));
        $EndDate  = date('Y-m-t', strtotime($month)); // A leap year!
        $StartDate =  $StartDate;
        $EndDate =  $EndDate;
    
        # Modification Log
        $ModfQuery = "SELECT *, `8yxzproduct_modification`.`coef` AS `modCoef`  FROM `8yxzproduct_modification` INNER JOIN `8yxzproducts` ON `8yxzproduct_modification`.`product_id` = `8yxzproducts`.`product_id` ORDER BY `date` DESC LIMIT 50;";
        $mod_list = $this->db->query($ModfQuery)->getResultArray();

        # Progress Log
        $ProgressQuery = "SELECT * FROM `8yxzprogress` INNER JOIN `8yxzproducts` ON `8yxzprogress`.`product_id` = `8yxzproducts`.`product_id` ORDER BY `date` DESC LIMIT 50";
        $progress_list = $this->db->query($ProgressQuery)->getResultArray();

        # Teams Daily Outputs Summart
        # Teams
        $team_list = $this->db->query("SELECT `8yxzdepartment`.`id` AS `id` FROM `8yxzdepartment` 
        LEFT JOIN `8yxzteam_output` ON `8yxzdepartment`.`id` = `8yxzteam_output`.`team`
        WHERE `date`>= '$StartDate' AND `date` <= '$EndDate' AND `8yxzteam_output`.`daily_output` > 0 AND `departmentId` = 1
        GROUP BY `8yxzdepartment`.`id`
        ORDER BY LENGTH(`8yxzdepartment`.`id`), `8yxzdepartment`.`id`;")->getResultArray();	
        # Get Days of Month
        $days_list = $this->db->query("SELECT `date`, ROUND(SUM(`daily_output`), 2) AS `dayTotal`, ROUND(SUM(`expected`),2) AS `expected` FROM 8yxzteam_output WHERE `date`>= '$StartDate' AND `date` <= '$EndDate' AND `daily_output` > 0 GROUP BY `date`; ")->getResultArray();	
        //$d['month'] = $month;
        # Outputs

        // Dashboard
        $title = 'Production Tacking Dashboard';
        //$d['account'] = $this->Admin_model->getAdmin($this->session->userdata['username']);
        $d['account'] = auth()->user()->username;
        //$d['display'] = $this->Admin_model->getDataForDashboard();

        /*
        $this->load->view('templates/dashboard_header', $d);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index', $d); // Dashboard Page
        $this->load->view('templates/dashboard_footer');
        */

        # Output results to template
        return view("ProductionDashboard/index",
            [
                "title" => $title,
                "days_list" => $days_list, 
                "month" => $month,
                "teams_list" => $team_list,
                "StartDate" => $StartDate,
                "EndDate" => $EndDate,
                "mod_list" => $mod_list,
                "progress_list" => $progress_list,
            ]
            )
        ;
    }

    #Very Rought starting workings no actual function yet
    # Recalculate selected month outpouts
    function ReCalcSelectedMonth () {
        $date = $this->request->getGet('date');

        # Get list of Teams
        $Teams = $this->db->query("SELECT `8yxzdepartment`.`id` AS `id` FROM `8yxzdepartment` 
        LEFT JOIN `8yxzteam_output` ON `8yxzdepartment`.`id` = `8yxzteam_output`.`team`
        WHERE MONTH(`date`) = MONTH('$date') 
        AND `8yxzdepartment`.`departmentId` = 1
        GROUP BY `8yxzdepartment`.`id`
        ORDER BY LENGTH(`8yxzdepartment`.`id`), `8yxzdepartment`.`id`;")->getResultArray();	
        # Get Days of Month
        //$Days = $this->db->query("SELECT `date` FROM `8yxzprogress` WHERE  MONTH(`date`) = MONTH('$date') AND `coefficent` > 0 GROUP BY `team` ASC; ")->getResultArray();	

        $Days=array();
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));
        
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $Days[]=date('Y-m-d', $time);
        }

        $data = array();

        foreach($Days as $Date) {
        $date = $Date;
        if($date <= date('Y-m-d')) {
            foreach($Teams as $Team) {

            $team = $Team['id'];
            
            /*
            $query = $this->db->query("CALL CalculateTeamDaily('$team', '$date');");
            foreach ($query->getResultArray() as $row)
            {
                $Output = $row['daysoutput'];
            }
            */
            $Output = reCalcMonth($team, $date);

            $data[] = $date." ".$team." ".$Output;
            # Need to calc factory day totals
            //mysqli_next_result( $this->db->conn_id );

            #Update the team totals 
            # Not perfect but get around Codeigniter 3 and NULL value sisue use if statement for now.
            if($Output > 0) {
                $this->db->query("UPDATE `8yxzteam_output` SET `daily_output`='$Output' WHERE `team`='$team' AND `date`='$date'");
            } else {
                $this->db->query("UPDATE `8yxzteam_output` SET `daily_output` = NULL WHERE `team`='$team' AND `date`='$date'");
            }
            }
        }

        #Sum Today output from all teams to give days out for factory.
        $this->db->query("UPDATE `8yxzfactory_output` SET `output`= (SELECT SUM(`daily_output`) FROM `8yxzteam_output` WHERE `date` = '$date') WHERE `date`='$date'");    
        }

        # Event Log
        $data = [
        'EventType' => 'RecalculateMonth',
        'EventDetails' => 'Recalculate Month Trigged - Month: '.date("M-Y", strtotime($date))/*.' Data: '.implode(", ", $data)*/,
        'User' => auth()->user()->username,
        ];
        $builder = $this->db->table('log');
        $builder->insert($data);
        
        $month = date('m-Y', strtotime($date));

        return redirect()->back() # Redirects 
                         ->with("message", "Force Month Totals Recalculate $month Completed"); # Adds message 
    
    }
    
    /*
    public function index(): string
    {
        return view("Admin/index");
    }
    */

    # Event Log
    public function eventLog()
    {
        # Call Data from Model
        $model = new ProductionDashboardModel;

        # Pass to array
        $data = $model->paginate();
        
        # Output results to template
        return view("ProductionDashboard/event-log",
            ["events" => $data]);
    }
    
}
