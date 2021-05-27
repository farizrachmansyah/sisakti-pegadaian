class UI {
  constructor() {
    this.content = document.querySelector('.report__content');
  }

  createTable() {
    const CURRENT_URL = new URL(window.location.href);
    const pageLocation = CURRENT_URL.searchParams.get('page');

    if (pageLocation.includes('realisasi-ma')) {
      this.tableRealisasiMA();
    } else if (pageLocation.includes('realisasi-dept')) {
      this.tableRealisasiDept();
    } else if (pageLocation.includes('realisasi-pa')) {
      this.tableRealisasiPA();
    } else if (pageLocation.includes('total-soa-ma')) {
      this.tableTotalSOA();
    }
  }

  tableRealisasiMA() {
    const content = this.content;
    const contentTable = document.createElement('section');
    contentTable.classList.add('main__content-table');
    contentTable.classList.add('report__content-table');

    contentTable.innerHTML = `
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Mata Anggaran</th>
              <th scope="col">Saldo</th>
              <th scope="col">Realisasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>1710101</td>
              <td>Rp. 50.000.000</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>2</td>
              <td>5143501</td>
              <td>Rp. 70.000.000</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>3</td>
              <td>5142301</td>
              <td>Rp. 90.000.000</td>
              <td>Realisasi</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;

    content.append(contentTable);
  }

  tableRealisasiDept() {
    const content = this.content;
    const contentTable = document.createElement('section');
    contentTable.classList.add('main__content-table');
    contentTable.classList.add('report__content-table');

    content.innerHTML = `
      <div class="dropdown show">
        <a
          class="btn dropdown-toggle"
          href="#"
          role="button"
          id="dropdownMenuLink"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Bulan
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item">5 Tahun Kedepan</a>
          <a class="dropdown-item">5 Tahun Kebelakang</a>
        </div>
      </div>
    `;

    contentTable.innerHTML = `
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Departemen</th>
              <th scope="col">Realisasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Logistik</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Humas</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Keuangan</td>
              <td>Realisasi</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;

    content.append(contentTable);
  }

  tableRealisasiPA() {
    const content = this.content;
    const contentTable = document.createElement('section');
    contentTable.classList.add('main__content-table');
    contentTable.classList.add('report__content-table');

    contentTable.innerHTML = `
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Pemegang Anggaran</th>
              <th scope="col">Realisasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>KABAG Anggaran & Akuntansi</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>2</td>
              <td>KABAG Tresuri & Perpajakan</td>
              <td>Realisasi</td>
            </tr>
            <tr>
              <td>3</td>
              <td>KABAG Pengembangan SDM</td>
              <td>Realisasi</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;

    content.append(contentTable);
  }

  tableTotalSOA() {
    const content = this.content;
    const contentTable = document.createElement('section');
    contentTable.classList.add('main__content-table');
    contentTable.classList.add('report__content-table');

    contentTable.innerHTML = `
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Mata Anggaran</th>
              <th scope="col">Total SOA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>1710101</td>
              <td>706</td>
            </tr>
            <tr>
              <td>2</td>
              <td>5143501</td>
              <td>236</td>
            </tr>
            <tr>
              <td>3</td>
              <td>5142301</td>
              <td>294</td>
            </tr>
          </tbody>
        </table>
      </div>
    `;

    content.append(contentTable);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const ui = new UI();

  ui.createTable();
})