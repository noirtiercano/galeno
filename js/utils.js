// ============================================
// GALENO - UTILIDADES COMPARTIDAS
// ============================================

// Configuración Global
const CONFIG = {
  STOCK_MIN_THRESHOLD: 10,
  EXPIRY_WARNING_DAYS: 60,
  STORAGE_KEYS: {
    PRODUCTS: "galeno_products",
    SALES: "galeno_sales",
    PROVIDERS: "galeno_providers",
    CUSTOMERS: "galeno_customers",
    RECEIPTS: "galeno_receipts",
    SETTINGS: "galeno_settings",
  },
}

// ============================================
// GESTIÓN DE LOCALSTORAGE
// ============================================

class StorageManager {
  static get(key, defaultValue = null) {
    try {
      const data = localStorage.getItem(key)
      return data ? JSON.parse(data) : defaultValue
    } catch (e) {
      console.error("Error reading from storage:", e)
      return defaultValue
    }
  }

  static set(key, value) {
    try {
      localStorage.setItem(key, JSON.stringify(value))
      return true
    } catch (e) {
      console.error("Error writing to storage:", e)
      return false
    }
  }

  static remove(key) {
    try {
      localStorage.removeItem(key)
      return true
    } catch (e) {
      console.error("Error removing from storage:", e)
      return false
    }
  }

  static clear() {
    try {
      localStorage.clear()
      return true
    } catch (e) {
      console.error("Error clearing storage:", e)
      return false
    }
  }
}

// ============================================
// GESTIÓN DE PRODUCTOS
// ============================================

class ProductManager {
  static getAll() {
    return StorageManager.get(CONFIG.STORAGE_KEYS.PRODUCTS, [])
  }

  static getById(id) {
    const products = this.getAll()
    return products.find((p) => p.id === id)
  }

  static add(product) {
    const products = this.getAll()
    product.id = Date.now().toString()
    product.createdAt = new Date().toISOString()
    product.updatedAt = new Date().toISOString()
    products.push(product)
    StorageManager.set(CONFIG.STORAGE_KEYS.PRODUCTS, products)
    return product
  }

  static update(id, updates) {
    const products = this.getAll()
    const index = products.findIndex((p) => p.id === id)
    if (index !== -1) {
      products[index] = {
        ...products[index],
        ...updates,
        updatedAt: new Date().toISOString(),
      }
      StorageManager.set(CONFIG.STORAGE_KEYS.PRODUCTS, products)
      return products[index]
    }
    return null
  }

  static delete(id) {
    const products = this.getAll()
    const filtered = products.filter((p) => p.id !== id)
    StorageManager.set(CONFIG.STORAGE_KEYS.PRODUCTS, filtered)
    return true
  }

  static decreaseStock(id, quantity) {
    const product = this.getById(id)
    if (product) {
      const newStock = Math.max(0, product.stock - quantity)
      return this.update(id, { stock: newStock })
    }
    return null
  }

  static increaseStock(id, quantity) {
    const product = this.getById(id)
    if (product) {
      const newStock = product.stock + quantity
      return this.update(id, { stock: newStock })
    }
    return null
  }

  static getLowStockProducts(threshold = CONFIG.STOCK_MIN_THRESHOLD) {
    return this.getAll().filter((p) => p.stock < threshold)
  }

  static getExpiringSoonProducts(daysWarning = CONFIG.EXPIRY_WARNING_DAYS) {
    const today = new Date()
    const warningDate = new Date(today.getTime() + daysWarning * 24 * 60 * 60 * 1000)

    return this.getAll().filter((p) => {
      if (!p.fechaCaducidad) return false
      const expireDate = new Date(p.fechaCaducidad)
      return expireDate <= warningDate && expireDate > today
    })
  }

  static getExpiredProducts() {
    const today = new Date()
    return this.getAll().filter((p) => {
      if (!p.fechaCaducidad) return false
      return new Date(p.fechaCaducidad) < today
    })
  }
}

// ============================================
// GESTIÓN DE VENTAS
// ============================================

class SalesManager {
  static getAll() {
    return StorageManager.get(CONFIG.STORAGE_KEYS.SALES, [])
  }

  static add(sale) {
    const sales = this.getAll()
    sale.id = Date.now().toString()
    sale.createdAt = new Date().toISOString()
    sales.push(sale)
    StorageManager.set(CONFIG.STORAGE_KEYS.SALES, sales)
    return sale
  }

  static getByDateRange(startDate, endDate) {
    const sales = this.getAll()
    return sales.filter((s) => {
      const saleDate = new Date(s.createdAt)
      return saleDate >= startDate && saleDate <= endDate
    })
  }

  static getTotalSales(startDate = null, endDate = null) {
    let sales = this.getAll()
    if (startDate && endDate) {
      sales = this.getByDateRange(startDate, endDate)
    }
    return sales.reduce((total, s) => total + (s.total || 0), 0)
  }

  static getLastSales(limit = 5) {
    return this.getAll().slice(-limit).reverse()
  }
}

// ============================================
// GESTIÓN DE CLIENTES
// ============================================

class CustomerManager {
  static getAll() {
    return StorageManager.get(CONFIG.STORAGE_KEYS.CUSTOMERS, [])
  }

  static getById(id) {
    const customers = this.getAll()
    return customers.find((c) => c.id === id)
  }

  static add(customer) {
    const customers = this.getAll()
    customer.id = Date.now().toString()
    customer.createdAt = new Date().toISOString()
    customer.purchaseHistory = []
    customers.push(customer)
    StorageManager.set(CONFIG.STORAGE_KEYS.CUSTOMERS, customers)
    return customer
  }

  static update(id, updates) {
    const customers = this.getAll()
    const index = customers.findIndex((c) => c.id === id)
    if (index !== -1) {
      customers[index] = {
        ...customers[index],
        ...updates,
        updatedAt: new Date().toISOString(),
      }
      StorageManager.set(CONFIG.STORAGE_KEYS.CUSTOMERS, customers)
      return customers[index]
    }
    return null
  }

  static delete(id) {
    const customers = this.getAll()
    const filtered = customers.filter((c) => c.id !== id)
    StorageManager.set(CONFIG.STORAGE_KEYS.CUSTOMERS, filtered)
    return true
  }

  static addPurchase(customerId, purchase) {
    const customer = this.getById(customerId)
    if (customer) {
      if (!customer.purchaseHistory) {
        customer.purchaseHistory = []
      }
      customer.purchaseHistory.push({
        ...purchase,
        date: new Date().toISOString(),
      })
      return this.update(customerId, customer)
    }
    return null
  }
}

// ============================================
// GESTIÓN DE PROVEEDORES
// ============================================

class ProviderManager {
  static getAll() {
    return StorageManager.get(CONFIG.STORAGE_KEYS.PROVIDERS, [])
  }

  static getById(id) {
    const providers = this.getAll()
    return providers.find((p) => p.id === id)
  }

  static add(provider) {
    const providers = this.getAll()
    provider.id = Date.now().toString()
    provider.createdAt = new Date().toISOString()
    provider.orders = []
    providers.push(provider)
    StorageManager.set(CONFIG.STORAGE_KEYS.PROVIDERS, providers)
    return provider
  }

  static update(id, updates) {
    const providers = this.getAll()
    const index = providers.findIndex((p) => p.id === id)
    if (index !== -1) {
      providers[index] = {
        ...providers[index],
        ...updates,
        updatedAt: new Date().toISOString(),
      }
      StorageManager.set(CONFIG.STORAGE_KEYS.PROVIDERS, providers)
      return providers[index]
    }
    return null
  }

  static delete(id) {
    const providers = this.getAll()
    const filtered = providers.filter((p) => p.id !== id)
    StorageManager.set(CONFIG.STORAGE_KEYS.PROVIDERS, filtered)
    return true
  }

  static addOrder(providerId, order) {
    const provider = this.getById(providerId)
    if (provider) {
      if (!provider.orders) {
        provider.orders = []
      }
      order.id = Date.now().toString()
      order.createdAt = new Date().toISOString()
      order.status = "pendiente"
      provider.orders.push(order)
      return this.update(providerId, provider)
    }
    return null
  }
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

function formatCurrency(amount) {
  return new Intl.NumberFormat("es-ES", {
    style: "currency",
    currency: "EUR",
  }).format(amount)
}

function formatDate(dateString) {
  const options = { year: "numeric", month: "2-digit", day: "2-digit" }
  return new Date(dateString).toLocaleDateString("es-ES", options)
}

function formatDateTime(dateString) {
  const options = {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
  }
  return new Date(dateString).toLocaleDateString("es-ES", options)
}

function daysUntilExpiry(expiryDate) {
  const today = new Date()
  const expiry = new Date(expiryDate)
  const diff = expiry - today
  return Math.ceil(diff / (1000 * 60 * 60 * 24))
}

function generateInvoiceNumber() {
  return "FAC-" + Date.now()
}

function calculateIVA(amount, rate = 0.21) {
  return amount * rate
}

function calculateTotal(subtotal, iva = null) {
  const ivaAmount = iva !== null ? iva : calculateIVA(subtotal)
  return subtotal + ivaAmount
}

function showAlert(message, type = "info", duration = 3000) {
  const alertDiv = document.createElement("div")
  alertDiv.className = `alert alert-${type}`
  alertDiv.innerHTML = `
        ${message}
        <span class="alert-close" onclick="this.parentElement.remove()">&times;</span>
    `
  document.body.appendChild(alertDiv)

  if (duration) {
    setTimeout(() => alertDiv.remove(), duration)
  }
}

function showModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.add("active")
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.remove("active")
  }
}

function updateDateTime() {
  const now = new Date()
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  }
  const formatted = now.toLocaleDateString("es-ES", options)
  const dateTimeElement = document.getElementById("dateTime")
  if (dateTimeElement) {
    dateTimeElement.textContent = formatted
  }
}

function confirmarCierre() {
  if (confirm("¿Está seguro de que desea cerrar sesión?")) {
    window.location.href = "index.html"
  }
}

// Actualizar hora cada segundo
setInterval(updateDateTime, 1000)
updateDateTime()
