<!doctype html>
<html class="no-js" lang="id">
<head>
    @include('partials.site.head')
    <style>
        .error-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 40px 20px;
        }
        
        .error-content {
            text-align: center;
            max-width: 600px;
            background: #ffffff;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 900;
            color: var(--rs-theme-primary);
            line-height: 1;
            margin-bottom: 20px;
            text-shadow: 3px 3px 0 rgba(232, 191, 111, 0.2);
        }
        
        .error-title {
            font-size: 32px;
            font-weight: 700;
            color: #1F1F1F;
            margin-bottom: 15px;
        }
        
        .error-message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 35px;
            line-height: 1.6;
        }
        
        .error-icon {
            font-size: 80px;
            color: var(--rs-theme-primary);
            margin-bottom: 20px;
            opacity: 0.8;
        }
        
        .error-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .error-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 30px;
            background: var(--rs-theme-primary);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border: 2px solid var(--rs-theme-primary);
        }
        
        .error-btn:hover {
            background: var(--rs-theme-primary-hover);
            border-color: var(--rs-theme-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232, 191, 111, 0.3);
            color: #ffffff;
        }
        
        .error-btn-secondary {
            background: transparent;
            color: var(--rs-theme-primary);
            border: 2px solid var(--rs-theme-primary);
        }
        
        .error-btn-secondary:hover {
            background: var(--rs-theme-primary);
            color: #ffffff;
        }
        
        @media (max-width: 768px) {
            .error-content {
                padding: 40px 25px;
            }
            
            .error-code {
                font-size: 80px;
            }
            
            .error-title {
                font-size: 24px;
            }
            
            .error-message {
                font-size: 14px;
            }
            
            .error-icon {
                font-size: 60px;
            }
            
            .error-buttons {
                flex-direction: column;
            }
            
            .error-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-page-wrapper">
        <div class="error-content">
            @yield('content')
        </div>
    </div>
    
    @include('partials.site.scripts')
</body>
</html>
