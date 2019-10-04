<nav id="sidebar">
    <div class="sidebar-header">
        <h3>WebMessenger</h3>
        <h6>You are logged as: <?= $_SESSION['username'] ?></h6>
    </div>

    <ul class="list-unstyled components">

        <li>
            <a href="home.php">Home</a>
        </li>

        <li>
            <a href="inbox.php">Inbox</a>
        </li>
        <li>
            <a href="newMessage.php">Nouveau message</a>
        </li>
        <?php
        if ($_SESSION['isAdmin']){
            echo "<li>";
            echo "<a href=\"admin.php\">Admin</a>";
            echo "</li>";
        }
        ?>
        <li>
            <a href="logout.php">Déconnexion</a>
        </li>
    </ul>

</nav>