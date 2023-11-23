<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Course');
define('PAGE', 'courses');
include('./tutorInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_tutor_login'])){
  $tutorEmail = $_SESSION['tutorLogEmail'];
 }
  // else {
//   echo "<script> location.href='../index.php'; </script>";
//  }
 if(isset($_REQUEST['courseSubmitBtn'])){
  // Checking for Empty Fields
  if(($_REQUEST['course_name'] == "") || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "") || ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "") || ($_REQUEST['course_original_price'] == "")){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   $tutorEmail = $_SESSION['email'];
   $course_name = $_REQUEST['course_name'];
   $course_desc = $_REQUEST['course_desc'];
   $course_author = $_REQUEST['course_author'];
   $course_duration = $_REQUEST['course_duration'];
   $course_price = abs($_REQUEST['course_price']);
   $course_original_price = abs($_REQUEST['course_original_price']);
   $course_image = $_FILES['course_img']['name']; 
   $course_image_temp = $_FILES['course_img']['tmp_name'];
   $img_folder = '../image/courseimg/'. $course_image; 
   move_uploaded_file($course_image_temp, $img_folder);
    $sql = "INSERT INTO course (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price, t_Email, status) VALUES ('$course_name', '$course_desc','$course_author', '$img_folder', '$course_duration', '$course_price', '$course_original_price','$tutorEmail','Pending')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Your request is under process! </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Course </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Course</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="course_name">Course Name</label>
      <input type="text" class="form-control" id="course_name" name="course_name">
    </div>
    <div class="form-group">
      <label for="course_desc">Course Description</label>
      <textarea class="form-control" id="course_desc" name="course_desc" row=2></textarea>
    </div>
    <div class="form-group">
      <label for="course_author">Author</label>
      <input type="text" class="form-control" id="course_author" name="course_author">
    </div>
    <div class="form-group">
      <label for="course_duration">Course Duration</label>
      <input type="text" class="form-control" id="course_duration" name="course_duration">
    </div>
    <div class="form-group">
      <label for="course_original_price">Course Original Price</label>
      <input type="text" class="form-control" id="course_original_price" name="course_original_price" onkeypress="isInputNumber(event)">
    </div>
    <div class="form-group">
      <label for="course_price">Course Selling Price</label>
      <input type="text" class="form-control" id="course_price" name="course_price" onkeypress="isInputNumber(event)">
    </div>
    <div class="form-group">
      <label for="course_img">Course Image</label>
      <input type="file" class="form-control-file" id="course_img" name="course_img">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="courseSubmitBtn" name="courseSubmitBtn">Submit</button>
      <a href="courses.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }
</script>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("courseSubmitBtn").addEventListener("click", function (event) {
      var courseName = document.getElementById("course_name").value.trim();
      var courseDesc = document.getElementById("course_desc").value.trim();
      var courseAuthor = document.getElementById("course_author").value.trim();
      var courseDuration = document.getElementById("course_duration").value.trim();
      var courseOriginalPrice = document.getElementById("course_original_price").value.trim();
      var coursePrice = document.getElementById("course_price").value.trim();
      var courseImg = document.getElementById("course_img").value.trim();

      var nameRegex = /^[A-Za-z][A-Za-z\s]*$/;
      var descRegex = /^[A-Za-z]/;
      var authorRegex = /^[A-Za-z]+(\s[A-Za-z]+)*$/;
      var durationRegex = /^\d+\s*(months|weeks|years)$/i;
      var priceRegex = /^\d+(\.\d+)?$/;
      var imgRegex = /\.(jpg|jpeg|png|dng)$/i;

      var isValid = true;

      if (!nameRegex.test(courseName)) {
        displayErrorMessage("course_name", "Course name only contains ");
        isValid = false;
      }

      if (!descRegex.test(courseDesc)) {
        displayErrorMessage("course_desc", "Course description only contains english alphabets.");
        isValid = false;
      }

      if (!authorRegex.test(courseAuthor)) {
        displayErrorMessage("course_author", "Author name format does not match");
        isValid = false;
      }

      if (!durationRegex.test(courseDuration)) {
        displayErrorMessage("course_duration", "Duration format does not match. eg: 2 Months/Weeks");
        isValid = false;
      }

      if (!priceRegex.test(courseOriginalPrice) || !priceRegex.test(coursePrice)) {
        displayErrorMessage("course_original_price", "Course price must be a positive number.");
        displayErrorMessage("course_price", "Course selling price must be a positive number.");
        isValid = false;
      }

      if (!imgRegex.test(courseImg)) {
        displayErrorMessage("course_img", "Invalid image format. Supported formats: jpg, jpeg, png, dng.");
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });

    function displayErrorMessage(elementId, message) {
      var errorMessage = document.getElementById(elementId + "_error");
      if (errorMessage === null) {
        errorMessage = document.createElement("div");
        errorMessage.className = "alert alert-danger mt-2";
        errorMessage.id = elementId + "_error";
        document.getElementById(elementId).parentNode.appendChild(errorMessage);
      }
      errorMessage.innerHTML = message;
    }
  });
</script>
<?php
include('./tutorInclude/footer.php'); 
?>