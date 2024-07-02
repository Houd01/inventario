document.addEventListener('DOMContentLoaded', () => {
    const formIndividual = document.getElementById('form-individual');
    const formCaja = document.getElementById('form-caja');

    if (formIndividual) {
        formIndividual.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(formIndividual);
            fetch('add_individual.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  window.location.href = 'inventario_individual.html'; // Redirigir después de agregar
              }).catch(error => console.error('Error:', error));
        });
    }

    if (formCaja) {
        formCaja.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(formCaja);
            fetch('add_caja.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(data => {
                  alert(data);
                  window.location.href = 'inventario_cajas.html'; // Redirigir después de agregar
              }).catch(error => console.error('Error:', error));
        });
    }

    // Lógica para llenar tablas de inventario con datos de la base de datos
});
