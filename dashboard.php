<?php
require_once 'core/init.php';

$pageNo = "";
$userDashboard = new User();

if (!$userDashboard->isLoggedin()) {
    Redirect::to('login.php');
}

$db = DB::getInstance();

if (isset($_GET["page"])) {
    $pageNo = $_GET["page"];   
}
if ($pageNo == "" || $pageNo == "1") {
    $page1 = 0;
} else {
    $page1 = ($pageNo * 2) - 2;
}


$query = $db->query("Select * from posts limit $page1,2");
$results = $db->results();




?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/templates/header.php") ?>

<body>
    <div>
        <?php include("includes/templates/nav.php") ?>
    </div>


    <div class="mx-auto px-4 mt-4">
        <a href="/oop-blog/addPosts.php">
            <button class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                Add Blog
            </button>
        </a>
    </div>

    <div class="mx-auto px-4 sm:px-8 w-full">

        <div class="py-8 flex items-center">
            <div class="w-screen overflow-x-auto">


                <div class="inline-block w-auto shadow rounded-lg overflow-hidden">
                    <?php

                    if ($db->count()) {
                        echo "<table class='min-w-full leading-normal'>";

                        echo "<thead>";
                        echo   "<tr>";

                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo  "Image";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo   " Title";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo    "Description";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo "Slug";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo  "Status";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo "Created at";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo "Updated at";
                        echo " </th>";
                        echo "<th scope='col' class='px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal'>";
                        echo "Actions";
                        echo "</th>";

                        echo "</tr>";
                        echo " </thead>";

                        echo "<tbody>";
                        foreach ($results as $blog) {
                            # code...

                            echo "<tr>";

                            echo "<td class='px-5 py-5 border-b border-gray-200 '>";
                            echo "<img alt='thumbnail image' src='images/{$blog->image}' class='object-cover w-36 mr-2' />";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->title}";
                            echo "</p>";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->description}";
                            echo "</p>";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->slug}";
                            echo "</p>";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->status}";
                            echo "</p>";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->created_at}";
                            echo "</p>";
                            echo "</td>";

                            echo " <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>";
                            echo "<p class='text-gray-900 whitespace-no-wrap'>";
                            echo "{$blog->updated_at}";
                            echo "</p>";
                            echo "</td>";

                            echo "<td class='flex px-5 py-5 border-b border-gray-200 bg-white text-sm space-x-3'>";
                            echo "<a href='posts.php?id={$blog->id}'>";
                            echo "<button class='px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80'>";
                            echo "View";
                            echo "</button>";
                            echo "</a>";


                            echo "<a href='updatePosts.php?id={$blog->id}'>";
                            echo "<button class='px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80'>";
                            echo "Update";
                            echo "</button>";
                            echo "</a>";

                            echo "<a href='deletePosts.php?id={$blog->id}'>";
                            echo "<button class='px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80'>";
                            echo "Delete";
                            echo "</button>";
                            echo "</a>";

                            echo "</td>";
                            echo "</tr>";
                        }


                        echo "</tbody>";
                        echo "</table>";

                        // echo '<pre>';
                        // var_dump($result);
                        // echo '</pre>';
                        $countRows = $db->query('Select * from posts')->count();
                        $page = $countRows / 2;
                        $page = ceil($page);

                        echo "<div class='flex'>";
                        for ($index = 1; $index <= $page; $index++) {
                            echo " <a href='dashboard.php?page={$index}' class='flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200'>";
                            echo $index;
                            echo "</a>";
                        }
                        echo "</div>";
                    } else {
                        echo "No Blog found";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>