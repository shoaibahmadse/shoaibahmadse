<!-- Use PHP code to get social data form admin panel -->
<?php
$sql = "SELECT * FROM site_details WHERE id=1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
?>
<footer class="w-full black-bg text-white font-semibold">
  <div class="flex flex-col md:flex-row">
    <div class="mx-auto mt-6">
      <p class="md:text-lg text-center bg-gray-800 mb-5">About Web-Developer</p>
      <a class="underline" href="about.php">Learn About Developer</a>
      <div class="p-2 mx-auto text-centre">
        <a class="underline" href="https://auaboi.github.io/auaahsan/dist/">Portfolio</a>
      </div>
    </div>
    <div class="mx-auto mt-6 align-middle text-center">
      <p class="md:text-lg bg-gray-800">Our Social Media</p>
      <ul class="flex text-center mt-5">
        <li class="mx-auto text-center">
          <a class="md:text-4xl" href="https://www.facebook.com/cafepyalafsd/">
            <i class="fab fa-facebook text-center"></i>
          </a>
        </li>
        <li class="mx-auto text-center">
          <a class="md:text-4xl" href="#">
            <i class="fab fa-instagram text-center"></i>
          </a>
        </li>
        <li class="mx-auto text-center">
          <a class="md:text-4xl" href="https://api.whatsapp.com/send?phone=923011112965&text=&source=&data=&app_absent=">
            <i class="fab fa-whatsapp text-center"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="mx-auto mt-6 text-center">
      <p class="md:text-lg bg-gray-800">Contact Us</p>
      <ul>
        <li class="flex flex-col">
          <a class="md:text-4xl" href="mailto: <?php echo $row['email_contact'] ?>">
            <i class="fas fa-envelope"></i>
          </a>
          <span class="md:text-lg">
            <?php echo $row['email_contact'] ?>
          </span>
        </li>
        <li class="text-center flex flex-col">
          <a class="md:text-4xl" href="tel: <?php echo $row['phone_contact'] ?>">
            <i class="fas fa-phone 3x"></i>
          </a>
          <span class="md:text-lg">
            <?php echo $row['phone_contact'] ?>
          </span>
        </li>
      </ul>
    </div>
  </div>
  <div class="text-center md:text-xl p-3">
    <p>&copy 2020 Modern Cafe, Pakistan</p>
  </div>
</footer>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
  AOS.init()
</script>
<script src="js/utils.js"></script>
<script src="script.js"></script>
</body>

</html>