class CartManager {
  constructor() {
    this.CART_API_URL = 'include/add_to_cart.php'
    this.CART_COUNT_URL = 'include/get_cart_count.php'
    this.init()
  }

  async init() {
    this.setupEventDelegation()
    await this.updateCartCount()
  }

  setupEventDelegation() {
    document.addEventListener('click', async (e) => {
      if (
        e.target.classList.contains('add-to-cart') ||
        e.target.closest('.add-to-cart')
      ) {
        e.preventDefault()
        const button = e.target.classList.contains('add-to-cart')
          ? e.target
          : e.target.closest('.add-to-cart')
        await this.handleAddToCart(button)
      }
    })
  }

  async handleAddToCart(button) {
    const productId = button.dataset.id
    const originalText = button.innerHTML
    const originalClass = button.className

    try {
      // Feedback visual imediato
      button.disabled = true
      button.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...'

      const response = await this.addToCart(productId)

      if (response.success) {
        await this.updateCartCount()
        this.showSuccessFeedback(button, originalText, originalClass)
      } else {
        this.showError(response.message || 'Failed to add to cart')
        button.innerHTML = originalText
        button.className = originalClass
      }
    } catch (error) {
      console.error('Cart Error:', error)
      this.showError('Network error, please try again')
      button.innerHTML = originalText
      button.className = originalClass
    } finally {
      button.disabled = false
    }
  }

  async addToCart(productId) {
    const formData = new FormData()
    formData.append('product_id', productId)

    const response = await fetch(this.CART_API_URL, {
      method: 'POST',
      body: formData,
    })

    if (!response.ok) {
      const errorData = await response.json().catch(() => null)
      throw new Error(errorData?.message || 'Network response was not ok')
    }

    return await response.json()
  }

  async updateCartCount() {
    try {
      const response = await fetch(this.CART_COUNT_URL)
      if (!response.ok) {
        throw new Error('Failed to fetch cart count')
      }
      const data = await response.json()
      this.updateCartUI(data.count || 0)
      return data
    } catch (error) {
      console.error('Failed to update cart count:', error)
      this.updateCartUI(0)
      return { success: false, count: 0 }
    }
  }

  updateCartUI(count) {
    const cartCounter = document.getElementById('cart-count')
    if (cartCounter) {
      cartCounter.textContent = count
      cartCounter.style.display = count > 0 ? 'inline-block' : 'none'
    }
  }

  showSuccessFeedback(button, originalText, originalClass) {
    button.innerHTML = '<i class="fa fa-check"></i> Added'
    button.className = originalClass.replace(
      'btn-outline-danger',
      'btn-success'
    )

    setTimeout(() => {
      button.innerHTML = originalText
      button.className = originalClass
    }, 1000)
  }

  showError(message) {
    // Implemente um sistema de notificação mais sofisticado se necessário
    const errorElement =
      document.getElementById('cart-error-message') || this.createErrorElement()
    errorElement.textContent = message
    errorElement.style.display = 'block'

    setTimeout(() => {
      errorElement.style.display = 'none'
    }, 5000)
  }

  createErrorElement() {
    const div = document.createElement('div')
    div.id = 'cart-error-message'
    div.style.position = 'fixed'
    div.style.bottom = '20px'
    div.style.right = '20px'
    div.style.padding = '15px'
    div.style.backgroundColor = '#dc3545'
    div.style.color = 'white'
    div.style.borderRadius = '5px'
    div.style.display = 'none'
    div.style.zIndex = '1000'
    document.body.appendChild(div)
    return div
  }
}

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  if (typeof CartManager !== 'undefined') {
    try {
      new CartManager()
    } catch (e) {
      console.error('Failed to initialize CartManager:', e)
    }
  }
})
