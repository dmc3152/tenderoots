<link rel='stylesheet' href='./family/family.css'>
<script src="./family/family.js"></script>
<div class="row family">
  <div class="col-sm-12">
    <h1>Family</h1>
    <div class="row">

      <div class='col-sm-4 offset-sm-1'>
        <div id="fathers" class="list-group">
          <li class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 mt-1">Father(s)</h5>
              <button class="btn btn-sm btn-success" onclick="openRelativeModal('fathers')"><i class="fa fa-plus"></i></button>
            </div>
          </li>
        </div>
      </div>

      <div class='col-sm-4 offset-sm-2'>
        <div id="mothers" class="list-group">
          <li class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 mt-1">Mother(s)</h5>
              <button class="btn btn-sm btn-success" onclick="openRelativeModal('mothers')"><i class="fa fa-plus"></i></button>
            </div>
          </li>
        </div>
      </div>

    </div>
    <div class="spacer"></div>
    <div class="row">

      <div id="me" class='col-sm-4 offset-sm-4'>
        <img src="/tenderoots/assets/profilePics/test-1.jpg">
        <h4>My Name</h4>
      </div>

      <div class='col-sm-4'>
        <div id="spouses" class="list-group">
          <li class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 mt-1">Spouse(s)</h5>
              <button class="btn btn-sm btn-success" onclick="openRelativeModal('spouses')"><i class="fa fa-plus"></i></button>
            </div>
          </li>
        </div>
      </div>

    </div>
    <div class="spacer"></div>
    <div class="row">

      <div class='col-sm-4 offset-sm-4'>
        <div id="children" class="list-group">
          <li class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 mt-1">Children</h5>
              <button class="btn btn-sm btn-success" onclick="openRelativeModal('children')"><i class="fa fa-plus"></i></button>
            </div>
          </li>
        </div>
      </div>

    </div>
  </div>
</div>
<?php //include_once($_SERVER['DOCUMENT_ROOT'] . '/tenderoots/components/relativeModal/relativeModal.php'); ?>

