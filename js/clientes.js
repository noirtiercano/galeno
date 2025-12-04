// ============================================
// GALENO - MÓDULO DE CLIENTES
// ============================================

let clientes = []
let clienteEditando = null

// Declare CustomerManager
const CustomerManager = {
  getAll: () => [],
  getById: (id) => null,
  update: (id, data) => { },
  add: (data) => { },
  delete: (id) => { },
}

// Declare formatCurrency
function formatCurrency(amount) {
  return amount.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
}

// Declare showModal
function showModal(modalId) {
  document.getElementById(modalId).style.display = "block"
}

// Declare showAlert
function showAlert(message, type) {
  const alert = document.createElement("div")
  alert.className = `alert alert-${type}`
  alert.textContent = message
  document.body.appendChild(alert)
  setTimeout(() => document.body.removeChild(alert), 3000)
}

// Declare closeModal
function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none"
}

// Declare formatDateTime
function formatDateTime(date) {
  return new Date(date).toLocaleDateString("es-ES", { year: "numeric", month: "long", day: "numeric" })
}

document.addEventListener("DOMContentLoaded", () => {
  cargarClientes()
})

function cargarClientes() {
  clientes = CustomerManager.getAll()
  actualizarTablaClientes(clientes)
}

function actualizarTablaClientes(clientesAMostrar) {
  const tbody = document.getElementById("clientesTable")
  tbody.innerHTML = ""

  if (clientesAMostrar.length === 0) {
    tbody.innerHTML =
      '<tr><td colspan="7" style="text-align: center; color: var(--color-gray-400)">No hay clientes registrados</td></tr>'
    return
  }

  clientesAMostrar.forEach((cliente) => {
    const totalCompras = cliente.purchaseHistory ? cliente.purchaseHistory.length : 0
    const totalGastado = cliente.purchaseHistory
      ? cliente.purchaseHistory.reduce((sum, c) => sum + (c.total || 0), 0)
      : 0

    const row = document.createElement("tr")
    row.innerHTML = `
      <td><strong>${cliente.nombre}</strong></td>
      <td>${cliente.telefono || "-"}</td>
      <td>${cliente.email || "-"}</td>
      <td><span class="badge badge-info">${cliente.descuento || 0}%</span></td>
      <td>${totalCompras}</td>
      <td>${formatCurrency(totalGastado)}</td>
      <td>
        <button class="btn btn-sm btn-secondary" onclick="editarCliente('${cliente.id}')">✏️ Editar</button>
        <button class="btn btn-sm btn-info" onclick="verHistorial('${cliente.id}')" style="background-color: var(--color-info)">📋 Historial</button>
        <button class="btn btn-sm btn-danger" onclick="eliminarCliente('${cliente.id}')">🗑️ Eliminar</button>
      </td>
    `
    tbody.appendChild(row)
  })
}

function abrirModalAgregarCliente() {
  clienteEditando = null
  document.getElementById("clienteModalTitle").textContent = "Nuevo Cliente"
  document.getElementById("clienteForm").reset()
  showModal("clienteModal")
}

function editarCliente(id) {
  const cliente = CustomerManager.getById(id)
  if (!cliente) return

  clienteEditando = id
  document.getElementById("clienteModalTitle").textContent = "Editar Cliente"
  document.getElementById("clienteNombre").value = cliente.nombre || ""
  document.getElementById("clienteTelefono").value = cliente.telefono || ""
  document.getElementById("clienteEmail").value = cliente.email || ""
  document.getElementById("clienteDescuento").value = cliente.descuento || 0
  document.getElementById("clienteNotas").value = cliente.notas || ""

  showModal("clienteModal")
}

function guardarCliente() {
  const nombre = document.getElementById("clienteNombre").value.trim()
  const telefono = document.getElementById("clienteTelefono").value.trim()
  const email = document.getElementById("clienteEmail").value.trim()
  const descuento = Number.parseFloat(document.getElementById("clienteDescuento").value) || 0
  const notas = document.getElementById("clienteNotas").value.trim()

  if (!nombre) {
    showAlert("El nombre es requerido", "danger")
    return
  }

  if (clienteEditando) {
    // Editar
    CustomerManager.update(clienteEditando, {
      nombre,
      telefono,
      email,
      descuento,
      notas,
    })
    showAlert("Cliente actualizado correctamente", "success")
  } else {
    // Crear
    CustomerManager.add({
      nombre,
      telefono,
      email,
      descuento,
      notas,
    })
    showAlert("Cliente creado correctamente", "success")
  }

  closeModal("clienteModal")
  cargarClientes()
}

function eliminarCliente(id) {
  if (confirm("¿Está seguro de que desea eliminar este cliente?")) {
    CustomerManager.delete(id)
    showAlert("Cliente eliminado correctamente", "success")
    cargarClientes()
  }
}

function verHistorial(id) {
  const cliente = CustomerManager.getById(id)
  if (!cliente) return

  const historial = cliente.purchaseHistory || []
  const content = document.getElementById("historialContent")
  content.innerHTML = `<h3>${cliente.nombre}</h3>`

  if (historial.length === 0) {
    content.innerHTML += '<p class="empty-state">Sin historial de compras</p>'
    showModal("historialModal")
    return
  }

  let html = '<div style="display: flex; flex-direction: column; gap: 1rem">'
  historial.reverse().forEach((compra) => {
    const fecha = formatDateTime(compra.date)
    html += `
      <div style="padding: 1rem; background-color: var(--color-gray-50); border-radius: var(--radius-md); border-left: 4px solid var(--color-primary)">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem">
          <strong>${fecha}</strong>
          <span style="color: var(--color-success); font-weight: 700">${formatCurrency(compra.total || 0)}</span>
        </div>
        <small>${compra.items ? compra.items.length + " artículos" : ""}</small>
      </div>
    `
  })
  html += "</div>"

  content.innerHTML += html
  showModal("historialModal")
}

function filtrarClientes() {
  const query = document.getElementById("searchCliente").value.toLowerCase()
  const filtrados = clientes.filter(
    (c) =>
      (c.nombre && c.nombre.toLowerCase().includes(query)) ||
      (c.telefono && c.telefono.toLowerCase().includes(query)) ||
      (c.email && c.email.toLowerCase().includes(query)),
  )
  actualizarTablaClientes(filtrados)
}
