<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'Libraries/Format.php';



/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */


class mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');

        $this->methods['index_get']['limit'] = 100;
        $this->methods['index_delete']['limit'] = 100;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_put']['limit'] = 100;
        
    }
    public function index_get()
    {
        $id = $this->get('id');
        if($id === null){
            $mahasiswa = $this->mahasiswa->getMahasiswa();

        }else{
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }
        
        if ($mahasiswa){
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ],REST_Controller::HTTP_OK);
            
        }else{
            $this->response([
                'status' => false,
                'message' => 'Id not found'
            ],REST_Controller::HTTP_NOT_FOUND);

        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === null){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID!'
            ],REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->mahasiswa->deleteMahasiswa($id) > 0 ){
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ],REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Id not found'
                ],REST_Controller::HTTP_BAD_REQUEST);
    
            }
        }
    }
    public function index_post()
    {
        $data =[ 
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];
        if($this->mahasiswa->createMahasiswa($data)> 0){
            $this->response([
                'status'=> true,
                'message' => 'New mahasiswa has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else{
            $this->response([
                'status' => false,
                'message' => 'failed to created new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this -> put('id');
        $data =[ 
            'nama' => $this->put('nama'),
            'nrp' => $this->put('nrp'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if($this->mahasiswa->updateMahasiswa($data, $id)> 0){
            $this->response([
                'status'=> true,
                'message' => 'Data has been updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else{
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }
} 
