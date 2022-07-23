// Fungsi Remove Status
function removeStatus () {
    let alertRemove = document.querySelector('.rmv-alert');
    alertRemove ? alertRemove.remove() : '';

    let flashRemove = document.querySelector('.rmv-flash');
    flashRemove ? flashRemove.remove() : '';
}

// fungsi menampilkan status
function displayStatus (json, param) {
    const alert = document.createElement('div');
    alert.classList.add('alert');
    alert.classList.add('alert-danger');
    alert.classList.add('rmv-alert');
    alert.setAttribute('role', 'alert');

    if(param == 'tambah') {
        document.getElementById('modalBody').prepend(alert);
    } else {
        document.getElementById('modalBodyEdit').prepend(alert);
    }

    let ul = document.createElement('ul');

    Object.entries(json.errors).forEach(([key, value]) => {
        let li = document.createElement('li');
        li.textContent = value[0];

        ul.appendChild(li);
    }
    )

    alert.appendChild(ul);
}

// Fungsi Render Element
function renderElement (mahasiswa) {
    return `<tr>
        <td>${mahasiswa.nama}</td>
        <td>${mahasiswa.nim}</td>
        <td>${mahasiswa.prodi}</td>
        <td>
            <button type="button" value="${mahasiswa.nim}" class="editMahasiswa btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
        </td>
        <td>
            <button type="button" value="${mahasiswa.nim}" class="deleteMahasiswa btn btn-danger">Hapus</button>
        </td>
    </tr>`
}

// Fungsi Mengambil data Mahasiswa
function getAllMahasiswa () {
    return fetch('https://laravel-ajax.dev/mahasiswas/all')
        .then(response => response.json())
        .then(response => response)
}

// Fungsi Menampilkan data Mahasiswa
async function displayAllMahasiswa () {
    // awit getAllMahasiswa tunggu sampai datanya resolve
    const mahasiswas = await getAllMahasiswa();

    document.getElementById('bodyMhs').innerHTML = '';

    mahasiswas.forEach(mahasiswa => {
        document.getElementById('bodyMhs').insertAdjacentHTML('beforeend', renderElement(mahasiswa));
    });

    displayEditModal();

    deleteMahasiswa();
}

// Fungsi hapus mahasiswa
function deleteMahasiswa () {
    const btnDeleteMahasiswa = document.querySelectorAll('.deleteMahasiswa');

    btnDeleteMahasiswa.forEach((deleteMahasiswa) => {
        deleteMahasiswa.addEventListener('click', function() {
            let hasil = confirm('Yakin Menghapus Mahasiswa');

            let valueNim = deleteMahasiswa.value;

            if(hasil) {
                const response = fetch(`https://laravel-ajax.dev/mahasiswas/${valueNim}`, {
                    method: 'DELETE',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Content-Type": 'application/x-www-form-urlencoded'
                    },
                })

                response
                    .then(response => response.json())
                    .then(json => {
                        removeStatus();

                        document.getElementById('modalClose').click();
                        document.getElementById('formTambah').reset();

                        document.querySelector('.modalTambah').insertAdjacentHTML('afterend',
                            `<div class="alert alert-success alert-dismissible fade show mt-2 rmv-flash" role="alert">
                                ${json.message}
                            </div>`
                        )

                        displayAllMahasiswa();
                    })
            }
        });
    });
}

// Fungi Tampil modal edit
function displayEditModal () {
    const btnEditMahasiswa = document.querySelectorAll('.editMahasiswa');

    btnEditMahasiswa.forEach((edit) => {
        edit.addEventListener('click', function(event) {
            removeStatus();

            let valueNim = edit.value;

            const response = fetch(`https://laravel-ajax.dev/mahasiswas/${valueNim}/edit`);

            response
                .then(response => response.json())
                .then(json => {
                    document.getElementById('nimBefore').value = json.nim;
                    document.getElementById('namaEdit').value = json.nama;
                    document.getElementById('nimEdit').value = json.nim;
                    document.getElementById('prodiEdit').value = json.prodi;
                })
                .catch(error => console.log('Mahasiswa Tidak Ada'))
        });
    })
}

// fungsi data form create mahasiswa
function formCreateDataMahasiswa () {
    const form = new URLSearchParams();
    form.append('nama', document.getElementById('nama').value);
    form.append('nim', document.getElementById('nim').value);
    form.append('prodi', document.getElementById('prodi').value);

    return form;
}

// event create mahasiswa
document.getElementById('tambahMahasiswa').addEventListener('click', function(event) {
    const response = fetch('https://laravel-ajax.dev/mahasiswas', {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": 'application/x-www-form-urlencoded'
        },
        body: formCreateDataMahasiswa()
    })

    response
        .then(response => response.json())
        .then(json => {
            if(json.status === 400) {
                removeStatus();

                displayStatus(json, 'tambah');
            } else {
                removeStatus();

                document.getElementById('modalClose').click();
                document.getElementById('formTambah').reset();

                document.querySelector('.modalTambah').insertAdjacentHTML('afterend',
                    `<div class="alert alert-success alert-dismissible fade show mt-2 rmv-flash" role="alert">
                        ${json.message}
                    </div>`
                )

                displayAllMahasiswa()
            }
        })
        .catch(error => {
            console.info(error);
        });
});

// fungsi data form edit mahasiswa
function formEditDataMahasiswa () {
    const form = new URLSearchParams();
    form.append('nama', document.getElementById('namaEdit').value);
    form.append('nim', document.getElementById('nimEdit').value);
    form.append('prodi', document.getElementById('prodiEdit').value);

    return form;
}

// event update mahasiswa
document.getElementById('editMahasiswa').addEventListener('click', function(event) {
    let valueMahasiswaNim = document.getElementById('nimBefore').value;

    const response = fetch(`https://laravel-ajax.dev/mahasiswas/${valueMahasiswaNim}`, {
        method: 'PATCH',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": 'application/x-www-form-urlencoded'
        },
        body: formEditDataMahasiswa()
    });

    response
    .then(response => response.json())
    .then(json => {
        if(json.status === 400) {
            removeStatus();

            displayStatus(json, 'edit');
        } else {
            removeStatus();

            document.getElementById('formEdit').reset();
            document.getElementById('modalCloseEdit').click();

            document.querySelector('.modalTambah').insertAdjacentHTML('afterend',
                `<div class="alert alert-success alert-dismissible fade show mt-2 rmv-flash" role="alert">
                    ${json.message}
                </div>`
            )

            displayAllMahasiswa()
        }
    })
    .catch(error => console.info(error));

});

displayAllMahasiswa()
