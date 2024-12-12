
document.getElementById('exportBtn').addEventListener('click', function () {
    const table = document.getElementById('myTable');
    let csvData = [];
    
    // Extract rows
    const rows = table.querySelectorAll('tr');
    rows.forEach(row => {
        let rowData = [];
        row.querySelectorAll('th, td').forEach(cell => {
            if (cell.querySelector('img')) {
                // If the cell contains an image, get the image's source URL
                rowData.push(cell.querySelector('img').src);
            } else {
                // Otherwise, get the cell's text content
                rowData.push(cell.textContent.trim());
            }
        });
        csvData.push(rowData.join(',')); // Join row data with commas
    });

    // Convert array to a CSV string
    const csvString = csvData.join('\n');

    // Create a downloadable link
    const blob = new Blob([csvString], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'table_data.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
});