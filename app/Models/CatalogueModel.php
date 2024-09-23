<?php 

namespace App\Models;

use CodeIgniter\Model;

class CatalogueModel extends Model
{
    // Define the table name
    protected $table = 'inverntory_products';  // Assuming 'products' is the correct table name

    // Specify the primary key of the table
    protected $primaryKey = 'id';

    // Allowable fields for insert/update
    protected $allowedFields = [
        'product_name',
        'upload_thumbnail',
        'sku',
        'price',
        'quantity',
        'rating',
        'status'
    ];


    public function searchProducts($search, $perPage, $currentPage)
    {
        return $this->like('product_name', $search)
                    ->orLike('sku', $search)
                    ->paginate($perPage, 'default', $currentPage);
    }

    // Optional: Enable automatic timestamps if your table has `created_at` and `updated_at` fields
    protected $useTimestamps = false;  // Set to true if timestamps are used

    // Custom validation messages (optional)
    protected $validationMessages = [
        'sku' => [
            'is_unique' => 'The SKU must be unique.'
        ]
    ];

    // Optional: Disable soft deletes (set true if using soft deletes)
    protected $useSoftDeletes = false;
    
}
