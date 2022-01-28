<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class PageModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'pages';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['page_name','created_by'];
 
}