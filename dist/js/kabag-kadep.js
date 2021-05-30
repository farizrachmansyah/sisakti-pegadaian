document.addEventListener('DOMContentLoaded', () => {
  // get the string of current url page
  const URL_STRING = window.location.href;

  // conditional statements for different pages
  if (URL_STRING.includes('dashboard')) {
    // REPORT THINGS
    const dropdownItem = document.querySelectorAll('.dropdown-item');
    dropdownItem.forEach(item => {
      item.href = `../report.html?page=${item.dataset.linked}`;
    });

    // TABLE THINGS
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
      row.addEventListener('click', el => {
        const thisRowData = el.target.parentElement;
        let theSOA;
        let thePerihal;

        if (URL_STRING.includes('kadep')) {
          theSOA = thisRowData.children[1].innerText;
          thePerihal = thisRowData.children[7].innerText;
          window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}&perihal=${encodeURIComponent(thePerihal)}&from=kadep`;
        } else if (URL_STRING.includes('tresuri')) {
          theSOA = thisRowData.firstElementChild.innerText;
          thePerihal = thisRowData.children[8].innerText;
          window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}&perihal=${encodeURIComponent(thePerihal)}&from=tresuri`;
        } else if (URL_STRING.includes('aa')) {
          theSOA = thisRowData.firstElementChild.innerText;
          thePerihal = thisRowData.children[8].innerText;
          window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}&perihal=${encodeURIComponent(thePerihal)}&from=aa`;
        }

      })
    })
  } else if (URL_STRING.includes('konfirmasi-dokumen')) {
    // SET SOA NUMBER TO APPEAR IN TOP OF CONTENT PAGE
    const CURRENT_URL = new URL(URL_STRING);
    const soaData = CURRENT_URL.searchParams.get('soa');
    const perihalData = CURRENT_URL.searchParams.get('perihal');
    // parameter from adalah untuk menentukan bahwa halaman konfirmasi ini sebelumnya berasal dari halaman mana
    const fromData = CURRENT_URL.searchParams.get('from');

    const soaField = document.querySelector('#soafield');
    const perihalField = document.querySelector('#perihalfield');

    soaField.placeholder = `SOA : ${soaData}`;
    perihalField.value = `${perihalData}`;



    // CHOOSING WHICH TEXT SHOULD BE SET IN CONFIRMATION BUTTON (KONFIRMASI/REGISTER)
    const confirmButton = document.querySelector('#confirmBtn');

    if (fromData == 'kadep')
      confirmButton.innerText = 'registrasi';

    // MENGECEK APAKAH SEMUA RADIO BUTTON TELAH TERISI
    if (fromData == 'tresuri') {
      const radioButton = document.querySelectorAll('input[type=radio]');
      radioButton.forEach(radio => {
        radio.setAttribute('required', '');
      });
    }

    // MERUBAH ISI RADIO BUTTON UNTUK YANG BERASAL DARI HALAMAN KABAG-AA
    if (fromData == 'aa') {
      const radiobtnComponent = document.querySelector('.konfirmasi__content-form .info');

      radiobtnComponent.innerHTML = `
        <p>Keterangan</p>
        <div class="info-choice ma">
          <label for="">Mata Anggaran</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="ma" id="1" />
              sesuai
            </div>
            <div class="option">
              <input type="radio" name="ma" id="2" />
              tidak sesuai
            </div>
          </div>
        </div>
        <div class="info-choice sa">
          <label for="">Saldo Anggaran</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="sa" id="1" />
              tersedia
            </div>
            <div class="option">
              <input type="radio" name="sa" id="2" />
              tidak tersedia
            </div>
          </div>
        </div>
        <span class="info-warning">Mohon dilakukan pergeseran mata anggaran</span>
      `;

      // NGASIH EVENT LISTENER BUAT RADIO BUTTON TIDAK TERSEDIA
      const radioSaldoAnggaran = document.querySelectorAll('.sa .option');
      const warningInfo = document.querySelector('.info-warning');
      radioSaldoAnggaran.forEach(radio => {
        radio.addEventListener('change', (e) => {
          if (e.target.id == '2') {
            warningInfo.classList.add('show');
          } else {
            warningInfo.classList.remove('show');
          }
        });
      });

      // NGASIH ATRIBUT ACTION KE FORM
      const form = document.querySelector('form');
      form.action = './kabag-aa/dashboard.html';
    } else if (fromData == 'tresuri' || fromData == 'kadep') {
      const radiobtnComponent = document.querySelector('.konfirmasi__content-form .info');

      radiobtnComponent.innerHTML = `
        <p>Keterangan</p>
        <div class="info-choice sopp">
          <label for="">SOPP</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="sopp" id="1" required />
              ada
            </div>
            <div class="option">
              <input type="radio" name="sopp" id="2" required />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="sopp" id="3" required />
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice notadinas">
          <label for="">Nota Dinas</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="nota" id="1" required />
              ada
            </div>
            <div class="option">
              <input type="radio" name="nota" id="2" required />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="nota" id="3" required />
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice spk">
          <label for="">SPK</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="spk" id="1"  required/>
              ada
            </div>
            <div class="option">
              <input type="radio" name="spk" id="2"  required/>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="spk" id="3"  required/>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice pkb">
          <label for="">PKB</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="pkb" id="1"  required/>
              ada
            </div>
            <div class="option">
              <input type="radio" name="pkb" id="2"  required/>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="pkb" id="3"  required/>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice po">
          <label for="">PO</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="po" id="1" / required>
              ada
            </div>
            <div class="option">
              <input type="radio" name="po" id="2" / required>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="po" id="3" / required>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice pr">
          <label for="">PR</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="pr" id="1" / required>
              ada
            </div>
            <div class="option">
              <input type="radio" name="pr" id="2" / required>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="pr" id="3" / required>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice fakturpajak">
          <label for="">Faktur Pajak</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="faktur" id=" required1" />
              ada
            </div>
            <div class="option">
              <input type="radio" name="faktur" id=" required2" />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="faktur" id=" required3" />
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice ktp">
          <label for="">KTP</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="ktp" id="1"  required/>
              ada
            </div>
            <div class="option">
              <input type="radio" name="ktp" id="2"  required/>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="ktp" id="3"  required/>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice npwp">
          <label for="">NPWP</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="npwp" id="1" required />
              ada
            </div>
            <div class="option">
              <input type="radio" name="npwp" id="2" required />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="npwp" id="3" required />
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice siup">
          <label for="">SIUP</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="siup" id="1" required />
              ada
            </div>
            <div class="option">
              <input type="radio" name="siup" id="2" required />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="siup" id="3" required />
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice tdp">
          <label for="">TDP</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="tdp" id="1"  required/>
              ada
            </div>
            <div class="option">
              <input type="radio" name="tdp" id="2"  required/>
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="tdp" id="3"  required/>
              lainnya
            </div>
          </div>
        </div>
        <div class="info-choice foto">
          <label for="">Foto Sebelum/Sesudah</label>
          <div class="info-choice-options flex flex-ai-c">
            <div class="option">
              <input type="radio" name="foto" id="1" required />
              ada
            </div>
            <div class="option">
              <input type="radio" name="foto" id="2" required />
              tidak ada
            </div>
            <div class="option">
              <input class="option-lainnya" type="radio" name="foto" id="3" required />
              lainnya
            </div>
          </div>
        </div>
      `;

      // RADIO BUTTON INPUT LOGIC
      const radioBtnLainnya = document.querySelectorAll('.option-lainnya');

      radioBtnLainnya.forEach(radio => {
        radio.addEventListener('click', () => {
          if (radio.checked == true) {
            radio.checked = false;

            let anotherOption = null;

            do {
              anotherOption = prompt('Masukkan pilihan lainnya');
            } while (anotherOption === '')

            if (anotherOption !== null) {
              radio.checked = true;
              radio.nextSibling.textContent = `\n${anotherOption}`;
            } else {
              radio.checked = false;
              radio.nextSibling.textContent = '\nlainnya';
            }
          }
        });
      });
    }

  } else if (URL_STRING.includes('report')) {
    const CURRENT_URL = new URL(URL_STRING);
    const pageData = CURRENT_URL.searchParams.get('page');

    // MENGUBAH TULISAN TITLE DI HEADER
    const headerTitle = document.querySelector('.header-container h1');

    switch (pageData) {
      case 'realisasi-ma':
        headerTitle.innerHTML = `Jumlah Realisasi per<br /><span>Mata Anggaran</span>`;
        break;
      case 'realisasi-dept':
        headerTitle.innerHTML = `Jumlah Realisasi per<br /><span>Departemen</span>`;
        break;
      case 'realisasi-pa':
        headerTitle.innerHTML = `Jumlah Realisasi per<br /><span>Pemegang Anggaran</span>`;
        break;
      case 'total-soa-ma':
        headerTitle.innerHTML = `Total SOA per<br /><span>Mata Anggaran</span>`;
        break;
    }
  }
});