<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Upload Background Image <small>Creative!</small></h3>
  </div>
  <div class="panel-body">
    <form id="file-upload-form" class="uploader" action="upload_img_process.php" method="POST" enctype="multipart/form-data">
      <input id="file-upload" type="file" name="fileUpload" accept="image/*" />

      <label for="file-upload" id="file-drag">
        <img id="file-image" src="#" alt="Preview" class="hidden">
        <div id="start">
          <i class="fa fa-download" aria-hidden="true"></i>
          <div>Select a file or drag here</div>
          <div id="notimage" class="hidden">Please select an image</div>
          <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
        </div>
        <div id="response" class="hidden">
          <div id="messages"></div>
          <progress class="progress" id="file-progress" value="0">
            <span>0</span>%
          </progress>
        </div>
      </label>
      <button type="submit" name="button" class="btn btn-default">SAVE</button>
    </form>
  </div>
</div>
<script src="js/fileupload.js"></script>
