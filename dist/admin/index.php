<?php
  include_once "layout/header.php";
  $sql = 'SELECT * FROM site_details';
  $res = mysqli_query($conn, $sql);
?>
<main class="sm:ml-48 mx-3 sm:mr-6 mt-4 relative">
  <div class="bg-white p-5 shadow-lg w-full">
      <p class="text-center text-2xl md:text-3xl font-extrabold m-2">Site Details</p>
  </div>
  <div class="my-4 p-2 shadow-lg table-responsive bg-white">
    <table 
            id="table-main" 
            data-toggle="table"
            data-pagination="true"
            data-search="true"
            class="table text-sm sm:text-lg p-2"
        >

            <thead class="thead-dark">
            <tr class="m-2 p-2 border-b-2 font-bold">
                <th data-field="id">ID</th>
                <th data-field="phone">Contact Phone</th>
                <th data-field="email">Contact Email</th>
                <th data-field="image">Menu Img</th>
                <th data-field="actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $i = 1;
                if(mysqli_num_rows($res) > 0) { 
                    while($row = mysqli_fetch_assoc($res)){
                        
            ?>
            <tr class="leading-9">
                <td class="text-center p-2"><?php echo $i ?></td>
                <td class="text-center p-2" id="row-name"><?php echo $row['phone_contact'] ?></td>
                <td class="text-center p-3"><?php echo $row['email_contact'] ?></td>
                <td class="text-center p-2" id="row-name">
                    <a class="text-center" href="<?php echo SITE_MENU_IMAGE.$row['menu_image']?>" target="_blank">
                        <img class="w-full rounded-md img-showcase" src="<?php echo SITE_MENU_IMAGE.$row['menu_image']?>">
                    </a>
                </td>
                <td class="text-center">
                    <span class="mr-2 p-1 text-orange-400 hover:text-orange-500">
                        <a href='editDetails.php?id=<?php echo $row['id']?>'>
                            <i class="fas fa-edit fa-2x"></i>
                        </a>
                    </span>
                </div>        
                </td>
                    
            </tr>
            <?php 
                    $i++;
                    }
                }
                else{ ?>
            
                <td colspan="4" class="text-center">No data found</td>
            <?php
                }
            ?>
            </tbody>
        </table>
  </div>
</main>

<?php
  include_once "layout/footer.php";
?>