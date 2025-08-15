<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset - MMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #FE8400, #FF6B6B);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FE8400;
            background: white;
            box-shadow: 0 0 0 3px rgba(254, 132, 0, 0.1);
        }

        .form-group input.error,
        .form-group select.error {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message::before {
            content: '⚠️';
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FE8400, #FF6B6B);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(254, 132, 0, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .admin-list {
            background: #f8f9fa;
            border: 1px solid #e1e5e9;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .admin-list h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-list h3::before {
            content: '👥';
        }

        .admin-item {
            background: white;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-info {
            flex: 1;
        }

        .admin-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .admin-details {
            color: #666;
            font-size: 12px;
            margin-top: 2px;
        }

        .copy-btn {
            background: #FE8400;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .copy-btn:hover {
            background: #e67300;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message::before {
            content: '✅';
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #FE8400;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #e67300;
        }

        .password-requirements {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #1565c0;
        }

        .password-requirements h4 {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .password-requirements h4::before {
            content: '🔒';
        }

        .password-requirements ul {
            margin-left: 20px;
        }

        .password-requirements li {
            margin-bottom: 4px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .admin-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .copy-btn {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Password Reset</h1>
            <p>Reset password for admin accounts</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-list">
            <h3>Available Admin Accounts</h3>
            <div id="adminList">
                <p style="text-align: center; color: #666;">Loading admin list...</p>
            </div>
        </div>

        <div class="password-requirements">
            <h4>Password Requirements</h4>
            <ul>
                <li>Minimum 8 characters</li>
                <li>Must contain uppercase letters</li>
                <li>Must contain lowercase letters</li>
                <li>Must contain numbers</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.reset.password') }}">
            @csrf
            
            <div class="form-group">
                <label for="admin_username">Admin Username</label>
                <select name="admin_username" id="admin_username" class="@error('admin_username') error @enderror" required>
                    <option value="">Select Admin Account</option>
                </select>
                @error('admin_username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="@error('new_password') error @enderror" required>
                @error('new_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="@error('confirm_password') error @enderror" required>
                @error('confirm_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @error('general')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>

        <div class="back-link">
            <a href="/login">← Back to Login</a>
        </div>
    </div>

    <script>
        // Load admin list
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/admin/reset-password/list')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayAdminList(data.admins);
                    } else {
                        document.getElementById('adminList').innerHTML = '<p style="text-align: center; color: #dc3545;">Error loading admin list</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('adminList').innerHTML = '<p style="text-align: center; color: #dc3545;">Error loading admin list</p>';
                });
        });

        function displayAdminList(admins) {
            const adminListDiv = document.getElementById('adminList');
            const selectElement = document.getElementById('admin_username');

            if (admins.length === 0) {
                adminListDiv.innerHTML = '<p style="text-align: center; color: #666;">No admin accounts found</p>';
                return;
            }

            // Clear existing options
            selectElement.innerHTML = '<option value="">Select Admin Account</option>';

            // Add admin options to select
            admins.forEach(admin => {
                const option = document.createElement('option');
                option.value = admin.username;
                option.textContent = `${admin.nama} (${admin.username}) - ${admin.cabang}`;
                selectElement.appendChild(option);
            });

            // Display admin list
            let adminListHTML = '';
            admins.forEach(admin => {
                adminListHTML += `
                    <div class="admin-item">
                        <div class="admin-info">
                            <div class="admin-name">${admin.nama}</div>
                            <div class="admin-details">
                                Username: ${admin.username} | Branch: ${admin.cabang} | Phone: ${admin.no_hp}
                            </div>
                        </div>
                        <button class="copy-btn" onclick="copyUsername('${admin.username}')">Copy Username</button>
                    </div>
                `;
            });

            adminListDiv.innerHTML = adminListHTML;
        }

        function copyUsername(username) {
            navigator.clipboard.writeText(username).then(function() {
                // Show temporary success message
                const btn = event.target;
                const originalText = btn.textContent;
                btn.textContent = 'Copied!';
                btn.style.background = '#28a745';
                
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = '#FE8400';
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Could not copy username. Please copy manually: ' + username);
            });
        }

        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    </script>
</body>
</html> 