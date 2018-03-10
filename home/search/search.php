<link rel='stylesheet' href='./search/search.css'>
<script src='./search/search.js'></script>
<div class="row">
  <div class="col-sm-12">
    <h1>Search</h1>
    <form id="searchForm">
      <div class="form-group">
        <label for="searchInput">Search Users</label>
        <input type="text" class="form-control" id="searchInput" name='searchInput' placeholder="Enter name">
        <small id="searchHelp" class="form-text text-muted">Enter the name of the user you want to search for.</small>
      </div>
      <button class="btn btn-success">Search</button>
    </form>
    <h2 id='resultsHeader'></h2>
    <div id='results'></div>
  </div>
</div>