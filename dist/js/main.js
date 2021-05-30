class UI {
  constructor() {
    this.soaData = document.querySelectorAll('.soadata-table');
    this.soppData = document.querySelectorAll('.soppdata-table');
    this.statusField = document.querySelector('#statusfield-table');
    this.statusData = document.querySelectorAll('.statusdata-table');
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
    this.statusField.innerHTML = `
      Status<br />
      <select name="statusFilter" id="statusfilter">
        <option value="all">All</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
        <option value="progress">On Progress</option>
      </select>
    `;
  }

  configureStatus() {
    const allTableRow = []
    this.statusData.forEach(data => {
      if (data.innerText.toLowerCase() == 'accepted') {
        data.style.color = '#00ab4e';
        data.parentElement.classList.add('status-accept');
      } else if (data.innerText.toLowerCase() == 'rejected') {
        data.style.color = '#e74c3c';
        data.parentElement.classList.add('status-reject');
      } else if (data.innerText.toLowerCase() == 'on progress') {
        data.style.color = '#636e72';
        data.parentElement.classList.add('status-progress');
      }

      allTableRow.push(data.parentElement);
    });

    this.filterStatus(allTableRow);
  }

  filterStatus(tableRow) {
    const selectedOption = document.querySelector('#statusfilter');
    selectedOption.addEventListener('change', () => {
      console.log(selectedOption.value);
      switch (selectedOption.value.toLowerCase()) {
        case 'all':
          tableRow.forEach(row => {
            row.style.display = 'table-row';
          });
          break;
        case 'accepted':
          tableRow.forEach(row => {
            row.style.display = 'table-row';
            if (!row.classList.contains('status-accept'))
              row.style.display = 'none';
          });
          break;
        case 'rejected':
          tableRow.forEach(row => {
            row.style.display = 'table-row';
            if (!row.classList.contains('status-reject'))
              row.style.display = 'none';
          });
          break;
        case 'progress':
          tableRow.forEach(row => {
            row.style.display = 'table-row';
            if (!row.classList.contains('status-progress'))
              row.style.display = 'none';
          });
          break;
      }
    });
  }
}


document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();

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