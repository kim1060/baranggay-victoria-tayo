var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}

//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

tinymce.init({
  selector: "textarea#tiny",
});

new DataTable("#example");

$(document).ready(function () {
  $("#example").DataTable();
});

$(document).on("click", ".delete_user", function() {
  var PlaceOrderID = $(this).data('id');
   alert(PlaceOrderID);
  // $.ajax({
  //     type: "POST",
  //     url: "delete_user.php",
  //     dataType: "text",
  //     data: {
  //         PlaceOrderID: PlaceOrderID
  //     },
  //     success: function(data) {
  //         //  alert('Item Removed!');
  //         swal({
  //             title: "Command Executed!",
  //             text: "The record has been deleted.",
  //             type: "info",
  //             showConfirmButton: false,
  //             timer: 3000
  //         }, function() {
  //             //window.location.href = "index.php?view=questionlist";
  //             document.location.reload(true)
  //         });
  //     },
  //     error: function(result) {
  //         //alert('error');
  //     }
  // });

  
});

