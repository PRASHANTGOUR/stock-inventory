<?php

namespace App\Controllers;

# Add the Model
use App\Models\HrModel;

class QrcodeTest extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->dbutil = \Config\Database::utils();
        $this->encrypter = \Config\Services::encrypter();
    }


    public function listStaff()
    {
        echo 'hiii';
        exit;
    }
}
