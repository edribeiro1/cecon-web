<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TermosDeUso extends CI_Controller
{
    public function index()
    {
        $this->twig->display('termosdeuso/index');
    }
}