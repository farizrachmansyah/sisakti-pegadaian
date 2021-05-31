class AdminUI {
  constructor() {
    this.tableRow = document.querySelectorAll('tbody tr');
  }

  buttonAndStatus() {
    this.tableRow.forEach(row => {
      // const rowCol = Array.from(row.children);
      const statusInfo = row.children[9].innerText;
      const editBtn = row.children[10].firstElementChild;

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
      const editBtn = rowCol[10].firstElementChild;

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
        } else if (index == 9) {
          status = col.innerText.toLowerCase();
        }
      })

      // create dataset for soa and status
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

  showModal() {
    this.editBtn.forEach(button => {
      button.addEventListener('click', () => {
        button.dataset.status === 'register' ? this.showRegisterModal(button.dataset.soa, button.dataset.nodata, button.dataset.kodedept, button.dataset.permintaan) : this.showKembaliModal(button.dataset.soa);
      });
    });
  }

  showRegisterModal(noSOA, noData, kodeDept, permintaan) {
    const popupContainer = document.querySelector('#popup');
    popupContainer.innerHTML = `
      <form action="data.php" method="POST" class="popup__container-form flex">
        <h1>Register</h1>
        <input id="swal-soa" class="popup__container-form-soa" type="text" name="soa-regis" value="${noSOA}" disabled/>
        <input id="swal-noregis" class="popup__container-form-noregis type="text" value="000${noData}/${kodeDept}/21" disabled/>
        <input id="swal-permintaan" type="text" value="${permintaan}" disabled/>
        <button class="btn" type="submit">Register</button>
        <button class="btn" onclick="closeForm()">Cancel</button>
      </form>
    `;

    // ini masih belom diurus tombol submitnya
    // Swal.fire({
    //   title: 'Register',
    //   html: `
    //     <form class="admin-action-form" action="data.php" method="POST">
    //       <input id="swal-soa" class="admin-action-form__soa" type="text" name="soa-regis" value="${noSOA}" disabled/>
    //       <input id="swal-noregis" class="admin-action-form__noregis type="text" value="000${noData}/${kodeDept}/21" disabled/>
    //       <input id="swal-permintaan" type="text" value="${permintaan}" disabled/>
    //       <button class="btn" type="submit">Register</button>
    //     </form>
    //   `,
    //   showConfirmButton: false,
    //   showCancelButton: true,
    // })
  }

  showKembaliModal(noSOA) {
    const popupContainer = document.querySelector('#popup');
    popupContainer.innerHTML = `
      <form action="data.php" method="POST" class="popup__container-form flex">
        <h1>Pengembalian</h1>
        <input id="swal-soa" class="popup__container-form-soa" type="text" name="soa-regis" value="${noSOA}" disabled/>
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
        <button class="btn" type="submit">Reject</button>
        <button class="btn" onclick="closeForm()">Cancel</button>
      </form>
    `;
    // ini masih belom diurus tombol submitnya
    // Swal.fire({
    //   title: 'Pengembalian',
    //   html: `
    //     <form class="admin-action-form" action="" method="POST">
    //       <input class="admin-action-form__soa" type="text" placeholder="SOA : ${noSOA}" disabled/>
    //       <select class="input" name="dept" id="">
    //         <option selected disabled>Departemen</option>
    //         <option value="02.01">Keuangan</option>
    //         <option value="03.01">SDM</option>
    //         <option value="04.01">Logistik</option>
    //         <option value="05.01">Legal Officer</option>
    //         <option value="06.01">Humas</option>
    //         <option value="07.01">Bussiness Support</option>
    //         <option value="08.01">Manajemen Risiko</option>
    //       </select>
    //       <input type="text" placeholder="Penerima" />
    //       <button class="btn" type="submit">Submit</button>
    //     </form>
    //   `,
    //   showConfirmButton: false
    // });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new AdminUI();
  const events = new EventListener();

  ui.buttonAndStatus();
  ui.setDatasetButton();
  events.showModal();
});

function closeForm() {
  const popupContainer = document.querySelector('#popup');
  popupContainer.innerHTML = '';
  // popupContainer.style.all = 'unset';
}