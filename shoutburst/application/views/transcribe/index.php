<div id="content">
   
  <div class="container">
    <div class="row content-header">
<a href="#" class="main-nav-toggle"></a><?php echo heading('&nbsp;&nbsp;&nbsp;&nbsp;'.'Transcriptions', 1);?>
        <?php echo $this->session->flashdata('message');?>
    </div>
    <?php if ( !empty($transcribe) ){ ?>
    <div class="row content-body">
        <div class="col-md-12">
          <table class="table table-striped table-bordered dataTable" id="example">
            <thead>
                <tr>
                    <th>Record Number</th>
                    <th>Sentiment Score</th>
                    <th>Date/Time (Year-month-date)</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transcribe as $key){ ?>
                <tr>
                    <td align="center"><?php echo $key->sur_id;?></td>
                    <td align="center"><?php echo (!empty($key->sentiment_score) ? full_txt( $key->sentiment_score ) : '-');?></td>
                    <td align="center"><?php echo $key->date_time; ?></td>
                    <td align="center"><?php echo (!empty($key->gender) ? full_txt( $key->gender ) : '-');?></td>
                    <td align="center">
                    <?php if (isset($key->transcription_id) && !empty($key->transcription_id)){?>
                        <a href="<?php echo base_url().'transcribe/edit/'. $key->transcription_id?>" title="Add/edit Transcription"><span class="glyphicon black glyphicon-pencil"></span></a>
                    <?php }else{?>
                        <a href="<?php echo base_url().'transcribe/add/'. $key->sur_id?>" title="Add/edit Transcription"><span class="glyphicon black glyphicon-pencil"></span></a>
                    <?php }?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
          </table>
        </div>
    </div>
    <?php }else{ ?>
        <code>No data found.</code>
    <?php }?>
  </div>
</div>