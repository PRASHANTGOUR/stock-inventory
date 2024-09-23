<?php

namespace App\Controllers;

# Add the Model
use App\Models\UserManagementModel;
use CodeIgniter\Shield\Entities\User;

class UserManagement extends BaseController
{
    private UserManagementModel $model;

    public function __construct()
    {
        $this->model = new UserManagementModel;
    }

    public function index()
    {
        $users = $this->model->findAll();

        $title = "User Management";

        return view('UserManagement/index', [
            "title" => $title,
            "users" => $users
        ]);
    }

    public function getUser($id) 
    {
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();
        $user = $users->findById($id);
        
        if($this->request->is('post')) {
            $username = $this->request->getPost('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = $this->request->getPost('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $groups = $this->request->getPost('groups', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $user->fill([
                'username' => $username,
                'email'    => $email,
            ]);
       
            $user->syncGroups(...$groups);

            return redirect()->to("/user-management")
                                ->with("message", $user->username." - User updated successfully");

        } else {
            $title = "Edit User";
            return view('UserManagement/editUser', [
                "title" => $title,
                'user'  => $user,
            ]);
        }

    }

    # Create User
    public function addUser() 
    {

        if($this->request->is('post')) {
            $username = $this->request->getPost('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = $this->request->getPost('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $groups = $this->request->getPost('groups', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $this->request->getPost('staff_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            // Get the User Provider (UserModel by default)
            $users = auth()->getProvider();
    
            $user = new User([
                'username' => $username,
                'email'    => $email,
                'password' => '8h945gh78gy459gy805897t90853kv4035.583k',
                'staff_id' => $id,
            ]);
            $users->save($user);
    
            // To get the complete user object with ID, we need to get from the database
            $user = $users->findById($users->getInsertID());
    
            $user->addGroup(...$groups);
            $user->forcePasswordReset();

            return redirect()->to("/user-management")
                             ->with("message", $user->username." - User created successfully");
        } else {
            $staffId = $this->request->getGet('staffId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $title = "Create User";
            return view('UserManagement/addUser', [
                "title" => $title,
                "staffId" => $staffId,
            ]);
        }


    }

    public function resetPassword()
    {
        $title = "Set Password";
        return view('UserManagement/reset', [
            "title" => $title,
        ]);
    }

    public function forcePasswordChange($id) {
        $users = auth()->getProvider();
        $user = $users->findById($id);
        $user->forcePasswordReset();
        return redirect()->to("/user-management")
                         ->with("message", $user->username." - User force password reset set");
    }

    public function disableUser($id) 
    {
        $users = auth()->getProvider();
        $user = $users->findById($id);
    
        $user->ban('Your account has been disabled');

        return redirect()->to("/user-management")
                         ->with("message", $user->username." - User has been disabled successfully");
    }

    public function enableUser($id) 
    {
        $users = auth()->getProvider();
        $user = $users->findById($id);
    
        $user->unBan();

        return redirect()->to("/user-management")
                         ->with("message", $user->username." - User has been disabled successfully");
    }

    public function setPassword() 
    {
        $rules = [
            "password" => [
                "label" => "Password",
                "rules" => "required|strong_password"
            ],
            "password_confirm" => [
                "label" => "Password Confirmation",
                "rules" => "required|matches[password]"
            ]
        ];

        if ( ! $this->validate($rules)) {

            return redirect()->back()
                             ->with("errors", $this->validator->getErrors());

        }

        $user = auth()->user();

        $user->password = $this->request->getPost('password');
        $user->undoForcePasswordReset();

        $model = new UserManagementModel;
        $model->save($user);

        session()->removeTempdata("magicLogin");

        return redirect()->to("/")
                         ->with("message", "Password changed successfully");
    }

    public function deleteUser($id) 
    {
        $users = auth()->getProvider();
        $user = $users->findById($id);
    
        $users->delete($user->id,true);

        return redirect()->to("/user-management")
                         ->with("message", $user->username." User has been deleted permantly");
    }
}