(function() {
    'use strict';
  
    var app = {
      spinner: document.querySelector('.loader')
    };
  
    var container = document.querySelector('.container');
  
  
    // Get Commit Data from Github API
    function fetchCommits() {
      var url = 'https://api.github.com/repos/PrinMeshia/persona/commits';
  
      fetch(url)
      .then(function(fetchResponse){ 
        return fetchResponse.json();
      })
      .then(function(response) {
        var test = 0;
        response.forEach(function(entry) {
          test++;
           var commitdiv = document.createElement('section');
          commitdiv.classList.add('card-half');
          if(test % 5 == 0)
            commitdiv.classList.add('wide');
          var msg =  "<div class='card-img'><img src='/approot/rsc/img/github.jpg' alt='img'></div>"+
          "<div class='card-text'><h4> Author: " + entry.commit.author.name + "</h4>" +
          "<p> Message: " + entry.commit.message + "<br/>" +
          "Time committed: " + (new Date(entry.commit.author.date)).toUTCString() +  "</p></div>"+
          "<ul class='card-tools'><li class='tools-item'></li><li class='tools-item'><span><a href='" + entry.html_url + "'>Click me to see more!</a></span></li></ul>"
          ;
          commitdiv.innerHTML = msg;
  
              container.appendChild(commitdiv);
        });
  
  
          app.spinner.setAttribute('hidden', true); //hide spinner
        })
        .catch(function (error) {
          console.error(error);
        });
    };
  
    fetchCommits();
  })();
