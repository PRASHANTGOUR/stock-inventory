<?php
namespace App\Controllers;
# Add the Model
use App\Models\HomeModel;
class Home extends BaseController
{
   public function __construct(){
        $this->db = db_connect();
        $this->dbutil = \Config\Database::utils();
    }
    public function index(){
        if(session("magicLogin") OR (auth()->user()->requiresPasswordReset())) {
            return redirect()->to("/user-management/password-reset")->with("message", "Please set new password");
        }
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $Output_query = $this->db->table('8yxztimesheet');
        if($search != ''){
            $Output_query->groupStart();
                $Output_query->like('employees.first_name',$search);
                $Output_query->orLike('employees.last_name',$search);
            $Output_query->groupEnd();
        }
        $Output_query->select('timesheet.*,employees.first_name,employees.last_name');
        $Output_query->join('employees', 'employees.id = 8yxztimesheet.employee_id');
        $Output = $Output_query->orderBy('employees.id', 'DESC')->get()->getResultArray();
        if($Output){
            foreach($Output as $key=>$Output_val){
                $start_time = $Output_val['start_time'];
                $end_time = $Output_val['end_time'];
                if($end_time == ''){
                  $end_time = '-';
                  $Output[$key]['total_time'] = '0:00';
                }else{
                    $Output[$key]['total_time'] = TimeDifferent($start_time,$end_time);    
                }
                $Output[$key]['end_time'] = $end_time;
                //printf("%d years, %d months, %d days, %d hours, ". "%d minutes, %d seconds", $years, $months,$days, $hours, $minutes, $seconds);
            }
        }
        $title = "Welcome to Airquee Project Phoenix";
        return view("Home/index",
        [
            "title" => $title,
            "products" => $Output,
        ]
        )

    ;

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



}

