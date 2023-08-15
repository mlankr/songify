<?php
    include_once("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">

    <?php
        $albumQuery = "SELECT * FROM albums ORDER BY RAND() LIMIT 10";
        $prepareQuery = $pdo->prepare($albumQuery);
        $prepareQuery->execute();

        $allRows = $prepareQuery->fetchAll();
        foreach ($allRows as $row) {
            echo "<div class='gridViewItem'>
                        <span role='link' tabindex='0' class='albumGrid browseAlbum' data-album-id='" . $row['id'] . "'>
                            <img src='" . $row['artworkPath'] . "' alt='Album image'>
                            <div class='gridViewInfo'>" . $row['title'] . "</div>
                        </span>
                </div>";
        }
    ?>
</div>