<?php
require_once 'core/init.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/templates/header.php") ?>

<body>
    <?php include("includes/templates/nav.php") ?>




    <section class="mt-6 max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <?php

        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {
                $validate = new Validate();
                $validation  = $validate->check($_POST, [
                    'firstname' => [
                        'required' => true,
                        'min' => 2
                    ],
                    'lastname' => [
                        'required' => true,
                        'min' => 2
                    ],
                    'username' => [
                        'required' => true,
                        'min' => 2,
                        'unique' => 'users'
                    ],
                    'password' => [
                        'required' => true,
                        'min' => 6
                    ],
                    'passwordConfirmation' => [
                        'required' => true,
                        'matches' => 'password'
                    ]
                ]);
                if (!$validation->passed()) {
                    foreach ($validation->errors() as $error) {
                        echo  "<p class='text-sm text-red-500'>{$error} </p>";
                    }
                } else {
                    $user = new User();


                    try {
                        $user->create([
                            'firstname' => Input::get('firstname'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'password' => Hash::make(Input::get('password'))
                        ]);

                        Session::flash('registerSuccess' , 'You have been registered and can now log in!');
                        Redirect::to('login.php');

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
            }
        }

        ?>
        <div class="w-full text-white bg-red-500 my-4">

        </div>
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Register</h2>

        <form action="" method="post">
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="firstname">First Name</label>
                    <input id="firstname" type="text" name="firstname" value="<?php echo escape(Input::get('firstname')) ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="lastname">Last Name</label>
                    <input id="lastname" type="text" name="lastname" value="<?php echo escape(Input::get('lastname')) ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="username">Username</label>
                    <input id="username" type="text" name="username" value="<?php echo escape(Input::get('username')) ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="password">Password</label>
                    <input id="password" type="password" name="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="passwordConfirmation">Password Confirmation</label>
                    <input id="passwordConfirmation" type="password" name="passwordConfirmation" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>
                <div>
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Register</button>
            </div>
        </form>
    </section>
</body>

</html>