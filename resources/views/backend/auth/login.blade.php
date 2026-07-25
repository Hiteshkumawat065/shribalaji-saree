<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign in — SareeInfo</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --font-sans: "Poppins", ui-sans-serif, system-ui, sans-serif;
  --font-display: "Playfair Display", ui-serif, Georgia, serif;
  --font-accent: "Cormorant Garamond", ui-serif, Georgia, serif;

  --wine: oklch(0.38 0.13 18);
  --wine-deep: oklch(0.27 0.11 20);
  --gold: oklch(0.78 0.13 85);
  --gold-soft: oklch(0.88 0.07 85);
  --blush: oklch(0.92 0.04 15);
  --cream: oklch(0.975 0.015 80);
  --charcoal: oklch(0.22 0.01 60);

  --background: oklch(0.995 0.005 80);
  --foreground: oklch(0.22 0.02 30);
  --muted-foreground: oklch(0.45 0.02 30);
  --border: oklch(0.9 0.015 60);

  --gradient-wine: linear-gradient(135deg, oklch(0.32 0.13 18) 0%, oklch(0.42 0.14 20) 50%, oklch(0.28 0.11 22) 100%);
  --shadow-luxe: 0 20px 60px -20px oklch(0.38 0.13 18 / 0.35);
  --shadow-gold: 0 8px 30px -10px oklch(0.78 0.13 85 / 0.5);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  font-family: var(--font-sans);
  background: var(--background);
  color: var(--foreground);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-height: 100vh;
  display: grid;
  grid-template-columns: 1fr 1fr;
}

@media (max-width: 900px) {
  body { grid-template-columns: 1fr; }
  .panel-editorial { display: none; }
}

.panel-editorial {
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 3.5rem;
  color: var(--cream);
}

.editorial-photo {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
}

.editorial-scrim {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, oklch(0.2 0.1 20 / 0.55) 0%, oklch(0.2 0.1 20 / 0.25) 45%, oklch(0.2 0.1 20 / 0.78) 100%);
  z-index: 0;
}

.zari-border {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 10px;
  background-image: repeating-linear-gradient(
    0deg,
    var(--gold) 0px,
    var(--gold) 3px,
    transparent 3px,
    transparent 14px
  );
  opacity: 0.85;
  z-index: 1;
}

.brand-mark {
  font-family: var(--font-display);
  font-size: 1.5rem;
  letter-spacing: 0.04em;
  position: relative;
  z-index: 1;
}
.brand-mark span { color: var(--gold-soft); }

.editorial-text {
  position: relative;
  z-index: 1;
  max-width: 26rem;
}

.editorial-text .eyebrow {
  font-size: 0.75rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold-soft);
  margin-bottom: 1rem;
  font-weight: 500;
}

.editorial-text h1 {
  font-family: var(--font-display);
  font-size: 2.75rem;
  line-height: 1.15;
  font-weight: 500;
  letter-spacing: -0.01em;
  margin-bottom: 1.25rem;
}
.editorial-text h1 em {
  font-style: italic;
  color: var(--gold-soft);
}

.editorial-text p {
  font-family: var(--font-accent);
  font-size: 1.2rem;
  font-style: italic;
  line-height: 1.6;
  color: oklch(0.975 0.015 80 / 0.85);
}

.editorial-stats {
  position: relative;
  z-index: 1;
  display: flex;
  gap: 2.5rem;
  padding-top: 2rem;
  border-top: 1px solid oklch(0.975 0.015 80 / 0.15);
}

.editorial-stats div strong {
  display: block;
  font-family: var(--font-display);
  font-size: 1.5rem;
  color: var(--gold-soft);
}

.editorial-stats div span {
  font-size: 0.75rem;
  color: oklch(0.975 0.015 80 / 0.65);
  letter-spacing: 0.03em;
}

.panel-form {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2.5rem;
}

.form-wrap {
  width: 100%;
  max-width: 26rem;
}

.form-eyebrow {
  font-size: 1rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--wine);
  font-weight: 600;
  margin-bottom: 0.75rem;
}

.form-wrap h2 {
  font-family: var(--font-display);
  font-size: 2rem;
  font-weight: 500;
  letter-spacing: -0.01em;
  margin-bottom: 0.5rem;
}

.form-wrap .sub {
  font-size: 0.9rem;
  color: var(--muted-foreground);
  margin-bottom: 2.25rem;
}
.form-wrap .sub a { color: var(--wine); font-weight: 500; text-decoration: none; }
.form-wrap .sub a:hover { text-decoration: underline; }

form { display: flex; flex-direction: column; gap: 1.25rem; }

.field label {
  display: block;
  font-size: 0.8rem;
  font-weight: 500;
  color: var(--foreground);
  margin-bottom: 0.4rem;
}

.field input {
  width: 100%;
  padding: 0.85rem 1rem;
  border: 1.5px solid var(--border);
  border-radius: 0.65rem;
  font-family: var(--font-sans);
  font-size: 0.9rem;
  background: var(--cream);
  color: var(--foreground);
  transition: border-color .2s, box-shadow .2s;
}

.field input::placeholder { color: oklch(0.6 0.01 60); }

.field input:focus {
  outline: none;
  border-color: var(--gold);
  box-shadow: 0 0 0 3px oklch(0.78 0.13 85 / 0.2);
}

.row-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.82rem;
}

.remember {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--muted-foreground);
}
.remember input { accent-color: var(--wine); width: 15px; height: 15px; }

.row-between a { color: var(--wine); text-decoration: none; font-weight: 500; }
.row-between a:hover { text-decoration: underline; }

.btn-submit {
  background: var(--wine);
  color: var(--cream);
  border: none;
  padding: 0.95rem 1.75rem;
  border-radius: 9999px;
  font-family: var(--font-sans);
  font-weight: 500;
  font-size: 0.95rem;
  cursor: pointer;
  box-shadow: var(--shadow-luxe);
  transition: transform .25s, box-shadow .25s;
  margin-top: 0.5rem;
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: var(--shadow-gold); }
.btn-submit:active { transform: translateY(0); }

.divider {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin: 1.75rem 0;
  color: var(--muted-foreground);
  font-size: 0.78rem;
}
.divider::before, .divider::after {
  content: "";
  flex: 1;
  height: 1px;
  background: var(--border);
}

.btn-social {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.6rem;
  width: 100%;
  padding: 0.8rem;
  border: 1.5px solid var(--border);
  border-radius: 0.65rem;
  background: var(--cream);
  font-family: var(--font-sans);
  font-size: 0.88rem;
  font-weight: 500;
  color: var(--foreground);
  cursor: pointer;
  transition: border-color .2s, background .2s;
}
.btn-social:hover { border-color: var(--gold); background: var(--blush); }

.footer-note {
  text-align: center;
  margin-top: 2rem;
  font-size: 0.82rem;
  color: var(--muted-foreground);
}
.footer-note a { color: var(--wine); font-weight: 500; text-decoration: none; }
.footer-note a:hover { text-decoration: underline; }
</style>
</head>
<body>

<section class="panel-editorial">
  <img class="editorial-photo" src="https://shribalaji-saree-production.up.railway.app/frontend/images/hero-saree.jpg" alt="">
  <div class="editorial-scrim"></div>
  <div class="zari-border"></div>

  <div class="brand-mark">SareeInfo <span>.</span></div>

  <div class="editorial-text">
    <div class="eyebrow">Welcome back to the atelier</div>
    <h1>The weave <em>remembers</em><br>you.</h1>
    <p>"25,000+ brides trust their story to our silk."</p>
  </div>

  <div class="editorial-stats">
    <div><strong>25k+</strong><span>Happy brides</span></div>
    <div><strong>500+</strong><span>Master artisans</span></div>
    <div><strong>4.9★</strong><span>Customer rating</span></div>
  </div>
</section>

<section class="panel-form">
   <!-- Success/Error messages -->
   <div id="loginMessage" class="mt-3"></div>
  <div class="form-wrap">
    <div class="form-eyebrow">Sign in</div>
    <h2>Welcome back to the atelier</h2>
    <!-- <p class="sub">New to SareeInfo? <a href="#">Create an account</a></p> -->

    <form id="login_form">
      @csrf

      <div class="field"> 
          <label for="email" class="form-label">Email or Username</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="name@email.com" autocomplete="off">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror     
      </div>

      <div class="field password-wrapper"> 
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" autocomplete="off">
        <span class="toggle-password">
            <i class="fas fa-eye" id="togglePasswordIcon"></i>
        </span>

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>

      <div class="row-between">
        <label for="remember" class="remember">
          <input type="checkbox" id="remember" name="remember">
          Remember me
        </label>
        <a href="{{-- route('password.request') --}}" >Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit">Sign in</button>
    </form>

    <div class="divider">or continue with</div>

    <button type="button" class="btn-social">
      <svg width="18" height="18" viewBox="0 0 18 18"><path fill="#4285F4" d="M17.64 9.2c0-.64-.06-1.25-.16-1.84H9v3.48h4.84c-.21 1.13-.85 2.09-1.8 2.73v2.27h2.92c1.71-1.57 2.68-3.88 2.68-6.64z"/><path fill="#34A853" d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.92-2.27c-.81.54-1.84.86-3.04.86-2.34 0-4.32-1.58-5.03-3.7H.96v2.34C2.44 15.98 5.48 18 9 18z"/><path fill="#FBBC05" d="M3.97 10.71a5.4 5.4 0 010-3.42V4.95H.96a9 9 0 000 8.1l3.01-2.34z"/><path fill="#EA4335" d="M9 3.58c1.32 0 2.51.45 3.44 1.35l2.59-2.59C13.46.9 11.43 0 9 0 5.48 0 2.44 2.02.96 4.95l3.01 2.34C4.68 5.16 6.66 3.58 9 3.58z"/></svg>
      Continue with Google
    </button>

    <p class="footer-note">By continuing, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.</p>
  </div>
</section>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

<script>
  // <!-- JS: Password Toggle -->
  const togglePassword = document.getElementById('togglePasswordIcon');
  const passwordField = document.getElementById('password');

  togglePassword.addEventListener('click', function () {
      const type = passwordField.getAttribute('type') == 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
  });

  $(document).ready(function () {

      $('#login_form').validate({
          rules: {
              email: {
                  required: true,
                  email: true,
              },
              password: {
                  required: true,
                  minlength: 7,
              }
          },
          messages: {
              email: {
                  required: "Please enter your email",
                  email: "Please enter a valid email address",
              },
              password: {
                  required: "Please enter your password",
                  minlength: "Your password must be at least 7 characters long",
              }
          },
          errorElement: 'strong',
          errorPlacement: function (error, element) {
              if (element.attr("name") == "email") {
                  $('.email-error').show().html(error);
              } else if (element.attr("name") == "password") {
                  $('.password-error').show().html(error);
              }
              element.addClass('is-invalid');
          },
          highlight: function (element) {
              $(element).addClass('is-invalid');
          },
          unhighlight: function (element) {
              $(element).removeClass('is-invalid');
          },
          submitHandler: function (form) {
              // Clear previous errors
              $('.email-error, .password-error').hide().html('');
              $('input').removeClass('is-invalid');

              let email       = $('#email').val();
              let password    = $('#password').val();
              let remember    = $('#remember').is(':checked') ? 1 : 0;

              $.ajax({
                  url: "{{ route('admin.auth.login') }}",
                  method: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },  
                  data: {
                      email: email,
                      password: password,
                      remember: remember,
                  },

                  success: function (response) {
                      if(response.success) {
                          window.location.href = response.redirect_url || "{{ route('admin.dashboard') }}";
                      } else {
                          $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                      }
                  },
                  error: function (xhr) {
                      if (xhr.status == 422) {
                          let errors = xhr.responseJSON.errors;
                          if (errors.email) {
                              $('#email').addClass('is-invalid');
                              $('.email-error').show().html('<strong>' + errors.email[0] + '</strong>');
                          }
                          if (errors.password) {
                              $('#password').addClass('is-invalid');
                              $('.password-error').show().html('<strong>' + errors.password[0] + '</strong>');
                          }
                      } else if (xhr.status == 401 || xhr.responseJSON.message) {
                          alert(xhr.responseJSON.message || "Login failed");
                      } else {
                          alert("Something went wrong");
                      }
                  }
              });
          }
      });
  });
</script>