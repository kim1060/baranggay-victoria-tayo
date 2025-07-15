<div class="container mb-5" data-aos="zoom-out-up">
    <div class="row mt-3">
        <h4><span class="bi-journal-check"></span> <?php echo $title;?></h4>
    </div>
    <hr>
    <div class="mt-3 mb-3">
        <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
            <?php
                $db = new Database();
                $qry = mysqli_query($db->conn, "SELECT * FROM transaction_type");
                while ($row = $qry->fetch_assoc()) :
                $Transaction = $row['Transaction'];
                $Path = $row['Path'];
                $Img = $row['Img'];
                $ModalID = $row['ModalID'];
            ?>
            <div class="col">
                <div class="card h-100">
                    <img src="IMG/<?php echo $Img ?>" style="width: 100%" class="card-img-top" alt="...">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title"><?php echo $Transaction?></h5>
                        <!-- <a href="<?php echo $Path ?>" class="btn btn-sm btn-outline-success">Select</a> -->

                        <?php 
                            if($_SESSION['IsVerified']==1)
                            {
                        ?>

                        <a href="index.php?view=<?php echo $ModalID ?>"><button type="button"
                                class="btn btn-sm btn-outline-primary btn-sm">Select</button></a>
                        <?php 
                            }
                            else
                            {
                        ?>

                        <a href="index.php?view=verification"><button type="button"
                                class="btn btn-sm btn-outline-primary btn-sm">Verify Your Account</button></a>
                        <?php 
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>


</div>