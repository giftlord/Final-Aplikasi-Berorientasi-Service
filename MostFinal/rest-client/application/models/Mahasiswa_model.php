<?php 

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model {


    private $_client;

    public function __construct() 
    {
        $this->_client = new Client([
            'base_uri' => 'http://localhost/rest-api/Tugas-rest-server/api/',
            'auth' =>   ['admin', 'secretpass']
        ]);
    }
    public function getAllMahasiswa()
    {
        $response = $this->_client->request('GET', 'mahasiswa',[
            'query' =>[
                'Servis-K-04' => 'kelompok04'
            ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['data'];
    }

    public function getMahasiswaById($id)
    {

        $response = $this->_client->request('GET', 'mahasiswa',[
            'query' =>[
                'Servis-K-04' => 'kelompok04',
                'id' => $id
            ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['data'][0];
    }

    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'Servis-K-04' => 'kelompok04'
        ];

        $response = $this->_client->request('POST','mahasiswa',[
            'form_params'=> $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function hapusDataMahasiswa($id)
    {
        $response = $this->_client->request( 'DELETE', 'mahasiswa',[
            'form_params' => [
                'id' => $id,
                'Servis-K-04' => 'kelompok04'
                ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result;
    }

    

    public function ubahDataMahasiswa()
{
    $nama = $this->input->input_stream('nama', true);
    $nrp = $this->input->input_stream('nrp', true);
    $email = $this->input->input_stream('email', true);
    $jurusan = $this->input->input_stream('jurusan', true);
    $id = $this->input->input_stream('id', true);

    // Check if required inputs are set
    if (!isset($nama, $nrp, $email, $jurusan, $id)) {
        return ["error" => "Incomplete data provided"];
    }

    $data = [
        "nama" => $nama,
        "nrp" => $nrp,
        "email" => $email,
        "jurusan" => $jurusan,
        "id" => $id,
        'Servis-K-04' => 'kelompok04'
    ];

    try {
        $response = $this->_client->request('PUT', 'mahasiswa', [
            'form_params' => $data
        ]);

        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody()->getContents(), true);
            return $result;
        } else {
            return ["error" => "Failed to update data"];
        }
    } catch (\Exception $e) {
        return ["error" => $e->getMessage()];
    }
}

    


    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}