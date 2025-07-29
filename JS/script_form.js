document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('registerForm')
  const successBox = document.getElementById('successMessage')
  const emailInput = document.getElementById('inputEmail')
  const unsubscribeBtn = document.getElementById('unsubscribeBtn')

  // Verificar se os elementos existem
  if (!form || !successBox || !emailInput || !unsubscribeBtn) return

  // Submissão do formulário de registo
  form.addEventListener('submit', async function (e) {
    e.preventDefault()

    const submitBtn = form.querySelector('button[type="submit"]')
    submitBtn.disabled = true
    submitBtn.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'

    try {
      const formData = new FormData(form)
      const response = await fetch('include/process_register.php', {
        method: 'POST',
        body: formData,
      })

      // Verifique se a resposta é JSON
      const contentType = response.headers.get('content-type')
      if (!contentType || !contentType.includes('application/json')) {
        const text = await response.text()
        throw new Error(`Invalid response: ${text.substring(0, 100)}...`)
      }

      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || 'Server error')
      }

      if (data.success) {
        document.getElementById('successMessage').classList.remove('d-none')
        if (data.redirect) {
          setTimeout(() => {
            window.location.href = data.redirect
          }, 2000)
        }
      } else {
        alert(data.message || 'Registration failed')
      }
    } catch (error) {
      console.error('Error:', error)
      alert(`Error: ${error.message}`)
    } finally {
      submitBtn.disabled = false
      submitBtn.innerHTML = 'Register'
    }
  })

  // Mostrar ou esconder botão "Unsubscribe" consoante o email
  emailInput.addEventListener('input', () => {
    unsubscribeBtn.style.display = emailInput.value.trim()
      ? 'inline-block'
      : 'none'
  })

  // Ação ao clicar no botão "Unsubscribe"
  unsubscribeBtn.addEventListener('click', function () {
    const email = emailInput.value.trim()

    if (!email) {
      alert('Please enter your email to unsubscribe.')
      return
    }

    const confirmed = confirm(
      'Are you sure you want to delete your registration? This action is irreversible!'
    )
    if (!confirmed) return

    fetch('include/unsubscribe.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `email=${encodeURIComponent(email)}`,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          alert('Your account has been successfully unsubscribed.')
          form.reset()
          unsubscribeBtn.style.display = 'none'
        } else {
          alert('Error: ' + data.message)
        }
      })
      .catch((err) => {
        console.error('Erro:', err)
        alert('Unexpected error while unsubscribing.')
      })
  })
})
