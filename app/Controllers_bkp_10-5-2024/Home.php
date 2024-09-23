<?php

namespace App\Controllers;

# Add the Model
use App\Models\HomeModel;

class Home extends BaseController
{

    public function __construct()
    {
       
    }

    public function index()
    {

        if(session("magicLogin") OR (auth()->user()->requiresPasswordReset())) 
        {
            return redirect()->to("/user-management/password-reset")
                             ->with("message", "Please set new password");
        }

        /*
                # Set Session Info
                if (auth()->loggedIn() AND !isset($_SESSION['aqId'])) {
                    $this->db = db_connect();
                    $employeeId = $this->db->table('_staff')
                                            ->select('aqId')
                                            ->where('userId', auth()->user()->id)
                                            ->get()
                                            ->getRowArray();
        
                    $id = $employeeId ? $employeeId['aqId'] : NULL;
                      
                    session()->set('aqId', $id);
                }   
                
       */  

        $title = "Welcome to Airquee Project Phoenix";

        return view("Home/index",
        [
            "title" => $title,
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
