<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PageModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;
 
class Page extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    //get all
    public function index()
    {
        $model = new PageModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
 
    }
    // get single page
    public function show($id = null)
    {
        $model = new PageModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if($data){
            return $this->respond($data, 200);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a page
    public function create()
    {
        helper(['form']);
        $rules = [
            'page_name' => 'required|min_length[2]|max_length[100]'
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if(!$header) return $this->failUnauthorized('Token Required');

        // extract the token from the header
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }
        // check if token is null or empty
        if(is_null($token) || empty($token)) {
            $response = service('response');
            $response->setBody('Access denied');
            $response->setStatusCode(401);
            return $response;
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $userdata = (array) $decoded;
        } catch (Exception $ex) {
            $response = service('response');
            $response->setBody('Access denied');
            $response->setStatusCode(401);
            return $response;
        }

        $data = [
            'page_name'     => $this->request->getVar('page_name'),
            'created_by'    => empty($userdata)?0:$userdata['data']->id
        ];
        $model = new PageModel();
        $registered = $model->save($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Page Created'
            ]
        ];
        return $this->respondCreated($response);
    }
 
 
}