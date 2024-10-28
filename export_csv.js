document.getElementById('exportButton').addEventListener('click', function () {
    const table = document.getElementById('dataTable');
    const rows = Array.from(table.rows);
    
    const csvContent = rows.map(row => {
        const cells = Array.from(row.cells);
        return cells.map(cell => cell.textContent).join(',');
    }).join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', 'data.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});
