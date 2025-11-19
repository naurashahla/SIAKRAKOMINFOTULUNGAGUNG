<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAKRA')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f8f9fa;
            min-height: 100vh;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 10px;
            overflow: hidden;
        }
        
        .logo-section-external {
            text-align: center;
            margin-bottom: 24px;
            color: #1a1a1a;
        }
        
        .logo-title-external {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }
        
        .logo-subtitle-external {
            font-size: 16px;
            color: #6b7280;
            font-weight: 400;
            line-height: 1.3;
        }
        
        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 32px 32px;
            max-width: 400px;
            width: 100%;
            max-height: none;
        }
        
        .form-section {
            margin-bottom: 20px;
        }
        
        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 6px;
            text-align: center;
        }
        
        .form-subtitle {
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.3;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }
        
        .input-group {
            position: relative;
        }
        
        .password-input-group {
            position: relative;
        }
        
        .password-toggle-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            z-index: 10;
            font-size: 16px;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }
        
        .password-toggle-btn:hover {
            color: #6b7280;
        }
        
        .password-toggle-btn:focus {
            outline: none;
            color: #3b82f6;
        }
        
        .password-input-group .form-control {
            padding-right: 48px;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
            font-size: 16px;
        }
        
        .form-control {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 16px 10px 48px;
            font-size: 15px;
            transition: all 0.2s ease;
            width: 100%;
            color: #1f2937;
            height: 44px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }
        
        .form-control::placeholder {
            color: #9ca3af;
            font-size: 15px;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-check-input {
            width: 16px;
            height: 16px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin: 0;
        }
        
        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .form-check-label {
            color: #6b7280;
            font-weight: 400;
            cursor: pointer;
        }
        
        .forgot-password {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .forgot-password:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        
        .btn-login {
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s ease;
            cursor: pointer;
            height: 44px;
        }
        
        .btn-login:hover {
            background: #2d2d2d;
            transform: translateY(-1px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 16px;
            padding: 12px 16px;
            font-size: 13px;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }
        
        @media (max-width: 480px) {
            body {
                padding: 5px;
            }
            
            .logo-title-external {
                font-size: 28px;
            }
            
            .logo-subtitle-external {
                font-size: 14px;
            }
            
            .logo-section-external {
                margin-bottom: 20px;
            }
            
            .login-container {
                padding: 24px 20px;
                margin: 5px;
            }
            
            .form-title {
                font-size: 18px;
            }
            
            .form-subtitle {
                margin-bottom: 20px;
            }
        }
        
        @media (max-height: 600px) {
            .logo-title-external {
                font-size: 24px;
            }
            
            .logo-subtitle-external {
                font-size: 12px;
            }
            
            .logo-section-external {
                margin-bottom: 12px;
            }
            
            .login-container {
                padding: 16px 24px;
            }
            
            .form-section {
                margin-bottom: 12px;
            }
            
            .form-title {
                font-size: 16px;
            }
            
            .form-subtitle {
                margin-bottom: 16px;
                font-size: 12px;
            }
            
            .form-group {
                margin-bottom: 12px;
            }
        }
    </style>
</head>
<body>
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Support multiple password toggle buttons across pages.
            const toggleButtons = document.querySelectorAll('.password-toggle-btn');
            toggleButtons.forEach(btn => {
                const targetId = btn.getAttribute('data-target') || 'password';
                const input = document.getElementById(targetId);
                // prefer an <i> inside the button as the icon
                const icon = btn.querySelector('i');

                if (!input || !icon) return;

                const updateTitle = (visible) => {
                    btn.setAttribute('title', visible ? 'Sembunyikan password' : 'Tampilkan password');
                };

                // initialize icon state
                icon.className = 'fas fa-eye-slash';
                updateTitle(false);

                btn.addEventListener('click', function() {
                    const isVisible = input.type === 'text';
                    if (isVisible) {
                        input.type = 'password';
                        icon.className = 'fas fa-eye-slash';
                        updateTitle(false);
                    } else {
                        input.type = 'text';
                        icon.className = 'fas fa-eye';
                        updateTitle(true);
                    }
                    input.focus();
                });
            });
        });
    </script>
</body>
</html>