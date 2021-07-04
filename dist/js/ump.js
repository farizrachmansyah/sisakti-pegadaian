class UmpUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
    this.headerUser = document.querySelector('.name');
    this.jtempoData = document.querySelectorAll('.jtempo-data');
    this.fcData = document.querySelectorAll('.fc-data');
  }

  setUserName(longJabatan, shortJabatan) {
    if (window.innerWidth > 480) {
      this.headerUser.textContent = `${longJabatan} - UMP`;
    } else {
      this.headerUser.textContent = `${shortJabatan} - UMP`;
    }
  }

  jatuhTempoWarning() {
    const recentDate = new Date();
    let jtempoDate;
    this.jtempoData.forEach(data => {
      // convert jtempodata ke date, ambil potongan2 tanggalnya dulu
      const year = parseInt(data.textContent.substr(6, 4));
      const month = parseInt(data.textContent.substr(3, 2)) - 1;
      const date = parseInt(data.textContent.substr(0, 2));
      // dijadiin date format
      jtempoDate = new Date(year, month, date);

      // ngebandingin waktunya udah lewat atau belum
      if (recentDate > jtempoDate) {
        // karna gaada parameter jam di data ump, jadi untuk hari yang sama namun jamnya udah lewat
        // tetep dianggap belom jatuh tempo
        if (recentDate.getDate() === jtempoDate.getDate()) {
          console.log('belum jatuh tempo');
        } else {
          // ngecek ada docid nya ga
          const docId = data.parentElement.lastElementChild;

          if (docId.textContent == '') {
            console.log('sudah jatuh tempo & tidak ada docId');
            // kasih warning
            data.classList.add('tempo-warning');
          }
        }
      }
    });
  }

  fcIcon() {
    this.fcData.forEach(data => {
      if (data.textContent === 'Y') {
        data.style.fontWeight = '700';
        data.innerHTML = '&#10003;';
        data.dataset.isfc = 'y'
      } else {
        data.innerHTML = '&mdash;';
        data.dataset.isfc = 'n'
      }
    });
  }

  btnActionAccess(url) {
    if (url.includes('admin') && url.includes('dashboard-ump')) {
      this.tableRow.forEach(row => {
        let fcData = row.children[6];
        let jtempoData = row.children[7];
        let btnAction = row.children[11];

        if (fcData.dataset.isfc === 'y' && jtempoData.innerText !== '') {
          btnAction.innerHTML = '';
        }
      })
    }
  }

  btnActionKepala(url) {
    // bikin row clickable dan munculin btn action berdasarkan syarat lokasi dan status
    if (url.includes('kabag-aa')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[9].innerText;
        const rowStatus = row.children[10].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('admin') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('anggaran & akuntansi') && rowStatus.toLowerCase().includes('pending');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          const rowBtn = row.children[11];
          rowBtn.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET UMP DATA
          const umpValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            // lakukan aksi konfirmasi
            window.location.href = `./konfirmasi-ump.php?ump=${encodeURIComponent(umpValue)}`;
          });
        }
      });
    } else if (url.includes('kabag-tresuri')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[9].innerText;
        const rowStatus = row.children[10].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('anggaran & akuntansi') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('tresuri & perpajakan') && rowStatus.toLowerCase().includes('pending');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          const rowBtn = row.children[11];
          rowBtn.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET UMP DATA
          const umpValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            // lakukan aksi konfirmasi
            window.location.href = `./konfirmasi-ump.php?ump=${encodeURIComponent(umpValue)}`;
          });
        }
      });
    } else if (url.includes('kadep')) {
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach(row => {
        const rowLokasi = row.children[9].innerText;
        const rowStatus = row.children[10].innerText;
        const firstCondition = rowLokasi.toLowerCase().includes('tresuri & perpajakan') && rowStatus.toLowerCase().includes('accepted');
        const secondCondition = rowLokasi.toLowerCase().includes('kepala departemen') && rowStatus.toLowerCase().includes('pending');

        if (firstCondition || secondCondition) {
          // CREATE BUTTON
          const rowBtn = row.children[11];
          rowBtn.innerHTML = `<button class="btn-action"><i class="fas fa-user-edit"></i></button>`;
          // GET UMP DATA
          const umpValue = row.children[1].innerText;
          // HOVER EFFECT ROW
          row.classList.add('hover-effect');
          // CLICKABLE ROW = TRUE
          row.addEventListener('click', () => {
            // lakukan aksi konfirmasi
            window.location.href = `./konfirmasi-ump.php?ump=${encodeURIComponent(umpValue)}`;
          });
        }
      });
    }
  }

  makeDateDisabled(url) {
    const fcInputField = document.querySelector('.fc.input');
    const fcOptions = document.querySelectorAll('.fc-radio input');
    const dateInputField = fcInputField.nextElementSibling;
    let fcFalseOption;

    fcOptions.forEach(option => {
      if (option.id === 'fc-gada')
        fcFalseOption = option;
    });

    if (url.includes('tambah-ump') || url.includes('konfirmasi-ump')) {
      if (fcFalseOption.checked) {
        dateInputField.setAttribute('disabled', 'disabled');
      }

      fcInputField.addEventListener('change', (e) => {
        if (e.target.value === 'Y') {
          dateInputField.removeAttribute('disabled');
        } else {
          dateInputField.setAttribute('disabled', 'disabled');
        }
      });
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const URL_STRING = window.location.href;
  const ui = new UmpUI();

  // ngeset tulisan di header, dibedain kalo buka di hp sama di desktop
  if (URL_STRING.includes('kabag-aa')) {
    ui.setUserName('KABAG Anggaran & Akuntansi', 'KABAG AA');
  } else if (URL_STRING.includes('kabag-tresuri')) {
    ui.setUserName('KABAG Tresuri & Perpajakan', 'KABAG TP');
  } else if (URL_STRING.includes('kadep')) {
    ui.setUserName('Kepala Departemen', 'KADEP');
  }
  // ngubah tulisan di header pada saat window di resize
  window.addEventListener('resize', () => {
    if (URL_STRING.includes('kabag-aa')) {
      ui.setUserName('KABAG Anggaran & Akuntansi', 'KABAG AA');
    } else if (URL_STRING.includes('kabag-tresuri')) {
      ui.setUserName('KABAG Tresuri & Perpajakan', 'KABAG TP');
    } else if (URL_STRING.includes('kadep')) {
      ui.setUserName('Kepala Departemen', 'KADEP');
    }
  });

  // validasi data
  ui.jatuhTempoWarning();
  ui.fcIcon();

  // tombol action dashboard ump admin
  ui.btnActionAccess(URL_STRING);

  // tombol action di dashboard ump kabag kadep
  ui.btnActionKepala(URL_STRING);

  //tambah ump - kalo fc gaada, maka input date disabled
  ui.makeDateDisabled(URL_STRING);
});