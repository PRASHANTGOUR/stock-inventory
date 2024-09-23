<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductionModel extends Model
{
    # Call in table
    protected $table = "products";

    # Need to set allowed fields
    # Example These are basically the column name in table in DB
    // protected $allowedFields = ['title', 'content']

    # Validation
    # Example
    /*
    protected $validationRules = [
        "title" => "required|max_length[128]", #Set as required and max length 128 characters
        "content" => "required"
    ]
    */

    # Custom validation error messages
    # Example
    /*
    protected $validationationMessages = [
        "title" => [ # Create array for the field
            "required" => "Please enter a title" # Set a new message for example required
        ]
    ];
    
    */

}