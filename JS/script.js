// === CONSTANTES E VARIÁVEIS GLOBAIS ===
const SCROLL_TOP_BEHAVIOR = 'smooth'
const CAROUSEL_INTERVAL = 3000
const COUNTDOWN_UPDATE_INTERVAL = 1000

// Dados
const screamSound = new Audio('Audio/growl.mp3')
let products = []
let carouselInterval

// === FUNÇÕES UTILITÁRIAS ===
function debounce(func, wait) {
  let timeout
  return function () {
    clearTimeout(timeout)
    timeout = setTimeout(func, wait)
  }
}

function formatPrice(price) {
  return parseFloat(price).toFixed(2)
}

// === 1. BOTÃO VOLTAR AO TOPO ===
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: SCROLL_TOP_BEHAVIOR,
  })
}

// === 2. CARROSSEL DE MEMBROS ===
function initCarousel() {
  const carousel = document.getElementById('membrosCarousel')
  const nextBtn = document.getElementById('next')
  const prevBtn = document.getElementById('prev')

  if (!carousel || !nextBtn || !prevBtn) {
    console.warn(
      'Elementos do carrossel não encontrados. Funcionalidade desativada.'
    )
    return false
  }

  function scrollNext() {
    const first = carousel.firstElementChild
    if (first) carousel.appendChild(first)
  }

  function scrollPrev() {
    const last = carousel.lastElementChild
    if (last) carousel.insertBefore(last, carousel.firstElementChild)
  }

  nextBtn.addEventListener('click', scrollNext)
  prevBtn.addEventListener('click', scrollPrev)

  // Pausar ao passar o mouse
  carousel.addEventListener('mouseenter', () => clearInterval(carouselInterval))
  carousel.addEventListener('mouseleave', () => {
    carouselInterval = setInterval(scrollNext, CAROUSEL_INTERVAL)
  })

  // Iniciar intervalo
  carouselInterval = setInterval(scrollNext, CAROUSEL_INTERVAL)
  return true
}

// === 3. FORMULÁRIO DE CONTACTO ===
function initContactForm() {
  const contactForm = document.getElementById('contactForm')
  const successMessage = document.getElementById('successMessage')

  if (!contactForm || !successMessage) {
    console.warn(
      'Elementos do formulário não encontrados. Funcionalidade desativada.'
    )
    return false
  }

  contactForm.addEventListener('submit', function (e) {
    e.preventDefault()

    if (!this.checkValidity()) {
      this.classList.add('was-validated')
      return
    }

    successMessage.classList.remove('d-none')
    successMessage.scrollIntoView({ behavior: SCROLL_TOP_BEHAVIOR })

    this.reset()
    this.classList.remove('was-validated')
  })

  return true
}

// === 4. LOJA / CATÁLOGO ===
function renderProducts(filteredProducts) {
  const productList = document.getElementById('product-list')
  if (!productList) {
    console.error('Elemento product-list não encontrado.')
    return
  }

  productList.innerHTML = ''

  filteredProducts.forEach((product) => {
    const col = document.createElement('div')
    col.className = 'col'

    col.innerHTML = `
      <div class="card h-100">
        <img src="${product.image}" class="card-img-top" alt="${
      product.name
    }" loading="lazy">
        <div class="card-body">
          <h5 class="card-title">${product.name}</h5>
          <p class="card-text">${product.description}</p>
          <p class="card-text"><strong>€${formatPrice(
            product.price
          )}</strong></p>
          <button class="btn btn-outline-danger btn-details" data-id="${
            product.id
          }">SEE DETAILS</button>
          <button class="btn btn-outline-danger add-to-cart" data-id="${
            product.id
          }">Add to Cart</button>
        </div>
      </div>
    `
    productList.appendChild(col)
  })

  // Adicionar eventos aos botões de detalhes
  document.querySelectorAll('.btn-details').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      const productId = e.target.dataset.id
      const product = products.find((p) => p.id === productId)
      if (product) openLightbox(product)
    })
  })
}

function openLightbox(product) {
  const lightbox = document.getElementById('lightbox')
  const lightboxTitle = document.getElementById('lightbox-title')
  const lightboxImage = document.getElementById('lightbox-image')
  const lightboxDescription = document.getElementById('lightbox-description')
  const lightboxPrice = document.getElementById('lightbox-price')

  if (
    !lightbox ||
    !lightboxTitle ||
    !lightboxImage ||
    !lightboxDescription ||
    !lightboxPrice
  ) {
    console.error('Elementos do lightbox não encontrados.')
    return
  }

  lightboxTitle.textContent = product.name
  lightboxImage.src = product.image
  lightboxDescription.textContent = product.description
  lightboxPrice.textContent = `Price: €${formatPrice(product.price)}`
  lightbox.style.display = 'flex'
}

function initLightbox() {
  const lightbox = document.getElementById('lightbox')
  const closeBtn = document.querySelector('.close-btn')

  if (!lightbox || !closeBtn) {
    console.warn(
      'Elementos do lightbox não encontrados. Funcionalidade desativada.'
    )
    return false
  }

  closeBtn.addEventListener('click', () => {
    lightbox.style.display = 'none'
  })

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      lightbox.style.display = 'none'
    }
  })

  return true
}

function initProductCalculator() {
  const productSelect = document.getElementById('product')
  const quantityInput = document.getElementById('quantity')
  const calculateBtn = document.getElementById('calculate')
  const totalValue = document.getElementById('total-value')

  if (!productSelect || !quantityInput || !calculateBtn || !totalValue) {
    console.warn(
      'Elementos da calculadora não encontrados. Funcionalidade desativada.'
    )
    return false
  }

  calculateBtn.addEventListener('click', () => {
    const selectedId = productSelect.value
    const quantity = parseInt(quantityInput.value)

    if (!selectedId) {
      alert('Por favor, selecione um produto.')
      return
    }

    if (isNaN(quantity) || quantity <= 0) {
      alert('Por favor, insira uma quantidade válida.')
      return
    }

    const product = products.find((p) => p.id === selectedId)
    if (product) {
      const total = (parseFloat(product.price) * quantity).toFixed(2)
      totalValue.textContent = `Total: €${total}`
      totalValue.classList.remove('d-none')
    } else {
      alert('Produto não encontrado.')
    }
  })

  return true
}

async function fetchCatalog() {
  try {
    const response = await fetch('catalog.json')
    if (!response.ok) throw new Error('Error loading catalog.')

    const data = await response.json()
    products = data.products

    // Preencher filtro de categoria
    const categoryFilter = document.getElementById('category-filter')
    if (categoryFilter) {
      data.categories.forEach((cat) => {
        const option = document.createElement('option')
        option.value = cat.id
        option.textContent = cat.name
        categoryFilter.appendChild(option)
      })

      categoryFilter.addEventListener('change', () => {
        const selected = categoryFilter.value
        const filtered = selected
          ? products.filter((p) => p.category === selected)
          : products
        renderProducts(filtered)
      })
    }

    // Preencher select de produtos
    const productSelect = document.getElementById('product')
    if (productSelect) {
      products.forEach((product) => {
        const option = document.createElement('option')
        option.value = product.id
        option.textContent = product.name
        productSelect.appendChild(option)
      })
    }

    renderProducts(products)
  } catch (error) {
    console.error('Erro ao carregar produtos:', error)
    const productList = document.getElementById('product-list')
    if (productList) {
      productList.innerHTML =
        '<p>Error loading the products. Please try again later.</p>'
    }
  }
}

// === 5. CONCERTOS / TOURS ===
function updateCountdowns() {
  const countdowns = document.querySelectorAll('.countdown')
  const now = new Date()

  countdowns.forEach((el) => {
    const targetDate = new Date(el.dataset.date)
    const diff = targetDate - now

    if (diff <= 0) {
      el.textContent = 'Live Now!'
      el.classList.add('text-danger', 'fw-bold')
      return
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24))
    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24)
    const minutes = Math.floor((diff / (1000 * 60)) % 60)
    const seconds = Math.floor((diff / 1000) % 60)

    el.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`
  })
}

async function fetchConcerts() {
  try {
    const response = await fetch('concerts.json')
    if (!response.ok) throw new Error('Error loading concerts.')

    const concerts = await response.json()
    const timelineContainer = document.querySelector('.timeline-container')

    if (!timelineContainer) {
      console.error('Container de concertos não encontrado.')
      return
    }

    timelineContainer.innerHTML = ''
    concerts.sort((a, b) => new Date(a.date) - new Date(b.date))

    concerts.forEach((con) => {
      const eventElement = document.createElement('div')
      eventElement.className = 'timeline-event fade-in'

      const eventDate = new Date(con.date)
      const options = {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      }

      eventElement.innerHTML = `
        <div class="timeline-icon"><i class="fa fa-microphone"></i></div>
        <div class="timeline-content">
          <h4 class="text-danger">${con.location} - ${con.event}</h4>
          <p><strong>Date:</strong> ${eventDate.toLocaleString(
            'pt-PT',
            options
          )}</p>
          <p><em>Venue:</em> ${con.venue}</p>
          <p><strong>Time left:</strong> <span class="countdown" data-date="${
            con.date
          }"></span></p>
          <div class="text-end">
            <a href="https://www.songkick.com/artists/453708-suicide-silence" 
               class="btn btn-outline-danger getticket scream-button" 
               target="_blank">GET TICKET</a>
          </div>
        </div>
      `
      timelineContainer.appendChild(eventElement)
    })

    updateCountdowns()
    initScreamButtons()
  } catch (error) {
    console.error('Erro ao carregar concertos:', error)
  }
}

function initScreamButtons() {
  document.querySelectorAll('.scream-button').forEach((btn) => {
    btn.addEventListener('click', () => {
      screamSound.currentTime = 0
      screamSound
        .play()
        .catch((err) => console.warn('Erro ao reproduzir som:', err))
    })
  })
}

// === 6. BIOGRAFIA DOS MEMBROS ===
function initMemberCards() {
  const cards = document.querySelectorAll('.member-card')
  if (!cards.length) {
    console.warn('Cartões de membros não encontrados.')
    return false
  }

  cards.forEach((card) => {
    card.addEventListener('click', () => {
      card.classList.toggle('active')
      screamSound.currentTime = 0
      screamSound
        .play()
        .catch((err) => console.warn('Erro ao reproduzir som:', err))
    })
  })

  return true
}

// === 7. POPOVER PERSONALIZADO ===
function initPopovers() {
  const popoverElements = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
  )
  if (!popoverElements.length) {
    console.warn('Elementos de popover não encontrados.')
    return false
  }

  popoverElements.forEach((el) => {
    const imgSrc = el.getAttribute('data-bs-img')
    const content = `
      <div class="popover-custom-content">
        <img src="${imgSrc}" alt="Membro" class="popover-image" loading="lazy">
        <p>Founding vocalist of Suicide Silence. His legacy lives on.</p>
      </div>
    `

    new bootstrap.Popover(el, {
      html: true,
      content: content,
      trigger: 'hover',
      placement: 'top',
      customClass: 'popover-mitch',
    })
  })

  return true
}

// === INICIALIZAÇÃO PRINCIPAL ===
document.addEventListener('DOMContentLoaded', () => {
  // Inicializar módulos
  initCarousel()
  initContactForm()
  initLightbox()
  initProductCalculator()
  initMemberCards()
  initPopovers()

  // Carregar dados
  fetchCatalog()
  fetchConcerts()

  // Atualizar countdowns a cada segundo
  setInterval(updateCountdowns, COUNTDOWN_UPDATE_INTERVAL)
})

// Função global para o botão "Voltar ao Topo"
window.scrollToTop = scrollToTop
