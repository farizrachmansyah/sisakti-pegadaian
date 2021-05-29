class UI {
  constructor() {
    this.soaData = document.querySelectorAll('.soadata-table');
    this.soppData = document.querySelectorAll('.soppdata-table');
    this.statusField = document.querySelector('#statusfield-table');
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

  setStatus() {
    this.statusData.forEach(data => {
      if (data.innerText.toLowerCase() == 'accepted') {
        data.style.color = '#00ab4e';
        data.parentElement.classList.add('status-acc');
      } else if (data.innerText.toLowerCase() == 'rejected') {
        data.style.color = '#e74c3c';
        data.parentElement.classList.add('status-reject');
      } else if (data.innerText.toLowerCase() == 'on progress') {
        data.style.color = '#636e72';
        data.parentElement.classList.add('status-progress');
      }
    });
  }

  configureStatus() {
    this.statusField.innerHTML = `
      <select name="statusFilter" id="statusfilter">
        <option value="all">Status</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
        <option value="progress">On Progress</option>
      </select>
    `;

    // element select
    const statusOption = document.querySelector('#statusfilter');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();

  ui.setSOA();
  ui.setSOPP();
  ui.setStatus();
  ui.configureStatus();
})

// search table data based on soa number (halaman pemegang anggaran)
function searchTableData() {
  const input = document.querySelector('#searchdata-soa');
  const filter = input.value.toLowerCase();
  const table = document.querySelector('#table-pa');
  const tr = table.getElementsByTagName('tr');
  let td, dataValue;

  // looping ke setiap row dan ilangin yang ga match
  for (let i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];

    if (td) {
      dataValue = td.textContent || td.innerText;
      if (dataValue.toLowerCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}