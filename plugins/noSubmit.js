

$olympiad_query = "SELECT * FROM achievements WHERE user_id = $session_id AND type = 'Олимпиада' ORDER BY achievement_id DESC";
$olympiads = mysqli_query($mysqli, $olympiad_query);

foreach ($olympiads as $olympiad) {
$('form').submit(function(e){
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "my_portolio.php",   
      datatype: "text",
      data: {enter : $("#enter").val() },
      success: function(data) {
        console.log(data);
      }
    });
});