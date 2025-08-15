<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>Sign Up - Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body>
    <a href="/" class="chevron-back">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 19L8 12L15 5" stroke="#FE8400" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
    <div class="signup-container">
        <div class="signup-form-section">
            <h2>Create Your Account</h2>
            <p>Create your profile and explore all that Mifta Motor Sport has to offer.</p>
            
            <!-- Success Message -->
            @if(session('success'))
            <div class="success-message" style="margin-bottom: 1.5rem; padding: 1rem; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 0.5rem; color: #155724; font-weight: 600; text-align: center;">
                {{ session('success') }}
            </div>
            @endif

            <!-- General Error Message -->
            @if($errors->has('general'))
            <div class="error-message" style="margin-bottom: 1.5rem; padding: 1rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 0.5rem; color: #721c24; font-weight: 600; text-align: center;">
                {{ $errors->first('general') }}
            </div>
            @endif

            <form class="signup-form" action="/register" method="POST">
                @csrf
                <div style="display: flex; gap: 1.1875rem; width: 25.0625rem;">
                    <div>
                        <label for="name">Name</label>
                        <div class="input-wrapper input-short">
                            <input name="name" type="text" id="name" class="input-underline @error('name') input-error @enderror" placeholder="Name" value="{{ old('name') }}" required style="width:11.875rem;height:4.375rem; @error('name') border-color: #dc3545; @enderror">
                        </div>
                        @error('name')
                        <div class="error-text" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="phone">Phone Number</label>
                        <div class="input-wrapper input-short">
                            <input name="phone" type="text" id="phone" class="input-underline @error('phone') input-error @enderror" placeholder="Phone Number" value="{{ old('phone') }}" required style="width:11.875rem;height:4.375rem; @error('phone') border-color: #dc3545; @enderror">
                        </div>
                        @error('phone')
                        <div class="error-text" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input name="username" type="text" id="username" class="input-underline @error('username') input-error @enderror" placeholder="Type your username here" value="{{ old('username') }}" required style="@error('username') border-color: #dc3545; @enderror">
                    </div>
                    @error('username')
                    <div class="error-text" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password">Enter your Password</label>
                    <input name="password" type="password" id="password" class="@error('password') input-error @enderror" placeholder="Type your password here" required style="@error('password') border-color: #dc3545; @enderror">
                    @error('password')
                    <div class="error-text" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
                <p class="register-link">Already have an account? <a href="/login" class="login-link">Log in here!</a></p>
            </form>
        </div>
        <div class="signup-image-section">
            <img src="{{ asset('images/tampilan1.png') }}" alt="Tampilan 1" class="signup-image" />
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
        // Auto-hide success message after 5 seconds
        @if(session('success'))
        setTimeout(function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
        @endif
    </script>
</body>
</html> 