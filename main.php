<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?> - Barangay Victoria Tayo</title>
    <link rel="icon" type="image/x-icon" href="IMG/baranggay-victoria.png">
    <!--FROM BOOTSTRAP 5.2.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!--FOR CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="CSS/mystyle.css?v=<?php echo time(); ?>">


    <!--FOR AOS CSS ANIMATION -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!--FOR FONT AWESOME -->
    <link rel="stylesheet" type="text/css" href="CSS/fontawesome/css/all/min.css">

    <!--FROM BOOTSTRAP DATATABLE -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!--SWEET ALERT -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!--JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body class="<?php echo isset($bodyClass) ? htmlspecialchars($bodyClass) : ''; ?>">

    <div>
        <?php include 'navigation.php'; ?>
    </div>
    <div class="forcontent">
        <div class="mt-3">
            <?php require_once $content; ?>
        </div>
    </div>
    <div class="push"></div>


    <?php include 'footer.php'; ?>


    <section>
        <button type="button" class="btn btn-default btn-md" id="btn-back-to-top">
            <i class="bi-arrow-up"></i>
        </button>
    </section>
    <!--FROM BOOTSTRAP 5.2.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <!--FOR CUSTOM JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!--FOR CUSTOM JS -->
    <script src="JS/myjs.js"></script>


    <!--FOR TINYMCE TEXT EDITOR -->
    <script src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="JS/init-tinymce.min.js"></script>

    <!--FOR CK TEXT EDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/super-build/ckeditor.js"></script>
    <script src="JS/ckeditor.min.js"></script>

    <!--FOR DATATABLE -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
    AOS.init();
    </script>

</body>

</html>