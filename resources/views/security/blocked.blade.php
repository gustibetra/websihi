<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Protected Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #1e1e1e 0%, #2d2d2d 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .warning-container {
            max-width: 700px;
            width: 100%;
            background: #ffffff;
            color: #1e1e1e;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }
        
        .warning-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .warning-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .warning-icon {
            font-size: 80px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
            position: relative;
            z-index: 1;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .warning-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .warning-header p {
            font-size: 16px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        
        .warning-content {
            padding: 40px 30px;
        }
        
        .warning-message {
            background: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        
        .warning-message h2 {
            font-size: 18px;
            font-weight: 700;
            color: #dc2626;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .warning-message p {
            font-size: 15px;
            line-height: 1.6;
            color: #374151;
        }
        
        .info-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .info-section h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-item {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 140px;
            font-size: 14px;
        }
        
        .info-value {
            color: #1f2937;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            word-break: break-all;
            flex: 1;
        }
        
        .legal-notice {
            background: #fffbeb;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .legal-notice h3 {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .legal-notice p {
            font-size: 14px;
            line-height: 1.6;
            color: #78350f;
            margin-bottom: 10px;
        }
        
        .legal-notice ul {
            list-style: none;
            padding-left: 0;
        }
        
        .legal-notice li {
            font-size: 13px;
            color: #78350f;
            padding: 6px 0;
            padding-left: 24px;
            position: relative;
        }
        
        .legal-notice li::before {
            content: '•';
            position: absolute;
            left: 8px;
            font-weight: bold;
        }
        
        .timestamp {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .highlight {
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            color: #92400e;
        }
        
        @media (max-width: 768px) {
            .warning-header {
                padding: 30px 20px;
            }
            
            .warning-header h1 {
                font-size: 24px;
            }
            
            .warning-icon {
                font-size: 60px;
            }
            
            .warning-content {
                padding: 30px 20px;
            }
            
            .info-item {
                flex-direction: column;
                gap: 5px;
            }
            
            .info-label {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="warning-container">
        <div class="warning-header">
            <div class="warning-icon">
                <i class="ri-shield-cross-line"></i>
            </div>
            <h1>ACCESS DENIED</h1>
            <p>Unauthorized Access Attempt Detected</p>
        </div>
        
        <div class="warning-content">
            <div class="warning-message">
                <h2>
                    <i class="ri-error-warning-line"></i>
                    Security Alert
                </h2>
                <p>
                    Your access attempt has been <span class="highlight">blocked and logged</span>. 
                    This website is protected by Indonesian law and international cybersecurity regulations.
                </p>
            </div>
            
            <div class="info-section">
                <h3>
                    <i class="ri-information-line"></i>
                    Your Information Has Been Recorded
                </h3>
                <div class="info-item">
                    <div class="info-label">IP Address:</div>
                    <div class="info-value">{{ $ipAddress }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">User Agent:</div>
                    <div class="info-value">{{ $userAgent }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Timestamp:</div>
                    <div class="info-value">{{ $timestamp }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Request URL:</div>
                    <div class="info-value">{{ $requestUrl }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Incident ID:</div>
                    <div class="info-value">{{ $incidentId }}</div>
                </div>
            </div>
            
            <div class="legal-notice">
                <h3>
                    <i class="ri-scales-3-line"></i>
                    Legal Notice
                </h3>
                <p>
                    This website is protected under:
                </p>
                <ul>
                    <li><strong>UU ITE No. 19 Tahun 2016</strong> - Indonesian Electronic Information and Transactions Law</li>
                    <li><strong>UU No. 27 Tahun 2022</strong> - Personal Data Protection Law</li>
                    <li><strong>Peraturan Pemerintah No. 71 Tahun 2019</strong> - Government Electronic Systems Security</li>
                </ul>
                <p style="margin-top: 15px;">
                    Unauthorized access attempts, data scraping, or any malicious activities are 
                    <strong>strictly prohibited</strong> and may result in legal action.
                </p>
            </div>
            
            <div class="timestamp">
                <i class="ri-time-line"></i>
                All access attempts are monitored and logged for security purposes
            </div>
        </div>
    </div>
</body>
</html>
