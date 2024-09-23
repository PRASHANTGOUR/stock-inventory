<?php

namespace App\Controllers;

# Add the Model
use App\Models\AdminModel;

class Admin extends BaseController
{
    public function __construct()
    {
      $this->db = db_connect();
      $this->dbutil = \Config\Database::utils();
    }

      #View All Units
  public function units()
  {
    // Department Data
    /*
        $Query = "SELECT * FROM `8yxzproducts` WHERE `status` <> 'Deleted ' ORDER BY `DateAdded` DESC LIMIT 100";
        $Output = $this->db->query($Query)->getResultArray();
        */
    $Output = $this->db->table('products')
    ->where('status !=', 'Deleted')
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

    public function addUnit()
    {
    if ($this->request->getGet('q') AND !$this->request->is('post')) {
        $this->request->getGet(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $Qty = $this->request->getGet('q');
        $type = $this->request->getGet('type');

        $phases = $this->db->table('_design_phase')
        ->get()
        ->getResultArray();
        #$phases = array_column($phases, 'title', 'id');
    
        $title = "Add New Unit";
        return view('Admin/addUnit', [
            "title" => $title,
            "Qty"   => $Qty,
            "type" => $type,
            "phases" => $phases,
        ]);

        } else if ($this->request->is('post')) {
            $this->request->getPost(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $PNumber = $this->request->getPost('d_pnumber');
            $AQCode = $this->request->getPost('d_aqcode');
            $ProductName = $this->request->getPost('d_productname');
            $Status = $this->request->getPost('d_status');
            $Notes = $this->request->getPost('Notes');
            $Deadline = $this->request->getPost('deadline');
            $phase = $this->request->getPost('phase', FILTER_SANITIZE_NUMBER_INT);

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
                'status' => $Status[0],
                'Deadline' => $Deadline[0],
                'Notes' => $Notes[0],
            ];

            //print_r($data);
            $checkId = $this->db->table('products')
                ->where(['pnumber' => $data['pnumber']])
                ->countAllResults();

            if ($checkId > 0 AND !empty($PNumber)) {
                return redirect()->to(url_to('Admin::units'))
                ->with("message", $PNumber[$i] . " - P Number already exisits");
            } else {
                $builder = $this->db->table('products');
                $builder->insert($data);
                $product_id = $this->db->insertID();
            }

            $data = [
                'productId' => $product_id,
                'phase' => $phase,
            ];
            $builder = $this->db->table('_design')
                                ->insert($data);

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
            'EventDetails' => 'Bulk Product Added - P No:' . $FirstP . ' > ' . $PNumber . ' Qty:' . $BulkQty . ' AQ Code: ' . $AQCode[0] . ' Name: ' . $ProductName[0],
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
                'status' => $Status[$i],
                'Deadline' => $Deadline[$i],
                'Notes' => $Notes[$i]
            ];

            //print_r($data);
            $checkId = $this->db->table('products')
                ->where(['pnumber' => $data['pnumber']])
                ->countAllResults();

            if ($checkId > 0 AND !empty($PNumber[$i])) {
                return redirect()->to(url_to('Production::units'))
                ->with("message", $PNumber[$i] . " - P Number already exisits");
            } else {
                $builder = $this->db->table('products');
                $builder->insert($data);

                $product_id = $this->db->insertID();

                $data = [
                    'productId' => $product_id,
                    'phase' => $phase[$i],
                ];
                $builder = $this->db->table('_design')
                                    ->insert($data);
                

                /*
                # Add PN + Name + Progress Percentage 
                $query = $this->db->query("SELECT `product_id` FROM `8yxzproducts` WHERE `pnumber` = '$PNumber[$i]' LIMIT 1");
                $row = $query->getResultArray();
                $product_id = $row['product_id'];
                */

                $data = [
                'EventType' => 'ProductAdded',
                'Product_Id' => $product_id,
                'EventDetails' => 'Product Added - P No:' . $PNumber[$i] . ' AQ Code: ' . $AQCode[$i] . ' Name: ' . $ProductName[$i],
                'User' => auth()->user()->username,
                ];
                $builder = $this->db->table('log');
                $builder->insert($data);
            }
            }
        }
        return redirect()->to(url_to('Admin::units'));
        } else {
        $title = "Add New Unit";
        return view('Admin/addUnit', [
            "title" => $title,
        ]);
        }
    }


}