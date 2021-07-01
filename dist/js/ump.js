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
      } else {
        data.innerHTML = '&mdash;';
      }
    });
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
            window.location.href = `./konfirmasi-ump.html?ump=${encodeURIComponent(umpValue)}`;
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
            console.log('row/btn clicked');
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
            console.log('row/btn clicked');
          });
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

  // jatuh tempo warning
  ui.jatuhTempoWarning();
  ui.fcIcon();
  ui.btnActionKepala(URL_STRING);
});