// ============================================
// GALENO - MÓDULO DE VENTAS (TPV)
// ============================================

let cart = []
const currentSale = null
let selectedCustomer = null

// Declaración de variables necesarias
const ProductManager = {
  getAll: () => [],
  add: () => {},
  getById: () => null,
  decreaseStock: () => {},
  increaseStock: () => {},
}

const CustomerManager = {
  getAll: () => [],
  getById: () => null,
}

const SalesManager = {
  add: () => {},
}

const formatCurrency = (amount) => amount.toFixed(2) + "€"
const calculateIVA = (amount) => amount * 0.21
const calculateTotal = (amount, iva) => amount + iva
const showModal = (modalId) => {}
const closeModal = (modalId) => {}
const generateInvoiceNumber = () => "INV12345"
const formatDateTime = (isoString) => isoString.split("T")[0]

const showAlert = (message, type, timeout = 3000) => {
  const alertDiv = document.createElement("div")
  alertDiv.className = `alert alert-${type}`
  alertDiv.textContent = message
  document.body.appendChild(alertDiv)

  setTimeout(() => {
    document.body.removeChild(alertDiv)
  }, timeout)
}

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  initializeVentas()
  setupEventListeners()
  populateCustomers()
  updateCartTotals()
})

function initializeVentas() {
  // Cargar datos de ejemplo si no existen
  const products = ProductManager.getAll()
  if (products.length === 0) {
    // Productos de ejemplo
    const ejemploProductos = [
      {
        nombre: "Paracetamol 500mg",
        codigo: "P001",
        precio: 5.99,
        stock: 50,
        lote: "L001",
        fechaCaducidad: "2025-12-31",
      },
      {
        nombre: "Ibuprofeno 400mg",
        codigo: "P002",
        precio: 7.49,
        stock: 30,
        lote: "L002",
        fechaCaducidad: "2025-11-15",
      },
      {
        nombre: "Amoxicilina 500mg",
        codigo: "P003",
        precio: 12.99,
        stock: 20,
        lote: "L003",
        fechaCaducidad: "2025-08-20",
      },
      {
        nombre: "Vitamina C 1000mg",
        codigo: "P004",
        precio: 8.99,
        stock: 100,
        lote: "L004",
        fechaCaducidad: "2026-06-30",
      },
    ]

    ejemploProductos.forEach((p) => ProductManager.add(p))
  }
}

function setupEventListeners() {
  // Búsqueda de productos
  document.getElementById("searchForm").addEventListener("submit", (e) => {
    e.preventDefault()
    buscarProducto()
  })

  // Cambio en tipo de descuento
  document.getElementById("discountType").addEventListener("change", function () {
    const isEnabled = this.value !== "none"
    document.getElementById("discountValue").disabled = !isEnabled
  })

  // Receta médica
  document.getElementById("hasRecipe").addEventListener("change", function () {
    document.getElementById("recipeFields").style.display = this.checked ? "block" : "none"
  })

  // Método de pago
  document.getElementById("paymentMethod").addEventListener("change", function () {
    const isCard = this.value === "card"
    document.getElementById("cardPaymentFields").style.display = isCard ? "block" : "none"
  })

  // Cambio en efectivo
  document.getElementById("cashReceived").addEventListener("input", function () {
    const total = calculateTotalAmount()
    const received = Number.parseFloat(this.value) || 0
    const change = received - total
    document.getElementById("changeAmount").textContent = formatCurrency(Math.max(0, change))
  })

  // Seleccionar cliente
  document.getElementById("customerSelect").addEventListener("change", function () {
    if (this.value) {
      const customer = CustomerManager.getById(this.value)
      if (customer) {
        selectedCustomer = customer
        document.getElementById("customerName").value = customer.nombre || ""
        document.getElementById("customerPhone").value = customer.telefono || ""
      }
    } else {
      selectedCustomer = null
      document.getElementById("customerName").value = ""
      document.getElementById("customerPhone").value = ""
    }
  })
}

function populateCustomers() {
  const customers = CustomerManager.getAll()
  const select = document.getElementById("customerSelect")
  const options = select.innerHTML

  customers.forEach((c) => {
    const option = document.createElement("option")
    option.value = c.id
    option.textContent = c.nombre || "Cliente sin nombre"
    select.appendChild(option)
  })
}

function buscarProducto() {
  const query = document.getElementById("productSearch").value.toLowerCase()
  const products = ProductManager.getAll()

  const filtered = products.filter(
    (p) => p.codigo.toLowerCase().includes(query) || p.nombre.toLowerCase().includes(query),
  )

  const resultsDiv = document.getElementById("searchResults")
  resultsDiv.innerHTML = ""

  if (filtered.length === 0) {
    resultsDiv.innerHTML = '<div class="alert alert-info">Producto no encontrado</div>'
    return
  }

  filtered.forEach((product) => {
    const div = document.createElement("div")
    div.style.cssText = `
      padding: 1rem;
      background-color: var(--color-gray-50);
      border-radius: var(--radius-md);
      margin-bottom: 0.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1px solid var(--color-gray-200);
    `

    const stock = product.stock > 0 ? "✅" : "❌"
    const info = `
      <div>
        <strong>${product.nombre}</strong> (${product.codigo})
        <br/>
        <small>Stock: ${stock} ${product.stock} | Precio: ${formatCurrency(product.precio)}</small>
      </div>
    `

    const btn = `
      <button class="btn btn-primary btn-sm" onclick="agregarAlCarrito('${product.id}')">
        Agregar
      </button>
    `

    div.innerHTML = info + btn
    resultsDiv.appendChild(div)
  })
}

function agregarAlCarrito(productId) {
  const product = ProductManager.getById(productId)
  if (!product) return

  if (product.stock <= 0) {
    showAlert("Este producto no tiene stock disponible", "danger")
    return
  }

  // Verificar si ya está en el carrito
  const existingItem = cart.find((item) => item.id === productId)
  if (existingItem) {
    if (existingItem.quantity < product.stock) {
      existingItem.quantity++
    } else {
      showAlert("No hay suficiente stock disponible", "warning")
      return
    }
  } else {
    cart.push({
      id: productId,
      nombre: product.nombre,
      codigo: product.codigo,
      precio: product.precio,
      lote: product.lote,
      quantity: 1,
    })
  }

  showAlert(`${product.nombre} agregado al carrito`, "success", 2000)
  updateCartDisplay()
  updateCartTotals()
  document.getElementById("productSearch").value = ""
  document.getElementById("searchResults").innerHTML = ""
}

function updateCartDisplay() {
  const cartDiv = document.getElementById("cartItems")
  cartDiv.innerHTML = ""

  if (cart.length === 0) {
    cartDiv.innerHTML = '<div class="empty-state">Carrito vacío</div>'
    return
  }

  cart.forEach((item, index) => {
    const itemDiv = document.createElement("div")
    itemDiv.style.cssText = `
      padding: 0.75rem;
      background-color: var(--color-gray-50);
      border-radius: var(--radius-sm);
      border: 1px solid var(--color-gray-200);
      display: flex;
      justify-content: space-between;
      align-items: center;
    `

    const subtotal = item.precio * item.quantity
    const info = `
      <div style="flex: 1">
        <strong>${item.nombre}</strong>
        <br/>
        <small>${item.quantity} x ${formatCurrency(item.precio)} = ${formatCurrency(subtotal)}</small>
      </div>
    `

    const controls = `
      <div style="display: flex; gap: 0.25rem">
        <button class="btn btn-sm" style="background-color: var(--color-secondary)" onclick="cambiarCantidad(${index}, -1)">−</button>
        <span style="min-width: 30px; text-align: center; font-weight: 600">${item.quantity}</span>
        <button class="btn btn-sm" style="background-color: var(--color-secondary)" onclick="cambiarCantidad(${index}, 1)">+</button>
        <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${index})">✕</button>
      </div>
    `

    itemDiv.innerHTML = info + controls
    cartDiv.appendChild(itemDiv)
  })

  // Llenar dropdown de devoluciones
  const devDropdown = document.getElementById("devolucionProduct")
  const currentValue = devDropdown.value
  devDropdown.innerHTML = '<option value="">-- Seleccionar --</option>'
  cart.forEach((item, index) => {
    const option = document.createElement("option")
    option.value = index
    option.textContent = `${item.nombre} (${item.quantity} en carrito)`
    devDropdown.appendChild(option)
  })
  devDropdown.value = currentValue
}

function cambiarCantidad(index, change) {
  const newQuantity = cart[index].quantity + change
  const product = ProductManager.getById(cart[index].id)

  if (newQuantity <= 0) {
    eliminarDelCarrito(index)
  } else if (newQuantity > product.stock) {
    showAlert("Stock insuficiente", "warning")
  } else {
    cart[index].quantity = newQuantity
    updateCartDisplay()
    updateCartTotals()
  }
}

function eliminarDelCarrito(index) {
  cart.splice(index, 1)
  updateCartDisplay()
  updateCartTotals()
}

function limpiarCarrito() {
  if (confirm("¿Desea vaciar el carrito?")) {
    cart = []
    updateCartDisplay()
    updateCartTotals()
    showAlert("Carrito vaciado", "info", 2000)
  }
}

function updateCartTotals() {
  const subtotal = cart.reduce((sum, item) => sum + item.precio * item.quantity, 0)

  const discountType = document.getElementById("discountType").value
  const discountValue = Number.parseFloat(document.getElementById("discountValue").value) || 0
  let discount = 0

  if (discountType === "percent") {
    discount = subtotal * (discountValue / 100)
  } else if (discountType === "fixed") {
    discount = Math.min(discountValue, subtotal)
  }

  const iva = calculateIVA(subtotal - discount)
  const total = calculateTotal(subtotal - discount, iva)

  document.getElementById("subtotalDisplay").textContent = formatCurrency(subtotal)
  document.getElementById("ivaDisplay").textContent = formatCurrency(iva)
  document.getElementById("discountDisplay").textContent = formatCurrency(discount)
  document.getElementById("totalDisplay").textContent = total.toFixed(2)
  document.getElementById("paymentTotal").textContent = formatCurrency(total)
}

function calculateTotalAmount() {
  const subtotal = cart.reduce((sum, item) => sum + item.precio * item.quantity, 0)
  const discountType = document.getElementById("discountType").value
  const discountValue = Number.parseFloat(document.getElementById("discountValue").value) || 0
  let discount = 0

  if (discountType === "percent") {
    discount = subtotal * (discountValue / 100)
  } else if (discountType === "fixed") {
    discount = Math.min(discountValue, subtotal)
  }

  return subtotal - discount + calculateIVA(subtotal - discount)
}

function procesarPago() {
  if (cart.length === 0) {
    showAlert("El carrito está vacío", "danger")
    return
  }

  showModal("paymentModal")
}

function finalizarVenta() {
  const method = document.getElementById("paymentMethod").value

  // Validaciones
  if (method === "card") {
    const cardNumber = document.getElementById("cardNumber").value
    const expiry = document.getElementById("cardExpiry").value
    const cvv = document.getElementById("cardCVV").value

    if (!cardNumber || !expiry || !cvv) {
      showAlert("Por favor complete los datos de la tarjeta", "danger")
      return
    }
  } else if (method === "cash") {
    const received = Number.parseFloat(document.getElementById("cashReceived").value)
    const total = calculateTotalAmount()
    if (!received || received < total) {
      showAlert("Cantidad insuficiente", "danger")
      return
    }
  }

  // Crear venta
  const sale = {
    items: [...cart],
    subtotal: cart.reduce((sum, item) => sum + item.precio * item.quantity, 0),
    discount:
      Number.parseFloat(document.getElementById("discountDisplay").textContent.replace("€ ", "").replace(",", ".")) ||
      0,
    iva: Number.parseFloat(document.getElementById("ivaDisplay").textContent.replace("€ ", "").replace(",", ".")) || 0,
    total: calculateTotalAmount(),
    paymentMethod: method,
    customer: selectedCustomer,
    recipe: document.getElementById("hasRecipe").checked
      ? {
          doctor: document.getElementById("doctorName").value,
          doctorLicense: document.getElementById("doctorLicense").value,
          patient: document.getElementById("patientName").value,
          diagnosis: document.getElementById("diagnosis").value,
        }
      : null,
  }

  // Descontar stock
  cart.forEach((item) => {
    ProductManager.decreaseStock(item.id, item.quantity)
  })

  // Guardar venta
  SalesManager.add(sale)

  // Generar recibo
  generarRecibo(sale)

  // Limpiar
  closeModal("paymentModal")
  cart = []
  updateCartDisplay()
  updateCartTotals()
  document.getElementById("customerName").value = ""
  document.getElementById("customerPhone").value = ""
  document.getElementById("customerSelect").value = ""
  document.getElementById("discountType").value = "none"
  document.getElementById("discountValue").value = ""
  document.getElementById("hasRecipe").checked = false
  document.getElementById("recipeFields").style.display = "none"

  showAlert("Venta registrada exitosamente", "success")
  showModal("reciboModal")
}

function generarRecibo(sale) {
  const invoiceNumber = generateInvoiceNumber()
  const now = new Date()
  const dateTime = formatDateTime(now.toISOString())

  let items = ""
  sale.items.forEach((item) => {
    const subtotalItem = (item.precio * item.quantity).toFixed(2)
    items += `
${item.nombre}
${item.quantity}x ${item.precio.toFixed(2)}€ = ${subtotalItem}€
`
  })

  const recibo = `
==========================================
           FARMACIA GALENO - RECIBO
==========================================
Número: ${invoiceNumber}
Fecha: ${dateTime}
==========================================
PRODUCTOS:
${items}
------------------------------------------
Subtotal:        ${sale.subtotal.toFixed(2)}€
Descuento:       ${sale.discount.toFixed(2)}€
IVA (21%):       ${sale.iva.toFixed(2)}€
------------------------------------------
TOTAL:           ${sale.total.toFixed(2)}€
------------------------------------------
Método Pago: ${translatePaymentMethod(sale.paymentMethod)}
${sale.customer ? `Cliente: ${sale.customer.nombre}` : "Cliente: General"}
${
  sale.recipe
    ? `
RECETA MÉDICA:
Médico: ${sale.recipe.doctor}
Paciente: ${sale.recipe.patient}
`
    : ""
}
==========================================
Gracias por su compra
==========================================
`

  document.getElementById("reciboContent").textContent = recibo
}

function translatePaymentMethod(method) {
  const translations = {
    cash: "Efectivo",
    card: "Tarjeta",
    check: "Cheque",
    transfer: "Transferencia",
  }
  return translations[method] || method
}

function imprimirRecibo() {
  const content = document.getElementById("reciboContent").textContent
  const printWindow = window.open("", "_blank")
  printWindow.document.write(`<pre style="font-family: monospace; margin: 2rem">${content}</pre>`)
  printWindow.document.close()
  printWindow.print()
}

function abrirModalDevolucion() {
  if (cart.length === 0) {
    showAlert("El carrito está vacío", "info")
    return
  }
  showModal("devolucionModal")
}

function procesarDevolucion() {
  const productIndex = Number.parseInt(document.getElementById("devolucionProduct").value)
  const cantidad = Number.parseInt(document.getElementById("devolucionCantidad").value)
  const motivo = document.getElementById("devolucionMotivo").value

  if (isNaN(productIndex) || isNaN(cantidad) || cantidad <= 0) {
    showAlert("Por favor complete todos los campos", "danger")
    return
  }

  const item = cart[productIndex]
  if (cantidad > item.quantity) {
    showAlert("Cantidad inválida", "danger")
    return
  }

  // Registrar devolución
  const product = ProductManager.getById(item.id)
  if (product) {
    ProductManager.increaseStock(item.id, cantidad)
  }

  // Actualizar carrito
  item.quantity -= cantidad
  if (item.quantity === 0) {
    cart.splice(productIndex, 1)
  }

  updateCartDisplay()
  updateCartTotals()
  closeModal("devolucionModal")

  showAlert(`Devolución registrada: ${cantidad} unidades de ${item.nombre}`, "success")

  // Limpiar modal
  document.getElementById("devolucionProduct").value = ""
  document.getElementById("devolucionCantidad").value = ""
  document.getElementById("devolucionMotivo").value = ""
}
