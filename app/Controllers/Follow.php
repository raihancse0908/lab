<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\FollowerModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;
 
class Follow extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    
    // follow a page
    public function page($id)
    {
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
            'user_id'       => 0,
            'page_id'       => $id,
            'followed_by'   => empty($userdata)?0:$userdata['data']->id
        ];
        $model = new FollowerModel();
        $registered = $model->save($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Followed Successfully'
            ]
        ];
        return $this->respondCreated($response);
    }
 
    // follow a person
    public function person($id)
    {
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
            'user_id'       => $id,
            'page_id'       => 0,
            'followed_by'   => empty($userdata)?0:$userdata['data']->id
        ];
        $model = new FollowerModel();
        $registered = $model->save($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Followed Successfully'
            ]
        ];
        return $this->respondCreated($response);
    }
 
 
}