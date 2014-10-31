<script>
function fileExtensionValidate(valId){       	
	var ext = $('#'+valId).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg','GIF','PNG','JPG','JPEG']) == -1) {
		jQuery('#'+valId).val('');
	    alert("Invalid File Type.");
		return false;
	}else
		return true;
}

function loadImg(img)
{
	if(fileExtensionValidate('logo'))
	{
		var reader = new FileReader();
        reader.onload = function (e) {            	
        $('#tempimg')
        	.attr('src', e.target.result);
		};
        reader.readAsDataURL(img.files[0]);
	}
}

function check_it()
{
	var title = jQuery('#title').val();

	// title validate
	if(title == "") {
		titleErr = "Wallboard title is required";
		jQuery('#titleErr').html(titleErr);
		jQuery('#titleErr').css('display','block');
		return false;
	}/*else if( ($("#type").val() == 'report') && ($("#wb_report").val() == 'select') ) {
		reportErr = "Please select report";
		jQuery('#reportErr').html(reportErr);
		jQuery('#reportErr').css('display','block');
		return false;
	}*/ else {
		jQuery('#titleErr').html('');
		jQuery('#titleErr').css('display','none');
		return true;
	}
}

$(document).ready(function () {

	// load wallboard reports
	$('#type').change(function ()
	{
		if ($("#type").val() == 'report')
		{		
			$("#wb_reports").show();
		} else {
			$("#wb_report option[value='select']").attr('selected', 'selected');
			$("#wb_reports").hide();
		}
	});

	// post data to delete method
	$('.delete_wb').click(function ()
	{
		$.ajax({
	        type : 'POST',
			url : "<?php echo base_url().'wallboard/delete/'?>",
			data: $("#wb_id").serialize(),
	        success:function (data) {
	        	window.location = "<?php echo base_url().'wallboard'?>";
	        }
	    });
	});
});
</script>
c
<div id="content">
    <div class="container">
        <div class="row content-header">
		<a href="#" class="main-nav-toggle"></a><?php echo heading('&nbsp;&nbsp;&nbsp;&nbsp;'.'Wallboard', 1);?>
			<?php echo $this->session->flashdata('message');?>
        </div>
        <!-- .row -->
        <div class="row content-body">
            <div class="col-sm-7 cf">
                <div class="wallboard-wrapper">
                    <div class="form-horizontal sb-form">
                        <div class="form-inlin">
                            <?php
							if ( !empty($wallboards) )
							{
								foreach ($wallboards as $k)
								{ 
									if($k['slug']!=="new-high-score")
									{
							?>
	                            <div class="wallboard-title form-group <?php echo (!empty($wb_info) && ($k['wb_id'] == $wb_info[0]->wb_id))?'active':''?>">
	                                <div class="col-xs-8">
	                                    <label for=""><?php echo $k['title']?></label>
	                                </div>
	                                <div class="col-xs-4">
	                                    <input type="text" class="sb-control sb-time-size" value="<?php echo $k['screen_delay']?>" readonly="readonly">
	                                    Sec <a class="action" href="<?php echo base_url().'wallboard/edit/'.$k['wb_id']?>">
	                                    <span class="glyphicon <?php echo (!empty($wb_info) && ($k['wb_id'] == $wb_info[0]->wb_id))?'glyphicon-minus-sign':'glyphicon-plus-sign'?>"></span></a> </div>
	                            </div>
	                            <?php
									}
								}
							}
							?>
                            <div class="wallboard-title form-group <?php echo empty($wb_info)?'active':''?>">
                                <div class="col-xs-8">
                                    <label for="">New wallboard</label>
                                </div>
                                <div class="col-xs-4">
                                    <input type="text" class="sb-control sb-time-size" value="0" readonly="readonly">
                                    Sec <a class="action" href="<?php echo base_url().'wallboard'?>">
                                    <span class="glyphicon <?php echo empty($wb_info)?'glyphicon-minus-sign':'glyphicon-plus-sign'?>"></span></a>
								</div>
                            </div>
                        </div>
                        <!-- .form inline -->
                        <div class="wallboard-form">
                        <?php
                        $report_id = 0;
                        $action = 'wallboard/add';
                        $title = 'New wallboard';
                        $type = 'main';
                        $screen_delay = 0;
                        $default_logo = '';
                        $logo_img = 'no_image_uploaded.png';
                        $logo = base_url().WB_PHOTO.'/'.$logo_img;
                        $effects = '';
                        $ticker_tape = '';
                        $wb_id = '';

                        if (isset($wb_info))
                        {
                        	$action = 'wallboard/edit';
                        	$title = $wb_info[0]->title;
                        	$type = $wb_info[0]->type;
                        	$screen_delay = $wb_info[0]->screen_delay;
                        	if (!empty($wb_info[0]->logo)){
                        		$logo_img = $wb_info[0]->logo;                        		
                        	}
                        	$logo = base_url().WB_PHOTO.'/'.$logo_img;
                        	$default_logo = $wb_info[0]->default_logo;
                        	$effects = $wb_info[0]->effects;
                        	$ticker_tape = $wb_info[0]->ticker_tape;
                        	$wb_id = $wb_info[0]->wb_id;
                        	$report_id = $wb_info[0]->report_id;
                        	$slug = $wb_info[0]->slug;
                        }
                        ?>
                        <?php echo form_open_multipart($action, array('name'=>'wallboard', 'id'=>'wallboard', 'onsubmit'=>"return check_it(this)")) ?>
	                            <div class="form-group">
	                                <label for="name" class="col-xs-4 control-label">Name:</label>
	                                <div class="col-xs-8">
	                                    <input type="text" class="sb-control" id="title" name="title" placeholder="<?php if($title =="New wallboard")echo $title;?>" value="<?php if($title !="New wallboard")echo $title;?>">
	                                    <div id='titleErr' style='color:red;diplay:none;'></div>
	                                </div>	                                
	                            </div>
	                            <div class="form-group">
	                                <label for="type" class="col-xs-4 control-label">Type:</label>
	                                <div class="col-xs-8">
	                                    <select class="sb-control" id="type" name="type">
	                                        <!-- <option value="main" <?php #echo $type=='main'?'selected="selected"':''?>>Main</option> -->
	                                        <option value="report" <?php echo $type=='report'?'selected="selected"':''?>>Report</option>
	                                    </select>
	                                </div>	                                	                                
	                            </div>
	                            
<!--	                            <div class="form-group" id="wb_reports" <?php echo ($type == 'main')?'style="display: none;"':''?>> -->
	                            <div class="form-group" id="wb_reports">

	                                <label for="type" class="col-xs-4 control-label">Report:</label>
	                                <div class="col-xs-8">
	                                <?php if (!empty($wb_reports)){?>
	                                    <select class="sb-control" id="wb_report" name="wb_report">
	                                    	<option value="select">Select</option>
	                                    <?php foreach ($wb_reports as $r){?>
	                                        <option value="<?php echo $r['report_id']?>" <?php echo $report_id==$r['report_id']?'selected="selected"':''?>><?php echo $r['report_name']?></option>
										<?php }?>
	                                    </select>
	                                    <div id='reportErr' style='color:red;diplay:none;'></div>
									<?php } else {?>
										<code>No report found</code>
									<?php }?>
	                                </div>	                                	                                
	                            </div>
	                          
	                            <div class="form-group">
	                                <label for="time" class="col-xs-4 control-label">Time on Screen:</label>
	                                <div class="col-xs-4">
	                                    <input type="text" class="txtTesting sb-control sb-time-size" id="time" name="screen_delay" maxlength="5" value="<?php echo $screen_delay?>">
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label for="use_logo" class="col-xs-4 control-label">Use main logo:</label>
	                                <div class="col-xs-8" style="padding-top: 7px;">
	                                    <input type="checkbox" id="use_logo" name="default_logo" <?php echo ($default_logo==1)?'checked':''?>>
	                                    <label for="use_logo"><span></span></label>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label for="logo" class="col-xs-4 control-label">Logo (Browse):</label>
	                                <div class="col-xs-8">
	                                	<input type="hidden" value="<?php echo $logo_img?>" name="old_photo" height="35%">
	                                	<img id="tempimg" style='border:1px solid black;' src="<?php echo $logo?>" width="35%" height="35%">
	                                    <input type="file" value="" name="logo" id="logo" class="mt-xxs sb-file" onChange="loadImg(this);">
	                                    <div class="mt-xxs mb-m">Allowed extensions (<code>jpeg</code>, <code>jpg</code>, <code>gif</code>, and <code>png</code>)</div>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label for="change_style" class="col-xs-4 control-label">Change Style:</label>
	                                <div class="col-xs-8">
	                                    <select class="sb-control" id="change_style" name="effects">
	                                        <?php
	                                        foreach ($style as $v)
	                                        {
	                                        	$selected = '';
	                                        	if ($effects == $v){
	                                        		$selected = 'selected="selected"';
	                                        	}                                        	
	                                        ?>
	                                        	<option <?php echo $selected?> value="<?php echo $v?>"><?php echo ucwords($v)?></option>
	                                        <?php }?>
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label for="tickertape" class="col-xs-4 control-label">Tickertape:</label>
	                                <div class="col-xs-8">
	                                    <textarea class="sb-textarea" id="tickertape" name="ticker_tape" rows="4"><?php echo $ticker_tape?></textarea>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                            	<input type="hidden" name="wb_id" id="wb_id" value="<?php echo $wb_id?>">
	                            	<div class="col-xs-6">
									<?php if (!empty($wb_info)){?>	                                
	                                    <button type="button" class="sb-btn sb-btn-delete delete_wb">Delete</button>	                                    
	                                <?php }?>
	                                </div>
	                                <div class="col-xs-6 text-right">
	                                <?php if (!empty($wb_info)){?>	
	                                	<a href="<?php echo base_url().'wallboard/launch/'.$slug?>" target="_blank"><button type="button" class="sb-btn sb-btn-blue launch_wb">Launch</button></a>
	                                <?php }?>
	                                    <button type="submit" class="sb-btn sb-btn-green">Save</button>
	                                </div>
	                            </div>
                            </form>
                        </div>
                        <!-- .wallboard-form -->
                    </div>
                    <!-- .form-horizontal -->
                </div>
                <!-- .wallboard-wrapper -->
            </div>
            <!-- .col-sm-5 .cf -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</div>
<!-- #content -->
<script type="text/javascript">$(".txtTesting").jStepper({minValue:10, maxValue:2000, minLength:4});</script>
