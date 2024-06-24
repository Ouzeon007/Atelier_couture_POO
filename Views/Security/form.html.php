<?php
use ond\AtelierCouturePoo\Core\Session;
$errors = [];
if (Session::get('errors')) {
    $errors = Session::get('errors');
}
?>
<div class=" items-center justify-center  bg-gray-200 dark:bg-gray-600">

    <div
        class="max-w-4xl mx-auto mt-52 items-center bg-white p-16 dark:bg-opacity-40 h-96 rounded-lg shadow-xl shadow-gray-500 dark:shadow-gray-800 dark:bg-gray-800  flex flex-row space-x-36 ">
        <div class="w-72">
            <div class=" flex justify-center items-center mb-6">
            <img  class="-mb-16 w-48 -mt-14" src="img/1-removebg-preview.png" alt="">
            </div>

            <h2 class="text-2xl font-bold mb-6 text-purple-900 dark:text-purple-400 text-center">Formulaire Connection
            </h2>
        </div>
        <div class="w-1/2 ">
            <div class="<?= add_classe_hidden('error_connexion') ?> p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800 flex items-center"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Attention! </span><?= $errors['error_connexion'] ?? "" ?>.
            </div>

            <form action="<?= WEBROOT ?>" method="post">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Login:</label>
                    <div class="flex items-center">
                        <svg class="w-[29px] h-[29px] mr-3 text-purple-800 dark:text-purple-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                        </svg>


                        <input id="login" type="text" name="login"
                            class="<?= add_classe_invalid('login') ?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400"
                            placeholder="email">
                    </div>
                    <div class="text-red-700 rounded relative" role="alert">
                        <strong class="font-bold"><?= $errors['login'] ?? "" ?></strong>
                    </div>

                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2 dark:text-gray-300">Password:</label>
                    <div class="flex items-center">
                        <svg class="w-[29px] h-[29px] mr-3 text-purple-800 dark:text-purple-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z" />
                        </svg>

                        <input id="password" type="password" name="password"
                            class="<?= add_classe_invalid('password') ?> w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 dark:bg-gray-800 text-gray-400"
                            placeholder="Mot de passe">
                    </div>
                    <div class="text-red-700 rounded relative " role="alert">
                        <strong class="font-bold"><?= $errors['password'] ?? "" ?></strong>
                    </div>

                </div>


                <div class="text-center">
                    <input type="hidden" name="controller" value="securite">
                    <input type="hidden" name="action" value="connexion">

                    <button
                        class="bg-purple-950 text-purple-400 border border-purple-400 border-b-4 font-medium overflow-hidden relative px-4 py-2 rounded-md hover:brightness-150 hover:border-t-4 hover:border-b active:opacity-75 outline-none duration-300 group">
                        <span
                            class="bg-purple-400 shadow-purple-400 absolute -top-[150%] left-0 inline-flex w-80 h-[5px] rounded-md opacity-50 group-hover:top-[150%] duration-500 shadow-[0_0_10px_10px_rgba(0,0,0,0.3)]"></span>
                        Se Connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
Session::remove('errors');
?>