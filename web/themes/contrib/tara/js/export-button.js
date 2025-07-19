document.addEventListener('DOMContentLoaded', function () {
  const exportButton = document.getElementById('export-btn');

  // Function to export table to Excel
  exportButton.addEventListener('click', function () {
    const table = document.querySelector('table');
    const wb = XLSX.utils.table_to_book(table); // Convert table to sheet
    XLSX.writeFile(wb, 'exported-data.xlsx'); // Trigger download
  });
});