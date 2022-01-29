<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostModel;
use App\Models\PageModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;
 
class Post extends ResourceController
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
        $model = new PostModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
 
    }
    // get single page
    public function show($id = null)
    {
        $model = new PostModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if($data){
            return $this->respond($data, 200);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a page
    public function create($id = 0)
    {
        if( $id >0 ){
            $pageModel = new PageModel();
            $data = $pageModel->getWhere(['id' => $id])->getResult();
            if( empty($data) ){
                return $this->failNotFound('No Data Found with page id '.$id);
            }
        }
        helper(['form']);
        $rules = [
            'post_content' => 'required'
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
            if(empty($userdata)){
                $response = service('response');
                $response->setBody('Access denied');
                $response->setStatusCode(401);
                return $response;            
            }
        } catch (Exception $ex) {
            $response = service('response');
            $response->setBody('Access denied');
            $response->setStatusCode(401);
            return $response;
        }

        $data = [
            'post_content'  => $this->request->getVar('post_content'),
            'page_id'       => $id,
            'created_by'    => empty($userdata)?0:$userdata['data']->id
        ];
        $model = new PostModel();
        $registered = $model->save($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Post Created'
            ]
        ];
        return $this->respondCreated($response);
    }
 
 
}