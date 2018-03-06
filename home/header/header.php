<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#/home" onclick="loadPage(this.href)">
    <img src="/tenderoots/assets/images/roots-white-logo.png" width="30" height="30" alt="">
    Tenderoots
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#/home" onclick="loadPage(this.href)">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#/feed" onclick="loadPage(this.href)">Feed</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#/friends" onclick="loadPage(this.href)">Friends</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#/family" onclick="loadPage(this.href)">Family</a>
      </li>
    </ul>
      <span id='greeting'>Hi <?php echo $_SESSION['firstName']; ?>!</span>
      <button class="btn btn-primary my-2 my-sm-0" onclick="signOut();">Sign Out</button>
  </div>
</nav>