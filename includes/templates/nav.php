<?php
require_once 'core/init.php';
$userLoggedinCheck = new User();
?>

<nav class="bg-white shadow dark:bg-gray-800">
    <div class="container flex items-center justify-center p-6 mx-auto text-gray-600 capitalize dark:text-gray-300">

        <a href="/oop-blog" class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Home</a>

        <?php if ($userLoggedinCheck->isLoggedin()) : ?>
            <a href="/oop-blog/dashboard.php" class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Dashboard</a>

            <a href="/oop-blog/logout.php" class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Logout</a>

        <?php elseif (!$userLoggedinCheck->isLoggedin()) : ?>

            <a href="/oop-blog/login.php" class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Login</a>

            <a href="/oop-blog/register.php" class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Register</a>

        <?php endif; ?>
    </div>
</nav>