<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // mengambil data dari input search
        $search = $request->search;
        // memanggil libraries baseapi method nya index dengan mengirim parameter1 berupa path data dari apinya, parameter2 data untuk mengisi search_nama apinya
        $data = (new BaseApi)->index('/api/students',['search_nama' => $search]);
        // ambil response json nya 
        $students = $data->json();
        // dd($students);
        // kirim hasil pengambilan data ke blade index
        // ambil property data dari response json
        return view ('index')->with(['students' => $students['data']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
           'nama' => $request->nama,
           'nis' => $request->nis,
           'rombel' => $request->rombel,
           'rayon' => $request->rayon,

        ];

        $proses = (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors ' => $errors]);
        }else {
            return redirect('/')->with('success', 'berhasil menambahkan data baru ke halaman students API');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //proses ambil data api ke route REST API /student/{id}
        $data = (new BaseApi)->edit('/api/student/' .$id);
         if ($data->failed()) {
            // kalau gagal proses $data diatas, ambil deskripsi err dari json property data
            $errors = $data->json(['data']);
            // balikin ke halaman awal , sama errors nya 
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // kalau berhasil ambil data dari json nya 
            $student = $data->json(['data']);
            // alihin ke blade edit dengan mengirim data $student diatas agar bisa digunakan pada blade 
            return view('edit')->with(['student' => $student]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // DATA YANGA AKAN DIKIRIM ($request ke REST APINYA)
        $spayload = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
         // panggil method update dari baseapi , kirim endpoint(route update dari rest apinya) dan data (spayload diatas)
        $proses = (new BaseApi)->update('/api/students/update/' .$id, $spayload);
        if ($proses->failed()) {
            // kalau gagal balikin lagi sama pesan erorrs dari json nya 
            $errors = $proses->json(['data']);
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            // berhasil, balikin halaman paling awal dengan pesan 
            return redirect('/')->with('success', 'berhasil mengubah data siswa dari API');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/' .$id);
        if ($proses->failed()) {
            $errors = $proses->json(['data']);
            return redirect()->back()->with(['errors' => $errors]);
    }else {
       
        return redirect('/')->with('success', 'berhasil hapus data sementara  dari API');
    }
}

 public function trash()
 {
    $proses = (new BaseApi)->trash('/api/students/show/trash');
    if ($proses->failed()) {
        $errors = $proses->json(['data']);
        return redirect()->back()->with(['errors' => $errors]);
}else {
        $studentsTrash = $proses->json('data');
        return view('trash')->with(['studentsTrash' => $studentsTrash]);
}
 }

  public function permanent($id)
  {
    $proses = (new BaseApi)->trash('/api/students/trash/delete/permanent/'.$id);
    if ($proses->failed()) {
        $errors = $proses->json(['data']);
        return redirect()->back()->with(['errors' => $errors]);
  }else {
    return redirect()->back()->with('success', 'berhasil menghapus data secara permanen');
  }
}

 public function restore($id)
 {
    $proses = (new BaseApi)->trash('/api/students/trash/restore/'.$id);
    if ($proses->failed()) {
        $errors = $proses->json(['data']);
        return redirect()->back()->with(['errors' => $errors]);
  }else {
    return redirect('/')->with('success', 'berhasil mengembalikan data dari sampah');
  }
}
 }

