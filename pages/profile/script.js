 function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => {
      tab.style.display = 'none';
    });

    document.getElementById(tabId).style.display = 'block';

    document.querySelectorAll('.tab-button').forEach(btn => {
      btn.classList.remove('active');
    });

    event.target.classList.add('active');
  }

/*let namaAsli = ''; // variabel global

function editNama(event) {
  event.preventDefault();

  const currentName = document.getElementById('nama-display').innerText;
  namaAsli = currentName; // Simpan nama sebelum diedit

  const namaRow = document.getElementById('nama-row');
  namaRow.innerHTML = `
    <span class="label">Nama</span>:
    <input type="text" id="nama-input" class="input-text" value="${currentName}" />
    <button class="btn" onclick="simpanNama()">Simpan</button>
    <button class="btn" onclick="batalNama()">Batal</button>
  `;
}

function simpanNama() {
  const newName = document.getElementById('nama-input').value;
  const namaRow = document.getElementById('nama-row');

  namaRow.innerHTML = `
    <span>Nama</span>: <span id="nama-display">${newName}</span>
    <a href="#" onclick="editNama(event)">Ubah nama</a>
  `;
}

function batalNama() {
  const namaRow = document.getElementById('nama-row');

  namaRow.innerHTML = `
    <span>Nama</span>: <span id="nama-display">${namaAsli}</span>
    <a href="#" onclick="editNama(event)">Ubah nama</a>
  `;
}*/

  const uploadInput = document.getElementById('uploadInput');
  const profilePreview = document.getElementById('profilePreview');

  uploadInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file && file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = function (e) {
        profilePreview.src = e.target.result;
      };
      reader.readAsDataURL(file); // Ubah file jadi base64 data URL
    }
  });

  let namaAsli = '';

function openNamaModal(event) {
  event.preventDefault();
  namaAsli = document.getElementById('nama-display').innerText;
  document.getElementById('nama-input-modal').value = namaAsli;
  document.getElementById('namaModal').style.display = 'block';
}

function closeNamaModal() {
  document.getElementById('namaModal').style.display = 'none';
}

function simpanNama() {
  const newName = document.getElementById('nama-input-modal').value;
  const namaDisplay = document.getElementById('nama-display');
  namaDisplay.textContent = newName;
  closeNamaModal();

  // (Opsional) Kirim data ke server via AJAX di sini
}

