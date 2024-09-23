<?php

namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';  

    // Fields that can be updated or inserted
    protected $allowedFields = [
        'categoryName', 
        'categoryDescription', 
        'status', 
        'created_at', 
        'updated_at', 
    ];

    // Enable automatic timestamps (created_at, updated_at)
    protected $useTimestamps = true;
    
    // Auto-managing the timestamps for created and updated fields
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


     // Fetch active categories with pagination
     public function getActiveCategories($perPage = 10, $search = null)
     {
         // If search is provided, use LIKE query
         if ($search) {
             return $this->whereIn('status', ['1', '0'])
                         ->like('categoryName', $search)
                         ->paginate($perPage);
         }
 
         // Return paginated results
         return $this->whereIn('status', ['1', '0'])
                     ->paginate($perPage);
     }

}
