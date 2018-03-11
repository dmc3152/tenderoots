<!-- Modal -->
<div id="replyModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reply</h5>
          <button type="button" class="close" onclick="closeReply();" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea name='replyText' autofocus></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="submitReply();">Reply</button>
          <button type="button" class="btn btn-secondary" onclick="closeReply();">Close</button>
        </div>
      </div>
    </div>
</div>