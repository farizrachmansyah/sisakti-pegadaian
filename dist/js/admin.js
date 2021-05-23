class UI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
  }

  buttonAndStatusColor() {
    this.tableRow.forEach(row => {
      const rowCol = Array.from(row.children);
      const statusInfo = rowCol[6];
      const editBtn = rowCol[8].firstElementChild;

      if (statusInfo.innerHTML.toLowerCase() == 'register') {
        statusInfo.style.color = '#00ab4e';
        editBtn.style.color = '#00ab4e';
      } else if (statusInfo.innerHTML.toLowerCase() == 'kembali') {
        statusInfo.style.color = '#e74c3c';
        editBtn.style.color = '#e74c3c';
      }
    })
  }

  setDatasetButton() {
    this.tableRow.forEach(row => {
      // get every column values from each row
      const rowCol = Array.from(row.children);

      // edit button from last column values in row and get the first element child 
      const editBtn = rowCol[8].firstElementChild;

      // get column value form soa column and status column, then put them in variables
      let noSOA = null;
      let status = null;
      rowCol.forEach((col, index) => {
        if (index == 1) {
          noSOA = col.innerHTML;
        } else if (index == 6) {
          status = col.innerHTML.toLowerCase();
        }
      })

      // create dataset for soa and status
      editBtn.dataset.soa = noSOA;
      editBtn.dataset.status = status;
    })
  }
}

class EventListener {
  constructor() {
    this.editBtn = document.querySelectorAll('.btn-edit');
  }

  showModal() {
    this.editBtn.forEach(button => {
      button.addEventListener('click', () => {
        button.dataset.status === 'register' ? this.showRegisterModal(button.dataset.soa) : this.showKembaliModal(button.dataset.soa);
      })
    });
  }

  showRegisterModal(noSOA) {
    // ini masih belom diurus tombol submitnya
    const { value: formValues } = Swal.mixin({
      customClass: {
        confirmButton: 'sweetalert-btn-primary'
      }
    }).fire({
      title: 'Register',
      html: `
        <div class="admin-action-form">
          <input class="admin-action-form__soa" type="text" placeholder="SOA : ${noSOA}" disabled/>
          <input type="date" />
          <input type="time" />
          <input type="text" placeholder="Nomor Register" />
          <div class="admin-action-form__permintaan flex flex-ai-c">
            <span>Rp. </span>
            <input type="number" placeholder="Jumlah Permintaan"/>
          </div>
        </div>
      `,
      confirmButtonText: 'Submit',
      focusConfirm: false,
      preConfirm: () => {
        return [
          document.getElementById('swal-input1').value,
          document.getElementById('swal-input2').value
        ]
      }
    })
  }

  showKembaliModal(noSOA) {
    // ini masih belom diurus tombol submitnya
    const { value: formValues } = Swal.mixin({
      customClass: {
        confirmButton: 'sweetalert-btn-primary'
      }
    }).fire({
      title: 'Pengembalian',
      html: `
        <div class="admin-action-form">
          <input class="admin-action-form__soa" type="text" placeholder="SOA : ${noSOA}" disabled/>
          <input type="date" />
          <input type="time" />
          <input type="text" placeholder="Departemen" />
          <input type="text" placeholder="Penerima" />
        </div>
      `,
      confirmButtonText: 'Submit',
      focusConfirm: false,
      preConfirm: () => {
        return [
          document.getElementById('swal-input1').value,
          document.getElementById('swal-input2').value
        ]
      }
    })
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();
  const events = new EventListener();

  ui.buttonAndStatusColor();
  ui.setDatasetButton();
  events.showModal();
});