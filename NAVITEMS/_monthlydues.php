<div class="container">

    <section data-aos="fade-down" data-aos-duration="3000">
        <h4 class="mt-4"><span class="bi-cash-stack"></span>
            <?php echo $title;?></h4>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="card-body">
                    <?php
                            $db = new Database();
                            $qry = mysqli_query($db->conn, "SELECT *,date_format(DateCreated, '%M %e, %Y [%r]') as DateCreateds from monthlydues");
                            while ($row = $qry->fetch_assoc()) :
                        ?>
                    <div class="card mb-2">

                        <div class="col-md-12">
                            <div class="card-body">
                                <p class="card-text"><small class="text-muted">Posted by:
                                        <?php echo $row['CreatedBy']?></small>
                                </p>
                                <h5 class="card-title"><?php echo $row['Title'] ?></h5>
                                <p class="card-text"><?php echo $row['Details'] ?>
                                </p>
                            </div>
                            <div class="card-footer text-muted">
                                <?php echo $row['DateCreateds']?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>


                </div>

            </div>
        </div>

        <!--
        <div>
            <textarea id="tiny"></textarea>
        </div>-->
    </section>
</div>