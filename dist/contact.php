<?php 
    include "layout/header.php";
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
    }
    if(isset($_GET['error'])) {
        if($_GET['error'] == 'empty-field'){
            $response = 'Please Fill All Fields';
        } else if($_GET['error'] == 'invalid-email') {
            $response = 'Please Write a Valid Email';
        } else if($_GET['error'] == 'invalid-number') {
            $response = 'Please Write a Valid Phone Number';
        } else {
            $response = '';
        }
    } else if(isset($_GET['status'])) {
        if($_GET['status'] == 'success') {
            $response = "Sent Successfully!";
        } else if($_GET['status'] == 'fail') {
            $response = "Some Error occurred, try again later";
        } else {
            $response = '';
        }
    } 
    $sql = "SELECT * FROM site_details WHERE id=1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
?>
<main class="general-font">
    <section class="m-4 p-2">
        <div class="mx-4 my-2">    
            <h1 class="text-2xl mt-3">Order Now by Calling or Visting Us!</h1>
            <h2>Contact Number: <a href="tel:<?php echo $row['phone_contact'] ?>"><?php echo $row['phone_contact'] ?></a></h2>
            <div class="container">
            <div class="lg:w-2/3 flex flex-col sm:flex-row sm:items-center items-start">
                <h1 class="flex-grow sm:pr-16 text-2xl font-medium title-font text-gray-900">Order Through WhatsApp</h1>
                <button class="flex-shrink-0 text-white bg-orange-500 border-0 py-2 px-8 focus:outline-none hover:bg-orange-600 rounded text-lg mt-10 sm:mt-0">Order Now</button>
            </div>
        </div>
            
        </div>
        <div class="my-2">
            <div class="mx-4">
                <h1 class="text-4xl">Our Location:</h1>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d425.70074239097903!2d73.11161987128092!3d31.39742744426485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3922673e9522eff1%3A0x8624e29a0ef0b24e!2sCafe%20Pyala!5e0!3m2!1sen!2s!4v1601358065617!5m2!1sen!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>        
            </div>
        </div>
    </section>
    <section class="text-gray-700 body-font relative">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Contact Us</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Any Complaints, Feedback or Suggestion, just write it here</p>
            </div>
            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                <form action="includes/contact.inc.php" method="post" class="flex flex-wrap -m-2">    
                    
                    <div class="p-2 w-1/2">
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-orange-500 text-base px-4 py-2" placeholder="Name" type="text" name="name">
                    </div>
                    <div class="p-2 w-1/2">
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-orange-500 text-base px-4 py-2" placeholder="Email" type="email" name="email">
                    </div>
                    <div class="p-2 w-full">
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-orange-500 text-base px-4 py-2" placeholder="Phone Number" type="number" name="phone">
                    </div>
                    <div class="p-2 w-full">
                        <textarea class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none h-48 focus:border-orange-500 text-base px-4 py-2 resize-none block" placeholder="Message" name="message"><?php if(isset($msg) && $msg != ''){ echo $msg ;}?></textarea>
                    </div>
                    <div class="p-2 w-full">
                        <input class="flex mx-auto text-white bg-orange-500 border-0 py-2 px-8 focus:outline-none hover:bg-orange-600 rounded text-lg" type="submit" name="submit"></input>
                    </div>
                    <?php 
                        if(isset($response) && $response != '') {
                            echo $response;
                        }
                    ?>
                </form>        
                <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center">
                    <a class="text-orange-500" href="tel: <?php echo $row['phone_contact'] ?>"><?php echo $row['phone_contact'] ?></a><br>
                    <a class="text-orange-500" href="mailto: <?php echo $row['email_contact'] ?>"><?php echo $row['email_contact'] ?></a>
                    <p class="leading-normal my-5">Satayana Road Cafe Pyala, near Allied Bank
                        <br>Faisalabad, Punjab
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>
<?php 
    include "layout/footer.php";
?> 