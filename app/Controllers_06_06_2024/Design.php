<?php



namespace App\Controllers;



# Add the Model

use App\Models\DesignModel;



class Design extends BaseController

{

    public function __construct()

    {

      $this->db = db_connect();

      $this->dbutil = \Config\Database::utils();

    }



      #View All Units

  public function units()

  {

    //if(auth()->user()->can('design.super')) {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->orderBy('status', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    /*} else {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->where('designerId', auth()->user()->staff_id)

      ->orderBy('status', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    }*/

        

    $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          #->orderBy('name', 'ASC')

                          ->get()

                          ->getResultArray();



    $cadStatuses = $this->db->table('_design_status')

                          ->where('phase', '2')

                          ->get()

                          ->getResultArray();



    $visualStatuses = $this->db->table('_design_status')

                          ->where('phase', '1')

                          ->get()

                          ->getResultArray();



    $phases = $this->db->table('_design_phase')

                          ->get()

                          ->getResultArray();





    $title = 'Units';



    # Output results to template

    return view(

      "Design/index",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,



        //'pager_links' => $pager_links,



      ]

    );

  }



  public function cadUnits()

  {

    if(auth()->user()->can('design.super')) {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->where('phase', '4')

      ->orderBy('status', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    } else {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->where('phase', '4')

      ->where('designerId', auth()->user()->staff_id)

      ->orderBy('status', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    }

        

    $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          #->orderBy('name', 'ASC')

                          ->get()

                          ->getResultArray();



    $cadStatuses = $this->db->table('_design_status')

                          ->where('phase', '2')

                          ->get()

                          ->getResultArray();



    $visualStatuses = $this->db->table('_design_status')

                          ->where('phase', '1')

                          ->get()

                          ->getResultArray();



    $phases = $this->db->table('_design_phase')

                          ->get()

                          ->getResultArray();





    $title = 'Units';



    # Output results to template

    return view(

      "Design/cad",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,



        //'pager_links' => $pager_links,



      ]

    );

  }



  public function filterDesignersUnits()

  {

    $designer = $this->request->getGet('designer', FILTER_SANITIZE_NUMBER_INT);



    $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->where('designerId', $designer)

      ->orderBy('DateAdded', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

        

    $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          #->orderBy('name', 'ASC')

                          ->get()

                          ->getResultArray();



    $cadStatuses = $this->db->table('_design_status')

                          ->where('phase', '2')

                          ->get()

                          ->getResultArray();



    $visualStatuses = $this->db->table('_design_status')

    ->where('phase', '1')

    ->get()

    ->getResultArray();



    $phases = $this->db->table('_design_phase')

                          ->get()

                          ->getResultArray();



    $title = 'Units';



    # Output results to template

    return view(

      "Design/index",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,

        "getDesigner" => $designer,

        //'pager_links' => $pager_links,



      ]

    );

  }



  public function filterPhaseUnits()

  {

    $phase = $this->request->getGet('phase', FILTER_SANITIZE_NUMBER_INT);



    $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->where('phase', $phase)

      ->orderBy('DateAdded', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

        

    $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          #->orderBy('name', 'ASC')

                          ->get()

                          ->getResultArray();



    $cadStatuses = $this->db->table('_design_status')

                          ->where('phase', '2')

                          ->get()

                          ->getResultArray();



    $visualStatuses = $this->db->table('_design_status')

    ->where('phase', '1')

    ->get()

    ->getResultArray();



    $phases = $this->db->table('_design_phase')

                          ->get()

                          ->getResultArray();



    $title = 'Units';



    # Output results to template

    return view(

      "Design/index",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,

        "getPhase" => $phase,

        //'pager_links' => $pager_links,



      ]

    );

  }



  public function unallocatedUnits()

  {

    $Output = $this->db->table('products')

    ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

    ->join('_design', '_design.productId = products.product_id')

    ->where('products.status', 'Design')

    ->where('designerId', NULL)

    ->orderBy('DateAdded', 'DESC')

    ->limit(100)

    ->get()

    ->getResultArray();

        

    $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          ->orderBy('name', 'DESC')

                          ->get()

                          ->getResultArray();



    $cadStatuses = $this->db->table('_design_status')

                          ->where('phase', '2')

                          ->get()

                          ->getResultArray();



    $visualStatuses = $this->db->table('_design_status')

    ->where('phase', '1')

    ->get()

    ->getResultArray();



    $phases = $this->db->table('_design_phase')

                          ->get()

                          ->getResultArray();





    $title = 'Units';



    # Output results to template

    return view(

      "Design/index",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,

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



    if (auth()->user()->can('design.super')) {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->like('pnumber', $search)

      ->orderBy('DateAdded', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    } else {

      $Output = $this->db->table('products')

      ->select('product_id, pnumber, aqcode, productname, designerId, _design.status, phase, visualPhase, cadPhase, artworkPhase')

      ->join('_design', '_design.productId = products.product_id')

      ->where('products.status', 'Design')

      ->like('pnumber', $search)

      ->where('designerId', auth()->user()->employee_id)

      ->orderBy('DateAdded', 'DESC')

      ->limit(100)

      ->get()

      ->getResultArray();

    }



      $designers = $this->db->table('_staff')

      ->select('name, id')

      ->where('departmentId', 2)

      ->orderBy('name', 'DESC')

      ->get()

      ->getResultArray();



      $cadStatuses = $this->db->table('_design_status')

      ->get()

      ->getResultArray();



      $visualStatuses = $this->db->table('_design_status')

                      ->where('phase', '1')

                      ->get()

                      ->getResultArray();



      $phases = $this->db->table('_design_phase')

      ->get()

      ->getResultArray();









    $title = 'Units';



    # Output results to template

    return view(

      "Design/index",

      [

        "title" => $title,

        "products" => $Output,

        "designers" => $designers,

        "cadStatuses" => $cadStatuses,

        "visualStatuses" =>$visualStatuses,

        "phases" => $phases,

        //'pager_links' => $pager_links,



      ]

    );

  }



  #Edit a P No

  /*

  public function editUnit()

  {

    if ($this->request->is('get')) {

      $id = $this->request->getGet('p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = $this->db->query("SELECT * FROM 8yxzproducts WHERE product_id = '$id'")->getRowArray();

      $PN = $query['pnumber'];



      $title = "Edit Unit $PN";

      return view('Production/editUnit', [

        "title" => $title,

        "result"   => $query,

      ]);

    } else if ($this->request->is('post')) {

      $id = $this->request->getPost('product_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $d_pnumber = $this->request->getPost('d_pnumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $d_aqcode = $this->request->getPost('d_aqcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $d_productname = $this->request->getPost('d_productname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $Notes = $this->request->getPost('Notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $status = $this->request->getPost('d_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $Deadline = $this->request->getPost('deadline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



      $data = [

        'pnumber' => $d_pnumber,

        'aqcode' => $d_aqcode,

        'productname' => $d_productname,

        'Notes' => $Notes,

        'status' => $status,

        'Deadline' => $Deadline

      ];



      $builder = $this->db->table('products');

      $builder->where('product_id', $id);

      $builder->update($data);

  

      $data = [

        'EventType' => 'ProductEdit',

        'Product_Id' => $id,

        'EventDetails' => 'Product Edit (Design) - PN: ' . $d_pnumber . ' New Values:' . implode(",", $data),

        'User' => auth()->user()->username,

      ];

      $builder = $this->db->table('log');

      $builder->insert($data);



      return redirect()->to(url_to('Design::units'))

                        ->with("message", $d_pnumber . " - P Number updated");

    }

  }

  */



  public function allocateDesigner() 

  {

    if($this->request->is('POST')) {

      $id = $this->request->getPost('productId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $Desigener = $this->request->getPost('designer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $status = $this->request->getPost('status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $phase = $this->request->getPost('phase', FILTER_SANITIZE_NUMBER_INT);







      $data = [

        'designerId' => $Desigener,

        'status' => $status,

        'phase' => $phase,



      ];



      $builder = $this->db->table('_design')

                          ->where('productId', $id)

                          ->update($data);



      $designers = $this->db->table('_staff')

                          ->select('name, id')

                          ->where('departmentId', 2)

                          #->orderBy('name', 'ASC')

                          ->get()

                          ->getResultArray();





      $encrypter = \Config\Services::encrypter();

      $designersArray = array_column($designers, 'name', 'id');



      $designer = $encrypter->decrypt(base64_decode($designersArray[$Desigener]));



      $data = [

        'productId' => $id,

        'department' => "Design",

        'type' => 'Designer Allocated',

        'details' => 'Unit designer has been allocated to '.$designer,

        'user' => auth()->user()->username,

        'date' => date("Y-m-d H:i:s"),

      ];



      $this->db->table('_production_unit_history')

      ->insert($data);



      return redirect()->back();

      #->with("message", $id . " - Designer allocated");

  

    }



  }



  public function setStatus() 

  {

    if($this->request->is('POST')) {

      $id = $this->request->getPost('productId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $status = $this->request->getPost('status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



      $data = [

        'status' => $status,

      ];



      $builder = $this->db->table('_design')

                          ->where('productId', $id)

                          ->update($data);

     

      $statuses = $this->db->table('_design_status')

      ->get()

      ->getResultArray();



      $statuses = array_column($statuses, 'name', 'id');

      $data = [

        'productId' => $id,

        'department' => "Design",

        'type' => 'Status Set',

        'details' => 'Unit has changed status to '.$statuses[$status],

        'user' => auth()->user()->username,

        'date' => date("Y-m-d H:i:s"),

      ];



      $this->db->table('_production_unit_history')

      ->insert($data);



      return redirect()->back();

      #->with("message", $id . " - Designer allocated");

  

    }



  }



  public function setPhase() 

  {

    if($this->request->is('GET')) {

      $id = $this->request->getGet('productId', FILTER_SANITIZE_NUMBER_INT);

      $phase = $this->request->getGet('phase', FILTER_SANITIZE_NUMBER_INT);



      $oldPhase = $this->db->table('_design')->select('phase')->where('productId', $id)->get()->getRowArray();





      $data = [

        'phase' => $phase,

        'designerId' => NULL,

        'status' => NULL,

      ];



      if($oldPhase['phase'] == 2 OR $oldPhase['phase'] == 3 ) {

        $data['visualPhase'] = 1;

      } else if ($oldPhase['phase'] == 4) {

        $data['cadPhase'] = 1;

      } else if ($oldPhase['phase'] == 5) {

        $data['artworkPhase'] = 1;     

      }



      $builder = $this->db->table('_design')

                          ->where('productId', $id)

                          ->update($data);





      $phases = $this->db->table('_design_phase')

      ->get()

      ->getResultArray();



      $phases = array_column($phases, 'title', 'id');



      $data = [

        'productId' => $id,

        'department' => "Design",

        'type' => 'Phase Set',

        'details' => 'Unit has changed phase to '.$phases[$phase],

        'user' => auth()->user()->username,

        'date' => date("Y-m-d H:i:s"),

      ];

  

      $this->db->table('_production_unit_history')

      ->insert($data);



      return redirect()->back();

      #->with("message", $id . " - Designer allocated");

  

    }



  }



  public function designComplete()

  {

    if($this->request->getPost('productId')) {

      $id = $this->request->getPost('productId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $totalMetres = $this->request->getPost('totalMetres', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $artwork = $this->request->getPost('artwork', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $foam = $this->request->getPost('foam', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $metal = $this->request->getPost('metal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $weld = $this->request->getPost('weld', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $discoReady = $this->request->getPost('discoReady', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $wood = $this->request->getPost('wood', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      

      $data = [

        'totalMetres' =>  $totalMetres,

        'artwork' => $artwork,

        'foam' => $foam,

        'metal' => $metal,

        'weld' =>  $weld,

        'discoReady' =>  $discoReady,

        'wood' => $wood,

      ];



      $this->db->table('_design')

                          ->where('productId', $id)

                          ->update($data);



      if($artwork == 1) {

        $data = [

          'phase' => 4,

          'designerId' => NULL,

        ];

  

        $builder = $this->db->table('_design')

                            ->where('productId', $id)

                            ->update($data);

  

        $data = [

          'productId' => $id,

          'department' => "Design",

          'type' => 'DCAD Complete',

          'details' => 'Unit Design has been moved to artwork phase',

          'user' => auth()->user()->username,

          'date' => date("Y-m-d H:i:s"),

        ];

    

        $this->db->table('_production_unit_history')

        ->insert($data);

      } else {

        $data = [

          'status' => 'Production',

        ];

  

        $this->db->table('products')

                            ->where('product_id', $id)

                            ->update($data);

  

        $data = [

          'productId' => $id,

          'department' => "Design",

          'type' => 'Unit Complete',

          'details' => 'Unit Design has been completed and moved to next department',

          'user' => auth()->user()->username,

          'date' => date("Y-m-d H:i:s"),

        ];

    

        $this->db->table('_production_unit_history')

        ->insert($data);

      }







    }



    return redirect()->back();

  }



  public function lookupModifications() 

  {

    $sku = $this->request->getGet('sku', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $output = $this->db->table('product_modification')

    ->select('id, product_modification.product_id, date, pnumber, type, details, team, product_modification.coef AS coef')

    ->join('products', 'products.product_id = product_modification.product_id')

    ->where('sku', $sku)

    ->where('resolvedBy', NULL)

    ->get()->getResultArray();

    $title = "Outstanding Modifications for - $sku";



    return view(

      "Design/lookupModifications",

      [

        "title" => $title,

        'outputs' => $output,        

      ]

    );

  }



  public function completeModification() 

  {

    $productId = $this->request->getPost('productId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



    $data = [

      'resolvedDate' => date("Y-m-d H:i:s"),

      'resolvedBy' => auth()->user()->username,

    ];



    $builder = $this->db->table('product_modification')

    ->where('id', $id)

    ->update($data);



    # addUnitHistory($productId, 'ProductModification', 'Product Modification has been marked as complete by designer');

        

    

    $data = [

      'productId' => $productId,

      'department' => "Design",

      'type' => 'Modification Complete',

      'details' => 'Unit Modification has been marked as complete by designer',

      'user' => auth()->user()->username,

      'date' => date("Y-m-d H:i:s"),

    ];



    $this->db->table('_production_unit_history')

    ->insert($data);



    return redirect()->back();

    

  }



  public function designerDaily () 

  {

    $builder = $this->db->table('log')

    ->where('staffId', 'SteveJ')

    ->get()

    ->getReslutsArray();



    dd($builder);

  }



  public function addUnitHistory()

  {

    $id = $this->request->getGet('id', FILTER_SANITIZE_NUMBER_INT);



    $events = $this->db->table('_production_unit_history')->where('productId', $id)->get()->getResultArray();



    dd($events);

  }



  /*

  private function addUnitHistory($id, $type, $details) 

  {

    $data = [

      'EventType' => $type,

      'Product_Id' => $id,

      'EventDetails' => $details,

      'User' => auth()->user()->username,

    ];

    $builder = $this->db->table('log');

    $builder->insert($data);

  }

  */

}