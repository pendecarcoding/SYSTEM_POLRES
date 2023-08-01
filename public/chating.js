function send(){
        var to = $('#to').val();
        var message = $('#message').val();
        var sess = $('#session').val();;

    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $("#send_form").html("Sending");
    $.ajax({
      //alert('dfdfdf');
        type: "POST",
        url: "https://skp.bengkaliskab.go.id/chat/send",
        data: {to:to,message:message,sess:sess},
        success: function () {
///alert('form was submitted');
$('#message').val('');
$("#send_form").html("Send");
$('#message').focus();

}
    });
  // alert("Submitted");
  }
function loadDoc(url,session) {
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("chats").innerHTML = this.responseText;
      var auto_refresh = setInterval(
          function () {
              $('#pesan'+session).load("{{url('chat/fetch')}}/"+session).fadeIn("slow");
          }, 1000); // refresh setiap 10000 milliseconds

    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}
function hide()
{
  document.getElementById('ch').style="display:none";
}
