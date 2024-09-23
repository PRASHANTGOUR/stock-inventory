<?php

namespace App\Controllers;

use App\Models\CatalogueModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Catalogue extends BaseController
{
    // Display the product listing
    public function index(): string
    {
        $model = new CatalogueModel();
        // Number of products per page
        $perPage = 10;
    
        // Get the current page number from the URL (default to 1 if not set)
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
    
        // Get the search term from the request
        $search = $this->request->getVar('search');
    
        // Check if there's a search query
        if ($search) {
            // If search query exists, fetch filtered paginated results
            $products = $model->searchProducts($search, $perPage, $currentPage);
        } else {
            // Otherwise, just fetch all paginated products
            $products = $model->paginate($perPage, 'default', $currentPage);
        }
    
        // Return the view with the required data
        return view("Catalogue/index", [
            'title' => 'Products',
            'products' => $products, // Use products that might be filtered or all
            'pager' => $model->pager, // Pager for pagination
            'search' => $search       // Retain the search term in the view
        ]);
    }
    

    // Display form for creating a new product
    public function create()
    {
        return view('Catalogue/create', [
            'title' => 'Add New Product',
        ]);
    }

    // Handle form submission to create a product
    public function store()
    {
        $model = new CatalogueModel();

        if (!$this->validate([
            'product_name' => 'required|min_length[3]|max_length[255]',
            'sku' => 'required|is_unique[inverntory_products.sku]|max_length[100]',
            'price' => 'required|decimal',
            'quantity' => 'required|integer',
            'rating' => 'permit_empty|decimal|less_than_equal_to[5.00]',
            'status' => 'required|in_list[available,out_of_stock,discontinued]',
            'thumbnail' => [
                'uploaded[thumbnail]',
                'mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'max_size[thumbnail,2048]',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form input data
        $productData = [
            'product_name' => $this->request->getPost('product_name'),
            'sku' => $this->request->getPost('sku'),
            'price' => $this->request->getPost('price'),
            'quantity' => $this->request->getPost('quantity'),
            'rating' => $this->request->getPost('rating'),
            'status' => $this->request->getPost('status'),
        ];

        // Handle file upload
        $file = $this->request->getFile('thumbnail');
        if ($file->isValid() && !$file->hasMoved()) {
            $newFileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newFileName);
            $productData['upload_thumbnail'] = 'uploads/' . $newFileName;
        }

        $model->insert($productData);

        return redirect()->to('/catalogue/products')->with('success', 'Product created successfully!');
    }

    // Display form for editing an existing product
    public function edit($id)
    {
        $model = new CatalogueModel();
        $product = $model->find($id);

        if (!$product) {
            throw new PageNotFoundException("Product with ID $id not found.");
        }

        return view('Catalogue/edit', [
            'title' => 'Edit Product',
            'product' => $product
        ]);
    }

    // Handle the form submission and update the product
    public function update($id)
    {
        $model = new CatalogueModel();
        $product = $model->find($id);

        if (!$product) {
            throw new PageNotFoundException("Product with ID $id not found.");
        }

        // Validation rules
        $validationRules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'sku' => 'required|max_length[100]',
            'price' => 'required|decimal',
            'quantity' => 'required|integer',
            'rating' => 'permit_empty|decimal|less_than_equal_to[5.00]',
            'status' => 'required|in_list[available,out_of_stock,discontinued]',
            'thumbnail' => [
                'mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
                'max_size[thumbnail,2048]',
            ],
        ];

        if ($this->validate($validationRules)) {
            $data = [
                'product_name' => $this->request->getPost('product_name'),
                'sku' => $this->request->getPost('sku'),
                'price' => $this->request->getPost('price'),
                'quantity' => $this->request->getPost('quantity'),
                'rating' => $this->request->getPost('rating'),
                'status' => $this->request->getPost('status'),
            ];

            // Handle the thumbnail upload
            $thumbnail = $this->request->getFile('thumbnail');
            if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
                $newName = $thumbnail->getRandomName();
                $thumbnail->move(WRITEPATH . 'uploads/', $newName);
                $data['upload_thumbnail'] = 'uploads/' . $newName;

                // Delete old thumbnail
                if (!empty($product['upload_thumbnail']) && file_exists(WRITEPATH . 'uploads/' . $product['upload_thumbnail'])) {
                    unlink(WRITEPATH . 'uploads/' . $product['upload_thumbnail']);
                }
            }

            if ($model->update($id, $data)) {
                session()->setFlashdata('success', 'Product updated successfully.');
            } else {
                session()->setFlashdata('error', 'Failed to update the product.');
            }

            return redirect()->to('/catalogue/products');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    // Method to handle product deletion
    public function delete($id)
    {
        $model = new CatalogueModel();
        $product = $model->find($id);

        if (!$product) {
            throw new PageNotFoundException("Product with ID $id not found.");
        }

        if ($model->delete($id)) {
            // Optionally, delete the thumbnail file if stored locally
            if (!empty($product['upload_thumbnail']) && file_exists(WRITEPATH . 'uploads/' . $product['upload_thumbnail'])) {
                unlink(WRITEPATH . 'uploads/' . $product['upload_thumbnail']);
            }

            session()->setFlashdata('success', 'Product deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete the product.');
        }

        return redirect()->to('/catalogue/products');
    }
}
