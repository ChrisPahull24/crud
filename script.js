document.addEventListener("DOMContentLoaded", function () {
    const clienteForm = document.getElementById("clienteForm");
    const tablaClientes = document.getElementById("tablaClientes");
    const exportXLSX = document.getElementById("exportXLSX");
    const exportPDF = document.getElementById("exportPDF");
    let clientes = JSON.parse(localStorage.getItem("clientes")) || [];

    renderizarTabla();

    clienteForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const id = document.getElementById("clienteId").value;
        const nombre = document.getElementById("nombre").value;
        const apellido = document.getElementById("apellido").value;
        const tipoDocumento = document.getElementById("tipoDocumento").value;
        const numeroDocumento = document.getElementById("numeroDocumento").value;
        const ciudad = document.getElementById("ciudad").value;
        const direccion = document.getElementById("direccion").value;
        const telefono = document.getElementById("telefono").value;
        const email = document.getElementById("email").value;

        if (id) {
            // Actualizar cliente existente
            clientes = clientes.map(cliente => 
                cliente.id == id ? { id, nombre, apellido, tipoDocumento, numeroDocumento, ciudad, direccion, telefono, email } : cliente
            );
        } else {
            // Agregar nuevo cliente
            const nuevoCliente = { id: Date.now(), nombre, apellido, tipoDocumento, numeroDocumento, ciudad, direccion, telefono, email };
            clientes.push(nuevoCliente);
        }

        localStorage.setItem("clientes", JSON.stringify(clientes));
        clienteForm.reset();
        document.getElementById("clienteId").value = "";
        renderizarTabla();
    });

    function renderizarTabla() {
        tablaClientes.innerHTML = "";
        clientes.forEach(cliente => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${cliente.nombre}</td>
                <td>${cliente.apellido}</td>
                <td>${cliente.tipoDocumento}</td>
                <td>${cliente.numeroDocumento}</td>
                <td>${cliente.ciudad}</td>
                <td>${cliente.direccion}</td>
                <td>${cliente.telefono}</td>
                <td>${cliente.email}</td>
                <td>
                    <button onclick="editarCliente(${cliente.id})">Editar</button>
                    <button onclick="eliminarCliente(${cliente.id})">Eliminar</button>
                </td>
            `;
            tablaClientes.appendChild(fila);
        });
    }

    window.editarCliente = function (id) {
        const cliente = clientes.find(c => c.id === id);
        document.getElementById("clienteId").value = cliente.id;
        document.getElementById("nombre").value = cliente.nombre;
        document.getElementById("apellido").value = cliente.apellido;
        document.getElementById("tipoDocumento").value = cliente.tipoDocumento;
        document.getElementById("numeroDocumento").value = cliente.numeroDocumento;
        document.getElementById("ciudad").value = cliente.ciudad;
        document.getElementById("direccion").value = cliente.direccion;
        document.getElementById("telefono").value = cliente.telefono;
        document.getElementById("email").value = cliente.email;
    };

    window.eliminarCliente = function (id) {
        clientes = clientes.filter(cliente => cliente.id !== id);
        localStorage.setItem("clientes", JSON.stringify(clientes));
        renderizarTabla();
    };

    exportXLSX.addEventListener("click", function () {
        const ws = XLSX.utils.json_to_sheet(clientes);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Clientes");
        XLSX.writeFile(wb, "clientes.xlsx");
    });

    exportPDF.addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        let y = 10;

        doc.text("Lista de Clientes", 10, y);
        y += 10;

        clientes.forEach(cliente => {
            doc.text(`${cliente.nombre} ${cliente.apellido} - ${cliente.tipoDocumento}: ${cliente.numeroDocumento}`, 10, y);
            y += 10;
        });

        doc.save("clientes.pdf");
    });
});
