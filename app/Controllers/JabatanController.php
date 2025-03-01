<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use CodeIgniter\HTTP\ResponseInterface;

class JabatanController extends BaseController
{

    protected $modelJabatan;
    public function __construct()
    {
        if (!session()->get('login')) {
            redirect()->to('/login')->with('error', 'Login dulu iciboss..')->send();
            exit;
        }
        $this->modelJabatan = new JabatanModel();
    }
    public function index()
    {
        $data['jabatan'] = $this->modelJabatan->findAll();
        return view('jabatan/index', $data);
    }

    public function show($id)
    {
        // 
    }

    public function create()
    {
        return view('jabatan/create');
    }
    public function store()
    {
        $data = [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'deskripsi_jabatan' => $this->request->getPost('deskripsi_jabatan'),

        ];

        $this->modelJabatan->save($data);
        //  membuat flash data
        session()->setFlashdata('sukses', 'Data jabatan berhasil ditambahkan');
        return redirect()->to('jabatan');
    }
    public function edit($id)
    {
        $data['jabatan'] =  $this->modelJabatan->find($id);
        return view('jabatan/edit', $data);
    }
    public function update($id)
    {
        $data = [
            'id' => $id,
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'deskripsi_jabatan' => $this->request->getPost('deskripsi_jabatan'),
        ];

        $this->modelJabatan->save($data);
        //  membuat flash data cara simple
        return redirect()->to('jabatan')->with('sukses', 'Data jabatan berhasil diupdate');
    }
    public function delete($id)
    {
        $modelPegawai = new PegawaiModel();
        $cekPegawai = $modelPegawai->where('jabatan_id', $id)->countAllResults();

        if($cekPegawai > 0){
            return redirect()->to('jabatan')->with('gagal', 'Data jabatan tidak dapat dihapus karena digunakan di data pegawai');

        }

        // Proses hapus
        $this->modelJabatan->delete($id);
        //  membuat flash data
        session()->setFlashdata('sukses', 'Data jabatan berhasil dihapus');
        return redirect()->to('jabatan');
    }
}
