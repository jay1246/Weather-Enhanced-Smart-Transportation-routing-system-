<?php

namespace App\Filters;
 
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class admin_login implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // print_r(session());
        // echo "fgfg"; 
        // print_r(session()->has('admin_user_id'));
        // exit;
        if (!session()->has('admin_id')) {
            return redirect()->to(base_url('admin/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
