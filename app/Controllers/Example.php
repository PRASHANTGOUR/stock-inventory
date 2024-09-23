<?php

namespace App\Controllers;

# Add the Model
use App\Models\ExampleModel;

class Example extends BaseController
{
    public function index(): string
    {
        # Call Data from Model
        $model = new ExampleModel;

        # Pass to array
        $data = $model->findAll();
        
        # Output results to template
        return view("Example/index",
            ["products" => $data]);
    }

    # Insert example
    
    public function create() 
    {
        $model = new ExampleModel;

        # Insert data in to DB from Post
        # Note this is not sanitized so have to use esc() when output.  Prefer to sanitised on input personally but training video does it this way.
        // $request->getVar(null, FILTER_SANITIZE_FULL_SPECIAL_CHARS); # returns all POST items with string sanitation
        $id = $model->insert($this->request->getPost());

        # Error handling after validation by model and output errors from seesion via with() and pssing back the error and go back to submit page
        if ($id === false) {
            return redirect()->back() # Return back to form page
                             ->with("errors", $model->errors()) # Errors passed to sessiong for output
                             ->withInput(); # Returns previous values
        }

        # Use $model -> insertID to get last ID of inserted value useful for log
        //$model -> insertID;

        # Redirect on completeion this would redirect to a page and use the id from the new record to view it.
        return redirect()->to("Example/$id") # Redirects 
                         ->with("message", "Product added"); # Adds message 


    }
    
    # Show Example
    public function show($id) 
    {
        $model = new ExampleModel;

        $example = $model->find($id);

        return view("Example/show", [
            "example" => $example
        ]);
    }

    # Edit Example 
    public function edit($id) 
    {
        $model = new ExampleModel;

        $example = $model->find($id);

        return view("Articles/edit", [
            "example" => $example
        ]);
    }

    
    
}
