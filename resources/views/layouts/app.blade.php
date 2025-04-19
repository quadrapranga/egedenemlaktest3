<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Egeden Emlak')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0066ff;
            --primary-hover: #0052cc;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --dark-gray: #666;
            --border-color: #e0e0e0;
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
        }
        
        .header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            color: var(--primary-color);
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        
        .nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .nav a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .nav a:hover {
            background-color: var(--light-gray);
        }
        
        .nav a.active {
            color: var(--primary-color);
            background-color: rgba(0, 102, 255, 0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 90px auto 20px;
            padding: 0 20px;
        }
        
        .footer {
            background-color: white;
            padding: 40px 0;
            margin-top: 40px;
            border-top: 1px solid var(--border-color);
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
            color: #666;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .btn-login:hover {
            background-color: var(--primary-hover);
        }
    </style>
</head>
<body>
    <header class="header">
    <div class="gtranslate_wrapper"></div>
<script>window.gtranslateSettings = {"default_language":"en","native_language_names":true,"detect_browser_language":true,"languages":["en","fr","it","es"],"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","switcher_vertical_position":"top"}</script>
<script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
        <div class="header-content">
            <a href="{{ route('home') }}" class="logo">
                Egeden Emlak
            </a>
            <nav class="nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
                <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'active' : '' }}">
                    Properties
                </a>
                @auth
                    <a href="{{ route('admin.properties.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        Admin Panel
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-login">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        Admin Login
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Egeden Emlak. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 