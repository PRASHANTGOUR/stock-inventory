<?php



namespace App\Controllers;



# Add the Model

use App\Models\AdminModel;


use App\Libraries\Barcode;


class Attendances extends BaseController

{

    public function __construct()

    {

        $this->db = db_connect();

        $this->dbutil = \Config\Database::utils();
    }
    public function addAttendances()
    {
        if ($this->request->is('post')) {
            $status = 'error';
            $message = 'SomeWent to Wrong';
            $current_date = date('Y-m-d H:i:s');
            $employees_id = $this->request->getPost('employees_id');
            $badge_number = $this->request->getPost('badge_number');
            $type = $this->request->getPost('type');
            if($type == 'barcode'){
                $get_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE badge_number = '$badge_number'")->getRowArray();
            }else{
                $get_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employees_id' AND badge_number = '".$badge_number."'")->getRowArray();
            }
            
            if($get_employees){
                $employees_id =  $get_employees['id'];
                //$get_timesheet = $this->db->query("SELECT * FROM 8yxztimesheet WHERE employee_id = '".$employees_id."'  AND DATE(start_time) = '".date('Y-m-d',strtotime($current_date))."' AND end_time is NULL")->getRowArray();
                $get_timesheet = $this->db->query("SELECT * FROM 8yxztimesheet WHERE employee_id = '".$employees_id."'  AND start_time is NOT NULL AND end_time is NULL")->getRowArray();
                $builder = $this->db->table('timesheet');
                if($get_timesheet){
                    $timesheet_id = $get_timesheet['id'];
                    $start_time = $get_timesheet['start_time'];
                    $data = [
                        'start_time' => $start_time,
                        'end_time' => $current_date,
                    ];
                    $builder->where('id', $timesheet_id);
                    $builder->update($data);
                    $message = 'Bye Bye '.srting_decrypt($get_employees['first_name']).' '.srting_decrypt($get_employees['last_name']);
                }else{
                    $data = [
                        'employee_id' => $employees_id,
                        'start_time' => $current_date,
                        'end_time' => NULL
                    ];
                    $builder->insert($data);
                    $product_id = $this->db->insertID();  
                    $message = 'WelCome '.srting_decrypt($get_employees['first_name']).' '.srting_decrypt($get_employees['last_name']);
                } 
                $status = 'success';
            }else{
                 $message = 'Employees Not Found';
            }
            $url = url_to('Attendances::addAttendances');
            $return_data['url'] = $url;
            $return_data['status'] = $status;
            $return_data['message'] = $message;
            echo json_encode($return_data);
            exit;
        } else {
            $employees_id = isset($_GET['employees_id']) ? $_GET['employees_id'] : '';

            // $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $get_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employees_id'")->getRowArray();
            $employees_name = '';
            if($get_employees){
                $employees_name = ' - '.srting_decrypt($get_employees['first_name']).' '.srting_decrypt($get_employees['last_name']);
            }
            $Output_query = $this->db->table('employees');
            $Output_query->select('employees.*,departments.department,users.id as users_id');
            $Output_query->join('users', 'users.employees = employees.id');
            $Output_query->join('departments', 'departments.id = employees.department_id');
            $employees_list = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
            $title = "Add Attendances";
            return view('Attendances/addAttendances', [
                "title" => $title,
                "employees_list" => $employees_list,
                "employees_id" => $employees_id,
                "employees_details" => $get_employees,
                "employees_name" => $employees_name,
            ]);
        }
    }
    
    public function check_barcode(){
        // Initialize cURL session
        $ch = curl_init();
        
        // $content = "some text here";
        $fp = fopen("public/myText.png","wb");
        fclose($fp);
        
        // // Set cURL options
        // curl_setopt($ch, CURLOPT_URL, 'https://barcodeapi.org/api/devang');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // // Execute cURL session and fetch the response
        // $response = curl_exec($ch);
        
        // // Check for cURL errors
        // if (curl_errno($ch)) {
        //     echo 'Error: ' . curl_error($ch);
        // }
        
        // // Close cURL session
        // curl_close($ch);
        
        $ch = curl_init('https://barcodeapi.org/api/devang');
        $fp = fopen('public/myText.png', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        
        // Output the response
        // file_get_content()
        // echo file_get_contents("https://barcodeapi.org/api/devang");
        // $html = "<img src='https://barcodeapi.org/api/devang' />";
        echo $fp;
		exit;
    }
}
