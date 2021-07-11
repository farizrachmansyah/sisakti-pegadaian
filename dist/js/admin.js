class AdminUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
  }

  buttonAndStatus(url) {
    this.tableRow.forEach(row => {
      // const rowCol = Array.from(row.children);
      let statusInfo;
      let editBtn;
      if (url.includes('dashboard-ump')) {
        statusInfo = row.children[10].innerText;
        editBtn = row.children[11].firstElementChild;
      } else {
        statusInfo = row.children[11].innerText;
        editBtn = row.children[12].firstElementChild;
      }

      editBtn.style.paddingLeft = '1rem';
      editBtn.style.paddingRight = '1rem';

      if (statusInfo.toLowerCase() == 'register') {
        editBtn.style.color = '#3498db';
        editBtn.innerHTML = '<i class="far fa-edit"></i>';
      } else if (statusInfo.toLowerCase() == 'registered') {
        editBtn.style.color = '#3498db';
        editBtn.innerHTML = '<i class="fas fa-check"></i>';
      } else if (statusInfo.toLowerCase() == 'rejected') {
        editBtn.style.color = '#e74c3c';
        editBtn.innerHTML = '<i class="fas fa-undo-alt"></i>';
      } else if (url.includes('dashboard-ump') && statusInfo.toLowerCase() == 'done') {
        editBtn.style.color = '#212529';
        editBtn.innerHTML = '<i class="fas fa-user-edit"></i>';
      } else {
        editBtn.style.visible = 'hidden';
      }
    })
  }

  setDatasetButton(url) {
    this.tableRow.forEach(row => {
      const rowCol = Array.from(row.children);
      // edit button from last column values in row and get the first element child 
      let editBtn;
      // get column value form soa column and status column, then put them in variables
      let status, noData, noSOA, noUMP, kodeDept, kodeBag, jumPermintaan, jatuhTempo = null;

      if (url.includes('dashboard-ump')) {
        editBtn = rowCol[11].firstElementChild;
        rowCol.forEach((col, index) => {
          if (index == 0) {
            noData = col.innerText;
          } else if (index == 1) {
            noUMP = col.innerText;
          } else if (index == 5) {
            kodeBag = col.innerText.slice(15, 20);
          } else if (index == 7) {
            jatuhTempo = col.innerText;
          } else if (index == 10) {
            status = col.innerText.toLowerCase();
          }
        })

        // create dataset
        editBtn.dataset.status = status;
        editBtn.dataset.ump = noUMP;
      } else {
        editBtn = rowCol[12].firstElementChild;
        rowCol.forEach((col, index) => {
          if (index == 0) {
            noData = col.innerText;
          } else if (index == 1) {
            noSOA = col.innerText;
          } else if (index == 2) {
            kodeDept = col.innerText.slice(15, 20);
          } else if (index == 5) {
            jumPermintaan = col.innerText;
          } else if (index == 11) {
            status = col.innerText.toLowerCase();
          }
        })

        // create dataset
        editBtn.dataset.status = status;
        editBtn.dataset.soa = noSOA;
      }
    })
  }

  showDownloadBtn() {
    const selectedOption = document.querySelector('#statusfilter');
    const downloadBtn = document.querySelector('.admin__content-button button');

    selectedOption.addEventListener('change', () => {
      if (selectedOption.value === 'done') {
        downloadBtn.style.transform = 'translateY(0)';
        downloadBtn.style.opacity = '1';
        downloadBtn.style.pointerEvents = 'all';
      } else {
        downloadBtn.style.pointerEvents = 'none';
        downloadBtn.style.opacity = '0';
        downloadBtn.style.transform = 'translateY(100%)';
      }
    });
  }
}

class EventListener {
  constructor() {
    this.editBtn = document.querySelectorAll('.btn-edit');
    this.soaUmpWarning = document.querySelector('#primary-warning');
    this.soaUmpField = document.querySelectorAll('.soa-ump');
    this.soaField = document.querySelector('#soa');
    this.umpField = document.querySelector('#ump');
  }

  setBtnAction(url) {
    this.editBtn.forEach(btn => {
      if (url.includes('dashboard-ump')) {
        const status = btn.dataset.status;
        const ump = btn.dataset.ump;

        btn.addEventListener('click', () => {
          const popupRegistered = document.querySelector('#popup-registered');

          if (status == 'register') {
            window.location.href = `./register-ump.php?ump=${ump}`;
          } else if (status == 'rejected') {
            window.location.href = `./reject-ump.php?ump=${ump}`;
          } else if (status == 'registered') {
            const hiddenInput = document.querySelector('#popup-registered-data');

            hiddenInput.setAttribute('value', ump);

            if (popupRegistered.classList.contains('show')) {
              popupRegistered.classList.remove('show');
            } else {
              popupRegistered.classList.add('show');
            }
          } else if (status == 'done') {
            window.location.href = `./konfirmasi-ump.php?ump=${ump}`;
          }
        });
      } else {
        const status = btn.dataset.status;
        const soa = btn.dataset.soa;

        btn.addEventListener('click', () => {
          const popupRegistered = document.querySelector('#popup-registered');

          if (status == 'register') {
            window.location.href = `./register.php?soa=${soa}`;
          } else if (status == 'rejected') {
            window.location.href = `./reject.php?soa=${soa}`;
          } else if (status == 'registered') {
            const hiddenInput = document.querySelector('#popup-registered-data');

            hiddenInput.setAttribute('value', soa);

            if (popupRegistered.classList.contains('show')) {
              popupRegistered.classList.remove('show');
            } else {
              popupRegistered.classList.add('show');
            }
          }
        });
      }
    });
  }

  soaUmpValidation() {
    const soaField = this.soaField;
    const umpField = this.umpField;

    // BLOM KELAR
    // const validate = (e) => {
    //   console.log(e.target);
    //   if (e.target.value == '')
    //     console.log('dua2nya kosong');
    // };

    // soaField.addEventListener('blur', validate);
    // umpField.addEventListener('change', validate);

    // this.soaUmpField.forEach(field => {
    //   field.addEventListener('blur', () => {
    //     if (soaField.value == '' && umpField.value == '') {
    //       this.soaUmpWarning.style.opacity = '1';
    //       this.soaUmpWarning.style.transform = 'translateY(0)';
    //     } else {
    //       this.soaUmpWarning.style.transform = 'translateY(100%)';
    //       this.soaUmpWarning.style.opacity = '0';
    //     }
    //   });
    // });
  }

  dropdownSearchable() {
    $('#ump').select2();
    $('#aktivitas').select2();

    // RESET THOSE FIELD STYLING
    const theField = document.querySelectorAll('.select2.select2-container.select2-container--default');

    theField.forEach(field => {
      if (field.previousElementSibling.id === 'ump') {
        field.classList.add('input', 'soa-ump', 'ump');
      } else {
        field.classList.add('input');
      }
    });

  }
}

document.addEventListener('DOMContentLoaded', () => {
  const URL_STRING = window.location.href;
  const ui = new AdminUI();
  const events = new EventListener();

  if (URL_STRING.includes('dashboard') && !URL_STRING.includes('tambah-ump')) {
    ui.buttonAndStatus(URL_STRING);
    ui.setDatasetButton(URL_STRING);
    ui.showDownloadBtn();
    events.setBtnAction(URL_STRING);
  } else if (URL_STRING.includes('terima-dokumen')) {
    events.soaUmpValidation();
    // events.dropdownSearchable();
  }
});