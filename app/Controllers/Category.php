<?php namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $perPage = 10; // Number of items per page
        $search = $this->request->getGet('search'); // Get search query from the request

        // Fetch categories with pagination and optional search
        $data['categories'] = $this->categoryModel->getActiveCategories($perPage, $search);
        
        // Passing pagination links and the search term to the view
        $data['pager'] = $this->categoryModel->pager;
        $data['search'] = $search; // Pass search query to the view to preserve it in the form

        return view("category/index", [
            'title' => 'Category',
            'data'  => $data
        ]);
    }

    // Display form for creating a new category
    public function create()
    {
        return view('category/create', [
            'title' => 'Category',
        ]);
    }

    // Handle the form submission and insert the category into the database
    public function store()
    {
        $validation =  \Config\Services::validation();

        // Define validation rules
        $validation->setRules([
            'categoryName'        => 'required|min_length[3]|max_length[255]',
            'categoryDescription' => 'permit_empty|max_length[500]',
            'status'              => 'required|in_list[1,0]', 
        ]);

        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            // Data is valid, proceed with saving
            $this->categoryModel->save([
                'categoryName'        => $this->request->getPost('categoryName'),
                'categoryDescription' => $this->request->getPost('categoryDescription'),
                'status'              => $this->request->getPost('status'),
                'sort_order'          => $this->request->getPost('sort_order'),
            ]);

            return redirect()->to('/category/index')->with('success', 'Category created successfully');
        } else {
            // Validation failed, return to the form with validation errors
            return view('category/create', [
                'validation' => $validation,
                'title'      => 'Category'
            ]);
        }
    }

    // ** Display form for editing an existing category
    public function edit($id)
    {
        // Find the category by ID
        $category = $this->categoryModel->find($id);

        // If the category is not found, return an error
        if (!$category) {
            return redirect()->to('/category/index')->with('error', 'Category not found');
        }

        // Pass the category data to the view
        return view('category/edit', [
            'title'    => 'Edit Category',
            'category' => $category
        ]);
    }

    // ** Handle the form submission and update the category in the database
    public function update($id)
    {
        $validation =  \Config\Services::validation();

        // Define validation rules
        $validation->setRules([
            'categoryName'        => 'required|min_length[3]|max_length[255]',
            'categoryDescription' => 'permit_empty|max_length[500]',
            'status'              => 'required|in_list[1,0]', 
        ]);

        // If the form is submitted and validation passes
        if ($this->request->getMethod() === 'post' && $validation->withRequest($this->request)->run()) {
            // Data is valid, proceed with updating the category
            $this->categoryModel->update($id, [
                'categoryName'        => $this->request->getPost('categoryName'),
                'categoryDescription' => $this->request->getPost('categoryDescription'),
                'status'              => $this->request->getPost('status'),
                'sort_order'          => $this->request->getPost('sort_order'),
            ]);

            return redirect()->to('/category/index')->with('success', 'Category updated successfully');
        } else {
            // Validation failed, return to the edit form with validation errors
            $category = $this->categoryModel->find($id);
            return view('category/edit', [
                'validation' => $validation,
                'category'   => $category,
                'title'      => 'Edit Category'
            ]);
        }
    }

    public function delete($id)
    {
        // Delete the category by its ID
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/category/index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->to('/category/index')->with('error', 'Failed to delete category');
        }
    }
    
}
