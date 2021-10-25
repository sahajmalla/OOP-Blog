<?php
require_once 'core/init.php';

$userAddPost = new User();

if (!$userAddPost->isLoggedin()) {
    Redirect::to('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/templates/header.php") ?>

<body>
    <div>
        <?php include("includes/templates/nav.php") ?>
    </div>


    <section class=" mt-6 max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <?php

        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {
                $validate = new Validate();
                $validation = $validate->check($_POST, [
                    'title' => [
                        'required' => true,
                    ],
                    'description' => [
                        'required' => true,
                    ],
                    'slug' => [
                        'required' => true,
                        'unique' => 'posts'
                    ],

                    'body' => [
                        'required' => true,
                    ],
                    'status' => [
                        'required' => true,
                    ]
                ]);

                $imageValidation = $validate->checkImage($_FILES, [
                    'image' => [
                        'required' => true,
                    ]
                ]);


                if (!($validation->passed() && $imageValidation->passed())) {
                    foreach ($validation->errors() as $error) {
                        echo  "<p class='text-sm text-red-500'>{$error} </p>";
                    }
                } else {
                    $blog = new Blog();


                    if ($blog->upload('image')) {
                        // echo Session::get(Config::get('session/session_name'));
                        try {
                            $blog->create([
                                'user_id' => Session::get(Config::get('session/session_name')),
                                'title' => Input::get('title'),
                                'body' => Input::get('body'),
                                'description' => Input::get('description'),
                                'slug' => Input::get('slug'),
                                'status' => Input::get('status'),
                                'image' => $blog->getUploadedFileName(),
                            ]);

                            Session::flash('addPostSuccess', 'Post Successfully added!');
                            Redirect::to('dashboard.php');
                        } catch (Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        echo  "<p class='text-sm text-red-500'>Cannot post blog. Something is wrong!</p>";
                    }
                }
            }
        }

        ?>

        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Add Blog</h2>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="grid grid-cols-1 gap-6 mt-4 ">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="title">Title</label>
                    <input id="title" type="text" name="title" value="<?php echo escape(Input::get('title')) ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="description">Description</label>
                    <textarea id="description" name="description" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"><?php echo escape(Input::get('description')) ?></textarea>
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="slug">Slug</label>
                    <input id="slug" type="text" name="slug" value="<?php echo escape(Input::get('slug')) ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="image">Thumbnail Image</label>
                    <input id="image" type="file" name="image" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="body">Body</label>
                    <textarea id="body" rows="20" cols="30" name="body" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"><?php echo escape(Input::get('body')) ?></textarea>
                </div>

                <div class="flex flex-col">
                    <label for="status">Publish or Draft Status</label>
                    <select name="status" id="status" class="block  border border-gray-300 rounded-md">
                        <option value="" disabled <?php if (Input::get('status') == '') echo "selected ='selected'" ?>>Select Publish or Draft</option>
                        <option value="draft" <?php if (Input::get('status') == 'draft') echo "selected ='selected' " ?>>Draft</option>
                        <option value="published" <?php if (Input::get('status') == 'published') echo "selected ='selected'" ?>>Publish</option>
                    </select>
                </div>

                <div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Save</button>
            </div>
        </form>
    </section>

</body>

</html>