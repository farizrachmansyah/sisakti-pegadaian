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

        if (URL_STRING.includes('kadep')) {
          theSOA = thisRowData.children[1].innerText;
          window.location.href = `./konfirmasi-dokumen.html?soa=${encodeURIComponent(theSOA)}`;
        } else if (URL_STRING.includes('tresuri')) {
          theSOA = thisRowData.firstElementChild.innerText;
          window.location.href = `./konfirmasi-dokumen.html?soa=${encodeURIComponent(theSOA)}`;
        } else if (URL_STRING.includes('aa')) {
          theSOA = thisRowData.firstElementChild.innerText;
          window.location.href = `./konfirmasi-dokumen.html?soa=${encodeURIComponent(theSOA)}`;
        }

      })
    })
  } else if (URL_STRING.includes('konfirmasi-dokumen')) {
    // SET SOA NUMBER TO APPEAR IN TOP OF CONTENT PAGE
    // const CURRENT_URL = new URL(URL_STRING);
    // const soaData = CURRENT_URL.searchParams.get('soa');
    // const perihalData = CURRENT_URL.searchParams.get('perihal');
    // parameter from adalah untuk menentukan bahwa halaman konfirmasi ini sebelumnya berasal dari halaman mana
    // const fromData = CURRENT_URL.searchParams.get('from');

    // const soaField = document.querySelector('#soafield');
    // const perihalField = document.querySelector('#perihalfield');

    // soaField.placeholder = `SOA : ${soaData}`;
    // perihalField.value = `${perihalData}`;



    // CHOOSING WHICH TEXT SHOULD BE SET IN CONFIRMATION BUTTON (KONFIRMASI/REGISTER)
    // const confirmButton = document.querySelector('#confirmBtn');

    // if (fromData == 'kadep')
    //   confirmButton.innerText = 'registrasi';

    // MENGECEK APAKAH SEMUA RADIO BUTTON TELAH TERISI
    // if (fromData == 'tresuri') {
    //   const radioButton = document.querySelectorAll('input[type=radio]');
    //   radioButton.forEach(radio => {
    //     radio.setAttribute('required', '');
    //   });
    // }

    // MERUBAH ISI RADIO BUTTON UNTUK YANG BERASAL DARI HALAMAN KABAG-AA

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

    if (fromData == 'aa') {
      // NGASIH ATRIBUT ACTION KE FORM
      // const form = document.querySelector('form');
      // form.action = './kabag-aa/dashboard.html';
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