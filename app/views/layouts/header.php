<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <span class="text-xl font-semibold">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </span>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">
                        Dashboard
                    </a>
                    <a href="/profile" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">
                        Profile
                    </a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">
                        Admin Panel
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/profile" class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-600 text-sm">
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        </span>
                    </div>
                </a>
                <form action="/logout" method="POST">
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Mobile menu button -->
    <div class="md:hidden">
        <button type="button" class="mobile-menu-button p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
            <span class="sr-only">Open menu</span>
            <!-- Menu icon -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</nav>

<!-- Mobile menu -->
<div class="md:hidden hidden mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="/dashboard" class="text-gray-700 hover:text-gray-900 block px-3 py-2 rounded-md">
            Dashboard
        </a>
        <a href="/profile" class="text-gray-700 hover:text-gray-900 block px-3 py-2 rounded-md">
            Profile
        </a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900 block px-3 py-2 rounded-md">
            Admin Panel
        </a>
        <?php endif; ?>
    </div>
</div>

<script>
// Mobile menu toggle
document.querySelector('.mobile-menu-button').addEventListener('click', function() {
    document.querySelector('.mobile-menu').classList.toggle('hidden');
});
</script> 