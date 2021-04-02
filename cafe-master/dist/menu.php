<?php 
    include "layout/header.php";
    $sql = "SELECT * FROM site_details WHERE id=1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
?>
<main>
    <section>
        <img src="<?php echo SITE_MENU_IMAGE.$row['menu_image'] ?>" class="w-full h-full">
    </section>
</main>
<?php 
    include "layout/footer.php";
?>