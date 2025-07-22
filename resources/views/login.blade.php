<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>Login - Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <a href="/" class="chevron-back">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 19L8 12L15 5" stroke="#FE8400" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
    <div class="login-container">
        <div class="login-form-section">
            <h2>Login to Your Account</h2>
            <p>Enter your username and password to access your account.</p>
            <form class="login-form" action="/login" method="POST" onsubmit="handleLogin(event)">
                @csrf
                <div>
                    <label for="username">Username</label>
                    <div class="input-wrapper" style="position:relative;">
                        <input type="text" id="username" name="username" class="input-underline @if($errors->any()) input-error @endif" placeholder="@if($errors->any()) Your username or password is incorrect. @else Type your username here @endif" value="{{ old('username') }}" required style="@if($errors->any()) border: 1.5px solid #d00; color: #d00; @endif">
                        @if($errors->any())
                        <span class="input-error-text">Your username or password is incorrect.</span>
                        @endif
                    </div>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Type your password here" required>
                </div>
                <button type="submit" class="login-btn">Log In</button>
                <p class="register-link">Don't have an account? <a href="/register" class="join-link">Join us today</a></p>
            </form>
        </div>
        <div class="login-image-section">
            <img src="{{ asset('images/tampilan1.png') }}" alt="Tampilan 1" class="login-image" />
            <svg class="ellipse-bg" width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.5 0.5C20.6977 0.5 26.5 6.11406 26.5 13C26.5 19.8859 20.6977 25.5 13.5 25.5C6.30235 25.5 0.5 19.8859 0.5 13C0.5 6.11406 6.30234 0.5 13.5 0.5Z" stroke="white" stroke-opacity="0.5" stroke-width="1"/>
            </svg>
            <svg class="ellipse-bg-bottom" width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.5 0.5C20.6977 0.5 26.5 6.11406 26.5 13C26.5 19.8859 20.6977 25.5 13.5 25.5C6.30235 25.5 0.5 19.8859 0.5 13C0.5 6.11406 6.30234 0.5 13.5 0.5Z" stroke="white" stroke-opacity="0.5" stroke-width="1"/>
            </svg>
            <svg class="ellipse-bg-large" width="47" height="45" viewBox="0 0 47 45" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M23.5 0.5C36.2233 0.5 46.5 10.37 46.5 22.5C46.5 34.63 36.2233 44.5 23.5 44.5C10.7767 44.5 0.5 34.63 0.5 22.5C0.5 10.37 10.7767 0.5 23.5 0.5Z" stroke="white" stroke-opacity="0.5" stroke-width="1"/>
            </svg>
        </div>
    </div>

    <script>
        function handleLogin(event) {
            
            // Simulate loading
            const loginBtn = document.querySelector('.login-btn');
            const originalText = loginBtn.textContent;
            loginBtn.textContent = 'Logging in...';
            loginBtn.disabled = true;
        }
    </script>
</body>
</html>

<style>
.login-error-message {
    margin-bottom: 1rem;
    color: #d00;
    background: #fff3f3;
    border: 1.5px solid #d00;
    border-radius: 0.5rem;
    padding: 0.85rem 1.2rem;
    font-family: 'Montserrat', sans-serif;
    font-size: 1.05rem;
    font-weight: 600;
    text-align: center;
    box-shadow: 0 2px 8px rgba(220,0,0,0.04);
    width: 100%;
    max-width: 100%;
    margin-left: 0;
    margin-right: 0;
}
.input-error {
    border: 1.5px solid #d00 !important;
    color: #d00 !important;
}
.input-error-text {
    position: absolute;
    left: 0;
    bottom: -1.6rem;
    font-size: 0.98rem;
    color: #d00;
    background: transparent;
    font-family: 'Montserrat', sans-serif;
    font-weight: 500;
    padding-left: 2px;
}
</style>
