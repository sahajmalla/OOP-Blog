<?php
require_once 'core/init.php';

if (Input::get('id') === '') {
    Redirect::to(404);
}

$blogPosts = new Blog();
$userPosts = new User();

if (!($blogPosts->findById(Input::get('id')))) {
    Redirect::to(404);
}
$userPosts->find($blogPosts->data()->user_id);

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/templates/header.php") ?>

<body>
    <?php include("includes/templates/nav.php") ?>

    <div class="mx-auto px-4 py-4 flex flex-col items-center">
        <div class="w-full mb-10 lg:mb-0 rounded-lg overflow-hidden">
            <img alt='post thumbnail' class='object-cover object-center h-96 w-full' src=<?php echo "images/{$blogPosts->data()->image}" ?>>;
        </div>
        <div>
            <h1 class="text-4xl"><?php echo $blogPosts->data()->title ?> </h1>
        </div>
        <div>
            <p>Written by <?php echo $userPosts->data()->firstname . ' ' . $userPosts->data()->lastname ?></p>
        </div>
        <div>
            <?php echo $blogPosts->data()->created_at ?>
        </div>

        <div class="mt-4">
            <p><?php echo $blogPosts->data()->body ?></p>
        </div>
    </div>

</body>

</html>