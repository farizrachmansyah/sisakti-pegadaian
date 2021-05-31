class AdminUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
  }

  buttonAndStatus() {
    this.tableRow.forEach(row => {
      // const rowCol = Array.from(row.children);
      const statusInfo = row.children[8].innerText;
      const editBtn = row.children[9].firstElementChild;

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
      const editBtn = rowCol[9].firstElementChild;

      // get column value form soa column and status column, then put them in variables
      let status = null;
      let noData = null;
      let noSOA = null;
      let kodeDept = null;
      rowCol.forEach((col, index) => {
        if (index == 0) {
          noData = col.innerText;
        } else if (index == 1) {
          noSOA = col.innerText;
        } else if (index == 2) {
          kodeDept = col.innerText.slice(15, 20);
        } else if (index == 8) {
          status = col.innerText.toLowerCase();
        }
      })

      // create dataset for soa and status
      editBtn.dataset.status = status;
      editBtn.dataset.nodata = noData;
      editBtn.dataset.soa = noSOA;
      editBtn.dataset.kodedept = kodeDept;
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
        button.dataset.status === 'register' ? this.showRegisterModal(button.dataset.soa, button.dataset.nodata, button.dataset.kodedept) : this.showKembaliModal(button.dataset.soa);
      });
    });
  }

  showRegisterModal(noSOA, noData, kodeDept) {
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
          <input class="admin-action-form__noregis type="text" placeholder="000${noData}/${kodeDept}/21" disabled/>
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
          <select class="input" name="dept" id="">
            <option selected disabled>Departemen</option>
            <option value="02.01">Keuangan</option>
            <option value="03.01">SDM</option>
            <option value="04.01">Logistik</option>
            <option value="05.01">Legal Officer</option>
            <option value="06.01">Humas</option>
            <option value="07.01">Bussiness Support</option>
            <option value="08.01">Manajemen Risiko</option>
          </select>
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
  const ui = new AdminUI();
  const events = new EventListener();

  ui.buttonAndStatus();
  ui.setDatasetButton();
  events.showModal();
});