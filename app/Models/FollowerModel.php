<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class FollowerModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'followers';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['user_id','page_id','followed_by'];
 
}