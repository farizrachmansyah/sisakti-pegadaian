document.addEventListener('DOMContentLoaded', () => {
  const tableRows = document.querySelectorAll('tbody tr');
  console.log(tableRows);

  tableRows.forEach(row => {
    row.addEventListener('click', el => {
      const thisRowData = el.target.parentElement;
      const theSOA = thisRowData.firstElementChild.innerText;

      // peernya adalah cari cara gimana caranya ngirim data dari element yang dibutuhkan ke halaman html lain untuk digunain data2nya
      window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}`;
    })
  })
});