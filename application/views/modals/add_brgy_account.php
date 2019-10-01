  	<!--modal for adding found_item -->
	<div class="modal fade bd-example-modal-lg " id="found_item_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">
        <i class="icon-user-plus success"></i>&nbsp;
        New Barangay Account
        </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<?php echo form_open_multipart('dashboard_controller/newbrgyuser'); ?>
        <div class="form-group">
          
          <label for="f_name">First Name</label>
          <input type="text" class="form-control" name="f_name" placeholder="Enter First Name" required>
          
          
          <label for="m_name">Middle Name</label>
          <input type="text" class="form-control" name="m_name" placeholder="Enter Middle Name" required>
          
          
          <label for="l_name">Last Name</label>
          <input type="text" class="form-control" name="l_name" placeholder="Enter Last Name" required>
          
        </div>
        <div class="form-group row">
          <div class="col-sm-5">
            <label for="job_title">Job Title</label>
            <input type="text" class="form-control" name="job_title" placeholder="Enter Job Title" required>
          </div>
          <div class="col-sm-2">
            <label for="sex">Sex</label>
            <select type="text" class="form-control" name="sex">
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </div>
          <div class="col">
            <label for="file_name">Add Profile Picture</label>
              
                <input style="border: solid gray;" class="bg-grey white" type="file" name="file_name">
              <br>  
              <small class="text-muted">*File must be on image format.</small>
          </div>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" class="form-control" placeholder="House no. Street Brgy, City" required></textarea>
        </div>
        <br>
        <div class="form-group row">
          <label for="assign" class="col-sm-2 col-form-label">Assign user to: </label>
          <div class="col-sm-4">
            <div class="input-group mb-3">
              <div class="input-group-addon">
                <span class="input-group-text" id="">Brgy</span>
              </div>
            <select name="assign" class="form-control">
              <option value="1">Bangkal</option>
              <option value="2">Bel-Air</option>
              <option value="3">Carmona</option>
              <option value="4">Cembo</option>
              <option value="5">Comembo</option>
              <option value="6">Dasmarinas</option>
              <option value="7">East Rembo</option>
              <option value="8">Forbes Park</option>
              <option value="9">Guadalupe Nuevo</option>
              <option value="10">Guadalupe Viejo</option>
              <option value="11">Kasilawan</option>
              <option value="12">Magallanes</option>
              <option value="13">Northside</option>
              <option value="14">Olympia</option>
              <option value="15">Palanan</option>
              <option value="16">Pembo</option>
              <option value="17">Pinagkaisahan</option>
              <option value="18">Pio Del Pilar</option>
              <option value="19">Pitogo</option>
              <option value="20">Poblacion</option>
              <option value="21">Rizal</option>
              <option value="22">San Antonio</option>
              <option value="23">San Isidro</option>
              <option value="24">San Lorenzo</option>
              <option value="25">Singkamas</option>
              <option value="26">South Cembo</option>
              <option value="27">Sta. Cruz</option>
              <option value="28">Tejeros</option>
              <option value="29">Urdaneta</option>
              <option value="30">Valenzuela</option>
              <option value="31">West Rembo</option>
            </select>
            </div>
          </div>
          <label class="col-sm-1 col-form-label">Email:</label>
          <div class="col-sm-5">
            <input type="email" name="email" class="form-control" placeholder="example@email.com" >
          </div>
        </div>
      
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Clear Input</button>
        <button type="submit" name="upload" value="Upload" class="btn btn-primary">Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- /modal for adding found_item (ending) -->
