// ============================================
// GALENO - MÓDULO DE PROVEEDORES
// ============================================

let proveedores = []
let proveedorEditando = null

// Declare ProviderManager and ProductManager variables
const ProviderManager = {
  getAll: () => [],
  getById: (id) => null,
  add: (proveedor) => {},
  update: (id, proveedor) => {},
  delete: (id) => {},
  addOrder: (proveedorId, orden) => {},
}

const ProductManager = {
  getAll: () => [],
  getById: (id) => null,
  increaseStock: (productId, cantidad) => {},
}

// Declare formatCurrency function
function formatCurrency(value) {
  return value.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
}

// Declare showModal, showAlert, and closeModal functions
function showModal(modalId) {
  document.getElementById(modalId).style.display = "block"
}

function showAlert(message, type) {
  const alertContainer = document.createElement("div")
  alertContainer.className = `alert alert-${type}`
  alertContainer.textContent = message
  document.body.appendChild(alertContainer)
  setTimeout(() => {
    document.body.removeChild(alertContainer)
  }, 3000)
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none"
}

document.addEventListener("DOMContentLoaded", () => {
  cargarProveedores()
  populateProductSelects()
})

function cargarProveedores() {
  proveedores = ProviderManager.getAll()
  actualizarTablaProveedores()
  actualizarTablaOrdenes()
}

function actualizarTablaProveedores() {
  const tbody = document.getElementById("proveedoresTable")
  tbody.innerHTML = ""

  if (proveedores.length === 0) {
    tbody.innerHTML =
      '<tr><td colspan="5" style="text-align: center; color: var(--color-gray-400)">No hay proveedores registrados</td></tr>'
    return
  }

  proveedores.forEach((proveedor) => {
    const ordenesPendientes = proveedor.orders ? proveedor.orders.filter((o) => o.status === "pendiente").length : 0

    const row = document.createElement("tr")
    row.innerHTML = `
      <td><strong>${proveedor.nombre}</strong></td>
      <td>${proveedor.contacto || "-"}</td>
      <td>${proveedor.telefono || "-"}</td>
      <td>
        ${
          ordenesPendientes > 0
            ? `<span class="badge badge-warning">${ordenesPendientes}</span>`
            : "<span style='color: var(--color-gray-400)'>-</span>"
        }
      </td>
      <td>
        <button class="btn btn-sm btn-secondary" onclick="editarProveedor('${proveedor.id}')">✏️ Editar</button>
        <button class="btn btn-sm btn-danger" onclick="eliminarProveedor('${proveedor.id}')">🗑️ Eliminar</button>
      </td>
    `
    tbody.appendChild(row)
  })
}

function actualizarTablaOrdenes() {
  const tbody = document.getElementById("ordenesTable")
  tbody.innerHTML = ""

  const todasOrdenes = []
  proveedores.forEach((proveedor) => {
    if (proveedor.orders) {
      proveedor.orders.forEach((orden) => {
        todasOrdenes.push({
          ...orden,
          proveedorId: proveedor.id,
          proveedorNombre: proveedor.nombre,
        })
      })
    }
  })

  if (todasOrdenes.length === 0) {
    tbody.innerHTML =
      '<tr><td colspan="8" style="text-align: center; color: var(--color-gray-400)">No hay órdenes registradas</td></tr>'
    return
  }

  todasOrdenes.forEach((orden) => {
    const statusBadge = {
      pendiente: "badge-warning",
      recibida: "badge-success",
      cancelada: "badge-danger",
    }
    const statusText = {
      pendiente: "Pendiente",
      recibida: "Recibida",
      cancelada: "Cancelada",
    }

    const total = (orden.cantidad * orden.precioUnitario).toFixed(2)

    const row = document.createElement("tr")
    row.innerHTML = `
      <td><small>${orden.id}</small></td>
      <td>${orden.proveedorNombre}</td>
      <td>${orden.producto}</td>
      <td>${orden.cantidad}</td>
      <td>${formatCurrency(orden.precioUnitario)}</td>
      <td><strong>${formatCurrency(total)}</strong></td>
      <td><span class="badge ${statusBadge[orden.status]}">${statusText[orden.status]}</span></td>
      <td>
        <button class="btn btn-sm btn-primary" onclick="cambiarEstadoOrden('${orden.proveedorId}', '${orden.id}', 'recibida')" ${orden.status !== "pendiente" ? "disabled" : ""}>✓ Recibida</button>
        <button class="btn btn-sm btn-danger" onclick="cancelarOrden('${orden.proveedorId}', '${orden.id}')">✕ Cancelar</button>
      </td>
    `
    tbody.appendChild(row)
  })
}

function abrirModalAgregarProveedor() {
  proveedorEditando = null
  document.getElementById("proveedorModalTitle").textContent = "Nuevo Proveedor"
  document.getElementById("proveedorForm").reset()
  showModal("proveedorModal")
}

function editarProveedor(id) {
  const proveedor = ProviderManager.getById(id)
  if (!proveedor) return

  proveedorEditando = id
  document.getElementById("proveedorModalTitle").textContent = "Editar Proveedor"
  document.getElementById("proveedorNombre").value = proveedor.nombre || ""
  document.getElementById("proveedorContacto").value = proveedor.contacto || ""
  document.getElementById("proveedorTelefono").value = proveedor.telefono || ""
  document.getElementById("proveedorEmail").value = proveedor.email || ""
  document.getElementById("proveedorDireccion").value = proveedor.direccion || ""

  showModal("proveedorModal")
}

function guardarProveedor() {
  const nombre = document.getElementById("proveedorNombre").value.trim()
  const contacto = document.getElementById("proveedorContacto").value.trim()
  const telefono = document.getElementById("proveedorTelefono").value.trim()
  const email = document.getElementById("proveedorEmail").value.trim()
  const direccion = document.getElementById("proveedorDireccion").value.trim()

  if (!nombre) {
    showAlert("El nombre es requerido", "danger")
    return
  }

  if (proveedorEditando) {
    ProviderManager.update(proveedorEditando, {
      nombre,
      contacto,
      telefono,
      email,
      direccion,
    })
    showAlert("Proveedor actualizado correctamente", "success")
  } else {
    ProviderManager.add({
      nombre,
      contacto,
      telefono,
      email,
      direccion,
    })
    showAlert("Proveedor creado correctamente", "success")
  }

  closeModal("proveedorModal")
  cargarProveedores()
}

function eliminarProveedor(id) {
  if (confirm("¿Está seguro de que desea eliminar este proveedor?")) {
    ProviderManager.delete(id)
    showAlert("Proveedor eliminado correctamente", "success")
    cargarProveedores()
  }
}

function abrirModalAgregarOrden() {
  populateProveedorSelect()
  populateProductSelects()
  document.getElementById("ordenForm").reset()
  showModal("ordenModal")
}

function populateProveedorSelect() {
  const select = document.getElementById("ordenProveedor")
  select.innerHTML = '<option value="">-- Seleccionar Proveedor --</option>'
  proveedores.forEach((p) => {
    const option = document.createElement("option")
    option.value = p.id
    option.textContent = p.nombre
    select.appendChild(option)
  })
}

function populateProductSelects() {
  const products = ProductManager.getAll()
  const select = document.getElementById("ordenProducto")
  select.innerHTML = '<option value="">-- Seleccionar Producto --</option>'
  products.forEach((p) => {
    const option = document.createElement("option")
    option.value = p.id
    option.textContent = p.nombre + " (" + p.codigo + ")"
    select.appendChild(option)
  })
}

function guardarOrden() {
  const proveedorId = document.getElementById("ordenProveedor").value
  const productoId = document.getElementById("ordenProducto").value
  const cantidad = Number.parseInt(document.getElementById("ordenCantidad").value)
  const precioUnitario = Number.parseFloat(document.getElementById("ordenPrecio").value)
  const fechaEntrega = document.getElementById("ordenFecha").value

  if (!proveedorId || !productoId || !cantidad || !precioUnitario) {
    showAlert("Por favor complete todos los campos requeridos", "danger")
    return
  }

  const producto = ProductManager.getById(productoId)
  const orden = {
    producto: producto.nombre,
    productoId: productoId,
    cantidad: cantidad,
    precioUnitario: precioUnitario,
    fechaEntrega: fechaEntrega,
  }

  ProviderManager.addOrder(proveedorId, orden)
  showAlert("Orden de compra creada correctamente", "success")
  closeModal("ordenModal")
  cargarProveedores()
}

function cambiarEstadoOrden(proveedorId, ordenId, nuevoEstado) {
  const proveedor = ProviderManager.getById(proveedorId)
  if (!proveedor) return

  const ordenIndex = proveedor.orders.findIndex((o) => o.id === ordenId)
  if (ordenIndex === -1) return

  proveedor.orders[ordenIndex].status = nuevoEstado

  // Si se recibe, agregar al inventario
  if (nuevoEstado === "recibida") {
    const orden = proveedor.orders[ordenIndex]
    const producto = ProductManager.getById(orden.productoId)
    if (producto) {
      ProductManager.increaseStock(orden.productoId, orden.cantidad)
      showAlert(`Se agregaron ${orden.cantidad} unidades al inventario`, "success")
    }
  }

  ProviderManager.update(proveedorId, proveedor)
  cargarProveedores()
}

function cancelarOrden(proveedorId, ordenId) {
  if (confirm("¿Está seguro de que desea cancelar esta orden?")) {
    const proveedor = ProviderManager.getById(proveedorId)
    if (!proveedor) return

    const ordenIndex = proveedor.orders.findIndex((o) => o.id === ordenId)
    if (ordenIndex === -1) return

    proveedor.orders[ordenIndex].status = "cancelada"
    ProviderManager.update(proveedorId, proveedor)
    showAlert("Orden cancelada correctamente", "success")
    cargarProveedores()
  }
}
