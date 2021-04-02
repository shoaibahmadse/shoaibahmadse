<?php
include "layout/header.php";
$dealsIdSql = "SELECT * FROM category WHERE category='Deals'";
$dealsIdRes = mysqli_query($conn, $dealsIdSql);
$dealsIdRow = mysqli_fetch_assoc($dealsIdRes);
$dealsId = $dealsIdRow['id'];

$dealsSql = "SELECT * FROM dish WHERE category_id=$dealsId";
$dealsRes = mysqli_query($conn, $dealsSql);

$sql = "SELECT * FROM site_details WHERE id=1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
?>
<main class="relative bg-orange main-frontpage">
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0&appId=273403943980488&autoLogAppEvents=1" nonce="iwY1V52U"></script>

  <div class="fancy-font absolute ml-3 top-0 mt-16 sm:mt-40 md:mt-32 lg:mt-64">
    <h1 class="text-white text-2xl sm:text-5xl md:text-6xl font-bold">
      Luxurious and Exquisite Dining
    </h1>
    <div class="mt-6 sm:ml-3 cursor-pointer">
      <a href="category.php" class="bg-yellow-400 transition-colors transition duration-150 hover:bg-yellow-600 text-black text-sm sm:text-lg sm:py-2 sm:px-4 font-bold mr-3 py-1 px-2 rounded-full">
        Browse Categories
      </a>
      <a href="menu.php" class="border cursor-pointer transition-colors transition duration-150 border-yellow-600 hover:bg-yellow-600 text-white text-sm sm:text-lg sm:py-2 sm:px-4 font-bold py-1 px-2 rounded-full">
        Menu
      </a>
    </div>
  </div>
  <img src="assets/hero-full.jpg" alt="" />

  <section>
    <article>
      <div data-aos="zoom-out-down" data-aos-duration="1500" class="font-extrabold sm:text-3xl shadow-xl text-2xl md:text-5xl m-6 fancy-font">
        <h1 class="text-center tracking-wider bg-yellow-300 p-2">Order Now or Visit us for Dine-In</h1>
      </div>
      <div data-aos="fade-right" data-aos-duration="1500" class="text-center text-xl p-2 m-2">
        <p class="leading-loose">We are open until 12:00 AM. You can Dine-In or order food for Takeaway</p>
        <p>We are also available for Delivery. Just Call us at <?php echo $row['phone_contact'] ?></p>
        <p class="leading-normal my-5">We are located at Satayana Road, near Allied Bank
          <br>Faisalabad, Punjab
        </p>
        <div class="mx-4">
          <h1 class="text-4xl">Our Location:</h1>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d425.70074239097903!2d73.11161987128092!3d31.39742744426485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3922673e9522eff1%3A0x8624e29a0ef0b24e!2sCafe%20Pyala!5e0!3m2!1sen!2s!4v1601358065617!5m2!1sen!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
      <!-- <a href="https://www.foodpanda.pk/restaurant/n6zl/cafe-pyala#"></a> -->
    </article>
  </section>
  <section class="my-4 flex w-full">
    <article class="w-full text-center">
      <div data-aos="zoom-out-down" data-aos-duration="1500" class="font-extrabold sm:text-3xl shadow-xl text-2xl md:text-5xl m-6 fancy-font">
        <h1 class="text-center tracking-wider bg-yellow-300 p-2">Visit Our Facebook Page</h1>
      </div>
      <div class="w-full mx-auto">
        <div class="fb-page desktop" data-href="https://www.facebook.com/cafepyalafsd/" data-tabs="timeline" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
          <blockquote cite="https://www.facebook.com/cafepyalafsd/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cafepyalafsd/">Cafe Pyala</a></blockquote>
        </div>
        <div class="fb-page mobile" data-href="https://www.facebook.com/cafepyalafsd/" data-tabs="timeline" data-width="250" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
          <blockquote cite="https://www.facebook.com/AUAW-with-cousins-1585210981740306/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/AUAW-with-cousins-1585210981740306/">AUAW with cousins</a></blockquote>
        </div>
      </div>
    </article>
  </section>
  <div data-aos="zoom-out-down" data-aos-duration="1500" class="font-extrabold sm:text-3xl shadow-xl text-2xl md:text-5xl m-6 fancy-font">
    <h1 class="text-center tracking-wider bg-yellow-300 p-2">HOT DEALS RIGHT NOW!!!</h1>
  </div>
  <section data-aos="zoom-in-right" data-aos-duration="1500" class="deals-section text-center p-2">
    <?php
    while ($dealsRow = mysqli_fetch_assoc($dealsRes)) {
    ?>
      <article class="deal-card m-3 bg-white shadow-lg hover:shadow-2xl rounded-t-lg">
        <div class="deal-img-container">
          <img class="inline w-full h-full deal-img rounded-t-lg" src="<?php echo SITE_DISH_IMAGE . $dealsRow['image'] ?>" alt="<?php echo $dealsRow['dish'] ?>">
        </div>
        <div class="disc border-t-2 border-black">
          <h2 class="fancy-font text-md md:text-lg font-bold text-left p-2"><?php echo $dealsRow['dish'] ?></h2>
          <p class="p-2 text-left text-sm">
            <?php echo $dealsRow['dish_detail'] ?>
          </p>
        </div>
        <div class="price-select m-1">
          <select name="" id="" class="w-full rounded-md bg-gray-400 text-lg p-1">
            <?php
            $dish_id = $dealsRow['id'];
            $dish_attr_sql = "SELECT * FROM dish_details WHERE dish_id='$dish_id' ORDER BY price ASC";
            $dish_attr_res = mysqli_query($conn, $dish_attr_sql);
            while ($dish_attr_row = mysqli_fetch_assoc($dish_attr_res)) {
            ?>
              <option value="<?php echo $dish_attr_row['attribute'] ?>"><?php echo $dish_attr_row['attribute'];
                                                                        echo ' ' . $dish_attr_row['price'] ?></option>
            <?php
            }
            ?>
          </select>
        </div>
      </article>
    <?php
    }
    ?>
  </section>
</main>
<?php
include "layout/footer.php";
?>