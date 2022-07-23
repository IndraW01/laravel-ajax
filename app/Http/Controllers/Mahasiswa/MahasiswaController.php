<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa\Mahasiswa;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->view('mahasiswa.index');
    }

    public function allMahasiswa()
    {
        $mahasiswas = Mahasiswa::latest()->get();

        return response()->json(
            $mahasiswas,
            200,
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMahasiswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMahasiswaRequest $request)
    {
        $rules = [
            'nama' => 'required|max:50',
            'nim' => 'required|max:12|' . Rule::unique('mahasiswas'),
            'prodi' => 'required'
        ];

        $validateData = Validator::make($request->all(), $rules);

        if($validateData->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validateData->errors()
            ]);
        }

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menambah Data Mahasiswa ' . $mahasiswa->nama
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMahasiswaRequest  $request
     * @param  \App\Models\Mahasiswa\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $rules = [
            'nama' => 'required|max:50',
            'nim' => 'required|max:12|' . Rule::unique('mahasiswas')->ignore($mahasiswa->id),
            'prodi' => 'required'
        ];

        $validateData = Validator::make($request->all(), $rules);

        if($validateData->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validateData->errors()
            ]);
        }

        $mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Edit Mahasiswa ' . $mahasiswa->nama
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Mengahapus Mahasiswa ' . $mahasiswa->nama
        ]);
    }
}
