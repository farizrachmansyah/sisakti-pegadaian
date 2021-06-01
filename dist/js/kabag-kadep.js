document.addEventListener('DOMContentLoaded', () => {
  // get the string of current url page
  const URL_STRING = window.location.href;

  // conditional statements for different pages
  if (URL_STRING.includes('dashboard')) {
    // MENYELEKSI BARIS DATA MANA YANG BISA DI KLIK OLEH USER TERTENTU
    if (URL_STRING.includes('kabag-aa')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[10].innerText;
        const rowStatus = row.children[11].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('admin') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('anggaran & akuntansi') && rowStatus.toLowerCase().includes('rejected');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          row.lastElementChild.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET SOA DATA
          const soaValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            window.location.href = `./konfirmasi-dokumen.php?soa=${encodeURIComponent(soaValue)}`;
          });
        }
      });

    } else if (URL_STRING.includes('kabag-tresuri')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[10].innerText;
        const rowStatus = row.children[11].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('anggaran & akuntansi') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('tresuri & perpajakan') && rowStatus.toLowerCase().includes('rejected');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          row.lastElementChild.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET SOA DATA
          const soaValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            window.location.href = `./konfirmasi-dokumen.php?soa=${encodeURIComponent(soaValue)}`;
          });
        }
      });
    } else if (URL_STRING.includes('kadep')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[10].innerText;
        const rowStatus = row.children[11].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('tresuri & perpajakan') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('kepala departemen') && rowStatus.toLowerCase().includes('rejected');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          row.lastElementChild.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET SOA DATA
          const soaValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            window.location.href = `./konfirmasi-dokumen.php?soa=${encodeURIComponent(soaValue)}`;
          });
        }
      });
    }

  } else if (URL_STRING.includes('konfirmasi-dokumen')) {
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
            radio.value = `\n${anotherOption}`;
          } else {
            radio.checked = false;
            radio.nextSibling.textContent = '\nlainnya';
          }
        }
      });
    });

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