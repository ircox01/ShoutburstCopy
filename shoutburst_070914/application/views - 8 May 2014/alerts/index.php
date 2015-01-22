<!-- Modal -->
<div id="myModal" class="modal sb fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
            <button type="button" class="sb-close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">New Alert</h4>
        </div>
        <div class="modal-body cf">
          <div class="f orm-horizontal s b-form">
            <div class="form-group">
                    <input type="text" autocomplete="off" autofocus="autofocus" name="report_name" id="input1" class="sb-control" placeholder="Alert name">
            </div>
            <div class="form-group">
                    <select name="" id="input2" class="sb-control">
                        <option value="">Select</option>
                        <option value="3">Total score</option>                
                        <option value="4">Question score</option>
                        <option value="4">Total surveys</option>
                      </select>
            </div>

            <div class="form-group">
                  <select name="" id="input4" class="sb-control">
                    <option value="">Select</option>
                    <option value="3">option 1</option>                
                    <option value="4">option 2</option>
                    <option value="4">option 3</option>
                  </select>
            </div>
            <div class="form-group">
                  <input type="checkbox" id="send_email">
                  <label for="send_email"><span></span>Send email</label>
                  <br>
                  <input type="checkbox" id="send_sms">
                  <label for="send_sms"><span></span>Send SMS</label>
            </div>
            <div class="form-group">
                    <textarea name="email_address" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="input5" placeholder="Add email addresses [comma separated] ..."></textarea>
            </div>
            <div class="form-group">
                    <textarea name="email_address" autocomplete="off" rows="3" cols="10" class="sb-textarea" id="input6" placeholder="Input telephones numbers ..."></textarea>
            </div>
          </div>
        </div><!-- .modal-body.cf -->
        <div class="modal-footer">
            <button type="button" class="sb-btn sb-btn-white" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" id="submit" class="sb-btn sb-btn-green">Save</button>
        </div>
    </div>
  </div>
</div>
<!--// Modal -->
<div id="content">
  <div class="container">
    <div class="row content-header">
		<a href="#myModal" id='modal1' class="sb-btn sb-btn-blue" role="button" data-toggle="modal">Add New Alert</a>
		<?php echo heading('Alerts', 1);?> 
		<?php echo $this->session->flashdata('message');?>
	</div>
    <div class="row content-body">
      <div class="col-md-12">
        <table class="table table-striped table-bordered dataTable" id="example">
          <thead>
            <tr>
              <th>Alert Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Alert 1</td>
			  <td align="center">
				<!-- <a href="#myModal" id="modal2" class="edit" role="button" agentId='' data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> -->
				<a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black glyphicon-pencil"></span></a>
				|
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black custom-icon icon-copy"></span></a>
                |
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon red glyphicon-remove"></span></a>
			  </td>              
            </tr>
            <tr>
              <td>Alert 2</td>
			  <td align="center">
				<!-- <a href="#myModal" id="modal2" class="edit" role="button" agentId='' data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> -->
				<a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black glyphicon-pencil"></span></a>
				|
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black custom-icon icon-copy"></span></a>
                |
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon red glyphicon-remove"></span></a>
			  </td>              
            </tr>
            <tr>
              <td>Alert 3</td>
			  <td align="center">
				<!-- <a href="#myModal" id="modal2" class="edit" role="button" agentId='' data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> -->
				<a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black glyphicon-pencil"></span></a>
				|
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon black custom-icon icon-copy"></span></a>
                |
                <a href="#myModal" id="modal1" role="button" agentId='agentID' data-toggle="modal"><span class="glyphicon red glyphicon-remove"></span></a>
			  </td>              
            </tr>
          </tbody>
        </table>
      </div>
    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- #content -->
