<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Users";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT * FROM accounts a INNER JOIN profiles p ON p.aid = a.aid ORDER BY a.aid DESC');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Users</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <div class="h-full w-full bg-gray-200 overflow-scroll border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Full Name</th>
                <th class="p-1 lg:p-3">Username</th>
                <th class="p-1 lg:p-3">Bio</th>
                <th class="p-1 lg:p-3">Email</th>
                <th class="p-1 lg:p-3">Phone #</th>
                <th class="p-1 lg:p-3">Address</th>
                <th class="p-1 lg:p-3">Gender</th>
                <th class="p-1 lg:p-3">Role</th>
                <th class="p-1 lg:p-3">Birthdate</th>
                <th class="p-1 lg:p-3">Created</th>
                <th class="p-1 lg:p-3">Updated</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr class="text-center border border-b-gray-400 even:bg-gray-300">
                        <td class="p-1 lg:p-3"><?= $user['aid'] ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['fullname']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['bio']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['phone']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['address']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['gender']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['role']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['birthdate']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['createDateTime']) ?></td>
                        <td class="p-1 lg:p-3"><?= htmlspecialchars($user['updateDateTime']) ?></td>
                        <td>
                            <div class="flex flex-col gap-2">
                                <a href="users/edit.php?aid=<?= $user['aid'];?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Edit</a>
                                <form action="../processors/users/delete.php" method="POST" class="flex">
                                    <button type="submit" name="delete" value="<?= $user['aid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                                </form>
                            </div>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="users/add.php" class="w-fit py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Admin/Employee</a>
</main>
<?php include('templates/foot.php'); ?>