// ============================================
// GALENO - DASHBOARD
// ============================================

// Declare necessary variables or import them
const ProductManager = {} // Placeholder for ProductManager
const CONFIG = {} // Placeholder for CONFIG
const SalesManager = {} // Placeholder for SalesManager

function daysUntilExpiry(date) {
  // Placeholder for daysUntilExpiry function
  return 0
}

function formatDate(date) {
  // Placeholder for formatDate function
  return date
}

function formatDateTime(date) {
  // Placeholder for formatDateTime function
  return date
}

function formatCurrency(amount) {
  // Placeholder for formatCurrency function
  return amount
}

document.addEventListener("DOMContentLoaded", () => {
  actualizarDashboard()
  setInterval(actualizarDashboard, 10000) // Actualizar cada 10 segundos
})

function actualizarDashboard() {
  actualizarAlertas()
  actualizarEstadisticas()
  actualizarVentasRecientes()
}

function actualizarAlertas() {
  const alertasStockDiv = document.getElementById("alertasStock")
  const alertasVencimientoDiv = document.getElementById("alertasVencimiento")

  // Alertas de Stock Bajo
  const productosStockBajo = ProductManager.getLowStockProducts()

  if (productosStockBajo.length === 0) {
    alertasStockDiv.innerHTML = '<p class="empty-state">No hay alertas de stock</p>'
  } else {
    alertasStockDiv.innerHTML = productosStockBajo
      .map(
        (p) => `
            <div class="alert-item critical">
                <strong>📉 ${p.nombre}</strong>
                <small>Stock actual: ${p.stock} unidades (Umbral: ${CONFIG.STOCK_MIN_THRESHOLD})</small>
            </div>
        `,
      )
      .join("")
  }

  // Alertas de Vencimiento
  const productosVencimiento = ProductManager.getExpiringSoonProducts()

  if (productosVencimiento.length === 0) {
    alertasVencimientoDiv.innerHTML = '<p class="empty-state">No hay productos próximos a vencer</p>'
  } else {
    alertasVencimientoDiv.innerHTML = productosVencimiento
      .map((p) => {
        const dias = daysUntilExpiry(p.fechaCaducidad)
        return `
                <div class="alert-item ${dias <= 30 ? "critical" : ""}">
                    <strong>⏰ ${p.nombre}</strong>
                    <small>Vence en ${dias} días (${formatDate(p.fechaCaducidad)})</small>
                </div>
            `
      })
      .join("")
  }
}

function actualizarEstadisticas() {
  const productos = ProductManager.getAll()
  const productosStockBajo = ProductManager.getLowStockProducts()
  const productosVencimiento = ProductManager.getExpiringSoonProducts()

  const totalProductos = productos.length
  const totalStock = productos.reduce((sum, p) => sum + (p.stock || 0), 0)
  const productosCriticos = productosStockBajo.length
  const proximosVencer = productosVencimiento.length

  document.getElementById("totalProductos").textContent = totalProductos
  document.getElementById("totalStock").textContent = totalStock
  document.getElementById("productosCriticos").textContent = productosCriticos
  document.getElementById("proximosVencer").textContent = proximosVencer
}

function actualizarVentasRecientes() {
  const ventasDiv = document.getElementById("ventasRecientes")
  const ventas = SalesManager.getLastSales(5)

  if (ventas.length === 0) {
    ventasDiv.innerHTML = '<p class="empty-state">No hay ventas registradas</p>'
  } else {
    ventasDiv.innerHTML = ventas
      .map(
        (v) => `
            <div class="sale-item">
                <div class="sale-item-info">
                    <strong>${v.id}</strong>
                    <small>${formatDateTime(v.createdAt)}</small>
                </div>
                <div class="sale-item-amount">${formatCurrency(v.total)}</div>
            </div>
        `,
      )
      .join("")
  }
}
