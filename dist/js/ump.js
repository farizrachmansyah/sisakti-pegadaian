class UmpUI {
  constructor() {
    this.headerUser = document.querySelector('.name');
  }

  setUserName(longJabatan, shortJabatan) {
    if (window.innerWidth > 480) {
      this.headerUser.textContent = `${longJabatan} - UMP`;
    } else {
      this.headerUser.textContent = `${shortJabatan} - UMP`;
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const URL_STRING = window.location.href;
  const ui = new UmpUI();

  if (URL_STRING.includes('kabag-aa')) {
    ui.setUserName('KABAG Anggaran & Akuntansi', 'KABAG AA');
  } else if (URL_STRING.includes('kabag-tresuri')) {
    ui.setUserName('KABAG Tresuri & Perpajakan', 'KABAG TP');
  } else if (URL_STRING.includes('kadep')) {
    ui.setUserName('Kepala Departemen', 'KADEP');
  }

  window.addEventListener('resize', () => {
    if (URL_STRING.includes('kabag-aa')) {
      ui.setUserName('KABAG Anggaran & Akuntansi', 'KABAG AA');
    } else if (URL_STRING.includes('kabag-tresuri')) {
      ui.setUserName('KABAG Tresuri & Perpajakan', 'KABAG TP');
    } else if (URL_STRING.includes('kadep')) {
      ui.setUserName('Kepala Departemen', 'KADEP');
    }
  });
});