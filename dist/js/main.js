class UI {
  constructor() {
    this.soaData = document.querySelectorAll('.soadata-table');
    this.soppData = document.querySelectorAll('.soppdata-table');
    this.statusData = document.querySelectorAll('.statusdata-table');
  }

  setSOA() {
    this.soaData.forEach(data => {
      data.innerText = `${data.innerText}/SOA-00108/2021`;
    });
  }

  setSOPP() {
    this.soppData.forEach(data => {
      let deptCode;
      const deptData = data.nextElementSibling;
      switch (deptData.innerText.toLowerCase()) {
        case 'keuangan':
          deptCode = '02.01';
          break;
        case 'sdm':
          deptCode = '03.01';
          break;
        case 'logistik':
          deptCode = '04.01';
          break;
        case 'legal officer':
          deptCode = '05.01';
          break;
        case 'humas':
          deptCode = '06.01';
          break;
        case 'business support':
          deptCode = '07.01';
          break;
        case 'manajemen risiko':
          deptCode = '08.01';
          break;
      }

      data.innerText = `${data.innerText}/SOPP-00108.${deptCode}/2021`;
    });
  }

  setStatusColor() {
    this.statusData.forEach(data => {
      if (data.innerText.toLowerCase() == 'diterima') {
        data.style.color = '#00ab4e';
      } else if (data.innerText.toLowerCase() == 'ditolak') {
        data.style.color = '#e74c3c';
      } else if (data.innerText.toLowerCase() == 'dalam proses') {
        data.style.color = '#636e72';
      }
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();

  ui.setSOA();
  ui.setSOPP();
  ui.setStatusColor();
})