function ParseURI(url) {
    var u = new URLSearchParams(url);
    for(let p of u) {
        console.log(p);
    }
}

function isLiked(pid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("liked").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "../../blogon/api/liked.php?post_id=" + pid, true);
    xhttp.send();
}

function isLikedR(pid) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("rlike").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../../blogon/api/liked.php?post_id=" + pid, true);
  xhttp.send();
}


function like(pid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      }
    };
    xhttp.open("GET", "../../blogon/api/like.php?post_id=" + pid, true);
    xhttp.send();
}

function dislike(pid) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      }
    };
    xhttp.open("GET", "../../blogon/api/dislike.php?post_id=" + pid, true);
    xhttp.send();
}

// working code in head.php file
// function searchD() {
//   var wild = document.getElementById("search_input").value;
//   var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//       if (this.readyState == 4 && this.status == 200) {
//         document.getElementById("sug").innerHTML = this.responseText; 
//       }
//     };
//     xhttp.open("GET", "../../blogon/api/search.php?wild=" + wild, true);
//     xhttp.send();
// }

function loadComments(pid) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("comms").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../../blogon/api/comments.php?pid=" + pid, true);
  xhttp.send();
}