
<div class="h-full flex fixed lg:static">
    <nav id="navbar" class="h-full w-fit flex flex-col justify-between bg-white shadow-xl hidden lg:flex">
        <header class="p-3 text-center bg-red-600 rounded-b-3xl shadow-xl">
            <h1 class="m-3 p-3 text-xl font-bold text-red-600 bg-white rounded-3xl">Control Panel</h1>
        </header>
        <ul class="p-3 flex flex-col text-red-600">
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Dashboard</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Toys</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Users</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Sales</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Reports</a>
        </ul>
        <div class="p-3 flex flex-col gap-3 bg-red-600 rounded-t-xl shadow-xl">
            <div class="p-3 flex bg-white rounded-3xl gap-5">
                <img src="" alt="profile picture" class="w-28 h-28 bg-gray-300 rounded-full">
                <div class="flex flex-col justify-center">
                    <a href="">Name</a>
                    <p>email@email.com</p>
                </div>
            </div>
            <div class="p-3 flex flex-col bg-white rounded-3xl">
                <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Main Site</a>
                <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Settings</a>
                <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Logout</a>
            </div>
        </div>
    </nav>
    <div id="showBar" class="py-2 px-2 h-fit w-fit flex item-center justify-center text-xl bg-red-500 rounded-r-xl cursor-pointer lg:hidden">
        >
    </div>
</div>

<script src="../../scripts/adminNavbarScript.js"></script>