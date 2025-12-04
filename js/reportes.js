// ============================================
// GALENO - MÓDULO DE REPORTES
// ============================================

// Declare necessary variables and managers
const SalesManager = {
  getByDateRange: (inicio, fin) => {
    // Mock implementation for demonstration purposes
    return [
      {
        createdAt: new Date(),
        items: [{ nombre: "Producto 1", quantity: 2, precio: 10 }],
        total: 20,
        iva: 2,
        discount: 1,
      },
      {
        createdAt: new Date(),
        items: [{ nombre: "Producto 2", quantity: 1, precio: 15 }],
        total: 15,
        iva: 1.5,
        discount: 0,
      },
    ]
  },
}

const ProductManager = {
  getAll: () => {
    // Mock implementation for demonstration purposes
    return [
      {
        nombre: "Producto A",
        codigo: "A123",
        stock: 50,
        precio: 10,
        fechaCaducidad: new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000),
      },
      {
        nombre: "Producto B",
        codigo: "B456",
        stock: 10,
        precio: 20,
        fechaCaducidad: new Date(new Date().getTime() + 20 * 24 * 60 * 60 * 1000),
      },
    ]
  },
  getLowStockProducts: () => {
    // Mock implementation for demonstration purposes
    return []
  },
  getExpiringSoonProducts: () => {
    // Mock implementation for demonstration purposes
    return []
  },
  getExpiredProducts: () => {
    // Mock implementation for demonstration purposes
    return []
  },
}

const CustomerManager = {
  getAll: () => {
    // Mock implementation for demonstration purposes
    return [
      { nombre: "Cliente 1", purchaseHistory: [{ total: 100 }] },
      { nombre: "Cliente 2", purchaseHistory: [{ total: 200 }] },
    ]
  },
}

const CONFIG = {
  STOCK_MIN_THRESHOLD: 20,
  EXPIRY_WARNING_DAYS: 10,
}

function formatCurrency(value) {
  return new Intl.NumberFormat("es-ES", { style: "currency", currency: "EUR" }).format(value)
}

function formatDateTime(date) {
  return date.toLocaleString("es-ES")
}

function formatDate(date) {
  return new Date(date).toLocaleDateString("es-ES")
}

function daysUntilExpiry(expiryDate) {
  const today = new Date()
  const expiry = new Date(expiryDate)
  const timeDifference = expiry.getTime() - today.getTime()
  const daysDifference = timeDifference / (1000 * 3600 * 24)
  return Math.floor(daysDifference)
}

document.addEventListener("DOMContentLoaded", () => {
  const hoy = new Date()
  const hace30Dias = new Date(hoy.getTime() - 30 * 24 * 60 * 60 * 1000)

  document.getElementById("fechaInicio").valueAsDate = hace30Dias
  document.getElementById("fechaFin").valueAsDate = hoy

  generarReporte()
})

function generarReporte() {
  const tipo = document.getElementById("reporteType").value
  const fechaInicio = new Date(document.getElementById("fechaInicio").value)
  const fechaFin = new Date(document.getElementById("fechaFin").value)

  let contenido = ""

  switch (tipo) {
    case "ventas":
      contenido = generarReporteVentas(fechaInicio, fechaFin)
      break
    case "inventario":
      contenido = generarReporteInventario()
      break
    case "clientes":
      contenido = generarReporteClientes()
      break
    case "productos-vendidos":
      contenido = generarReporteProductos(fechaInicio, fechaFin)
      break
  }

  document.getElementById("reporteContent").innerHTML = contenido
}

function generarReporteVentas(inicio, fin) {
  const ventas = SalesManager.getByDateRange(inicio, fin)
  const totalVentas = ventas.reduce((sum, v) => sum + (v.total || 0), 0)
  const totalIVA = ventas.reduce((sum, v) => sum + (v.iva || 0), 0)
  const totalDescuentos = ventas.reduce((sum, v) => sum + (v.discount || 0), 0)

  let html = `
    <div class="dashboard-card" style="margin-bottom: 2rem">
      <h3>Reporte de Ventas</h3>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-label">Total Ventas</span>
          <span class="stat-value" style="color: var(--color-success)">${formatCurrency(totalVentas)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Número de Transacciones</span>
          <span class="stat-value">${ventas.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">IVA Total</span>
          <span class="stat-value">${formatCurrency(totalIVA)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Descuentos Aplicados</span>
          <span class="stat-value">${formatCurrency(totalDescuentos)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Ticket Promedio</span>
          <span class="stat-value">${formatCurrency(ventas.length > 0 ? totalVentas / ventas.length : 0)}</span>
        </div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Subtotal</th>
            <th>Descuento</th>
            <th>IVA</th>
            <th>Total</th>
            <th>Método Pago</th>
          </tr>
        </thead>
        <tbody>
  `

  ventas.forEach((venta) => {
    const fecha = formatDateTime(venta.createdAt)
    const numProductos = venta.items.length
    const metodo =
      {
        cash: "Efectivo",
        card: "Tarjeta",
        check: "Cheque",
        transfer: "Transferencia",
      }[venta.paymentMethod] || venta.paymentMethod

    html += `
      <tr>
        <td>${fecha}</td>
        <td>${numProductos}</td>
        <td>${formatCurrency(venta.subtotal)}</td>
        <td>${formatCurrency(venta.discount)}</td>
        <td>${formatCurrency(venta.iva)}</td>
        <td><strong>${formatCurrency(venta.total)}</strong></td>
        <td>${metodo}</td>
      </tr>
    `
  })

  html += `
        </tbody>
      </table>
    </div>
  `

  return html
}

function generarReporteInventario() {
  const productos = ProductManager.getAll()
  const lowStock = ProductManager.getLowStockProducts()
  const expiringSoon = ProductManager.getExpiringSoonProducts()
  const expired = ProductManager.getExpiredProducts()

  const totalValor = productos.reduce((sum, p) => sum + p.precio * p.stock, 0)

  let html = `
    <div class="dashboard-card" style="margin-bottom: 2rem">
      <h3>Reporte de Inventario</h3>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-label">Total Productos</span>
          <span class="stat-value">${productos.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Valor Total Inventario</span>
          <span class="stat-value" style="color: var(--color-primary)">${formatCurrency(totalValor)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Stock Bajo</span>
          <span class="stat-value critical">${lowStock.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Próximos a Vencer</span>
          <span class="stat-value warning">${expiringSoon.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Vencidos</span>
          <span class="stat-value critical">${expired.length}</span>
        </div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Código</th>
            <th>Stock</th>
            <th>Precio Unit.</th>
            <th>Valor Total</th>
            <th>Lote</th>
            <th>Caducidad</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
  `

  productos.forEach((p) => {
    const valorTotal = p.precio * p.stock
    const caducidad = formatDate(p.fechaCaducidad || "")
    const diasVencimiento = p.fechaCaducidad ? daysUntilExpiry(p.fechaCaducidad) : null

    let estado = '<span class="badge badge-success">OK</span>'
    if (p.stock < CONFIG.STOCK_MIN_THRESHOLD) {
      estado = '<span class="badge badge-danger">STOCK BAJO</span>'
    }
    if (diasVencimiento !== null && diasVencimiento < CONFIG.EXPIRY_WARNING_DAYS && diasVencimiento > 0) {
      estado = '<span class="badge badge-warning">PRÓXIMO A VENCER</span>'
    }
    if (diasVencimiento !== null && diasVencimiento <= 0) {
      estado = '<span class="badge badge-danger">VENCIDO</span>'
    }

    html += `
      <tr>
        <td><strong>${p.nombre}</strong></td>
        <td>${p.codigo}</td>
        <td>${p.stock}</td>
        <td>${formatCurrency(p.precio)}</td>
        <td>${formatCurrency(valorTotal)}</td>
        <td>${p.lote}</td>
        <td>${caducidad}</td>
        <td>${estado}</td>
      </tr>
    `
  })

  html += `
        </tbody>
      </table>
    </div>
  `

  return html
}

function generarReporteClientes() {
  const clientes = CustomerManager.getAll()

  // Calcular total gastado por cliente
  const clientesConGasto = clientes.map((c) => {
    const totalGastado = c.purchaseHistory ? c.purchaseHistory.reduce((sum, p) => sum + (p.total || 0), 0) : 0
    return {
      ...c,
      totalGastado,
      numeroCompras: c.purchaseHistory ? c.purchaseHistory.length : 0,
    }
  })

  // Ordenar por gasto descendente
  clientesConGasto.sort((a, b) => b.totalGastado - a.totalGastado)

  const top10 = clientesConGasto.slice(0, 10)
  const totalClientele = clientesConGasto.reduce((sum, c) => sum + c.totalGastado, 0)

  let html = `
    <div class="dashboard-card" style="margin-bottom: 2rem">
      <h3>Reporte de Clientes Top 10</h3>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-label">Total Clientes</span>
          <span class="stat-value">${clientes.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Ingresos por Clientes</span>
          <span class="stat-value" style="color: var(--color-success)">${formatCurrency(totalClientele)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Gasto Promedio por Cliente</span>
          <span class="stat-value">${formatCurrency(clientes.length > 0 ? totalClientele / clientes.length : 0)}</span>
        </div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Posición</th>
            <th>Cliente</th>
            <th>Número Compras</th>
            <th>Total Gastado</th>
            <th>Descuento</th>
          </tr>
        </thead>
        <tbody>
  `

  top10.forEach((cliente, index) => {
    html += `
      <tr>
        <td><strong>#${index + 1}</strong></td>
        <td>${cliente.nombre}</td>
        <td>${cliente.numeroCompras}</td>
        <td>${formatCurrency(cliente.totalGastado)}</td>
        <td>${cliente.descuento || 0}%</td>
      </tr>
    `
  })

  html += `
        </tbody>
      </table>
    </div>
  `

  return html
}

function generarReporteProductos(inicio, fin) {
  const ventas = SalesManager.getByDateRange(inicio, fin)

  // Contar productos vendidos
  const productosVendidos = {}
  ventas.forEach((venta) => {
    venta.items.forEach((item) => {
      if (!productosVendidos[item.id]) {
        productosVendidos[item.id] = {
          nombre: item.nombre,
          codigo: item.codigo,
          cantidadVendida: 0,
          ingresoTotal: 0,
        }
      }
      productosVendidos[item.id].cantidadVendida += item.quantity
      productosVendidos[item.id].ingresoTotal += item.precio * item.quantity
    })
  })

  // Convertir a array y ordenar
  const productos = Object.values(productosVendidos).sort((a, b) => b.cantidadVendida - a.cantidadVendida)

  let html = `
    <div class="dashboard-card" style="margin-bottom: 2rem">
      <h3>Productos Más Vendidos</h3>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-label">Productos Únicos Vendidos</span>
          <span class="stat-value">${productos.length}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Unidades Totales</span>
          <span class="stat-value">${productos.reduce((sum, p) => sum + p.cantidadVendida, 0)}</span>
        </div>
        <div class="stat-item">
          <span class="stat-label">Ingreso Total</span>
          <span class="stat-value" style="color: var(--color-success)">${formatCurrency(productos.reduce((sum, p) => sum + p.ingresoTotal, 0))}</span>
        </div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Ranking</th>
            <th>Producto</th>
            <th>Código</th>
            <th>Cantidad Vendida</th>
            <th>Ingreso Total</th>
            <th>Ingreso Promedio por Unidad</th>
          </tr>
        </thead>
        <tbody>
  `

  productos.forEach((producto, index) => {
    const precioPromedio = producto.cantidadVendida > 0 ? producto.ingresoTotal / producto.cantidadVendida : 0

    html += `
      <tr>
        <td><strong>#${index + 1}</strong></td>
        <td>${producto.nombre}</td>
        <td>${producto.codigo}</td>
        <td>${producto.cantidadVendida}</td>
        <td><strong>${formatCurrency(producto.ingresoTotal)}</strong></td>
        <td>${formatCurrency(precioPromedio)}</td>
      </tr>
    `
  })

  html += `
        </tbody>
      </table>
    </div>
  `

  return html
}

function cambiarReporte() {
  generarReporte()
}

function exportarPDF() {
  alert("Función de exportación a PDF disponible en versión premium. Se abre nueva ventana con contenido imprimible.")
  const reporteContent = document.getElementById("reporteContent").innerHTML
  const printWindow = window.open("", "_blank")
  printWindow.document.write(`
    <html>
      <head>
        <title>Reporte GALENO</title>
        <link rel="stylesheet" href="css/style.css">
        <style>
          body { margin: 2rem; }
          table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
          th, td { padding: 0.5rem; text-align: left; border: 1px solid #ddd; }
          th { background-color: #f0f0f0; }
          .stat-value { font-weight: 700; }
        </style>
      </head>
      <body>
        <h1>GALENO - Reporte</h1>
        <p>Generado: ${new Date().toLocaleString("es-ES")}</p>
        ${reporteContent}
      </body>
    </html>
  `)
  printWindow.document.close()
  printWindow.print()
}
