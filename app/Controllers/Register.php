<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
 
class Register extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]|max_length[100]',
            'password' => 'required|min_length[6]|max_length[100]',
            'confpassword' => 'matches[password]'
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $data = [
            'first_name'     => $this->request->getVar('first_name'),
            'last_name'     => $this->request->getVar('last_name'),
            'email'     => $this->request->getVar('email'),
            'password'  => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT) 
        ];
        $model = new UserModel();
        $registered = $model->save($data);
        $user_id = $model->getInsertID();
        $person = $model->getWhere(['id' => $user_id])->getResult();
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved',
                'person' => $person
            ]
        ];
        return $this->respondCreated($response);
 
    }
 
}