<x-app-layout title="All Mahasiswa">

    <div class="row mt-5">
        <h2 class="text-center">All Mahasiswa</h2>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-10">
            <a href="#" class="btn btn-primary mb-2 modalTambah" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Mahasiswa</a>
            <table class="table table-hover">
                <thead>
                  <tr class="table-secondary">
                    <th scope="col">Nama</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Prodi</th>
                    <th scope="col" colspan="2" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody id="bodyMhs">

                </tbody>
              </table>
        </div>
    </div>

    <x-partials.modal-create/>
    <x-partials.modal-edit/>

    @push('costum-js')
        <script src="{{ asset('assets/js/script.js') }}"></script>
    @endpush
</x-app-layout>
