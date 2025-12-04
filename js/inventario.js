// ============================================
// GALENO - MÓDULO INVENTARIO
// ============================================

let currentEditingId = null

// Declare necessary variables and functions
const ProductManager = {
  getAll: () => {
    // Mock implementation
    return []
  },
  getById: (id) => {
    // Mock implementation
    return null
  },
  add: (data) => {
    // Mock implementation
  },
  update: (id, data) => {
    // Mock implementation
  },
  delete: (id) => {
    // Mock implementation
  },
}

const CONFIG = {
  STOCK_MIN_THRESHOLD: 10,
  EXPIRY_WARNING_DAYS: 30,
}

function updateDateTime() {
  const now = new Date()
  document.getElementById("dateTime").textContent = now.toLocaleString()
}

function daysUntilExpiry(expiryDate) {
  const now = new Date()
  const expiry = new Date(expiryDate)
  const difference = expiry - now
  return Math.ceil(difference / (1000 * 60 * 60 * 24))
}

function formatCurrency(amount) {
  return amount.toLocaleString("es-ES", { style: "currency", currency: "EUR" })
}

function formatDate(date) {
  return new Date(date).toLocaleDateString("es-ES")
}

function showModal(modalId) {
  document.getElementById(modalId).style.display = "block"
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none"
}

function showAlert(message, type) {
  const alertDiv = document.createElement("div")
  alertDiv.className = `alert alert-${type}`
  alertDiv.textContent = message
  document.getElementById("alertsContainer").appendChild(alertDiv)
  setTimeout(() => {
    document.getElementById("alertsContainer").removeChild(alertDiv)
  }, 3000)
}

document.addEventListener("DOMContentLoaded", () => {
  cargarProductos()
  setupEventListeners()
  updateDateTime()
  setInterval(updateDateTime, 1000)
})

function setupEventListeners() {
  const searchInput = document.getElementById("searchInput")
  if (searchInput) {
    searchInput.addEventListener("input", filtrarProductos)
  }

  // Cerrar modal al hacer click fuera
  const modal = document.getElementById("productModal")
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeProductModal()
    }
  })
}

// ============================================
// GESTIÓN DE PRODUCTOS
// ============================================

function cargarProductos() {
  const productos = ProductManager.getAll()
  const tbody = document.getElementById("productosBody")

  if (productos.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>No hay productos registrados</p>
                </td>
            </tr>
        `
    return
  }

  tbody.innerHTML = productos
    .map((producto) => {
      const estado = getProductStatus(producto)
      const badgeClass = getBadgeClass(estado)
      const diasVencer = daysUntilExpiry(producto.fechaCaducidad)

      return `
            <tr>
                <td><strong>${producto.codigo}</strong></td>
                <td>${producto.nombre}</td>
                <td>${formatCurrency(producto.precio)}</td>
                <td>
                    <strong class="${producto.stock < CONFIG.STOCK_MIN_THRESHOLD ? "text-danger" : ""}">
                        ${producto.stock}
                    </strong>
                </td>
                <td>${producto.lote}</td>
                <td>
                    ${formatDate(producto.fechaCaducidad)}
                    <small style="color: var(--color-gray-500); display: block;">
                        (${diasVencer} días)
                    </small>
                </td>
                <td>
                    <span class="badge ${badgeClass}">${estado}</span>
                </td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="editarProducto('${producto.id}')">
                        ✏️ Editar
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarProducto('${producto.id}')">
                        🗑️ Eliminar
                    </button>
                </td>
            </tr>
        `
    })
    .join("")
}

function getProductStatus(producto) {
  const diasVencer = daysUntilExpiry(producto.fechaCaducidad)

  if (diasVencer < 0) {
    return "Vencido"
  }
  if (producto.stock < CONFIG.STOCK_MIN_THRESHOLD) {
    return "Stock Bajo"
  }
  if (diasVencer <= CONFIG.EXPIRY_WARNING_DAYS) {
    return "Próx. Vencer"
  }
  return "OK"
}

function getBadgeClass(estado) {
  switch (estado) {
    case "OK":
      return "badge-success"
    case "Stock Bajo":
      return "badge-warning"
    case "Próx. Vencer":
      return "badge-warning"
    case "Vencido":
      return "badge-danger"
    default:
      return "badge-info"
  }
}

// ============================================
// MODAL: ABRIR/CERRAR
// ============================================

function openProductModal() {
  currentEditingId = null
  document.getElementById("modalTitle").textContent = "Nuevo Producto"
  document.getElementById("productForm").reset()
  showModal("productModal")
  document.getElementById("codigo").focus()
}

function closeProductModal() {
  closeModal("productModal")
  currentEditingId = null
}

function editarProducto(id) {
  const producto = ProductManager.getById(id)
  if (!producto) {
    showAlert("Producto no encontrado", "danger")
    return
  }

  currentEditingId = id
  document.getElementById("modalTitle").textContent = "Editar Producto"

  // Llenar formulario con datos existentes
  document.getElementById("codigo").value = producto.codigo
  document.getElementById("nombre").value = producto.nombre
  document.getElementById("precio").value = producto.precio
  document.getElementById("stock").value = producto.stock
  document.getElementById("lote").value = producto.lote
  document.getElementById("fechaCaducidad").value = producto.fechaCaducidad
  document.getElementById("descripcion").value = producto.descripcion || ""

  showModal("productModal")
}

// ============================================
// GUARDAR PRODUCTO
// ============================================

function guardarProducto(event) {
  event.preventDefault()

  const formData = {
    codigo: document.getElementById("codigo").value.trim(),
    nombre: document.getElementById("nombre").value.trim(),
    precio: Number.parseFloat(document.getElementById("precio").value),
    stock: Number.parseInt(document.getElementById("stock").value),
    lote: document.getElementById("lote").value.trim(),
    fechaCaducidad: document.getElementById("fechaCaducidad").value,
    descripcion: document.getElementById("descripcion").value.trim(),
  }

  // Validaciones
  if (!formData.codigo || !formData.nombre || !formData.lote || !formData.fechaCaducidad) {
    showAlert("Por favor completa todos los campos requeridos", "danger")
    return
  }

  if (formData.precio <= 0) {
    showAlert("El precio debe ser mayor a 0", "danger")
    return
  }

  // Validar fecha de caducidad
  const fechaCaducidad = new Date(formData.fechaCaducidad)
  if (fechaCaducidad < new Date()) {
    showAlert("La fecha de caducidad no puede ser anterior a hoy", "danger")
    return
  }

  // Verificar código único (solo si es nuevo)
  if (!currentEditingId) {
    const codigoExiste = ProductManager.getAll().some((p) => p.codigo === formData.codigo)
    if (codigoExiste) {
      showAlert("Ya existe un producto con este código", "danger")
      return
    }
  }

  try {
    if (currentEditingId) {
      // Actualizar producto
      ProductManager.update(currentEditingId, formData)
      showAlert("Producto actualizado correctamente", "success")
    } else {
      // Crear nuevo producto
      ProductManager.add(formData)
      showAlert("Producto registrado correctamente", "success")
    }

    closeProductModal()
    cargarProductos()
  } catch (error) {
    showAlert("Error al guardar el producto: " + error.message, "danger")
  }
}

// ============================================
// ELIMINAR PRODUCTO
// ============================================

function eliminarProducto(id) {
  const producto = ProductManager.getById(id)

  if (confirm(`¿Está seguro de que desea eliminar "${producto.nombre}"?`)) {
    try {
      ProductManager.delete(id)
      showAlert("Producto eliminado correctamente", "success")
      cargarProductos()
    } catch (error) {
      showAlert("Error al eliminar el producto", "danger")
    }
  }
}

// ============================================
// FILTRO Y BÚSQUEDA
// ============================================

function filtrarProductos() {
  const searchTerm = document.getElementById("searchInput").value.toLowerCase()
  const filterStatus = document.getElementById("filterStatus").value
  const productos = ProductManager.getAll()
  const tbody = document.getElementById("productosBody")

  const productosFiltrados = productos.filter((producto) => {
    // Filtro de búsqueda
    const matchSearch =
      producto.nombre.toLowerCase().includes(searchTerm) || producto.codigo.toLowerCase().includes(searchTerm)

    // Filtro de estado
    let matchStatus = true
    if (filterStatus) {
      const estado = getProductStatus(producto)
      matchStatus = estado === filterStatus
    }

    return matchSearch && matchStatus
  })

  if (productosFiltrados.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>No se encontraron productos que coincidan con los criterios</p>
                </td>
            </tr>
        `
    return
  }

  tbody.innerHTML = productosFiltrados
    .map((producto) => {
      const estado = getProductStatus(producto)
      const badgeClass = getBadgeClass(estado)
      const diasVencer = daysUntilExpiry(producto.fechaCaducidad)

      return `
            <tr>
                <td><strong>${producto.codigo}</strong></td>
                <td>${producto.nombre}</td>
                <td>${formatCurrency(producto.precio)}</td>
                <td>
                    <strong class="${producto.stock < CONFIG.STOCK_MIN_THRESHOLD ? "text-danger" : ""}">
                        ${producto.stock}
                    </strong>
                </td>
                <td>${producto.lote}</td>
                <td>
                    ${formatDate(producto.fechaCaducidad)}
                    <small style="color: var(--color-gray-500); display: block;">
                        (${diasVencer} días)
                    </small>
                </td>
                <td>
                    <span class="badge ${badgeClass}">${estado}</span>
                </td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="editarProducto('${producto.id}')">
                        ✏️ Editar
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarProducto('${producto.id}')">
                        🗑️ Eliminar
                    </button>
                </td>
            </tr>
        `
    })
    .join("")
}

// ============================================
// CSS DINÁMICO PARA FILTROS
// ============================================

const style = document.createElement("style")
style.textContent = `
    .controls-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filters-section {
        display: flex;
        gap: 1rem;
        flex: 1;
        min-width: 300px;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        min-width: 200px;
    }

    .filter-select {
        min-width: 150px;
    }

    .text-danger {
        color: var(--color-danger) !important;
    }

    @media (max-width: 768px) {
        .controls-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filters-section {
            flex-direction: column;
        }

        .search-input,
        .filter-select {
            width: 100%;
        }
    }
`
document.head.appendChild(style)
