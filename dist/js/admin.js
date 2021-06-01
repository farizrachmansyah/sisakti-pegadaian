class AdminUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
  }

  buttonAndStatus() {
    this.tableRow.forEach(row => {
      // const rowCol = Array.from(row.children);
      const statusInfo = row.children[11].innerText;
      const editBtn = row.children[12].firstElementChild;

      editBtn.style.paddingLeft = '1rem';
      editBtn.style.paddingRight = '1rem';

      if (statusInfo.toLowerCase() == 'register') {
        editBtn.style.color = '#3498db';
        editBtn.innerHTML = '<i class="far fa-edit"></i>';
      } else if (statusInfo.toLowerCase() == 'rejected') {
        editBtn.style.color = '#e74c3c';
        editBtn.innerHTML = '<i class="fas fa-undo-alt"></i>';
      } else if (statusInfo.toLowerCase() == 'accepted') {
        editBtn.style.visible = 'hidden';
      }
    })
  }

  setDatasetButton() {
    this.tableRow.forEach(row => {
      const rowCol = Array.from(row.children);
      // edit button from last column values in row and get the first element child 
      const editBtn = rowCol[12].firstElementChild;

      // get column value form soa column and status column, then put them in variables
      let status, noData, noSOA, kodeDept, jumPermintaan = null;
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
      editBtn.dataset.nodata = noData;
      editBtn.dataset.soa = noSOA;
      editBtn.dataset.kodedept = kodeDept;
      editBtn.dataset.permintaan = jumPermintaan;
    })
  }
}

class EventListener {
  constructor() {
    this.editBtn = document.querySelectorAll('.btn-edit');
  }

  setBtnAction() {
    this.editBtn.forEach(btn => {
      const status = btn.dataset.status;
      const noData = btn.dataset.nodata;
      const soa = btn.dataset.soa;
      const kodeDept = btn.dataset.kodedept;
      const permintaan = btn.dataset.permintaan;

      btn.addEventListener('click', () => {
        if (status == 'register') {
          window.location.href = `./register.php?noData=${noData}&soa=${soa}&kodeDept=${kodeDept}&nominal=${permintaan}`;
        } else if (status == 'rejected') {
          window.location.href = `./reject.html?soa=${soa}`;
        }
      });
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const URL_STRING = window.location.href;
  const ui = new AdminUI();
  const events = new EventListener();

  if (URL_STRING.includes('dashboard')) {
    ui.buttonAndStatus();
    ui.setDatasetButton();
    events.setBtnAction();
  } else if (URL_STRING.includes('register')) {
    const CURRENT_URL = new URL(URL_STRING);
    const noDataValue = CURRENT_URL.searchParams.get('noData');
    const soaValue = CURRENT_URL.searchParams.get('soa');
    const kodeDeptValue = CURRENT_URL.searchParams.get('kodeDept');
    const permintaanValue = CURRENT_URL.searchParams.get('nominal');

    const inputFormSoa = document.querySelector('.soa');
    inputFormSoa.setAttribute('value', soaValue);

    const inputFormNoRegis = document.querySelector('.noregis');
    inputFormNoRegis.setAttribute('value', `000${noDataValue}/${kodeDeptValue}/21`);

    const inputFormPermintaan = document.querySelector('.permintaan');
    inputFormPermintaan.setAttribute('value', permintaanValue);

  } else if (URL_STRING.includes('reject')) {
    const CURRENT_URL = new URL(URL_STRING);
    const soaValue = CURRENT_URL.searchParams.get('soa');

    const inputFormSoa = document.querySelector('.soa');
    inputFormSoa.setAttribute('value', soaValue);
  }
});