class UI {
  constructor() {
    this.soaData = document.querySelectorAll('.soadata-table');
    this.soppData = document.querySelectorAll('.soppdata-table');
  }

  setSOA() {
    this.soaData.forEach(data => {
      data.innerText = `${data.innerText}/SOA-00108/2021`;
    });
  }

  setSOPP() {
    this.soppData.forEach(data => {
      data.innerText = `${data.innerText}/SOPP-00108.(KodeDept)/2021`;
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();

  ui.setSOA();
  ui.setSOPP();
})