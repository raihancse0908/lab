<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;
 
class Feed extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
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

        $db = db_connect();

        $query = $db->query("   SELECT a.post_content,CONCAT(u.first_name, ' ', u.last_name) as created_by FROM followers f
                                INNER JOIN posts a ON (a.created_by = f.user_id) 
                                INNER JOIN users u ON (a.created_by = u.id) 
                                WHERE f.user_id !=0 AND f.followed_by= ".(empty($userdata)?0:$userdata['data']->id)."

                                UNION ALL 

                                SELECT a.post_content,CONCAT(u.first_name, ' ', u.last_name) as created_by FROM followers f
                                INNER JOIN posts a ON (a.page_id = f.page_id)  
                                INNER JOIN users u ON (a.created_by = u.id) 
                                WHERE f.page_id !=0 AND f.followed_by= ".(empty($userdata)?0:$userdata['data']->id)
                            );
       
        return $this->respond(['posts' => $query->getResult()], 200);
    }
 
}