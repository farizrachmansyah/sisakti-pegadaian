class UmpUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
    this.headerUser = document.querySelector('.name');
    this.jtempoData = document.querySelectorAll('.jtempo-data');
  }

  setUserName(longJabatan, shortJabatan) {
    console.log(this.tableRow);
    if (window.innerWidth > 480) {
      this.headerUser.textContent = `${longJabatan} - UMP`;
    } else {
      this.headerUser.textContent = `${shortJabatan} - UMP`;
    }
  }

  jatuhTempoWarning() {
    const recentDate = new Date().toLocaleDateString('id-ID');
    console.log(recentDate);
    let jtempoDate;
    this.jtempoData.forEach(data => {
      // convert jtempodata ke date
    });
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
});