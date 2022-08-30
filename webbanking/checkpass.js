var script = document.createElement('script');

script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
document.getElementsByTagName('head')[0].appendChild(script);

$(document).ready(function(){

  var reg = /^S*(?=\S*[\W])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;

  $('input[type="button"]').click(function() {
    if($("input[type=password]").val().length<8) {
        alert('Password should be at least 8 characters');
    }
    else if (reg.test($("input[type=password]").val())==false) {
        alert('Password should have at least a capital letter,a small letter,digit and special symbol');
    }
     else {
        $('form').submit();
    }
    });

});
