<?php
// perbedaan helpers dan libraries
// helpers : bikin api 
// libraries : bikin api
namespace App\Http\Libraries;
//mengatur posisi file :namespace
use Illuminate\Support\Facades\Http;

class BaseApi 
{
    //variabel yang cuma bisa di akses d class ini dan turunan nya
    protected $baseUrl;
    // constraktor: menyiapkan isi data , di jalankan otomatis tanpa d panggil
    public function __construct()
    {
        // var $baseUrl yang di atas diisi nilai nya dari isian file .env bagian API_HOST 
        // var ini diisi otomatis ketika file/class BaseApi dipanggil di controller
        $this->baseUrl = env('API_HOST');
    }

    private function client()
    {
        // koneksikan ip dari var $baseUrl ke depedency Http 
        // menggunakan depedency Http karena projek API nya berbasis web (protokol Http)
        return Http::baseUrl($this->baseUrl);
    }

    public function index(string $endpoint, Array $data = [])
    {
        // manggil ke func client yg d atas , trs manggil path yang dari endpoint yg dikirim controllernya kalau ada data yang mau d cari params di postman di ambil dari parameter $data
        return $this->client()->get($endpoint, $data);
    }

    public function store(String $endpoint, Array $data = [])
    {
        // pake ()post karena route tambah data di projek REST API nya pake ::post 
        return $this->client()->post($endpoint, $data);
    }
    public function edit(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }
    public function update(String $endpoint, Array $data = [])
    {
        return $this->client()->patch($endpoint, $data);
    }
    public function delete(String $endpoint, Array $data = [])
    {
        return $this->client()->delete($endpoint, $data);
    }
    public function trash(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }
    public function permanent(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }
}