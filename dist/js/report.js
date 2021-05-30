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
              <th scope="col">Aktivitas</th>
              <th scope="col">Saldo</th>
              <th scope="col">Realisasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>1710101</td>
              <td>Aktiva Tetap</td>
              <td>Rp. 50.000.000</td>
              <td>Rp. 40.000.000</td>
            </tr>
            <tr>
              <td>2</td>
              <td>5143501</td>
              <td>Biaya Penanganan Pandemi</td>
              <td>Rp. 70.000.000</td>
              <td>Rp. 60.000.000</td>
            </tr>
            <tr>
              <td>3</td>
              <td>5142301</td>
              <td>Biaya Penyaluran Bina Lingkungan</td>
              <td>Rp. 90.000.000</td>
              <td>Rp. 80.000.000</td>
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
      <div class="main__content-dropdown report__content-dropdown flex">
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
            <a class="dropdown-item">Januari</a>
            <a class="dropdown-item">Februari</a>
            <a class="dropdown-item">Maret</a>
            <a class="dropdown-item">April</a>
            <a class="dropdown-item">Mei</a>
            <a class="dropdown-item">Juni</a>
            <a class="dropdown-item">Juli</a>
            <a class="dropdown-item">Agustus</a>
            <a class="dropdown-item">September</a>
            <a class="dropdown-item">Oktober</a>
            <a class="dropdown-item">November</a>
            <a class="dropdown-item">Desember</a>
          </div>
        </div>

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
            Tahun
          </a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item">2016</a>
            <a class="dropdown-item">2017</a>
            <a class="dropdown-item">2018</a>
            <a class="dropdown-item">2019</a>
            <a class="dropdown-item">2020</a>
            <a class="dropdown-item">2021</a>
            <a class="dropdown-item">2022</a>
            <a class="dropdown-item">2023</a>
            <a class="dropdown-item">2024</a>
            <a class="dropdown-item">2025</a>
            <a class="dropdown-item">2026</a>
          </div>
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
              <td>Rp. 700.000.000</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Humas</td>
              <td>Rp. 800.000.000</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Keuangan</td>
              <td>Rp. 900.000.000</td>
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
              <td>Rp. 400.000.000</td>
            </tr>
            <tr>
              <td>2</td>
              <td>KABAG Tresuri & Perpajakan</td>
              <td>Rp. 500.000.000</td>
            </tr>
            <tr>
              <td>3</td>
              <td>KABAG Pengembangan SDM</td>
              <td>Rp. 600.000.000</td>
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
              <th scope="col">Aktivitas</th>
              <th scope="col">Total SOA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>1710101</td>
              <td>Aktiva Tetap</td>
              <td>706</td>
            </tr>
            <tr>
              <td>2</td>
              <td>5143501</td>
              <td>Biaya Penanganan Pandemi</td>
              <td>236</td>
            </tr>
            <tr>
              <td>3</td>
              <td>5142301</td>
              <td>Biaya Penyaluran Bina Lingkungan</td>
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