<?php
    session_start();
    require_once "./functions/database_functions.php";
    $conn = db_connect();

    $query = "SELECT * FROM publisher ORDER BY publisherid";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Can't retrieve data " . mysqli_error($conn);
        exit;
    }
    if(mysqli_num_rows($result) == 0){
        echo "Empty publisher ! Something wrong! check again";
        exit;
    }

    $title = "List Of Publishers";
    require "./template/header.php";
?>
<div class="container" style="background-image: url('images.jpg'); background-size: cover;">
    <h2 class="mt-5 mb-4">List of Publishers</h2>
    <ul class="list-group">
    <?php 
        while($row = mysqli_fetch_assoc($result)){
            $count = 0; 
            $query = "SELECT publisherid FROM books";
            $result2 = mysqli_query($conn, $query);
            if(!$result2){
                echo "Can't retrieve data " . mysqli_error($conn);
                exit;
            }
            while ($pubInBook = mysqli_fetch_assoc($result2)){
                if($pubInBook['publisherid'] == $row['publisherid']){
                    $count++;
                }
            }
    ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>
                <span class="badge badge-primary badge-pill"><?php echo $count; ?></span>
                <a href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>"><?php echo $row['publisher_name']; ?></a>
            </span>
        </li>
    <?php } ?>
        <li class="list-group-item">
            <a href="books.php">List full of books</a>
        </li>
    </ul>
</div>
<?php
    mysqli_close($conn);
    require "./template/footer.php";
?>
