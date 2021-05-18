document.addEventListener('DOMContentLoaded', () => {
  // get the string of current url page
  const URL_STRING = window.location.href;

  // conditional statements for different pages
  if (URL_STRING.includes('dashboard')) {
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
      row.addEventListener('click', el => {
        const thisRowData = el.target.parentElement;

        if (URL_STRING.includes('kadep')) {
          const theSOA = thisRowData.children[1].innerText;
          window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}`;
        } else {
          const theSOA = thisRowData.firstElementChild.innerText;
          window.location.href = `${row.dataset.linked}?soa=${encodeURIComponent(theSOA)}`;
        }
      })
    })
  } else if (URL_STRING.includes('konfirmasi-dokumen')) {
    // set soa number to appear in top of content page
    const CURRENT_URL = new URL(URL_STRING);
    const soaData = CURRENT_URL.searchParams.get('soa');
    const soaField = document.querySelector('#soafield');

    soaField.placeholder = `SOA : ${soaData}`;

    const radioBtnLainnya = document.querySelectorAll('.option-lainnya');

    radioBtnLainnya.forEach(radio => {
      radio.addEventListener('click', () => {
        if (radio.checked == true) {
          radio.checked = false;

          let anotherOption = null;

          do {
            anotherOption = prompt('Masukkan pilihan lainnya');
          } while (anotherOption === '')

          if (anotherOption !== null) {
            radio.checked = true;
            radio.nextSibling.textContent = `\n${anotherOption}`;
          } else {
            radio.checked = false;
            radio.nextSibling.textContent = '\nlainnya';
          }
        }
      });
    });
  };
});