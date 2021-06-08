document.addEventListener('DOMContentLoaded', () => {
  const URL_STRING = window.location.href;

  if (URL_STRING.includes('dashboard')) {
    const tableRows = document.querySelectorAll('tbody tr');

    // tiap row dikonfigurasi
    tableRows.forEach(row => {
      const rowLokasi = row.children[10].innerText.toLowerCase();

      // seleksi yang statusnya reject dengan menyeleksi pake class
      if (row.classList.contains('status-reject')) {
        const soa = row.children[1].innerText;

        // nentuin kalo di klik
        if (rowLokasi.includes('kabag anggaran')) {
          row.addEventListener('click', () => {
            window.location.href = `./review-anggaran.html?soa=${soa}`;
          })
        } else if (rowLokasi.includes('kabag tresuri') || rowLokasi.includes('kepala departemen')) {
          row.addEventListener('click', () => {
            window.location.href = `./review-lampiran.html?soa=${soa}`;
          });
        }
      }
    });
  }
});