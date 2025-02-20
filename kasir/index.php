<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santoso Jaya Teknik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
            background-size: cover;
            transition: background 0.5s;
        }
        body.scrolled {
            background: white;
        }
    </style>
</head>
<body class="text-black flex justify-center items-center min-h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-4 transform -translate-x-full transition-transform duration-300 z-50">
        <button id="closeSidebar" class="text-xl mb-4"></button>
        <ul class="space-y-4">
            <li><a href="#" class="block hover:text-gray-400">Home</a></li>
            <li><a href="#" class="block hover:text-gray-400">Product</a></li>
            <li><a href="#" class="block hover:text-gray-400">Contact</a></li>
            <li><a href="adminlogin.php" class="block hover:text-gray-400">Admin Login</a></li>
        </ul>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed top-0 left-0 w-full h-full bg-black opacity-50 hidden z-40"></div>

    <!-- Main Content -->
    <div class="text-center z-10">
        <h1 class="text-4xl font-bold mb-4">Depot Ko Bagio</h1>
        <p class="text-lg">
            Solusi terbaik tempat makan yang enak dan murah. Depot Ko Bagio merupakan tempat makan dengan makanan khas nusantara. <br>
            Depot Ko Bagio berlokasi di Jl. Dr. Moch Saleh No.02, Sukabumi, Kec. Mayangan, Kota Probolinggo, Jawa Timur 67219
        </p>
    </div>

    <!-- Sidebar Toggle Button -->
    <button id="toggleSidebar" class="fixed top-4 left-4 bg-gray-800 text-white p-2 rounded z-50">☰</button>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                document.body.classList.add('scrolled');
            } else {
                document.body.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
