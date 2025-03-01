<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\PegawaiModel;
use CodeIgniter\HTTP\ResponseInterface;

class PegawaiController extends BaseController
{

    protected $modelPegawai;
    public function __construct()
    {
        $this->modelPegawai = new PegawaiModel();
    }

    public function index()
    {
        $data['pegawai'] = $this->modelPegawai->getPegawaiWithJabatan();
        return view('pegawai/index', $data);
    }

    public function show($id)
    {
        $data['pegawai'] = $this->modelPegawai->getPegawaiWithJabatanWhere($id);
        return view('pegawai/show', $data);
    }

    public function create()
    {
        $modelJabatan = new JabatanModel();
        $data['jabatan'] = $modelJabatan->findAll();
        return view('pegawai/create', $data);
    }
    public function store()
    {
        $data = [
            'nama_pegawai' => $this->request->getPost('nama_pegawai'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
        ];
        // menghandle foto
        $fileFoto = $this->request->getFile('file_foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFile = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFile);
            $data['foto_pegawai'] = $namaFile;
        }

        $this->modelPegawai->save($data);
        session()->setFlashdata([
            'swal_icon' => 'success',
            'swal_title' => 'Sukses Membuat!',
            'swal_text' => 'Data pegawai berhasil ditambahkan.'

        ]);
        return redirect()->to('pegawai');
    }
    public function edit($id)
    {
        $modelJabatan = new JabatanModel();
        $data['jabatan'] = $modelJabatan->findAll();
        $data['pegawai'] =  $this->modelPegawai->find($id);
        return view('pegawai/edit', $data);
    }
    public function update($id)
    {
        $data = [
            'id' => $id,
            'nama_pegawai' => $this->request->getPost('nama_pegawai'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),

        ];
        // Ambil foto lama
        $fotoLama = $this->request->getPost('foto_lama');

        // menghandle foto
        $fileFoto = $this->request->getFile('file_foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFile = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFile);
            $data['foto_pegawai'] = $namaFile;

            // hapus fotolama jika ada
            $fotoLama = $this->request->getPost('foto_lama');
            if (!empty($fotoLama)) {
                $filePath = 'uploads/' . $fotoLama;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->modelPegawai->save($data);
        session()->setFlashdata([
            'swal_icon' => 'success',
            'swal_title' => 'Sukses Update!',
            'swal_text' => 'Data pegawai berhasil diupdate.'

        ]);
        return redirect()->to('pegawai');
    }
    public function delete($id)
    {
        // $this->modelPegawai->delete($id);
        $pegawai = $this->modelPegawai->find($id);
        if ($pegawai) {
            if (!empty($pegawai->foto_pegawai)) {
                $filePath = 'uploads/' . $pegawai->foto_pegawai;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }
            $this->modelPegawai->delete($id);
        }
        session()->setFlashdata([
            'swal_icon' => 'success',
            'swal_title' => 'Sukses!',
            'swal_text' => 'Data pegawai berhasil dihapus.'

        ]);
        return redirect()->to('pegawai');
    }
}
