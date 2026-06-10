
<div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="material-logo">
                    <div class="logo-layers">
                        <div class="layer layer-1"></div>
                        <div class="layer layer-2"></div>
                        <div class="layer layer-3"></div>
                    </div>
                </div>
                <h2>Sign in</h2>
                <p>to continue to your account</p>
            </div>

            @if (session()->has('error'))
                <div style="text-align: center; font-size:14px; color: red">{{ session('error') }} <br>
        Please try again.<br><br></div>
            @endif
            
            <form wire:submit.prevent="login" class="login-form" id="loginForm">
  
                <div class="form-group">
                    <div class="input-wrapper">
                        <input wire:model="email" wire:model.blur="email"  type="email" id="email" name="email" required >
                        <label for="email">Email</label>
                        <div class="input-line"></div>
                        <div class="ripple-container"></div>
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input wire:model="password" wire:model.blur="password"  type="password" id="password" name="password" required  >
                        <label for="password">Password</label>
                        <div class="input-line"></div>
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <div class="toggle-ripple"></div>
                            <span class="toggle-icon"></span>
                        </button>
                        <div class="ripple-container"></div>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">
                            <div class="checkbox-material">
                                <div class="checkbox-ripple"></div>
                                <svg class="checkbox-icon" viewBox="0 0 24 24">
                                    <path class="checkbox-path" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                            </div>
                            Keep me signed in
                        </label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn material-btn">
                    <div class="btn-ripple"></div>
                    <span class="btn-text">SIGN IN</span>
                    <div class="btn-loader">
                        <svg class="loader-circle" viewBox="0 0 50 50">
                            <circle class="loader-path" cx="25" cy="25" r="12" fill="none" stroke="currentColor" stroke-width="3"/>
                        </svg>
                    </div>
                </button>
            </form>



            <div class="success-message" id="successMessage">
                <div class="success-elevation">
                    <div class="success-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </div>
                    <h3>Welcome back!</h3>
                    <p>Signing you in...</p>
                </div>
            </div>
        </div>
    </div>
</div>

 