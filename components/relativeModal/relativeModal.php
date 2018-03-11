<link rel='stylesheet' href='/tenderoots/components/relativeModal/relativeModal.css'>
<script src="/tenderoots/components/relativeModal/relativeModal.js"></script>
<!-- Modal -->
<div id="relativeModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Relative</h5>
          <button type="button" class="close" onclick="closeRelativeModal();" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form id="relativeForm">
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="firstName">First Name*</label>
              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name">
              <small id="firstNameHelp" class="form-text text-muted">Only enter the first name (no spaces).</small>
            </div>
            <div class="form-group col-sm-6">
              <label for="lastName">Last Name*</label>
              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name">
              <small id="lastNameHelp" class="form-text text-muted">Only enter the last name (no spaces).</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-12">
              <label for="middleNames">Middle Names</label>
              <input type="text" class="form-control" id="middleNames" name="middleNames" placeholder="Enter All Middle Names">
              <small id="middleNameHelp" class="form-text text-muted">Enter all middle names.</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="birthday">Birthday</label>
              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="mm/dd/yyyy">
              <small id="birthdayHelp" class="form-text text-muted">Format: mm/dd/yyyy</small>
            </div>
            <div class="form-group col-sm-6">
              <label for="deathDate">Death Date</label>
              <input type="date" class="form-control" id="deathDate" name="deathDate" placeholder="mm/dd/yyyy">
              <small id="deathDateHelp" class="form-text text-muted">Format: mm/dd/yyyy</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-12">
              <label for="bio">Biography</label>
              <textarea class="form-control" id="bio" name="bio" rows="5" maxlength="500"></textarea>
              <small id="bioHelp" class="form-text text-muted">Used <span id='charCount'>0</span> out of 500 characters.</small>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-12">
              <label for="profilePic">Profile Picture</label>
              <input type="file" class="form-control" id="profilePic" name="profilePic">
              <small id="profilePicHelp" class="form-text text-muted">Only gif, png, and jpg file types are allowed.</small>
            </div>
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button id="submitButton" class="btn btn-success" onclick="addRelative()">Add Relative</button>
          <button type="button" class="btn btn-secondary" onclick="closeRelativeModal();">Close</button>
        </div>
      </div>
    </div>
</div>