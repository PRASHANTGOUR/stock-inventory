<?php



namespace App\Controllers;



# Add the Model

use App\Models\AdminModel;



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
           
            // $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $id = $this->request->getPost('id');
            $employees_id = $this->request->getPost('employees_id');
            $code = $this->request->getPost('code');
            $get_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employees_id'")->getRowArray();
            $data = [
                'employee_id' => 1,
                'start_time' => date('Y-m-d H:i:s', time()),
            ];
            $builder = $this->db->table('timesheet');
            $builder->insert($data);
           
            $product_id = $this->db->insertID();
            return redirect()->to(url_to('Attendances::addAttendances'));
        } else {
            $employees_id = isset($_GET['employees_id']) ? $_GET['employees_id'] : '';

            // $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $get_employees = $this->db->query("SELECT * FROM 8yxzemployees WHERE id = '$employees_id'")->getRowArray();
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
            ]);
        }
    }
}
