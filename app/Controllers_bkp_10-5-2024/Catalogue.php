<?php

namespace App\Controllers;

# Add the Model
use App\Models\CatalogueModel;

class Catalogue extends BaseController
{
    public function index(): string
    {
        # Call Data from Model
        $model = new CatalogueModel;

        # Pass to array
        $data = $model->paginate();
        
        # Output results to template
        return view("Catalogue/index",
            [
            'title' => 'Products',
            "products" => $data,
            "pager" => $model->pager
            ]
        );
    }

}
