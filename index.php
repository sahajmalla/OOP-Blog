<?php
require_once 'core/init.php';

$pageNo = "";
// $homeBlog = new Blog();
// $homeBlog->get(['status', '=' , 'published']);
// $results =  $homeBlog->data();
$db = DB::getInstance();

if (isset($_GET["page"])) {
    $pageNo = $_GET["page"];
}
if ($pageNo == "" || $pageNo == "1") {
    $page1 = 0;
} else {
    $page1 = ($pageNo * 2) - 2;
}

$query = $db->query("Select * from posts where status = 'published' limit $page1,2");
$results = $db->results();
?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/templates/header.php") ?>

<body>
    <?php include("includes/templates/nav.php") ?>

    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="-my-8 divide-y-2 divide-gray-100">
                <?php
                if ($db->count()) {
                    foreach ($results as $blog) {
                        echo "<div class='py-8 flex flex-wrap md:flex-nowrap'>";
                        echo  "<div class='md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col'>";
                        echo " <img alt='thumbnail image' class='lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded' src='images/{$blog->image}'>";
                        echo "<span class='mt-1 text-gray-500 text-sm'>{$blog->created_at}</span>";
                        echo "</div>";
                        echo " <div class='md:flex-grow'>";
                        echo "<h2 class='text-2xl font-medium text-gray-900 title-font mb-2'>{$blog->title}</h2>";
                        echo "<p class='leading-relaxed'>{$blog->description}</p>";
                        echo "<a href='posts.php?id={$blog->id}' class='text-indigo-500 inline-flex items-center mt-4'>Learn More";
                        echo "<svg class='w-4 h-4 ml-2' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'>";
                        echo " <path d='M5 12h14'></path>";
                        echo "<path d='M12 5l7 7-7 7'></path>";
                        echo "</svg>";
                        echo " </a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    $countRows = $db->query("Select * from posts where status ='published'")->count();
                    $page = $countRows / 2;
                    $page = ceil($page);

                    echo "<div class='flex'>";
                    for ($index = 1; $index <= $page; $index++) {
                        echo " <a href='index.php?page={$index}' class='flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200'>";
                        echo $index;
                        echo "</a>";
                    }
                } else {
                    echo "No Blog found";
                }
                ?>
            </div>
    </section>

</body>

</html>