document.getElementById('searchButton').addEventListener('click', function() {
  let query = document.getElementById('searchInput').value;
  alert('You searched for: ' + query);
});

document.getElementById('button1').addEventListener('click', function() {
  alert('Should return to home page');
});

document.getElementById('button2').addEventListener('click', function() {
  alert('Should send to about page');
});

document.getElementById('button3').addEventListener('click', function() {
  //alert('Should send to credits');
  if (!event.target.matches(#button3"))
    return;
  fetch("credits.html);
});

document.getElementById('button4').addEventListener('click', function() {
  alert('Should send to contact info');
});
