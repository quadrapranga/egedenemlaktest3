<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Egeden Emlak Admin')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0066ff;
            --primary-hover: #0052cc;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --error-color: #e53e3e;
            --success-color: #38a169;
            --header-height: 60px;
            --dark-gray: #666;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .admin-header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            z-index: 1000;
        }
        
        .admin-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .admin-logo {
            color: var(--primary-color);
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        
        .admin-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .admin-nav a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .admin-nav a:hover {
            background-color: var(--light-gray);
        }
        
        .admin-nav a.active {
            color: var(--primary-color);
            background-color: rgba(0, 102, 255, 0.1);
        }
        
        .admin-main {
            max-width: 1200px;
            margin: calc(var(--header-height) + 20px) auto 20px;
            padding: 0 20px;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: var(--primary-hover);
        }
        
        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background-color: var(--border-color);
        }
        
        .btn-danger {
            background-color: var(--error-color);
        }
        
        .btn-danger:hover {
            background-color: #c53030;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table th {
            background-color: var(--light-gray);
            font-weight: 600;
        }
        
        .table tr:hover {
            background-color: rgba(0, 102, 255, 0.05);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: var(--error-color);
        }
        
        .alert-success {
            background-color: #f0fff4;
            border: 1px solid #9ae6b4;
            color: var(--success-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }
        
        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
            cursor: pointer;
        }
        
        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }
        
        .pagination a {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .pagination a:hover {
            background-color: var(--light-gray);
        }
        
        .pagination .active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-success {
            background-color: #f0fff4;
            color: var(--success-color);
        }
        
        .badge-warning {
            background-color: #fffaf0;
            color: #d97706;
        }
        
        .badge-danger {
            background-color: #fff5f5;
            color: var(--error-color);
        }

        .logout-form {
            margin: 0;
            padding: 0;
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--text-color);
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: var(--light-gray);
        }

        .admin-nav a i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-header-content">
            <a href="{{ route('admin.properties.index') }}" class="admin-logo">
                Egeden Emlak
            </a>
            <nav class="admin-nav">
                <a href="{{ route('admin.properties.index') }}" class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Properties
                </a>
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html> 