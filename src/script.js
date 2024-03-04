document.addEventListener('DOMContentLoaded', function () {
    const busquedaInput = document.getElementById('busquedaInput');
    const tablaDatosBody = document.getElementById('tablaDatosBody');

    // Attach event listener to the table body to handle row clicks (event delegation)
    tablaDatosBody.addEventListener('click', onRowClick);

    // Function to update the table with search results
    function updateTable() {
        const searchInputValue = busquedaInput.value;
        if (searchInputValue !== '') {
            // Send the search input to the server-side script using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../configuraciones/search_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Update the table body with the server response
                    tablaDatosBody.innerHTML = xhr.responseText;
                }
            };
            xhr.send('search_input=' + encodeURIComponent(searchInputValue));
        } else {
            // Clear the table if the search input is empty
            tablaDatosBody.innerHTML = '';
        }
    }

    // Function to handle the row click event
    function onRowClick(event) {
        const target = event.target;

        // Check if the click was on an input field (for editing) or a button (for saving/canceling)
        if (target.tagName === 'INPUT' || target.tagName === 'BUTTON') {
            return;
        }

        // Check if the clicked element is a table cell (td)
        if (target.tagName === 'TD') {
            // Check if a "Guardar" button is already present in the clicked row
            if (target.querySelector('button')) {
                return;
            }

            // Get the current text content of the cell
            const currentText = target.textContent.trim();

            // Create an input field with the current text as its value
            const inputField = document.createElement('input');
            inputField.type = 'text';
            inputField.value = currentText;

            // Create a "Guardar" button
            const guardarButton = document.createElement('button');
            guardarButton.textContent = 'Guardar';

            // Append the input field and "Guardar" button to the cell
            target.textContent = '';
            target.appendChild(inputField);
            target.appendChild(guardarButton);

            // Focus on the input field
            inputField.focus();

            // Add event listener to the "Guardar" button
            guardarButton.addEventListener('click', () => {
                // Perform data modification logic here
                modifyDataInDatabase(rowData); // Call the function to modify data in the database
            });
        }
    }

    // Function to handle the modification of data in the database
    function modifyDataInDatabase(rowData) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../configuraciones/modify_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Handle the server response after modifying the data (if needed)
                const response = xhr.responseText;
                alert(response); // Display the response message (you can customize this)

                // Update the table again to reflect the changes
                updateTable();
            }
        };

        // Assuming you have a PHP condition in modify_data.php to check for modification requests
        // Add parameters to indicate that it's a modification request and pass the record data to modify
        const params =
        'modify_data=true' +
        '&record_id=' + encodeURIComponent(rowData.id) +
        '&cuenta=' + encodeURIComponent(rowData.cuenta) +
        '&operador=' + encodeURIComponent(rowData.operador) +
        '&turno=' + encodeURIComponent(rowData.turno) +
        '&entidad=' + encodeURIComponent(rowData.entidad) +
        '&partido=' + encodeURIComponent(rowData.partido) +
        '&coalicion=' + encodeURIComponent(rowData.coalicion) +
        '&cliente=' + encodeURIComponent(rowData.cliente) +
        '&identidad_perfil=' + encodeURIComponent(rowData.identidad_perfil) +
        '&reaccion=' + encodeURIComponent(rowData.reaccion) +
        '&nombre_usuario=' + encodeURIComponent(rowData.nombre_usuario) +
        '&usuario=' + encodeURIComponent(rowData.usuario) +
        '&contraseña=' + encodeURIComponent(rowData.contraseña) +
        '&correo=' + encodeURIComponent(rowData.correo) +
        '&telefono=' + encodeURIComponent(rowData.telefono) +
        '&compañia=' + encodeURIComponent(rowData.compañia) +
        '&fecha_nacimiento=' + encodeURIComponent(rowData.fecha_nacimiento) +
        '&sexo=' + encodeURIComponent(rowData.sexo);

        xhr.send(params);
    }

    // Call the updateTable function when the search input changes
    busquedaInput.addEventListener('keyup', updateTable);

    // Initial call to update the table with data on page load
    updateTable();
    
});
